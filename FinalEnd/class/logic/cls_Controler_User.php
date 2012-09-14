<?php
class Controler_User
{
	
	
	public function start()
	{
		$Request= new Request();
		$Planet= Controler_Main::getInstance()->getUser(); 	
		switch($Request->getAsString("Action"))
		{   
			case "GetBanner":
			{
				$this->getBanner();
			} break;
			
			
			case "ShowProfil":
			{
				$this->showProfil();
			} break;
			
			
			
			case "ShowChargePremiumAccount":
			{
				$this->showChargePremiumAccount();
			} break;
			
			  case "AddAFriend":
			{
				$this->addAFriend();
			} break;
			case "ShowChangePass":
			{
				$this->showChangePass();
			}  break;

			case "ChangePass":
			{
				$this->changePass();
			}  break;
			
			case "ShowSettings":
			{
				$this->showSettings();
			}  break;
			
			case "ShowChangeLog":
			{
				$this->showChangeLog();
			}  break;	
				
			case "ShowDeleteUser":
			{
				$this->showDeleteUser();
			}  break;	
			
			
			case "DeleteUser":
			{
				$this->deleteUser();
			}  break;
				
				
			case "ShowPremiumPayments":
			{
				$this->showPremiumPayments();
			}  break;
			
			case "ShowCompareStats":
			{
				$this->showCompareStats();
			}  break;
			
			case "UsePremium":
			{
				$this->usePremiumKey();
			}  break;
			
			case "UploadAvatar":
			{
				$this->uploadAvatar();
			}  break;		
				
			default:
				$this->showUserStats();
		}
		
	}

	public function usePremiumKey()
	{
		$Request = new Request();
		$Key=$Request->getAsString("s_Old");
		if ($Key != "")
		{
			$User= Controler_Main::getInstance()->getUser();
			$UserFinder= new UserFinder();
			$KeysFound = $UserFinder->checkPremiumKey($Key);

			if ($KeysFound > 0)
			{
				$UserManager=new UserManager();
				$UserManager->setPremium($User);
				$UserManager->updatePremiumKey($User, $Key);
				$Length = $UserFinder->getKeyLength($Key);
				if($Length == 0)
				  $UserManager->deletePremiumKey($Key);
			}
		}
		


		$this->showSettings();

	}

	public function uploadAvatar()
	{
		$Request= new Request();
		$User= Controler_Main::getInstance()->getUser();
		ini_set("upload_max_filesize",6291456);
		$Error=0;
		$i=0;
		do
		{
			$Name=md5(basename($Request->parse($_FILES['File']['name'])).$i);
			$Path= USER_PICTURE_PATH.$Name;
			$i++;
		}
		while(file_exists($Path));
		
		
		//$Templatte= Template::getInstance("tpl_UserProfil.php");
		$User= Controler_Main::getInstance()->getUser(); 
		//$TempLate->assign("MyUser",$User);
		//$TempLate->render();
		
		
		@list($src_width, $src_height, $src_typ) = getimagesize($_FILES['File']['tmp_name']);
		//echo "temp bild Korrekt\n";
		if(strlen($_FILES['File']['name'])==0){$Error++;}		
		//echo "Name ok\n";
		if(!$src_typ){$Error++;}	
		//echo "bild test 2 ok\n";
		if($_FILES['File']['size']>(1024*1024*10)){$Error++;}
		if(!$ErrorString && !move_uploaded_file($_FILES['File']['tmp_name'], $Path)){$Error++;}
		$this->createThumb($Path,100,100,$Path);// thumpnail erstellen
		if($Error==0)
		{
			// Das bild eintragen 
			$UserManager= new UserManager();	
			$UserManager->updatePictureString($User,$Path);
			$User->setPictureString($Path);
		}

		$this->showSettings();

	}

	private function createThumb($img_src,$img_width="100",$img_height="100",$des_src = "p/thumbs")    
	{
		// Größe und Typ ermitteln
		list($src_width, $src_height, $src_typ) = getimagesize($img_src);
		// neue Größe bestimmen
		if($src_width >= $src_height)
		{
			$new_image_width = $img_width;
			$new_image_height = $src_height * $img_width / $src_width;
		}
		if($src_width < $src_height)
		{
			$new_image_height = $img_width;
			$new_image_width = $src_width * $img_height / $src_height;
		}
		if($src_typ == 1)     // GIF
		{
			$image = imagecreatefromgif($img_src);
			$new_image = imagecreate($new_image_width, $new_image_height);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_image_width,$new_image_height, $src_width, $src_height);
			imagegif($new_image, $des_src);
			imagedestroy($image);
			imagedestroy($new_image);
			return true;
		}
		elseif($src_typ == 2) // JPG
		{
			$image = imagecreatefromjpeg($img_src);
			$new_image = imagecreatetruecolor($new_image_width, $new_image_height);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_image_width,$new_image_height, $src_width, $src_height);
			imagejpeg($new_image, $des_src);
			imagedestroy($image);
			imagedestroy($new_image);
			return true;
		}
		elseif($src_typ == 3) // PNG
		{
			$image = imagecreatefrompng($img_src);
			$new_image = imagecreatetruecolor($new_image_width, $new_image_height);
			imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_image_width,$new_image_height, $src_width, $src_height);
			imagepng($new_image, $des_src);
			imagedestroy($image);
			imagedestroy($new_image);
			return true;
		}
		else
		{
			return false;
		}
	}



	public function showProfil()
	{
		$ReQuest= new Request();
		$Templatte= Template::getInstance("tpl_UserProfil.php");
		$User= Controler_Main::getInstance()->getUser(); 
		$TempLate->assign("MyUser",$User);
		$TempLate->render();

	}
	public function getBanner()
	{
		$ReQuest= new Request();
		$User= Controler_Main::getInstance()->getUser(); 
		$ServerId=$ReQuest->getAsInt("s");
		$UserId=$ReQuest->getAsInt("u");
		// User Von der DB Laden 
		// banne rLaden 
		
		// Baner Manipulieren 
		// Bild header laden 
		// bild rausschicken




	}
	
	public function showChargePremiumAccount()
	{
		$ReQuest= new Request();
		$TempLate=Template::getInstance("tpl_PremiumChargeAccount.php");
		$User= Controler_Main::getInstance()->getUser(); 
		$TempLate->assign("MyUser",$User);
		
		switch($ReQuest->getAsInt("Packet"))
		{
			case 1:
			{
				$TempLate->assign("Packet",PREMIUM_1_MONTH_PRICE);
				}break;
			case 2:
			{
				$TempLate->assign("Packet",PREMIUM_2_MONTH_PRICE);
			}break;
			case 3:
			{
				$TempLate->assign("Packet",PREMIUM_3_MONTH_PRICE);
			}break;
		}
		
		$TempLate->render();

	}
	
	public function showPremiumPayments()
	{
		$ReQuest= new Request();
		$TempLate=Template::getInstance("tpl_PremiumPayments.php");
		$User= Controler_Main::getInstance()->getUser(); 
		$TempLate->assign("MyUser",$User);
		
		$TempLate->assign("Packet",$ReQuest->getAsInt("Packet"));
		
		$TempLate->render();

	}
	
	
	public function addAFriend()
	{
		$ReQuest= new Request();
		$TempLate=Template::getInstance("tpl_AddAFriend.php");
		$User= Controler_Main::getInstance()->getUser(); 
		$TempLate->assign("MyUser",$User);
		$TempLate->render();

	}

	public function showChangeLog()
	{
		$ReQuest= new Request();
		$TempLate=Template::getInstance("tpl_ChangeLog.php");
		$TempLate->render();

	}


	public function deleteUser()
	{
		$ReQuest= new Request();
		$User= Controler_Main::getInstance()->getUser();
		if($User->getName() == "TestAccount")
		{
			return false;
		}
		$Controler_Message = new Controler_Message();
		if($ReQuest->getAsString("s_Delete")=="LÖSCHEN" || $ReQuest->getAsString("s_Delete")=="DELETE")
		{
			$UserManager= new UserManager();
			
			$Controler_Message->sendMessage("","Administrator",":T_PLAYER_TAG: ".$User->getName()." ".$User->getMail()." :T_ERROR_USERLEFT2:  -  Server: ".$_SESSION['DataBase'],":T_ERROR_USERLEFT2_TITLE:");
			$UserManager->deleteUserById($User->getId());
			$_SESSION['UserId']="";
			@session_destroy();
			$TempLate=Template::getInstance("tpl_Quote.php");
			$QuoteFinder = new QuoteFinder();
			$TempLate->assign("Quote",$QuoteFinder->findOne());
			$TempLate->render();
		}
		$Controler= new Controler_Login();
		$Controler->showLogin();
		return true;
	}
	  
	public function showDeleteUser()
	{
		$TempLate=Template::getInstance("tpl_SettingsDeleteUser.php");
		$User= Controler_Main::getInstance()->getUser(); 
		$TempLate->assign("MyUser",$User);
		$TempLate->render();
	}
	
	public function showSettings()
	{
		$TempLate=Template::getInstance("tpl_Setings.php");
		$User= Controler_Main::getInstance()->getUser();
		if(!$User->isPremium())
		{
			$TempLate->assign("IsNotPremium",true);
		}
		$UserFinder = new UserFinder();
		$DaysValid = $UserFinder->getKeyTimeLeftInDays($User->getId());
		if($DaysValid == "")
			$DaysValid = ":T_SETUP_PREMUNLIMITED:";
		$TempLate->assign("DaysValid",$DaysValid);
		$TempLate->assign("MyUser",$User);
		$TempLate->render();
	}
	
	
	public function changePass()
	{
		$User= Controler_Main::getInstance()->getUser(); 
		$Request= new Request();
		
		$OldPass= $Request->getAsString("s_Old");
		$NewPass= $Request->getAsString("s_NewPass");
		$NewPassConfirme= $Request->getAsString("s_NewPassConfirme");
		if(md5($OldPass)!=$User->getPass())
		{
			$ErrorString=":T_PASS_FAIL:<br />";
		}
		
		if($NewPass!=$NewPassConfirme)
		{
			$ErrorString=":T_PASS_NEVERBETHESAME:<br />";
		}
		
		if(strlen($ErrorString))
		{
			$TempLate=Template::getInstance("tpl_SettingsChangePass.php");
			$TempLate->assign("Error",$ErrorString);
			$TempLate->render();
			return false;	
		}
		$UserManager= new UserManager();
		$UserManager->updateUserPass(md5($NewPassConfirme),$User->getId());
		$User->setPass(md5($NewPassConfirme));
		$UserManager->updateUserPassForum($User,$_SESSION['DataBase']);
		$TempLate=Template::getInstance("tpl_SettingsChangePass.php");
		$TempLate->assign("Error",":T_PASS_NEWSET:");
		$TempLate->render();
		
	}
	
	
	public function showChangePass()
	{
		$User= Controler_Main::getInstance()->getUser(); 	
		$TempLate=Template::getInstance("tpl_SettingsChangePass.php");
		$TempLate->render();
	}
	
	
	
	public function showUserStats()
	{
		$User= Controler_Main::getInstance()->getUser(); 
		$UnitFinder= new UnitFinder();
		$UnitCollection= $UnitFinder->findByUserId($User->getId());
		$PlanetFinder= new PlanetFinder();
		$PlanetCollection= $PlanetFinder->findByUserId($User->getId());
		$ShipControler= new Controler_Ships();
		
		$UnitFinder= new UnitFinder();
		$DMG=$UnitFinder->findDMGByUser($User);	// flotten sold wegrechnen
		if($DMG!=0)
		{
			$PayPerHour= (int) $DMG/100;
		}
		

		settype($PayPerHour,"integer");	  //den sold auf int setzen
		//$People= $PlanetFinder->countAllPeopleByUser($User);	
//		$PlanetCollection=Controler_Main::getInstance()->getPlanetCollection();
		$People=$PlanetCollection->getPeopleCountFormatet();
		$CreditsPerHour=(int)$PlanetFinder->findCreditsByUser($User);

		
		$MaxCredits=$User->getLevel()* CREDITS_PER_LEVEL;
		
		$MaxCredits=number_format($MaxCredits,0,",",".");
		
		$StatsFinder = new StatsFinder();
		$Stats = $StatsFinder->findStatsById($User->getId());

		
		$TempLate=Template::getInstance("tpl_UserStats.php");
		$TempLate->assign("Units",$UnitFinder->countUnitsByUser($User));
		$TempLate->assign("People",$People);
		$TempLate->assign("PayPerHour",$PayPerHour);
		$TempLate->assign("CreditsPerHour",$CreditsPerHour);
		$TempLate->assign("UserPlanets",$PlanetFinder->countPlanetsByUser($User));
		$TempLate->assign("MaxUnits",$ShipControler->getMaxUnits());
		$TempLate->assign("MaxCredits",$MaxCredits);
		
		$TempLate->assign("EXP",number_format($User->getExperience(),0,",","."));
		$TempLate->assign("EXPNextLevel",number_format($User->getUserNextLevelExp(),0,",","."));
		
		
		
		$TempLate->assign("MessagesWritten", $Stats->getMessagesWritten());
		$TempLate->assign("MessagesReceived", $Stats->getMessagesReceived());
		$TempLate->assign("AlliWritten", $Stats->getAlliWritten());
		$TempLate->assign("AlliAnswerd", $Stats->getAlliAnswerd());
		$TempLate->assign("MetallBought", number_format($Stats->getMetallBought(),0,",","."));
		$TempLate->assign("MetallSold", number_format($Stats->getMetallSold(),0,",","."));
		$TempLate->assign("CrystalBought", number_format($Stats->getCrystalBought(),0,",","."));
		$TempLate->assign("CrystalSold", number_format($Stats->getCrystalSold(),0,",","."));
		$TempLate->assign("DeuteriumBought", number_format($Stats->getDeuteriumBought(),0,",","."));
		$TempLate->assign("DeuteriumSold", number_format($Stats->getDeuteriumSold(),0,",","."));
		$TempLate->assign("FoodBought", number_format($Stats->getFoodBought(),0,",","."));
		$TempLate->assign("FoodSold", number_format($Stats->getFoodSold(),0,",","."));
		$TempLate->assign("FleetLost", $Stats->getFleetLost());

		$TempLate->render();
	}
	
	
	// Vergleichen von 2 Usern
	public function showCompareStats()
	{
		$Request= new Request();
		$User= Controler_Main::getInstance()->getUser(); 
		$PlanetFinder= new PlanetFinder();			
		$StatsFinder = new StatsFinder();
		$Stats = $StatsFinder->findStatsById($User->getId());
		$UserFinder= new UserFinder();
		
		$TempLate=Template::getInstance("tpl_UserCompare.php");
		$CompareUser=$UserFinder->findByName($Request->getAsString("tb_Player"));
		if($CompareUser->getId())
		{
			$CompareStats = $StatsFinder->findStatsById($CompareUser->getId());
			$TempLate->assign("CompareUserState",true);
			$TempLate->assign("CompareUser",$CompareUser);	
			$TempLate->assign("CompareStats",$CompareStats);
			$TempLate->assign("CompareUserPlanets",$PlanetFinder->countPlanetsByUser($CompareUser));
		
			$TempLate->assign("UserCompareName",$CompareUser->getName());
		}	else
		{
			$TempLate->assign("ErrorMessage",":T_COMPARE_PLAYERNOTFOUND:");
		}
		$TempLate->assign("UserPlanets",$PlanetFinder->countPlanetsByUser($User));
		$TempLate->assign("UserStats", $Stats);
		$TempLate->render();
	}
	
}



?>