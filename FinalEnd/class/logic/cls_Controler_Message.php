<?php


class Controler_Message
{
	
	public function start()
	{
		$Respons= new Request();
		
		switch($Respons->getAsString("Action"))
		{
			case "WorkOnMessage":
			{
				$this->workOnMessage();
				$this->showAll();
			}break;

			case "InsertMessage":
			{
				$this->saveNewMessage();
				//$this->showAll();
			}break;
			
			
			
			default:
				$this->showAll();
			
		}
	}

	public function workOnMessage()
	{
		$Request= new Request();
		$MessageManager= new MessageManager();
		if(!is_array($Request->getAsArray("Id"))) {return false;}
		foreach($Request->getAsArray("Id") as $ID)
		{
			
			if($Request->getAsString("Mode")=="Exit")
			{
				$MessageManager->setDeletetByFrom($ID);
				$Request->setPost("Show","Exit");
				continue;
			}
			
			switch($Request->getAsInt("cb_Mode"))
			{
				case"0": // auf ungelesen setzen  in den eingang
				{
					$MessageManager->setUnViewedByTo($ID);
				}break;
				case"1":// gelsesen setzen	 ins archiv
				{
					$MessageManager->setViewedByTo($ID);
				}break;
				case"2":// löschen
				{
					$MessageManager->setDeletetByTo($ID);
				}break;
			}
		}
		$MessageManager->deleteFromSystemAndDeleted();	
	}
	
	private function showAll($ErrorString="")
	{
		$Request= new Request();
		$Page=$Request->getAsInt("i_Page");
		if(!$Page)
		{
			$Page=0;	
		}
		$User= Controler_Main::getInstance()->getUser();
		$Messagefinder = new MessageFinder();
		//$UserFinder= new UserFinder();
		//$UserCollection = $UserFinder->findAllUser();
		$MessageFinder= new MessageFinder();
		$MessageCount= $MessageFinder->countMessageNoneListen($User->getName());
		$MessageCollection= new MessageCollection();
		$TempLate=Template::getInstance("tpl_Message.php");
		switch($Request->getAsString("Show"))
		{
			case "UnRead":
			{
				$MessageCollection =$Messagefinder->findUnReadTo($User->getName(),$Page*30);
				$MessageCountPage  =$MessageFinder->countMessageByReciver($User->getName(),0,0,0,0);
			}break;
			case "Archiv":
			{
				$MessageCollection =$Messagefinder->findReadTo($User->getName(),$Page*30);
				$MessageCountPage  =$MessageFinder->countMessageByReciver($User->getName(),0,1,0,0);
			}break;
			
			case "Exit":
			{
				$MessageCollection =$Messagefinder->findFromAndNotDeletet($User->getName(),$Page*30);
				$TempLate->assign("Exit",true);
				$MessageCountPage  =$MessageFinder->countMessageByReciver($User->getName(),0,0,0,1);
			}break;
			
			default:
				$MessageCollection =$Messagefinder->findUnReadTo($User->getName(),$Page*30);
				$MessageCountPage  =$MessageFinder->countMessageByReciver($User->getName(),0,0,0,0);
		}
		
		$MessageCollection->Parse();
		
		$MainControler=  Controler_Main::getInstance();	 // nachrichten symbol ausblenden 
		$User=$MainControler->getUser();

		
		if($Page>0)
		{
			$TempLate->assign("LastPageView",true);
			$TempLate->assign("LastPage",$Page-1);
		}
		
		if(($Page+1)*30<$MessageCountPage)// nur premium account können mehr als 30 nachrichten einsehenund mehr nachrichten vorhanden als angezeigt
		{
			if($Page*30<$MessageCountPage && $User->isPremium())// nur premium account können mehr als 30 nachrichten einsehenund mehr nachrichten vorhanden als angezeigt
			{
				$TempLate->assign("NextPage",$Page+1);
			}
		}
		
		$TempLate->assign("Show",$Request->getAsString("Show"));
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->assign("PlayerName",$Request->getAsString("PlayerName"));
		$TempLate->assign("MessageCount",$MessageCount);
		$TempLate->assign("MessageCollection",$MessageCollection);// die nachrichten Collection ins template schieben
		$TempLate-> render();
		
	}
	
	private function saveNewMessage()
	{
		$Request= new Request();
		$User= Controler_Main::getInstance()->getUser();
		$UserFinder= new UserFinder();
		$Reciver=$UserFinder->findByName($Request->getAsString("tb_Resiver"));
		if (strlen($Request->getAsString('rtb_Text'))>3 && $Reciver->getId()!=0)
		{
			$MessageManager= new MessageManager();
			$Message= new Message(0,$User->getName(),$Request->getAsString("tb_Resiver"),$Request->getAsString("rtb_Text"),$Request->getAsString("tb_Header"),"",0,0,0,0);
			$MessageManager->saveNewMessage($Message);
			Controler_Event::getInstance()->addEvent(new MessageSendEvent($User));// nachricht geschrieben event platziern
			Controler_Event::getInstance()->addEvent(new MessageReciveEvent($Reciver));// nachricht geschrieben event platziern
			//$this->sendMailNewMessagePlayer($Reciver);
			$this->showAll();
			return true;
		}else
		{
			$this->showAll(":T_MESSAGE_SENTFAIL:");
			return true;
		}
	}
	
	public function sendMessageToUserFromUnitCollection($FromName,UnitCollection $UnitCollection,$Message,$Header)
	{
		foreach($UnitCollection as $Unit)
		{
			$this->sendMessage($FromName,$Unit->getUser()->getName(),$Message,$Header);
		}
	}
	
		
	 
	/**
	 * schreibt dem angegebenen User eine nachricht
	 *
	 * @param string $FromName der Absender
	 * @param string $ToUser Der Name des Spielers an die diese Nachricht gesendet werden soll
	 * @param string $Message der Content
	 * @return void 
	 *
	 */
	public function sendMessage($FromName,$ToUser,$Message,$Header)
	{
		$UserFinder= new UserFinder();
		$MessageManager= new MessageManager();
		$Message=new Message(0,$FromName,$ToUser,$Message,$Header,"",0,0,0,0);
		$MessageManager->saveNewMessage($Message);
	}
	
	
	
	 
	
	/**
	 * wendet eine nachricht zu den spielern die am raid beteiligt waren
	 *
	 * @param mixed $ToPlayerName This is a description
	 * @param Unit $Unit This is a description
	 * @param mixed $Planet This is a description
	 * @return mixed This is the return value description
	 *
	 */
	public function sendPlanetRaidMessageToPlayer($ToPlayerName,Unit $Unit,$Planet,$Metal,$Cristal,$HyDrogen,$BioMass)
	{
		
		$MessageManager= new MessageManager();
		$MessageString=":T_PLANET_TAKE1: ".$Planet->getName()." :T_MESSAGE_RAIDED: </br>";
		$MessageString.="<img src='./images/metal.png' width='20px' height='20px' class='Icons' alt=':T_HEADER_METAL:' title=':T_HEADER_METAL:' />".round($Metal);
		$MessageString.="<img src='./images/kristal.png' width='20px' height='20px' class='Icons' alt=':T_HEADER_CRYSTAL:' title=':T_HEADER_CRYSTAL:' />".round($Cristal);
		$MessageString.="<img src='./images/Treibstoff.png' width='20px' height='20px' class='Icons' alt=':T_HEADER_HYDROGEN:' title=':T_HEADER_HYDROGEN:' />".round($HyDrogen);
		$MessageString.="<img src='./images/fleisch.png' width='20px' height='20px' class='Icons' alt=':T_HEADER_BIOMAS:' title=':T_HEADER_BIOMAS:' />".round($BioMass);
		$Message=new Message(0,SYSTEM_NAME,$ToPlayerName,$this->enCode($MessageString),$Planet->getName()." :T_MESSAGE_RAIDED_TITLE:","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
		
		$MessageString=":T_PLANET_TAKEN1: ".$Planet->getName()." :T_MESSAGE_WASRAIDED: </ br>";
		$MessageString.="<img src='./images/metal.png' width='20px' height='20px' class='Icons' alt=':T_HEADER_METAL:' title=':T_HEADER_METAL:' />".round($Metal);
		$MessageString.="<img src='./images/kristal.png' width='20px' height='20px' class='Icons' alt=':T_HEADER_CRYSTAL:' title=':T_HEADER_CRYSTAL:' />".round($Cristal);
		$MessageString.="<img src='./images/Treibstoff.png' width='20px' height='20px' class='Icons' alt=':T_HEADER_HYDROGEN:' title=':T_HEADER_HYDROGEN:' />".round($HyDrogen);
		$MessageString.="<img src='./images/fleisch.png' width='20px' height='20px' class='Icons' alt=':T_HEADER_BIOMAS:' title=':T_HEADER_BIOMAS:' />".round($BioMass);
		$Message=new Message(0,SYSTEM_NAME,$Planet->getUser()->getName(),$this->enCode($MessageString),":T_MESSAGE_RAIDED_TILE2:","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
	}

	/**
	* sendet dem User die scann nachricht
	*
	* @param string $ToPlayerName der spieler der den scann vorgang ausgelöst hat
	* @param Unit $Unit 
	* @param Planet $Planet 
	* @return void 
	*
	*/
	public function sendPlanetViewMessageToPlayer($ToPlayerName,Unit $Unit,$Planet)
	{
		$MessageManager= new MessageManager();
		$Template= new Template("message/tpl_Planet.php");
		$Template->assign("Planet",$Planet);
		$MessageString=$Template->renderWithoutSend(false);
		$Message=new Message(0,SYSTEM_NAME,$ToPlayerName,$this->enCode($MessageString),":T_PLANET_SINGLE: ".$Planet->getName()." :T_MESSAGE_WASSCANNED:","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
		
		$Message=new Message(0,SYSTEM_NAME,$Planet->getUser()->getName(),":T_PLANET_TAKEN1: ".$Planet->getName()." :T_MESSAGE_SCANWAS: ".$ToPlayerName." :T_MESSAGE_SCANNED_SINGLE:",":T_MESSAGE_SCANNED_TITLE:","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
		
	}
		
	/**
	 * sendet eine nachricht an den spieler mit dem inhalt das er credits verloren hat
	 *
	 * @param string $ToPlayerName 
	 * @param int $Credits 
	 * @return void 
	 *
	 */
	public function sendCreditStealToPlayer($ToPlayerName,$Credits)
	{
		$MessageManager= new MessageManager();
		$TplCount=mt_rand(1,5);
		$Template= new Template("message/tpl_LostCredits".$TplCount.".php");
		$Template->assign("Credits",$Credits);
		$MessageString=$Template->renderWithoutSend(false);
		$Message=new Message(0,SYSTEM_NAME,$ToPlayerName,$this->enCode($MessageString),":T_MESSAGE_SCANNED_STOLEN:","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
	}
	
	
	
	public function sendPlanetOverTake(Planet $Planet,User $FromUser,User $OldUser)
	{
		if($OldUser->getId())
		{
			$this->sendMessage("System",  $OldUser->getName(),":T_PLANET_TAKEN1: <a title=\":T_LINK_TOMAP:\" href=\"index.php?Section=Map&amp;X=".$Planet->getX()."&amp;Y=".$Planet->getY()."\"> ".$Planet->getName()."</a> :T_PLANET_TAKEN2:",":T_PLANET_LOST_TITLE:");
		}
		if($FromUser && $FromUser->getId())
		{
			$this->sendMessage("System",  $FromUser->getName(),":T_PLANET_TAKE1: <a title=\":T_LINK_TOMAP:\" href=\"index.php?Section=Map&amp;X=".$Planet->getX()."&amp;Y=".$Planet->getY()."\"> ".$Planet->getName()."</a> :T_PLANET_TAKE2: ".BASE_XP_PER_PLANET." :T_PLANET_TAKE3:",":T_PLANET_TAKE_TITLE:");
		}
	}
	
	
	public function sendCreditGetToPlayer($ToPlayerName,$Credits)
	{
		$MessageManager= new MessageManager();
		$Template= new Template("message/tpl_getCredits.php");
		$Template->assign("Credits",$Credits);
		$MessageString=$Template->renderWithoutSend(false);
		$Message=new Message(0,SYSTEM_NAME,$ToPlayerName,$this->enCode($MessageString),":T_MESSAGE_CREDITS_TAKEN:","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
	}
	
	public function sendPlanetDestroyed($ToPlayerName,$Planet,$From)
	{
		$MessageManager= new MessageManager();
		$Message=new Message(0,SYSTEM_NAME,$ToPlayerName,":T_PLAN_DESTROYED_PLAYER: ".$From." :T_PLAN_DESTROYED_HASDONE:.",":T_PLAN_DESTROYED_TITLE: ".$Planet." :T_PLAN_DESTROYED_WASDEST:.","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
	}
	 
	public function sendPlanetAttacked($ToPlayerName,$Planet,$From)
	{
		$MessageManager= new MessageManager();
		$Message=new Message(0,SYSTEM_NAME,$ToPlayerName,":T_PLAN_DESTROYED_PLAYER: ".$From." :T_PLAN_DESTROYED_ATTACK2:.",":T_PLAN_DESTROYED_TITLE: ".$Planet." :T_PLAN_DESTROYED_ATTACK:.","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
	}
	
	public function sendPlanetYouAttacked($ToPlayerName,$Planet,$From)
	{
		$MessageManager= new MessageManager();
		$Message=new Message(0,SYSTEM_NAME,$From,":T_PLAN_DESTROYED_ATTACKYOU2::.",":T_PLAN_DESTROYED_TITLE: ".$Planet." :T_PLAN_DESTROYED_ATTACKYOU:.","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
	}
	
	public function sendGetNewPlanetsToPlayer($ToPlayerName)
	{
		$MessageManager= new MessageManager();
		$TplCount=mt_rand(1,5);
		$Template= new Template("message/tpl_UserNewPlanet.php");
		$MessageString=$Template->renderWithoutSend(false);
		$Message=new Message(0,SYSTEM_NAME,$ToPlayerName,$this->enCode($MessageString),":T_MESSAGE_NEW_SHORE:","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
	}
	

	/**
	 * sendet
	 *
	 * @param User $User der User zudem die Mail gesendet werden soll
	 * @return void 
	 *
	 */
	public function sendMailNewMessagePlayer(User $User)
	{
		$Message = ':T_MESSAGE_NEWMAIL:';
		$Subject = ':T_MESSAGE_NEWMAIL_SUBJ:';
		$this->sendMail($User,$Message,$Subject);
	}
	
	public function sendMail(User $ToUser,$Message,$Header)
	{
		require_once "Mail.php";  // ka ob das hier geht
		$From = " Final-End.de <".SYSTEM_EMAIL_ADRESS.">";
		$To = "Recipient <".$ToUser->getMail().">";
		$Subject =$Header;
		$Headers = array ('From' => $From,
			'To' => $To,
			'Subject' => $Subject);
		$smtp = Mail::factory('smtp',
			array ('host' => SYSTEM_EMAIL_HOST,
					'auth' => true,
					'username' => SYSTEM_EMAIL_ADRESS,
					'password' => SYSTEM_EMAIL_PASS));
		$mail = $smtp->send($To, $Headers, $Message);
	}
	
	
	/**
	 * sendet eine ingame nachricht zum spieler wenn auf seinen Ref link geklickt wurde
	 *
	 * @param User $User 
	 * @param int $Exp 
	 * @param int $Crediits 
	 * @return void 
	 *
	 */
	public function sendBenefitToPlayer(User $User,$Exp,$Crediits)
	{
		$MessageManager= new MessageManager();
		$Message=new Message(0,SYSTEM_NAME,$User->getName(),":T_MESSAGE_TRANS_REC: ".$Crediits." :T_HEADER_CREDITS:",":T_MESSAGE_TRANS_TITLE:","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
	}
	
	public function cantRepairDeathStar(User $User)
	{
		$MessageManager= new MessageManager();
		$Message=new Message(0,SYSTEM_NAME,$User->getName(),":T_MESSAGE_CANT_REPAIR_DESTHSTAR:",":T_MESSAGE_CANT_REPAIR_DESTHSTAR_HEADER:","",0,0,0,0);	
		$MessageManager->saveNewMessage($Message);
	}
	
	
	
	/**
	 * sendet nachrichten an die spieler der Planetaren verseuchung
	 *
	 * @param User $DamagedPlayer der Spieler dessen Planet verseucht wurde
	 * @param User $ActionPlayer der Spieler der die seuche ausgelöst hat
	 * @return mixed This is the return value description
	 *
	 */
	public function sendPlanetEpidemicToPlayer(User $DamagedPlayer,User $ActionPlayer, Planet $Planet)
	{
		$MessageManager= new MessageManager();

		$Message=new Message(0,SYSTEM_NAME,$DamagedPlayer->getName(),":T_PLANET_TAKEN1: ".$Planet->getName()." :T_PLANET_WAS_POISONED:" ,":T_PLANET_POISONTITLE:!","",0,0,0,0);
		$MessageManager->saveNewMessage($Message);
		
		$Message=new Message(0,SYSTEM_NAME,$ActionPlayer->getName(),":T_PLANET_TAKE1: ".$Planet->getName()." :T_PLANET_FROM: ".$DamagedPlayer->getName()." :T_PLANET_POISONED:",":T_PLANET_YOUPOISONED:","",0,0,0,0);
		$MessageManager->saveNewMessage($Message);
	}
	
	public function sendSabotageWin(User $DamagedPlayer,User $ActionPlayer, Planet $Planet, $Count, $ShipType)
	{
		$MessageManager= new MessageManager();

		$Message=new Message(0,SYSTEM_NAME,$DamagedPlayer->getName(),":T_PLANET_TAKEN1: ".$Planet->getName()." :T_PLANET_TAKECASUALT: ".$Count." :T_PLANET_TAKECASUALT2:" ,":T_PLANET_TAKECASUALT_TITLE:!","",0,0,0,0);
		$MessageManager->saveNewMessage($Message);
		
		$Message=new Message(0,SYSTEM_NAME,$ActionPlayer->getName(),":T_PLANET_HAVEON: ".$Planet->getName()." :T_PLANET_FROM: ".$DamagedPlayer->getName()." ".$Count." :T_PLANET_DESTROYEDSHIPS:",":T_PLANET_YOUSABOTAGED:","",0,0,0,0);
		$MessageManager->saveNewMessage($Message);
	}
	 
	public function sendSabotageFail(User $DamagedPlayer, User $ActionPlayer, Planet $Planet)
	{
		$MessageManager= new MessageManager();

		$Message=new Message(0,SYSTEM_NAME,$DamagedPlayer->getName(),":T_PLANET_FIRSTCASE: ".$Planet->getName()." :T_PLANET_PREVENTSABO:" ,":T_PLANET_SABOWARNING:","",0,0,0,0);
		$MessageManager->saveNewMessage($Message);
		
		$Message=new Message(0,SYSTEM_NAME,$ActionPlayer->getName(),":T_PLANET_FIRSTCASE: ".$Planet->getName()." :T_PLANET_FROM: ".$DamagedPlayer->getName()." :T_PLANET_COULDNTSABO:",":T_PLANET_SABOFAIL:","",0,0,0,0);
		$MessageManager->saveNewMessage($Message);
	}

	public function sendExtractRessources(User $DamagedPlayer, User $ActionPlayer, Planet $Planet, $Count, $Name)
	{
		$MessageManager= new MessageManager();

		$Message=new Message(0,SYSTEM_NAME,$DamagedPlayer->getName(),":T_PLANET_THIRDCASE: ".$Planet->getName()." :T_PLANET_ARE: ".$Count." ".$Name." :T_PLANET_LOSTTHEGAME:.",":T_PLANET_LOSTRES:!","",0,0,0,0);
		$MessageManager->saveNewMessage($Message);
		
		$Message=new Message(0,SYSTEM_NAME,$ActionPlayer->getName(),":T_PLANET_FIRSTCASE: ".$Planet->getName()." :T_PLANET_FROM: ".$DamagedPlayer->getName()." :T_PLANET_HAS: ".$Count." ".$Name." :T_PLANET_LOST:.",":T_PLANET_RESDESTR:","",0,0,0,0);
		$MessageManager->saveNewMessage($Message);
	}
	
	
	/**
	 * sendet eine nachricht zum spieler der einee gegnerische flotte zerstört hat
	 *
	 * @param User $User der User das die Flotte zerstört hat
	 * @param Unit $Unit die zerstörte Flotte
	 * @return void This is the return value description
	 *
	 */
	public function sendEnemyUnitDestroyed(User $User,Unit $Unit)
	{
		$this->sendMessage(SYSTEM_NAME,  $User->getName(),
			"Sie haben die Einheit: <a title=\"zur Karte\" href=\"index.php?Section=Map&amp;X=".round($Unit->getX())."&amp;Y=".round($Unit->getY())."\">".$Unit->getName()." ".round($Unit->getX()).":".round($Unit->getY())."</a> von ".$Unit->getUser()->getName()." zerstört <br /><br />Sie haben ".$Unit->getHealts(true)." Erfahrung erhalten.",
			"Gegnerische Einheiten wurde zerstört");	
	}
	
	
	
	public function sendAllianzTopicCreate(User $User, AllianzTopic $Topic,UserCollection $Members)
	{
		foreach($Members as $Member)
		{
			if($Member->getName()!=$User->getName())
			{
				$MessageManager= new MessageManager();
				$Message=new Message(0,SYSTEM_NAME,$Member->getName(),$User->getName()." :T_PLANET_TOPICHAS: ".$Topic->getName()." :T_PLANET_CREATED:." ,":T_NEW_TOPIC:","",0,0,0,0);
				$MessageManager->saveNewMessage($Message);
			}
		}
	}
	
	public function sendAllianzTopicReply(User $User, AllianzTopic $Topic,UserCollection $Members)
	{
		foreach($Members as $Member)
		{
			if($Member->getName()!=$User->getName())
			{
				$MessageManager= new MessageManager();
				$Message=new Message(0,SYSTEM_NAME,$Member->getName(),$User->getName()." :T_PLANET_TOPICHASON: ".$Topic->getName()." :T_MESSAGE_ANSWERD:. <a href=\"index.php?Section=Allianz&Action=ShowTopic&TId=".$Topic->getid()."\">:T_MESSAGE_LINKTOPIC:</a> ",":T_MESSAGE_ANSWERINALLI:","",0,0,0,0);
				$MessageManager->saveNewMessage($Message);
			}
		}
		
	}
	
	public function sendAllianzNewMember(User $User,UserCollection $Members)
	{
		foreach($Members as $Member)
		{
			if($Member->getName()!=$User->getName())
			{
				$MessageManager= new MessageManager();
				$Message=new Message(0,SYSTEM_NAME,$Member->getName(),$User->getName()." :T_MESSAGE_ALLINEWMEM: .",":T_MESSAGE_NEWMEMBER:","",0,0,0,0);
				$MessageManager->saveNewMessage($Message);
			}
		}
		
	}
	
	public function sendAllianzMemberFaint(User $User,UserCollection $Members)
	{
		foreach($Members as $Member)
		{
			if($Member->getName()!=$User->getName())
			{
				$MessageManager= new MessageManager();
				$Message=new Message(0,SYSTEM_NAME,$Member->getName(),$User->getName()." :T_MESSAGE_FAINTALLI:",":T_MESSAGE_FAINTTILE:","",0,0,0,0);
				$MessageManager->saveNewMessage($Message);
			}
		}
		
	}
	/**
	 * entfernt alle " und ersetzt diese mit &QQ;
	 *
	 * @param string $Text 
	 * @return string 
	 *
	 */
	public function enCode($Text)
	{
		$TempText=str_replace('"',"&QQ;",$Text);
		$TempText=str_replace("'","&RR;",$Text);
		return $TempText;
	}
		
	/**
	 * entfernt alle &QQ; und ersetzt diese mit "
	 *
	 * @param string $Text 
	 * @return string 
	 *
	 */
	public function deCode($Text)
	{
		$TempText=str_replace("&QQ;",'"',$Text);
		$TempText=str_replace("&RR;","'",$Text);
		return $TempText;
	}	
	
	public function sendMapTutorialToPlayer(User $Target) 
	{ 
		$MessageManager= new MessageManager();
		$Message=new Message(0,SYSTEM_NAME,$Target->getName(),":T_MESSAGE_MAPTUT:",":T_MESSAGE_MAPTUT_TITLE:","",0,0,0,0);      
		$MessageManager->saveNewMessage($Message);                                                                     
		
	}
	
	public function sendUpgradeTutToPlayer(User $Target) 
	{ 
		$MessageManager= new MessageManager();
		$Message=new Message(0,SYSTEM_NAME,$Target->getName(),":T_MESSAGE_SHIPTUT:",":T_MESSAGE_SHIPTUT_TITLE:","",0,0,0,0);      
		$MessageManager->saveNewMessage($Message);                                                                     
		
	} 
	
	public function sendBattleTutToPlayer(User $Target) 
	{ 
		$MessageManager= new MessageManager();
		$Message=new Message(0,SYSTEM_NAME,$Target->getName(),":T_MESSAGE_BATTLETUT:",":T_MESSAGE_BATTLETUT_TITLE:","",0,0,0,0);      
		$MessageManager->saveNewMessage($Message);                                                                     
		
	}
	
	
}

?>
