<?php

class Controler_Allianz
{
	
	
	public function start()
	{
		$Request= new Request();
		switch($Request->getAsString("Action"))
		{
			
			case "ShowDeleteUser":
			{
				$this->showDeleteUser();
			}  break;	
			
			case "DeleteRank":
			{
				$this->deleteRank();
			}  break;
				
			case "AddRank":
			{
				$this->addRank();
			}  break;
			
			case "DeleteUser":
			{
				$this->deleteUser();
			}  break;
			
			
			 case "ShowForeignAllianz":
			{
				$this->showForeignAllianz();
			}break;
			
			
			case "AllianzWorkOn":
			{
				$this->allianzWorkOn();
			}break;
			
			case "ShowAllianzWorkOn":
			{
				$this->showAllianzWorkOn();
			}break;
			
			case "ShowMember":
			{
				$this->showMember();
			}break;
			
			case "CreateAllianz":
			{
				$this->createAllianz();
			}break;
			
			case "ShowCreateAllianz":
			{
				$this->showCreateAllianz();
			}break;
				
			case "AllianzMemberWorkOn":
			{
				$this->allianzMemberWorkOn();
			}break;
			
			case "AllianzKickMember":
			{
				$this->allianzKickMember();
			}break;
			
			case "ShowAllianzMemberWorkOn":
			{
				$this->showAllianzMemberWorkOn();
			}break;
				
			case "SendAllianzInvite":
			{
				$this->sendAllianzInvite();
			}break;	
				
			case "AllianzInvite":
			{
				$this->allianzInvite();
			}break;	
			
			
			case "ShowCreateTopic":
			{
				$this->showCreateTopic();
			}break;	
			case "CreateTopic":
			{
				$this->createTopic();
			}break;		
			
			case "ShowTopic":
			{
				$this->showTopic();
			}break;
			
				
			case "AddComment":
			{
				$this->addComment();
			}break;	
			
			
			case "DeleteTopic":
			{
				$this->deleteTopic();
			}break;	
			
			default:
				$this->showAllianz();
		}
		
	}
	
	
	
	public function deleteUser()
	{
		$ReQuest= new Request();
		$User= Controler_Main::getInstance()->getUser(); 
		$MessageControler= new Controler_Message();
		if($ReQuest->getAsString("s_Delete")=="Austreten" || $ReQuest->getAsString("s_Delete")=="leave")
		{
			$AllianzFinder= new AllianzFinder();
			$Allianz=$AllianzFinder->findByUser($User)->getByIndex(0);
			$AllianzManager= new AllianzManager();
			$AllianzManager->deleteMember($User->getId());
			if($Allianz->getUserCount()<=1)
			{// der letzte User also muss die allianz gelöscht werden
				$AllianzManager->deleteAllianz($Allianz);
			}
			$Members=$Allianz->getUserCollection();
			$MessageControler->sendAllianzMemberFaint($User,$Members);
			
		}
		$this->showAllianz();
	}
	
	public function showDeleteUser()
	{
		$TempLate=Template::getInstance("tpl_AllianzDeleteUser.php");
		$User= Controler_Main::getInstance()->getUser(); 
		$TempLate->assign("MyUser",$User);
		$TempLate->render();
	}
	
	public function deleteRank()
	{
		$ReQuest= new Request();
		$Name=$ReQuest->getAsString("cb_Ranks");
		if($Name == "")
			$this->showAllianzMemberWorkOn();
		$User= Controler_Main::getInstance()->getUser();
		$AllianzFinder= new AllianzFinder();
		$Allianz=$AllianzFinder->findByUser($User)->getByIndex(0);
		$AllianzManager = new AllianzManager();
		$AllianzManager->deleteRankByNameAndAllianz($Name, $Allianz->getId());
		$this->showAllianzMemberWorkOn();
	}
	
	public function addRank()
	{
		$ReQuest= new Request();
		$Name=$ReQuest->getAsString("tb_NewRank");
		if($Name == "")
			$this->showAllianzMemberWorkOn();
		$User= Controler_Main::getInstance()->getUser();
		$AllianzFinder= new AllianzFinder();
		$Allianz=$AllianzFinder->findByUser($User)->getByIndex(0);
		$Rank = new AllianzRank($Name, $Allianz->getId());
		$AllianzManager = new AllianzManager();
		$AllianzManager->addAllianzRank($Rank);
		$this->showAllianzMemberWorkOn();
	}
	
	 
	/**
	 *  zeigt eine fremde allianz an
	 *
	 * @return void 
	 *
	 */
	public function showForeignAllianz()
	{
		$Request= new Request();
		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		if(strlen($Request->getAsString("s_Name"))<=0)
		{
			$this->showAllianz();
			return false;
		}
		$Allianz=   $AllianzFinder->findByName($Request->getAsString("s_Name"))->getByIndex(0);
		
		if($Allianz->getId()==0)
		{
			$this->showAllianz();
			return false;
		}
		
		
		$TempLate=Template::getInstance("tpl_AllianzForeigen.php");
		$TempLate->assign("Allianz",$Allianz);
		$TempLate->render();
	}
	
	
	public function allianzWorkOn()
	{
		$Request= new Request();
		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);

		$FilePath="images/allianz/";
		$PictureString=$FilePath.$Allianz->getName()."_".$_FILES['s_Picture']['name'];
		if($Allianz->getName()."_".$_FILES['s_Picture']['name']!=$Allianz->getPictureString() && $_FILES['s_Picture'] && strlen($_FILES['s_Picture']['name'])>0)
		{
			$SizeCheck=false;
			$Size = filesize($_FILES['s_Picture']['tmp_name']);
			if($Size<1024*1024*1024) // abfrage wie groß das bild ist
			{
				$SizeCheck=true;
			}
			if ($_FILES['s_Picture']['type']=="image/png" || $_FILES['s_Picture']['type']=="image/jpeg" || $_FILES['s_Picture']['type']=="image/gif" || $Size) 
			{
				//ini_set("upload_tmp_dir","/home/FinalEnd/tmp/");
				//var_dump($_FILES['s_Picture']);
				move_uploaded_file($_FILES['s_Picture']['tmp_name'], $FilePath.$Allianz->getName()."_".$_FILES['s_Picture']['name']);// orginal speichern
				chmod($_SERVER['DOCUMENT_ROOT']."/".$FilePath.$Allianz->getName()."_".$_FILES['s_Picture']['name'],644);   // recht setzen
				$Allianz->setPictureString($FilePath.$Allianz->getName()."_".$_FILES['s_Picture']['name']);
			}
		}
		
		$Allianz->setDescription($Request->getAsString("tb_Description"));
		$AllianzManager= new AllianzManager();
		$AllianzManager->updateAllianz($Allianz);
		$TempLate=Template::getInstance("tpl_AllianzWorkOn.php");
		$this->showAllianz();
	}
	
	

	public function showAllianzWorkOn()
	{
		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		$TempLate=Template::getInstance("tpl_AllianzWorkOn.php");
		$TempLate->assign("Allianz",$Allianz);
		$TempLate->render();
	}
	
	
	public function showMember()
	{
		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		
		$TempLate=Template::getInstance("tpl_AllianzShowUser.php");
		$TempLate->assign("Allianz",$Allianz);
		$TempLate->assign("Ranks",$AllianzRanks);
		$TempLate->assign("UserCollection",$Allianz->getUserCollection());
		$AllianUserCollection=$Allianz->getUserCollection();
		$TempLate->render();
	}
	
	
	public function deleteTopic()
	{
		if(!$this->checkForAllianz())
		{
			return false;	
		}
		$Request= new Request();
		$TopicId=	$Request->getAsInt("TId");

		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		$AllianzTopicfinder= new AllianzTopicFinder();
		$Topic=$AllianzTopicfinder->findById($TopicId);
		if($Topic->getAllianzId()!=$User->getAllianzId())
		{
			$this->showNoAllianz();
			return false;	
		}
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		$AllianUserCollection=$Allianz->getUserCollection();
		if(!$AllianUserCollection->isAllianzAdmin($User->getId()))
		{

			$this->showAllianz();
			// darf nicht 
			return false;
		}
		
		 // Topic entfernen
		$TopicManager= new AllianzTopicManager();
		$TopicManager->deleteById($TopicId);
		
		
		$this->showAllianz();

	}
	
	
	public function addComment()
	{
		if(!$this->checkForAllianz())
		{
			return false;	
		}
		$Request= new Request();
		$TopicId=	$Request->getAsInt("TId");
		$Comment=	$Request->getAsString("tb_Content");
		$AllianzFinder= new AllianzFinder();
		$MessageControler= new Controler_Message();
		$User= Controler_Main::getInstance()->getUser();
		$AllianzTopicfinder= new AllianzTopicFinder();
		$Topic=$AllianzTopicfinder->findById($TopicId);
		$MessageControler= new Controler_Message();
		if($Topic->getAllianzId()!=$User->getAllianzId())
		{
			$this->showNoAllianz();
			return false;	
		}
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		$AllianzCommentManager= new AllianzCommentManager();
		$AllianzCommentManager->addComment(new AllianzComment(0,$Comment,$User,""),$Topic->getId());
		$Topic=$AllianzTopicfinder->findById($TopicId);
		$Members=$Allianz->getUserCollection();
		$MessageControler->sendAllianzTopicReply($User,$Topic,$Members);
		Controler_Event::getInstance()->addEvent(new AllianzTopicAnswerEvent($User));
		$TempLate=Template::getInstance("tpl_AllianzTopic.php");
		$TempLate->assign("Topic",$Topic);
		$TempLate->render();

	}
	
	
	public function showTopic()
	{
		if(!$this->checkForAllianz())
		{
			return false;	
		}
		$Request= new Request();
		$TopicId=	$Request->getAsInt("TId");
		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		$AllianzTopicfinder= new AllianzTopicFinder();
		$Topic=$AllianzTopicfinder->findById($TopicId);

		if($Topic->getAllianzId()!=$User->getAllianzId())
		{
			$this->showNoAllianz();
			return false;	
		}
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		$AllianUserCollection=$Allianz->getUserCollection();
		$TempLate=Template::getInstance("tpl_AllianzTopic.php");
		if($AllianUserCollection->isAllianzAdmin($User->getId()))
		{
			$TempLate->assign("IsAdmin",true);
		}
		
		$TempLate->assign("Topic",$Topic);
		$TempLate->render();

	}
	
	
	/**
	 * prüft ob der eingeloggte User eine allianz hat oder nicht wenn nicht wird false zurück gegeben und showNoAllianz ausgeführt
	 *
	 * @return bool 
	 *
	 */
	public function checkForAllianz()
	{
		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		if($Allianz->getId()==0)
		{
			$this->showNoAllianz();
			return false;	
		}
		return true;
		
	}
	
	
	/**
	 * erstellt themas innerhalb einer allianz
	 *
	 * @return void 
	 *
	 */
	public function createTopic()
	{
		if(!$this->checkForAllianz())
		{
			return false;	
		}
		$MessageControler= new Controler_Message();
		$Request= new Request();
		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		$AllianzCommentCollection=new AllianzCommentCollection();
		$AllianzCommentCollection->add(new AllianzComment(0,$Request->getAsString("tb_Content"),$User,""));
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		$Topic= new AllianzTopic(0,$Request->getAsString("tb_Name"),$User,"",$AllianzCommentCollection ,$Allianz->getId());
		$AllianzTopicManager= new AllianzTopicManager();
		$AllianzTopicManager->addAllianzTopic($Topic);
		$Members=$Allianz->getUserCollection();
		$MessageControler->sendAllianzTopicCreate($User,$Topic,$Members);
		Controler_Event::getInstance()->addEvent(new AllianzTopicCreateEvent($User));
		$this->showAllianz();
	}
	
	public function showCreateTopic()
	{
		if(!$this->checkForAllianz())
		{
			return false;	
		}
		$TempLate=Template::getInstance("tpl_AllianzAddTopic.php");
		$TempLate->render();
	}
	
	
	
	public function allianzInvite()
	{
		$Request= new Request();
		$User= Controler_Main::getInstance()->getUser();
		$MessageControler= new Controler_Message();
		$AllianzManager= new AllianzManager();
		$AllianzManager->doInvite($User);
		$AllianzFinder= new AllianzFinder();
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		$Members=$Allianz->getUserCollection();
		$MessageControler->sendAllianzNewMember($User,$Members);
		
		$this->showAllianz();
	}
	
	public function sendAllianzInvite()
	{
		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		$AllianUserCollection=$Allianz->getUserCollection();
		if(!$AllianUserCollection->isAllianzAdmin($User->getId()))
		{
			$this->showAllianz();
			return false;
		}
		$Request= new Request();
		$TempLate=Template::getInstance("tpl_Allianz.php");
		$UserFinder= new UserFinder();
		$UserToInvite=$UserFinder->findByName($Request->getAsString("tb_UserName"));
		if($UserToInvite->getId()==0)
		{
			$TempLate->assign("Message", ":T_ALLIANZ_PLAYER: <br />");
			$this->showAllianzMemberWorkOn();
			return false;
		}
		$TempLate->assign("Message",":T_ALLIANZ_INVITESEND:<br />");
		$AllianzManager= new AllianzManager();
		$AllianzManager->addInvite($UserToInvite->getId(),$User->getAllianzId());
		$AllianzManager->deleteOldInvites(); // entfernt allte allianz einladungen
		$Controler_Message= new Controler_Message();
		$Controler_Message->sendMessage($User->getName(),
			$UserToInvite->getName(),$User->getName()." :T_MSG_ALLIANZ_INVITE_PART1: ".$User->getAllianzName()." :T_MSG_ALLIANZ_INVITE_PART2: <a href=\"index.php?Section=Allianz&amp;Action=AllianzInvite\">:T_MSG_ALLIANZ_INVITE_PART3:</a>",
			":T_MSG_ALLIANZ_INVITE_HEADER:");
		
		
		$this->showAllianzMemberWorkOn();
	}
	
	
	public function allianzMemberWorkOn()
	{
		$AllianzFinder= new AllianzFinder();
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		$AllianUserCollection=$Allianz->getUserCollection();
		if(!$AllianUserCollection->isAllianzAdmin($User->getId()))
		{
			$this->showAllianz();
			return false;
		}
		$AllianzManager= new AllianzManager();
		$AllianzManager->setMemberState($Request->getAsInt("UserId"),$Request->getAsString("cb_MemberstateState"));
		$AllianzManager->deleteRankByUser($Request->getAsInt("UserId"));
		$Rank = $AllianzFinder->findRanksByNameAndAllianz($Request->getAsString("cb_Rank"),$Allianz->getId());
		$AllianzManager->addRankToUser($Rank, $Request->getAsInt("UserId"));
		$this->showAllianzMemberWorkOn();
	}
	
	public function allianzKickMember()
	{
		$AllianzFinder= new AllianzFinder();
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		$AllianUserCollection=$Allianz->getUserCollection();
		if(!$AllianUserCollection->isAllianzAdmin($User->getId()))
		{
			$this->showAllianz();
			return false;
		}
		$AllianzManager= new AllianzManager();
		$AllianzManager->deleteMember($Request->getAsInt("UserId"));
		if($Allianz->getUserCount()<=1)
		{// der letzte User also muss die allianz gelöscht werden
			$AllianzManager->deleteAllianz($Allianz);
		}
		$this->showAllianzMemberWorkOn();
	}
	
	 public function showAllianzMemberWorkOn()
	{
		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		$TempLate=Template::getInstance("tpl_AllianzMemberManagment.php");
		$TempLate->assign("Allianz",$Allianz);
		$AllianzRanks = $AllianzFinder->findRanksByAllianz($Allianz->getId());
		$OwnRank=$AllianzFinder->findRankByUser($User->getId());
		$TempLate->assign("Own",$OwnRank);
		$TempLate->assign("Ranks",$AllianzRanks);
		$TempLate->assign("UserCollection",$Allianz->getUserCollection());
		$AllianUserCollection=$Allianz->getUserCollection();
		if(!$AllianUserCollection->isAllianzAdmin($User->getId()))
		{
			$this->showAllianz();
			return false;
		}
		$TempLate->render();
	}




	
	public function showAllianz()
	{
		$AllianzFinder= new AllianzFinder();
		$User= Controler_Main::getInstance()->getUser();
		$Allianz=   $AllianzFinder->findByUser($User)->getByIndex(0);
		if($Allianz->getId()==0)
		{
			$this->showNoAllianz();
			return true;	
		}
		$TempLate=Template::getInstance("tpl_Allianz.php");
		$TempLate->assign("Allianz",$Allianz);
		$AllianUserCollection=$Allianz->getUserCollection();
		if($AllianUserCollection->isAllianzAdmin($User->getId()))
		{
			$TempLate->assign("IsAdmin",true);
		}
		$TempLate->render();
	}
	
	public function showNoAllianz()
	{
		$Request= new Request();
		$AllianzFinder= new AllianzFinder();
		$AllianzCollection=$AllianzFinder->findByName($Request->getAsString("s_Name"));
		$TempLate=Template::getInstance("tpl_AllianzNoAllianz.php");
		$TempLate->assign("AllianzCollection",$AllianzCollection);
		$TempLate->render();
	}
	
	
	
	
	public  function showCreateAllianz()
	{
		$TempLate=Template::getInstance("tpl_AllianzCreate.php");
		$TempLate->render();
	}
	
	public  function createAllianz()
	{
		$Request= new Request();
		$AllianzFinder= new AllianzFinder();
		$Allianz=$AllianzFinder->findByName($Request->getAsString("tb_Name"));
		if(strlen($Request->getAsString("tb_Name"))<3 || $Allianz->getByIndex(0)->getId()!=0)
		 {
			$TempLate=Template::getInstance("tpl_AllianzCreate.php");
			$TempLate->assign("Error",":T_ALLIANZ_NAMEFAIL:");
			$TempLate->render();
			return false;
		}
		
		$User= Controler_Main::getInstance()->getUser();
		$AllianzManager= new AllianzManager();
		$Allianz=new  Allianz(0,$Request->getAsString("tb_Name"),$Request->getAsString("tb_Description"),new UserCollection(),"",$User);
		$AllianzManager->addAllianz($Allianz);
		$AllianzId=$AllianzManager->getLastInsertId();
		$Allianz->setId($AllianzId);
		$AllianzManager->addUserToAllianz($Allianz,$User);
		$AllianzManager->setMemberState($User->getId(),"admin");
		$this->showAllianz();
	}
	
}


?>