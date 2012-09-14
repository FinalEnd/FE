<?php

/**
 * class cls_Controler_Click
 *
 * Description for class cls_Controler_Click
 *
 * @author:
*/
class Controler_Login  
{

	/**
	 * cls_Controler_Click constructor
	 *
	 * @param 
	 */
	function __construct() {

	}
	
	
	public function start()
	{
		$Request= new Request();
		switch($Request->getAsString('Action'))
		{
			case "ShowRegister":
			{
				$this->showRegister();
			}break;
			case "Register":
			{
				$this->registerNewUser();
			}break;
			case "UserLogin":
			{
				$this->userLogin();
			}break;
			case "Logout":
			{
				$this->userLogout();
			}break;
			
			case "ShowStory":
			{
				$this->showStory();
			}break;
			
			case "GetCaptcha":
			{
				$this->getCaptcha();
			}break;
			
			case "TEMP":
			{
				$this->temp();
			}break;
			
			default:
				$this->showLogin();
		}
	}
	
	public  function temp()
	{
		$PlanetSystem = new PlanetSystem();
		$PlanetSystem->generateSystem(5,5);
		var_dump($PlanetSystem);

	}
	
	
	public  function showStory()
	{
		$Template= Template::getInstance("tpl_Story.php");
		$Template->render();
	}
	/**
	 * setzt den captcha cod in die session
	 *
	 * @return void 
	 *
	 */
	private function setCaptchaCode()
	{
		$Pass= Controler_Main::getInstance()->getRandomPass(5);
		$_SESSION['Captcha']=$Pass;
	}
	
	public function showRegister($ErrorString="")
	{
		$Request= new Request();
		$this->setCaptchaCode();
		
		if($Request->getAsInt("Ref"))  // wenn der Spieler (neuer Spieler) von einem anderen spieler (werber) geworben wurde die Id des Werbers
		{
			$_SESSION['FriendID']=$Request->getAsInt("Ref");
		}
		$TempLate=Template::getInstance("tpl_Register.php"); 
		$TempLate->assign("Name",$Request->getAsString("tb_Name"));
		$TempLate->assign("MyMail",$Request->getAsString("tb_Mail"));
		$TempLate->assign("Pass",$Request->getAsString("tb_Pass"));
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->render();
	}
	
	
	
	/**
	 * diese fu8nction schickt ein bild zum browser
	 *
	 * @return void 
	 *
	 */
	public function getCaptcha()
	{
		
		//Header ("Content-type: image/png");
		// Laden der Rohdatei, die sich im Verzeichnis befinden muss
		
		$Pic = ImageCreate(250, 250);
		$Background=imagecreatefrompng("./images/Captcha.png");
		ImageCopy($Pic,$Background,0,0,$_SESSION['Random'][$_SESSION['PicCounter']],$_SESSION['Random'][$_SESSION['PicCounter']],250,250);
		//$Font=imageloadfont("./images/font/sector_017.ttf");
		$farbe_w = ImageColorAllocate ($Pic, 255, 255, 255);
		$farbe_b = ImageColorAllocate ($Pic, 0, 0, 0);

		ImageString($Pic,5, mt_rand(120,160),  mt_rand(50,90), $_SESSION['Captcha'][0], $farbe_b);
		ImageString($Pic, 5,  mt_rand(165,175),  mt_rand(125,150), $_SESSION['Captcha'][1], $farbe_b);
		ImageString($Pic, 5,  mt_rand(120,150),  mt_rand(190,220), $_SESSION['Captcha'][2], $farbe_b);
		ImageString($Pic, 5,  mt_rand(60,100),  mt_rand(170,210), $_SESSION['Captcha'][3], $farbe_b);
		ImageString($Pic, 5,  mt_rand(60,100), mt_rand(100,140), $_SESSION['Captcha'][4], $farbe_b);	

		header ("Content-type: image/png");
		ImagePNG ($Pic);
		ImageDestroy ($Pic);
		
		
		
		/*header ("Content-type: image/png");
		$mein_bild = ImageCreate (300, 150);
		$blau = ImageColorAllocate ($mein_bild, 21, 0, 177);
		$gruen = ImageColorAllocate ($mein_bild, 50,148,0);
		$rot = ImageColorAllocate ($mein_bild, 255,0,25);
		$hellblau = ImageColorAllocate ($mein_bild,0,255,242);
		imageFilledRectangle($mein_bild,20,20,280,130,$blau);
		imagearc($mein_bild,150,75,50,50,0,360,$rot);
		imageline($mein_bild,0,0,300,150,$hellblau);
		imagedashedline($mein_bild,0,150,300,0,$hellblau);
		$polygon_werte=array(20,130,50,110,70,90,90,50,110,100,120,150);
		imagepolygon($mein_bild,$polygon_werte,6,$hellblau);
		ImageString ($mein_bild, 10, 22, 5, "Was würde Picasso dazu sagen", $gruen);
		ImagePNG ($mein_bild);*/
		
		
		
		return false;
		
		
		
		
		
		
		
	}
	
	
	
	
	
	/**
	 * registriert neue benutzer im system
	 *
	 * @return void This is the return value description
	 *
	 */
	public function registerNewUser()
	{
		$Request= new Request();
		$Server=$Request->getAsInt("i_Server");
		$Controler_Main= Controler_Main::getInstance();
		$Controler_Main->setDataBaseId($Server);
		$ErrorString="";
		if(strlen($Request->getAsString("tb_Name"))<3){$ErrorString.=":T_REGISTER_ERROR1: <br />";}
		if(strlen($Request->getAsString("tb_Pass"))<5){$ErrorString.=":T_REGISTER_ERROR2: <br />";}
		if(strlen($Request->getAsString("tb_Pass"))===$Request->getAsString("tb_PassConfirme")){$ErrorString.=":T_REGISTER_ERROR3:<br />";}
		$UserFinder= new UserFinder();
		if(strlen($Request->getAsString("tb_Mail"))>3)
		{
			$User=$UserFinder->findByMail($Request->getAsString("tb_Mail"));
			if($User->getId()!=0)
			{
				$ErrorString.=":T_REGISTER_ERROR4: <br />";
			}
		}else
		{
			$ErrorString.=":T_REGISTER_ERROR5: <br />";
		}	
		if(strlen($Request->getAsString("tb_Mail"))===$Request->getAsString("tb_MailConfirme")){$ErrorString.=":T_REGISTER_ERROR6:<br />";}
		if(strlen($Request->getAsString("tb_Name")))
		{
			$User=$UserFinder->findByName($Request->getAsString("tb_Name"));
			if($User->getId()!=0){$ErrorString.=":T_REGISTER_ERROR7: <br />";}
		}
		
		
		if(!$this->isMailCorrect($Request->getAsString("tb_Mail")))
		{
			$ErrorString.=":T_REGISTER_ERROR8: <br />";
		}	
		
		/*if(strtolower($_SESSION['Captcha'])!=(strtolower($Request->getAsString("tb_Captcha"))))
		{
			$ErrorString.=":T_REGISTER_ERROR9: <br />";
		}*/
		
		if(strlen($Request->getAsString("email")))
		{
			$ErrorString.=":T_REGISTER_ERROR9: <br />";
		}
		
		
		
		
		
		
		
		if(strlen($ErrorString)!=0)
		{
			$this->showRegister($ErrorString);
			//$this->setCaptchaCode();
			return false;
		}
		$User= new User(0,$Request->getAsString("tb_Name"),$Request->getAsString("tb_Pass"),$Request->getAsString("tb_Mail"),0,1,0,0);	
		$UserManager= new UserManager();
		$UserManager->insertUser($User);
		$User->setId($UserManager->getLastInsertId());
		
		if(!$UserManager->getLastInsertId())
		{
			$this->showRegister($ErrorString);
			return false;
		}
		
		$UserManager->insertUserToForumDataBase($User,$Server);
		//var_dump($Server);
		
		$this->setUserToMap($User);// setzt den spieler auf die karte und generiert im notfall sonnen systeme 
		// erste schiffe setzten
		$UnitManager= new UnitManager();
		$TempString1="d:0;sh:50;hh:0;b:0;bs:0";
		$TempString2="d:0;sh:0;hh:50;b:0;bs:0";
		$TempString3="d:50;sh:0;hh:0;b:0;bs:0";
		$ShipFinder= new ShipFinder();
		$Ship1=$ShipFinder->findById(3);
		$Ship2=$ShipFinder->findById(4);
		$Ship3=$ShipFinder->findById(2);	
		$TempDMG1=$Ship1->getDMG()*50;
		$TempDMG2=$Ship2->getDMG()*50;
		$TempDMG3=$Ship3->getDMG()*50;
		$Storage1=$Ship1->getStorage()*50;
		$Storage2=$Ship2->getStorage()*50;
		$Storage3=$Ship3->getStorage()*50;
		$Healts1=$Ship1->getHealth()*50;
		$Healts2=$Ship2->getHealth()*50;
		$Healts3=$Ship3->getHealth()*50;
		$Stored="t:500;m:0;b:0;c:0;";
		$PlanetFinder = new PlanetFinder();
		$Planet = $PlanetFinder->findByUserId($User->getId())->getByIndex(0);
		$X = mt_rand($Planet->getX()-50, $Planet->getX()+50);
		$Y = mt_rand($Planet->getY()-50, $Planet->getY()+50);
		$NewUnit1= new Unit(0,"Hunter",$TempString1,$TempDMG1,$Ship1->getAmor(),$Ship1->getSpeed(),$Healts1,$User,0,0,$X,$Y,1,$Storage1,$Stored,0,0,new Task());
		$UnitManager->insertUnit($NewUnit1);
		$X = mt_rand($Planet->getX()-50, $Planet->getX()+50);
		$Y = mt_rand($Planet->getY()-50, $Planet->getY()+50);
		$NewUnit2= new Unit(0,"Heavy Hunter",$TempString2,$TempDMG2,$Ship2->getAmor(),$Ship2->getSpeed(),$Healts2,$User,20,0,$X,$Y,1,$Storage2,$Stored,0,0,new Task());
		$UnitManager->insertUnit($NewUnit2);
		$X = mt_rand($Planet->getX()-50, $Planet->getX()+50);
		$Y = mt_rand($Planet->getY()-50, $Planet->getY()+50);
		$NewUnit3= new Unit(0,"Probe",$TempString3,$TempDMG3,$Ship3->getAmor(),$Ship3->getSpeed(),$Healts3,$User,10,0,$X,$Y,1,$Storage3,$Stored,0,0,new Task());
		$UnitManager->insertUnit($NewUnit3);	


		// STATS anlegen
		$Statsmanger = new StatsManager();
		$Statsmanger->createStats($User);
		
		
		//$this->showLogin();
		
		// wenn von einem freund geworben dann dem werber ein level schenken
		if($_SESSION['FriendID'])  // wenn der Spieler (neuer Spieler) von einem anderen spieler (werber) geworben wurde die Id des Werbers
		{
			// User ziehen 
			// ein Level schencken
			$Friend=$UserFinder->findById($_SESSION['FriendID']);
			$EXP=$Friend->getExpForNextLevel()+1;
			//$Friend->addExperience($EXP);
			$UserManager->addExperiance($Friend->getId(),$EXP);
			$UserManager->updateUserCredits($Friend->getCredits()+USER_FRIEND_UINVTE_CREDITS,$Friend->getId());// dem werbenten freund 100k Credits gut schreiben
			//$UserManager->updateFriendID($User->getId(),$Friend->getId());
			// nachrichten verschicken an den werber das er ein Level bekommen hat und ein Level geschenkt bekommen hat
			$Controler_Message= new Controler_Message();
			$Controler_Message->sendMessage("","Administrator","Spieler: ".$Friend->getName().", Mail: ".$Friend->getMail()." hat Credits und Level erhalten  -  Server: ".$_SESSION['DataBase'],"Neuer User geworben");
			$Controler_Message->sendMessage("System",  $Friend->getName(),":T_REGISTER_MSG1_PART1: ".$User->getName()." :T_REGISTER_MSG1_PART2:",":T_REGISTER_MSG1_PART3:");	
		}
		
		
		// Willkommensnachricht
		$Controler_Message= new Controler_Message();
		$Controler_Message->sendMessage("","Administrator","Spieler: ".$User->getName().", Mail: ".$User->getMail()." hat sich angemeldet  -  Server: ".$_SESSION['DataBase'],"Neuer User");

		$Controler_Message->sendMessage("System",  $User->getName(),":T_REGISTER_MSG1_PART4:",":T_REGISTER_MSG1_PART5:");
		
		//$this->addPlanets();// fügt planeten auf die karte
		$this->userLogin();
	}
	
	
	/**
	 * setzt den spieler auf die karte oder erzeugt ein nes sonnen system
	 *
	 * @return void 
	 *
	 */
	public function setUserToMap(User $User)
	{
		// leeren planeten suchen
		$PlanetFinder= new PlanetFinder();
		$PlanetManager= new PlanetManager();
		$PlanetCollection=$PlanetFinder->findEmptyPlanetByRange(PLANET_NEW_USER_RANGE);
		if($PlanetCollection->getCount()>0)// wenn es einen leeren planeten gibt 
		{ // den User in einen planeten setzen
			
			$UserPlanet=$PlanetCollection->getByIndex(0);
			$BuildingManager= new BuildingManager();
			$BuildingManager->addHQ($UserPlanet->getId());
			$BuildingManager->addMetallMine($UserPlanet->getId());
			$BuildingManager->addTown($UserPlanet->getId());
			$BuildingManager->addPlantation($UserPlanet->getId());
			$PlanetManager->setUserToPlanet($UserPlanet,$User);
			$PlanetManager->updateRefeshTime($UserPlanet);
			$PlanetManager->updatePeople($UserPlanet,PLANET_START_PEOPLE);
			
		}else
		{
			// es gibt undbesidelte planeten mit dem angegeben abstand 
			// dem User den Planeten geben
			$MapObjectFinder= new MapObjectFinder();
			$KorrdArry= $MapObjectFinder->findFallesAway();// wenn es noch keine planeten gibt 
			
			if(!$KorrdArry)
			{	 // das erste sonnen system erstellen in der mitte 
				$PlanetSystem = new PlanetSystem();
				$PlanetSystem->generateSystem(100000,100000);
			}else
			{
				// alpha Neu berechnen
				if($KorrdArry['i_X']!=100000 || $KorrdArry['i_Y']!=100000)
				{
					$RangeOld=$KorrdArry['MaxRange']; //c
					$SystemRange=6500; //a
					$Range=sqrt(pow($RangeOld,2)+pow($SystemRange,2));
					$NewAlpha=asin(6500/$Range)*(360/2*pi());
				}else
				{
					$NewAlpha=50;
					$Range=6500;
				}
				$NewX=$Range*cos($NewAlpha)+100000;
				$NewY=$Range*sin($NewAlpha)+100000;
				$PlanetSystem = new PlanetSystem();
				$PlanetSystem->generateSystem($NewX,$NewY);
			}
			// Planeten system eintragen
			$PlanetenManager= new PlanetManager();
			$PlanetenManager->inserPlanetSystem($PlanetSystem);
			// einen leeren planeten finden
			
			$UserPlanet=$PlanetCollection=$PlanetFinder->findEmptyPlanetByRange(PLANET_NEW_USER_RANGE)->getByIndex(0);
			$BuildingManager= new BuildingManager();
			$BuildingManager->addHQ($UserPlanet->getId());
			$BuildingManager->addMetallMine($UserPlanet->getId());
			$BuildingManager->addTown($UserPlanet->getId());
			$BuildingManager->addPlantation($UserPlanet->getId());
			$PlanetManager->setUserToPlanet($UserPlanet,$User);
		}
		
		
		
	}
	
	
	/**
	 * fügt dem Spiel neue unbewohnte planeten hinzu
	 *
	 * @return void 
	 *
	 */
	public function addPlanets()
	{
		for($i=1;$i<=NEW_PLANETS_PER_PLAYER;$i++)
		{
			$PlanetControler= new Controler_Planet(); 
			$Planet=$PlanetControler->getRandomPlanet();
			$PlanetManager= new PlanetManager();
			$PlanetManager->insertPlanet($Planet);
			$PlanetId=$PlanetManager->getLastInsertId();
			$BuildingManager= new BuildingManager();
			$BuildingManager->addHQ($PlanetId);
			$BuildingManager->addMetallMine($PlanetId);
			$BuildingManager->addTown($PlanetId);
			$BuildingManager->addPlantation($PlanetId);
		}
		
	}
	
	/**
	 * prüft ob die eingegebene Mail im filter ist wenn ja wird false zurück gegeben
	 *
	 * @return bool This is the return value description
	 *
	 */
	public function isMailCorrect($Mail)
	{
		$MailArray=explode(",",EMAIL_FILTER);
		
		foreach($MailArray as $Filter)
		{
			if(strpos($Mail,$Filter)>0 || strpos($Mail,$Filter)===0)
			{
				return false;
			}
		}		
		return true;
	}
	
	
	public function showLogin()
	{
		
		$Request= new Request();
		$Controler_Main= Controler_Main::getInstance();
		$Controler_Main->setDataBaseId(1);
		$UserFinder= new UserFinder();
		//$UserCount= $UserFinder->countAllUsers();
		
		$UserOnlineCount=0;
		$UserOnlineCount+= $UserFinder->countAllOnlineUsers();// das erst universum 
		
		Controler_Main::getInstance()->setDataBaseId(2);#
		MySqldb::getInstance()->close();// die bereits exsistieren db verbindgun schliessen
		$UserFinder= new UserFinder();
		$UserOnlineCount+= $UserFinder->countAllOnlineUsers();// vom 2ten server die spieler holen
		
		/*$PlanetFinder= new PlanetFinder();
		$PlanetCount=  $PlanetFinder->countPlanets();
		$UnitFinder= new UnitFinder();
		$UnitCount= $UnitFinder->countUnits();
		$Battles= $UnitFinder->countBattles();*/
		
		
		
		if($Request->getAsInt("Ref"))  // wenn der Spieler (neuer Spieler) von einem anderen spieler (werber) geworben wurde die Id des Werbers
		{
			$_SESSION['FriendID']=$Request->getAsInt("Ref");
			$this->showBenefit();
			return true;
		}
		$TempLate=Template::getInstance("tpl_Login.php"); 
		$TempLate->assign("OnlinePlayer",$UserOnlineCount);
		/*$TempLate->assign("Player",$UserCount);
		
		$TempLate->assign("Planets",$PlanetCount);
		$TempLate->assign("Units",$UnitCount);
		$TempLate->assign("Battles",$Battles);*/
		
		if($_COOKIE['LoginName'])
		{
			$TempLate->assign("LoginName",$_COOKIE['LoginName']);
		}
		
		$TempLate->render();
		
	}
	
	
	
	public function showBenefit()
	{
		$Request= new Request();
		//echo "1";
		$ServerID=$Request->getAsInt("S");
		Controler_Main::getInstance()->setDataBaseId($ServerID);#
		MySqldb::getInstance()->close();// die bereits exsistieren db verbindgun schliessen
		if($ServerID>0 && $ServerID<=2)
		{
			require("./cfg/db".$ServerID.".php");// db setzen	
		}
		//echo "2";
		$UserFinder= new UserFinder();
		$UserManager= new UserManager();
		$User=$UserFinder->findById($Request->getAsInt("Ref"));
		$MessageControler= new Controler_Message();
		//echo "3";
		$IviteFinder= new InviteFinder();
		//echo "3";
		$Invite=$IviteFinder->findByTypeAndUserAndTempAndToday(IVENTCONSTANTS::BENEFIT_IP,$User,$_SERVER['REMOTE_ADDR']);
		//echo "3";
		//var_dump($Invite);
		//var_dump($User);
		$ICount=$IviteFinder->countByUser($User);
		if($Invite->getId() || $ICount > 50)// die ip abfrage ob diesem user von der ip schon gespennet wurden ist
		{
			$Request->setPost("Ref","");
			//echo "4";
			$this->showLogin();
			//echo "5";
			return false;	
		}
		$InviteManager= new InviteManager();
		$InviteManager->addInvite($User,IVENTCONSTANTS::BENEFIT_IP,$_SERVER['REMOTE_ADDR']);
		//echo "3";
		if($User->getLevel() > 10)
		{
			$Exp=0;
		} else
		{
			$Exp=mt_rand(200,500);
		}
		$Crediits=mt_rand(200,500);

		//echo "4";
		$TempLate=Template::getInstance("tpl_Benefit.php"); 
		if(!$_SESSION['IsBenefit'])
		{
			$UserManager->addExperiance($User->getId(),$Exp);
			$UserManager->updateUserCredits($Crediits+$User->getCredits(),$User->getId());
			$TempLate->assign("CanBenefit",true);
			$MessageControler->sendBenefitToPlayer($User,$Exp,$Crediits);
		}
		$TempLate->assign("User",$User);
		$TempLate->assign("Exp",$Exp);
		$TempLate->assign("Crediits",$Crediits);
		//echo "5";
		$TempLate->render();
		$_SESSION['IsBenefit']=true;
		return true;
	}
	
	
	
	
	
	public function userLogin()
	{
		$Request= new Request();
		$Server=$Request->getAsInt("i_Server");
		
		if($Server<=0)
		{
			$this->showLogin();
			return false;
		}
		
		$Controler_Main= Controler_Main::getInstance();
		$Controler_Main->setDataBaseId($Server);
		
		if($_SESSION['BadLogin']==5)
		{
			$this->showLogin();
			return false;
		}
		
		$UserFinder= new UserFinder();
		$User=$UserFinder->findByNameAndPass($Request->getAsString("tb_Name"),md5($Request->getAsString("tb_Pass")));
		if ($User->getId()==0)
		{
			$this->showLogin();
			if(!$_SESSION['BadLogin'])
			{
				$_SESSION['BadLogin']=1;
			}else
			{
				$_SESSION['BadLogin']++;
			}
			return false;	
		}
		$_SESSION['UserId']=$User->getId();
		$_SESSION['UserName']=$Request->getAsString("tb_Name");
		$_SESSION['UserPass']=md5($Request->getAsString("tb_Pass"));
		$_SESSION['DataBase']=$Request->getAsInt("i_Server");
		
		if($Request->getAsInt("ResX")<SYSTEM_RES_X_MIN || $Request->getAsInt("ResY")<SYSTEM_RES_Y_MIN)
		{
			$_SESSION['ResX']=SYSTEM_RES_X_MIN;
			$_SESSION['ResY']=SYSTEM_RES_Y_MIN;
		}else
		{
			$_SESSION['ResX']=$Request->getAsInt("ResX");
			$_SESSION['ResY']=$Request->getAsInt("ResY");
		}
		
		if($User->getLooked())
		{	  // der User ist gesperrt und darf sich nicht einloggen
			$TempLate=Template::getInstance("tpl_Login.php"); 
			$TempLate->renderError("Fehler",":T_LOGIN_ERROR1:","index.php");
			return false;
		}
		setcookie("LoginName", $User->getName(), time()+3600*24*30);// cookie für den Loginnamen setzen auf 30 tage maximal länge gesetzt
		
		Controler_Main::getInstance()->setUser($User);
		$UserManager= new UserManager();
		$UserManager->updateLoginTime($User->getId());
		
		
		$PlanetControler=new Controler_Planet();

		Controler_Main::getInstance()->updateControler();
		if($User->getName() == "TestAccount")
		{
			$PlanetFinder = new PlanetFinder();
			$Planet = $PlanetFinder->findByUserId($User->getId())->getByIndex(0);
			$UserManager = new UserManager();
			$UserManager->setRefreshTimeAndCredits($User->getId(), 10000);
			$Planetmanager = new PlanetManager();
			$Planetmanager->addMetal($Planet,10000);
			$Planetmanager->addCristal($Planet,10000);
			$Planetmanager->addHydrogen($Planet,10000);
			$Planetmanager->addBioMass($Planet,10000);
			$UnitManager= new UnitManager();
			$UnitFinder=new UnitFinder();
			$UnitCollection=$UnitFinder->findByUserId($User->getId());
			foreach($UnitCollection as $DeleteThis)
			{
				$UnitManager->deleteUnit($DeleteThis);	
			}
			$NewUnit= new Unit(0,"Testflotte","d:0;sh:50;hh:0;b:0;bs:0",1250,50,125,7500,$User,0,0,$Planet->getX(),$Planet->getY(),1,2500,"",0,0,new Task());
			$UnitManager->insertUnit($NewUnit);
			
		}
		Controler_Main::getInstance()->addPermanentOutPut();
		$PlanetControler->showPlanet();
	}
	
	
	
	public function userLogout()
	{
		$UserManager= new UserManager();
		$User=Controler_Main::getInstance()->getUser();
		if($_SESSION['UserId'])
		{
			$UserManager->settLoginTimeNULL($_SESSION['UserId']);
		}
		$_SESSION['UserId']="";
		unset($_SESSION['DataBase']);	// server vari entfernen
		@session_destroy();
		$TempLate=Template::getInstance("tpl_Quote.php");
		if($User->getPremiumUser()==0)
		{
			$TempLate->assign("AdView",true);
		} 
		
		$QuoteFinder = new QuoteFinder();
		$TempLate->assign("Quote",$QuoteFinder->findOne());
		$TempLate->render();
	}
}

?>