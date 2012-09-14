<?php

class Controler_Admin
{
	private $User;
	private static $Mode;
	private static $Instance;
	private static $Instance2;
	private $Planet;
	//private $PlanetCollection; // wir dnicht mehr benutzt 
	private $PlanetArray;// es wird nur noch die Id,der Name, und die aktuell gebauten gebäude + ob geforsch wird gezogen
	private $StartTime;
	private $Date;
	private $DataBaseId=1; // die datenbank schnittstelle >1 gibt den index der datenbank an
	private $Language;
	

	public static function getInstance()
	{
		if(self::$Instance2===null)
		{
			self::$Instance2 = new Controler_Admin();	
		}
		return self::$Instance2;	
	}
	
	/**
	 * der Contructor
	 *
	 * @return void 
	 *
	 */
	public function __construct()
	{
		$this->loadConfig();
	}
	
	public function start()
	{
		$Request= new Request();
		
		if( $Request->getAsString('Section')=="Login")
			{
				$this->login();
			}
		
		
		if($_SESSION['IsLoggedIn']==false)
		{
			$this->showLogin();
			return false;
		}
		
		switch($Request->getAsString('Section'))
		{			
			case "User":
			{
				$this->showUsers();
			}break;
			
			case "WorkOnMessage":
			{
				$this->workOnMessage();
				$this->showMessagePage();
			}break;
			
			case "MainPage":
			{
				$this->showMainPage();
			}break;
			
			case "Messages":
			{
				$this->showMessagePage();
			}break;

			case "Logout":
			{
				$this->logout();
			}break;
			
			case "SpawnNewPlanet":
			{
				$this->spawnNewPlanet();
				$this->showMainPage();
			}break;
			
			case "InsertMessage":
			{
				$this->saveNewMessage();
			}break;
			
			case "SolarSystem":
			{
				$this->spawnNewSolarsystem();
				$this->showMainPage();
			}break;
			
			case "InsertKey":
			{
				$this->insertPremiumKey(false,"");
				$this->showMainPage();
			}break;
			
			case "SetEnemyToMap":
			{
				$this->setEnemysToMap();
				$this->showMainPage();
			}break;
			case "DeleteOldKeys":
			{
				$this->checkTimedOutKey();
				$this->showMainPage();
			}break;
			
			default:
				$this->showLogin();
				break;
			
		}
	}
	
	

	
	
	/**
	* setzt in der bewohneten zone des Universums feindliche flotten 
	*
	* @return mixed This is the return value description
	*
	*/
	private function setEnemysToMap()
	{
		$ReQuest= new Request();

		$MapObjectFinder= new MapObjectFinder();
		$MapObjectCollection=$MapObjectFinder->findAllSuns();
		$UnitManager= new UnitManager();
		foreach($MapObjectCollection as $Sun)
		{
			$UnitCount= mt_rand(0,3);
			for($i=0;$i<$UnitCount;$i++)
			{
				$TempUnit=$this->getRandomRaiderUnit($ReQuest->getAsString("Type"),"A_Raider");
				
				$TempUnit->setX(mt_rand(-900,-900)+$Sun->getX());
				$TempUnit->setY(mt_rand(-900,-900)+$Sun->getY());
				$UnitManager->insertUnit($TempUnit);
			}
		}

		/*= mt_rand(UNIT_RAIDER_MIN_COUNT,UNIT_RAIDER_MAX_COUNT);
		$UnitManager= new UnitManager();
		$ShipFinder= new ShipFinder();
		
		$DockControler= new Controler_Dock();
		for($i=0;$i<$UnitsCount;$i++)
		{

			// neunen trupp eintragen
			$UnitManager->insertUnit($NewUnit);
			
		}*/
		
		return true;
	}
	
	private function getRandomRaiderUnit($Mode="SMALL",$UnitName="Raider")
	{
		$ShipCollection= new ShipCollection();
		$ShipCount=mt_rand(UNIT_RAIDER_SHIP_MIN_COUNT,UNIT_RAIDER_SHIP_MAX_COUNT);
		$ShipFinder= new ShipFinder();
		$Hunter=$ShipFinder->findById(3);
		$LagreHunter=$ShipFinder->findById(4);
		$Bomber=$ShipFinder->findById(5);
		$BattleShip=$ShipFinder->findById(6);
		switch($Mode)
		{
		case "SMALL":
			{
				$ShipCollection->add($Hunter,$ShipCount);
			}break;	
			case "MEDIUM":
			{
				$ShipCollection->add($Hunter,$ShipCount);
				$ShipCollection->add($LagreHunter,$ShipCount/2);
				$ShipCollection->add($Bomber,$ShipCount/4);
			}break;	
			case "TALL":
			{
				$ShipCollection->add($Hunter,$ShipCount);
				$ShipCollection->add($LagreHunter,$ShipCount/2);
				$ShipCollection->add($Bomber,$ShipCount/4);
				$ShipCollection->add($BattleShip,$ShipCount/8);
			}break;	
		}

		$TempString=$this->getUnitString(0,$ShipCount,0,0,0,0,0);
		$TempDMG=$ShipCollection->getDMG();
		$Amor=$ShipCollection->getAmor();
		$Speed=$ShipCollection->getSpeed();
		$Storage=$ShipCollection->getStorage();
		$Healts=$ShipCollection->getHealth();
		$NewUnit= new Unit(0,$UnitName,$TempString,$TempDMG,$Amor,$Speed,$Healts,User::getEmptyInstance(),0,0,mt_rand(UNIT_RAIDER_X_MIN,UNIT_RAIDER_X_MAX),mt_rand(UNIT_RAIDER_Y_MIN,UNIT_RAIDER_Y_MAX),1,$Storage,"",0,mt_rand(0,10),new Task());
		return $NewUnit;
	}
	
	
	private function getUnitString($DroneCount,$SmallHunterCount,$HunterCount,$BomberCount,$BattleShipCount)
	{
		$TempString=  "d:".$DroneCount;
		$TempString.=  ";sh:".$SmallHunterCount;
		$TempString.=  ";hh:".$HunterCount;
		$TempString.=  ";b:".$BomberCount;
		$TempString.=  ";bs:".$BattleShipCount;
		return	$TempString;
	}
	
	
	private function showUsers()
	{
		$TempLate=Template::getInstance("admin/tpl_AdminUsers.php");
		$TempLate->assign("IsLoggedIn",true);
		$UserFinder = new UserFinder();
		$Users = $UserFinder->findAllUser();
		$TempLate->assign("Users",$Users);
		$TempLate->render();
	}
	
	private function insertPremiumKey($ReturnKey=false,$Length)
	{
		$UserManager = new UserManager();
		$Request= new Request();
		$Key=$Request->getAsInt("i_Y");
		do{
			
			if($Length == "")
				if($Request->getAsInt("i_X") == "")
					$Length=30;
				else
					$Length=$Request->getAsInt("i_X");
			
			if($Key == "")
			{
				
				$Key=substr(md5(time()),mt_rand(1,23),8);
				
			}
			$Done = $UserManager->insertPremiumKey($Length,$Key);
			if($Done == 1)
			{
				break;
			}else
				$Key = "";
		} while(true);
		if($ReturnKey)
			return $Key;
	}
	
	private function checkTimedOutKey()
	{
		$TempLate=Template::getInstance("admin/tpl_AdminPanel.php");
		$UserManager = new UserManager();
		$PremUsers = $UserManager->unsetPremiumByOldKeys();
		$DelKeys = $UserManager->deleteOldKeys();
		$TempLate->assign("PremUsers",$PremUsers);
		$TempLate->assign("DelKeys",$DelKeys);
	}

	private function spawnNewPlanet()
	{
		$Request= new Request();
		$X=$Request->getAsInt("i_X");
		$Y=$Request->getAsInt("i_Y");
		if($X!="" && $Y!="")
		{
			$PlanetControler= new Controler_Planet(); 
			$Planet=$PlanetControler->getRandomPlanet();
			$Planet->setX($X);
			$Planet->setY($Y);
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
	
	private function spawnNewSolarsystem()
	{
		$Request= new Request();
		$TempLate=Template::getInstance("admin/tpl_AdminPanel.php");
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
			
			if($Request->getAsInt("i_X")=="" && $Request->getAsInt("i_Y")=="")
			{
				$PlanetSystem = new PlanetSystem();
				$PlanetSystem->generateSystem($NewX,$NewY);
				$TempLate->assign("X",$NewX);
				$TempLate->assign("Y",$NewY);
			} else
			{
				$X=$Request->getAsInt("i_X");
				$Y=$Request->getAsInt("i_Y");
				$PlanetSystem = new PlanetSystem();
				$PlanetSystem->generateSystem($X,$Y);
				$TempLate->assign("X",$X);
				$TempLate->assign("Y",$Y);
			}

		}
		// Planeten system eintragen
		$PlanetenManager= new PlanetManager();
		$PlanetenManager->inserPlanetSystem($PlanetSystem);
		// einen leeren planeten finden
		
	}
	
	private function saveNewMessage()
	{
		
		$Request= new Request();
		$MessageManager= new MessageManager();
		
		if($Request->getAsString("ToAll") ==  "true")
		{
			$UserFinder = new UserFinder();
			$AllUsers = $UserFinder->findAllUser();
			
			foreach ($AllUsers as $User)
			{
				$Text=$Request->getAsString("rtb_Text");
				if($Request->getAsString("WithKeys") ==  "true")
				{
					$Key="";
					for($i=0;$i<$Request->getAsString("tb_Lenght");$i++)
					{
						$Key .= $this->insertPremiumKey(true,$Request->getAsString("tb_KeyLenght"));
						$Key .= "\n";
					}
					$Text .= $Key;
				}
				$Message= new Message(0,"Administrator",$User->getName(),$Text,$Request->getAsString("tb_Header"),"",0,0,0,0);
				$MessageManager->saveNewMessage($Message);
			}
		} else
		{
			$Text=$Request->getAsString("rtb_Text");
			if($Request->getAsString("WithKeys") ==  "true")
			{
				$Key="";
				for($i=0;$i<$Request->getAsString("tb_Lenght");$i++)
				{
					$Key .= $this->insertPremiumKey(true,$Request->getAsString("tb_KeyLenght"));
					$Key .= "\n";
				}
				$Text .= $Key;
			}
			$Message= new Message(0,"Administrator",$Request->getAsString("tb_Resiver"),$Text,$Request->getAsString("tb_Header"),"",0,0,0,0);
			$MessageManager->saveNewMessage($Message);
		}
		//$this->sendMailNewMessagePlayer($Reciver);
		$this->showMessagePage();
	}
	
	
	
	public function workOnMessage()
	{
		$Request= new Request();
		$MessageManager= new MessageManager();
		if(!is_array($Request->getAsArray("Id"))) {return false;}
		foreach($Request->getAsArray("Id") as $ID)
		{	
			switch($Request->getAsInt("cb_Mode"))
			{
				case"2":// löschen
				{
					$MessageManager->setDeletetByTo($ID);
				}break;
			}
		}
		$MessageManager->deleteFromSystemAndDeleted();	
	}
		
	public function showMessages()
	{
		$Request= new Request();
		$Page=$Request->getAsInt("i_Page");
		if(!$Page)
		{
			$Page=0;	
		}
		$Messagefinder = new MessageFinder();
		//$UserFinder= new UserFinder();
		//$UserCollection = $UserFinder->findAllUser();
		$MessageFinder= new MessageFinder();
		$MessageCount= $MessageFinder->countMessageNoneListen("Administrator");
		$MessageCollection= new MessageCollection();
		$TempLate=Template::getInstance("admin/tpl_AdminMessage.php");
		switch($Request->getAsString("Show"))
		{
			case "UnRead":
			{
				$MessageCollection =$Messagefinder->findUnReadTo("Administrator",$Page*30);
				$MessageCountPage  =$MessageFinder->countMessageByReciver("Administrator",0,0,0,0);
			}break;
	
			default:
				$MessageCollection =$Messagefinder->findUnReadTo("Administrator",$Page*30);
				$MessageCountPage  =$MessageFinder->countMessageByReciver("Administrator",0,0,0,0);
		}
		
		$MessageCollection->Parse();
				
		if($Page>0)
		{
			$TempLate->assign("LastPageView",true);
			$TempLate->assign("LastPage",$Page-1);
		}
		
		if(($Page+1)*30<$MessageCountPage)// nur premium account können mehr als 30 nachrichten einsehenund mehr nachrichten vorhanden als angezeigt
		{
			if($Page*30<$MessageCountPage)// nur premium account können mehr als 30 nachrichten einsehenund mehr nachrichten vorhanden als angezeigt
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
	
	public function showMessagePage()
	{
		$TempLate=Template::getInstance("admin/tpl_AdminMessage.php");
		$this->showMessages();
		$TempLate->render();
	}
	
	public function showMainPage()
	{
		$TempLate=Template::getInstance("admin/tpl_AdminPanel.php");
		$this->addPermanentOutput();
		$TempLate->render();		
	}
	
	public function login()
	{
		echo "in der Login fkt";
		$Request= new Request();
		$Name=$Request->getAsString("tb_NameAdmin");
		$Pass=$Request->getAsString("tb_PassAdmin");
		$Server=$Request->getAsInt("i_Server");
		if($_SESSION['BadLogin']==5)
		{
			$this->showLogin();
			return false;
		}
		if($Name == ADMIN_NAME && $Pass == ADMIN_PASS)
		{
			echo "Pass Stimmt";
			$_SESSION['UserName']=ADMIN_NAME;
			$_SESSION['UserPass']=md5($Request->getAsString("tb_PassAdmin"));
			$_SESSION['DataBase']=$Request->getAsInt("i_Server");
			$_SESSION['IsLoggedIn']=true;
			$TempLate=Template::getInstance("admin/tpl_AdminPanel.php");
			$this->addPermanentOutput();
			$TempLate->render();// hier nen aufruf von ner fkt fürs admin panel
			return true;
		} else
		{
			$_SESSION['IsLoggedIn']==false;
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
	}
	
	public function addPermanentOutput()
	{
		$TempLate=Template::getInstance("admin/tpl_AdminPanel.php");
		$TempLate->assign("IsLoggedIn",true);
		
	}
	
	public function logout()
	{
		$_SESSION['UserId']="";
		unset($_SESSION['DataBase']);	// server vari entfernen
		@session_destroy();
		$this->showLogin();
	}
	
	public function showLogin()
	{
		$TempLate=Template::getInstance("admin/tpl_AdminPanelLogin.php");
		$TempLate->render();
	}
		
	private function loadConfig()
	{
		@include("cfg/cfg.php");// normale einstellungen laden	  nicht die db einstellungen die werden direkt von der db schnittstelle geladen 
		$ReQuest= new Request();
		if(!$ReQuest->getAsInt("i_Server") && !$_SESSION['DataBase'])
		{
			//$_SESSION['DataBase']=1;// wenn neu auf die seite gekommen darf es kein server in der session sein
			$this->DataBaseId=1;
		}else
		{
			if($ReQuest->getAsInt("i_Server") && $_SESSION['DataBase'])// wenn beides belegt ist dann nimm das ding aus der session denn nur der login controler darf da rumspielen 
			{
				$this->DataBaseId=$_SESSION['DataBase'];	
			}
			if($ReQuest->getAsInt("i_Server") && !$_SESSION['DataBase'])// beim login
			{
				$_SESSION['DataBase']=$ReQuest->getAsInt("i_Server");
				$this->DataBaseId=$ReQuest->getAsInt("i_Server");	
			}
			if($_SESSION['DataBase'] && !$ReQuest->getAsInt("i_Server"))   // aus der session wenn bereits eine db gewählt worden ist
			{
				$this->DataBaseId=$_SESSION['DataBase'];
			}
		}				   	
	}
}

?>