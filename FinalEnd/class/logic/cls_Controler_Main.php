<?php

class Controler_Main
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
	private $DataBaseId=0; // die datenbank schnittstelle >1 gibt den index der datenbank an
	private $Language;
	
	/**
	 * singelton
	 *
	 * @return Controler_Main 
	 *
	 */
	public static function getInstance()
	{
		if(self::$Instance2===null)
		{
			self::$Instance2 = new Controler_Main();	
		}
		return self::$Instance2;	
	}
	
	/**
	 * gibt den User zurück
	 *
	 * @return User 
	 *
	 */
	public function getUser()
	{
		return $this->User;	
	}
	public function setUser($User)
	{
		$this->User=$User;	
	}
	
	public function setPlanetCollection($PlanetCollection)
	{
		$this->PlanetCollection=$PlanetCollection;	
	}
	public function getPlanetCollection()
	{
		return $this->PlanetCollection;	
	}
	

	/**
	 * der Contructor
	 *
	 * @return void 
	 *
	 */
	public function __construct()
	{
		$this->StartTime=microtime(true);
		$this->loadConfig();	// config ins system laden		$this->addClick();
		$this->Date=date("d.m.Y")."<br />".date("H:i");	// start zeit holen
		$this->setLanguage();  // sprache setzen
	}
	
	
	private function setLanguage()
	{
		$Request= new Request();
		$TempLate=Template::getInstance();
		if($Request->getAsString("Lang")&& $this->checkLangFile($Request->getAsString("Lang")))
		{
			$_SESSION['Language'] =$Request->getAsString("Lang");
			$this->Language=$_SESSION['Language'];
			$TempLate->setLanguage($this->Language);
			setcookie("Lang", $Request->getAsString("Lang"), time()+3600*24*30);
			return false;	
		}
		
		if(!empty($_COOKIE['Lang']))
		{
			$_SESSION['Language'] =$_COOKIE['Lang'];
			$this->Language=$_SESSION['Language'];
			$TempLate->setLanguage($this->Language);
			return false;	
		}
		
		
		if(isset($_SESSION['Language']) && !$Request->getAsString("Lang"))
		{
			$this->Language=$_SESSION['Language'];
		}
		if(!isset($_SESSION['Language']) && !$Request->getAsString("Lang"))// standart sprache ist auf deutsch gestellt
		{
			$this->Language=LANGUAGE_GER;
			$_SESSION['Language'] =LANGUAGE_GER;
			$_COOKIE['Lang']=LANGUAGE_GER;
			setcookie("Lang", LANGUAGE_GER, time()+3600*24*30);
		}
		
		$TempLate->setLanguage($this->Language);
	}
	
	
	/**
	 * prüft ob die sprachdatei exsistiert
	 *
	 * @param mixed $LangFileName This is a description
	 * @return mixed This is the return value description
	 *
	 */
	private function checkLangFile($LangFileName)
	{
		if(file_exists("./language/lang_".$LangFileName.".php"))
		{
			return true;
		}
		return false;
	}
	
	
	public function getResX()
	{
		return $_SESSION['ResX']-2;
	}
	
	public function getResY()
	{
		return $_SESSION['ResY']-5;
	}
	
	/**
	 * initialisiert das spiel
	 *
	 * @return void 
	 *
	 */
	private function init()
	{
		$this->mappUser();
		if($this->User->getId()<=0){return false;}  // wenn user nicht eingeloggt ist dann raus hier
		$this->checkBuildings(); // prüf die gebäude ob welche ausgebaut werden müssen
		$this->checkReSearchs(); // prüf die Forschungsobjekte ob welche ausgebaut werden müssen  
		// ressorcen des spielers updaten

		
		$this->mappPlanet();
		$this->mappPlanetCollection();
		
		$RessourceControler= new Controler_Resource(); 
		//$RessourceControler->setResourceByUser($this->User);
		$RessourceControler->start();
		
		//$this->Planet=$this->PlanetCollection->getById($_SESSION['i_PlanetId']);
		$RessourceControler->setCreditsByUser($this->User);
	}	

	public function getEndTime()
	{
		return substr(microtime(true)-$this->StartTime,0,5);	
	}
	
	public function updateControler()
	{
		$this->mappUser();
		$this->mappPlanet();
		$this->mappPlanetCollection();
		$this->addPermanentOutPut();
	}

	private function checkBuildings()
	{
		if($_SESSION['i_PlanetId'])
		{
			$BuildingManager= new BuildingManager();
			$BuildingManager->updateBuildingsFromAllUser();
			//$BuildingManager->updateBuildings($_SESSION['i_PlanetId']);
		}
	}

	/**
	 * baut die forschungen aus
	 *
	 * @return void 
	 *
	 */
	private function checkReSearchs()
	{
		if($_SESSION['i_PlanetId'])
		{
			$ReSearchManager= new ReSearchManager();
			$ReSearchManager->updateReSearchs($_SESSION['i_PlanetId']);
		}
	}

	private function mappPlanet()
	{	
		$PlanetFinder= new PlanetFinder();
		//if(!$_SESSION['i_PlanetId'])
		//{
			//$_SESSION['i_PlanetId']
		if($_SESSION['i_PlanetId'])
		{
			$Planet=$PlanetFinder->findById($_SESSION['i_PlanetId']);
			if($Planet->getId()==0){$Planet=$PlanetFinder->findByUserId($this->User->getId())->getByIndex(0);}
			$_SESSION['i_PlanetId']=$Planet->getId();
			//}
			$this->Planet=$Planet;
		}else
		{
			if($this->User->getId())
			{
				$Planet=$PlanetFinder->findByUserId($this->User->getId())->getByIndex(0);
				$_SESSION['i_PlanetId']=$Planet->getId();
				$this->Planet=$Planet;
			}else
			{
				$this->Planet=Planet::getEmptyInstance();
			}
		}
	}

	public function mappPlanetCollection()
	{
		$PlanetFinder= new PlanetFinder();
		if($this->User->getId()!=0)
		{
			$this->PlanetArray=$PlanetFinder->findArrayByUserId($this->User);
			$this->PlanetCollection= New PlanetCollection();
			//$PlanetFinder->findByUserId($this->User->getId());
		}else
		{
			$this->PlanetArray=$PlanetFinder->findArrayByUserId($this->User);
			$this->PlanetCollection= New PlanetCollection();
		}
	}
	
	/**
	 * fürg user und planeten des useres z7um template hinzu
	 *
	 * @return void 
	 *
	 */
	public function addPermanentOutPut()
	{
		$ReQuest= new Request();
		$TempLate=Template::getInstance();
		$TempLate->assign("MyPlanetCollection",$this->PlanetCollection);
		$TempLate->assign("Planet",$this->Planet);
		$TempLate->assign("User",$this->User);
		$TempLate->assign("Section",$ReQuest->getAsString("Section"));
		$TempLate->assign("Action",$ReQuest->getAsString("Action"));

		$TempLate->assign("PlanetArray",$this->PlanetArray);// das Planeten array in das tpl schmeisen
		
		$MessageFInder= new MessageFinder();
		$MessageCount= $MessageFInder->countMessageNoneListen($this->User->getName());
		$TempLate->assign("MessageCount",$MessageCount);
		$TempLate->assign("Date",$this->Date);
		
		$TempLate->assign("ResX",$this->getResX());
		$TempLate->assign("ResY",$this->getResY());
	}
	
	/**
	 * aktualisiert die nachrichten anzeige 
	 *
	 * @return void 
	 *
	 */
	public function refreshMessageIcon()
	{
		$MessageFInder= new MessageFinder();
		$MessageCount= $MessageFInder->countMessageNoneListen($this->User->getName());
		$TempLate=Template::getInstance();
		$TempLate->assign("MessageCount",$MessageCount);	
	}

	/**
	 * gibt den aktuellen Planeten des aktuellen users zurück
	 *
	 * @return Planet 
	 *
	 */
	public function getPlanet($Refference=true)
	{
		if($Refference)
		{
			return $this->Planet;	
		}
		return clone $this->Planet;
	}	
	
	 public function setPlanet($Planet)
	{
		$this->Planet=$Planet;	
		
	}

	private function mappUser()
	{
		if(!$_SESSION['UserId'])
		{
			$this->User= new User(0);
			return true;
		}
		$UserFinder= new UserFinder();
		$UserManager= new UserManager();
		$UserManager->updateLoginTime($_SESSION['UserId']);
		$this->User=$UserFinder->findById($_SESSION['UserId']);	
	}


	/**
	 * lädt die einstellungen für das system aus der config datei
	 *
	 * @return  
	 *
	 */
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

	
	/**
	 * gibt die Id der Datenbank zurück
	 *
	 * @return int 
	 *
	 */
	public function getDataBaseId()
	{
		return $this->DataBaseId;
	}

	public function setDataBaseId($DataBaseId)
	{
		$this->DataBaseId=$DataBaseId;
		$_SESSION['DataBase']=$DataBaseId;
	}

	public function setServerCon($ServerCount)
	{
		
		
		
	}


	private function userLogin()
	{
		$User = user::getInstance();
		$User->mapper();
		
		//var_dump($_COOKIE);
		if($User->getId()==0 && !empty($_COOKIE['UserName']) && !empty($_COOKIE['UserPass']) )
		{
			$User->login($_COOKIE['UserName'],md5($_COOKIE['UserPass']));
			$User->mapper();
		}
	}

	
	/**
	 * baut schiffe und trägt sie wenn fertiggebaut aus der db aus
	 *
	 * @return void 
	 *
	 */
	private function buildShips()
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$User=$Planet->getUser();
		$ShipFinder= new ShipFinder();
		$ShipBuildCollection = $ShipFinder->findShipBuildingByPlanetIdWhereMustBuild($Planet->getId());
		// aufträge suchen
		// schleiffe
		$ShipManager=	 new ShipManager();
		foreach($ShipBuildCollection as $ShipBuild)
		{
			$TimeDiff = $ShipBuild->getStartTime()-microtime(true);
			if($TimeDiff<=$ShipBuild->getBuildTime()*$ShipBuild->getCount())
			{// alle komplett fertigen eintragen
				$ShipManager->deleteShipBuilding($ShipBuild->getId());
				$ShipManager->insertShips($Planet->getId(),	$ShipBuild->getShip()->getId(),$ShipBuild->getCount());
			}
			if($TimeDiff<=$ShipBuild->getBuildTime())
			{
				// nur die berechneten eintragen
				

			}
	
		}		
		// neue schiffe berechnen 
		// db einträge bearbeiten
	
	}
	
	
	
	// Diese Function startet das system
	public function start()
	{
		//var_dump($_SESSION['DataBase']);
		$Request= new Request();
		$this->init();// läd und mappt den user, planeten ,....	
		
		if($this->User->getId()>0)
		{
			$this->buildShips(); // baut schiffe die in der bauschleife sind
			$this->addPermanentOutPut();// alles in die ausgabe schieben
			switch($Request->getAsString('Section'))
			{
				
				case "Dock":
				{
					$Controler= new Controler_Dock();
					$Controler->start();
				}break;
				
				case "Skill":
				{
					$Controler= new Controler_Skill();
					$Controler->start();
				}break;
				
				case "Trade":
				{
					$Controler= new Controler_Sale();
					$Controler->start();
				}break;
				
				case "ReSearch":
				{
					$Controler= new Controler_Research();
					$Controler->start();
				}break;
				
				case "Help":
				{
					$Controler= new Controler_Help();
					$Controler->start();
				}break;
				
				case "Ranking":
				{
					$Controler= new Controler_Ranking();
					$Controler->start();
				}break;
				
				case "ChangeActivePlanet":
				{
					$this->changeActivePlanet();
				}break;
				
				case "User":
				{
					$Controler= new Controler_User();
					$Controler->start();
				}break;
				
				case "Allianz":
				{
					$Controler= new Controler_Allianz();
					$Controler->start();
					
				}break;
				case "Ships":
				{
					$Controler= new Controler_Ships();
					$Controler->start();
					
				}break;
				
				case "Click": 
				{
					$Controler= new Controler_Click();
					$Controler->start();
				}break;
				
				case "news":
					$Controler= new Controler_News();
					$Controler->start();
					break;
				
				case "Login": 
				{
					$Controler= new Controler_Login();
					$Controler->start();
				}break;
				
				
				

				case "Impressum": 
				{
					$this->showImpressum();
				}break;			
				
				case "Messages":
					$Controler= new Controler_Message();
					$Controler->start();
					break;
				
				case "Map":
					$Controler= new Controler_Map();
					$Controler->start();
					break;
				
				case "Planet":
					$Controler= new Controler_Planet();
					$Controler->start();
					break;
					
					
				case "Building":
					//$Request->setPost("Action","ShowBuildings");
					$Controler= new Controler_Building();
					$Controler->start();
				break;	
					
				case "admin":
					
					if($this->User->check(10))
					{
						$Controler= new Controler_Admin();
						$Controler->start();
					}
					else 
					{
						$Controler= new Controler_News();
						$Controler->start();
					}
					break;

				case "CalculateMap": 
				{
					$Controler= new Controler_Map();
					$Controler->calculateMap();
					// 

					echo $this->getEndTime();
				}break;

				case "Statics": 
				{
					$this->showStatics();
				}break;
				
				case "AGB": 
				{
					$this->showAGB();
				}break;
				
				default:
					$Controler= new Controler_Login();
					$Controler->start();
					break;
					
			}
			
		}else
		{
			switch($Request->getAsString('Section'))
			{
				case "news":
					$Controler= new Controler_News();
					$Controler->start();
					break;
				
				case "Login": 
				{
					$Controler= new Controler_Login();
					$Controler->start();
				}break;
				
				case "Statics": 
				{
					$this->showStatics();
				}break;
				
				case "CalculateMap": 
				{
					$Controler= new Controler_Map();
					$Controler->calculateMap();
					echo $this->getEndTime();
				}break;
				
				case "SetEnemysToMap": 
				{
					$Controler= new Controler_Map();
					$Controler->setEnemysToMap();
					echo $this->getEndTime();
				}break;
				
				case "ImpressumExtern": 
				{
					$this->showImpressumExtern();
				}break;
				
				case "AGB": 
				{
					$this->showAGB();
				}break;	
					
				default:
			
				$Controler= new Controler_Login();
				$Controler->start();
			
				break;
				}
			
			}
		Controler_Event::getInstance()->handleEvents();	// hier werden nun alle eventuellen Events abgearbeitet
		}
	
	public function showStatics()
	{
		
		$Request= new Request();
		$Controler_Main= Controler_Main::getInstance();
		$Controler_Main->setDataBaseId(1);
		$UserFinder= new UserFinder();
		$UserCount= $UserFinder->countAllUsers();
		$UserOnlineCount= $UserFinder->countAllOnlineUsers();
		$PlanetFinder= new PlanetFinder();
		$PlanetCount=  $PlanetFinder->countPlanets();
		$UnitFinder= new UnitFinder();
		$UnitCount= $UnitFinder->countUnits();
		$Battles= $UnitFinder->countBattles();
		
		
		$TempLate=Template::getInstance("tpl_Statics.php");  

		$TempLate->assign("Player",$UserCount);
		$TempLate->assign("OnlinePlayer",$UserOnlineCount);
		$TempLate->assign("Planets",$PlanetCount);
		$TempLate->assign("Units",$UnitCount);
		$TempLate->assign("Battles",$Battles);


		$Controler_Main->setDataBaseId(2);
		$UserFinder= new UserFinder();
		$UserCount= $UserFinder->countAllUsers();
		$UserOnlineCount= $UserFinder->countAllOnlineUsers();
		$PlanetFinder= new PlanetFinder();
		$PlanetCount=  $PlanetFinder->countPlanets();
		$UnitFinder= new UnitFinder();
		$UnitCount= $UnitFinder->countUnits();
		$Battles= $UnitFinder->countBattles();


		$TempLate->assign("Player2",$UserCount);
		$TempLate->assign("OnlinePlayer2",$UserOnlineCount);
		$TempLate->assign("Planets2",$PlanetCount);
		$TempLate->assign("Units2",$UnitCount);
		$TempLate->assign("Battles2",$Battles);




		$TempLate->render();
		
		
	}
	
	/**
	 * bla
	 *
	 * @return void 
	 *
	 */
	public function showAGB()
	{
		$Template=Template::getInstance("tpl_AGB.php");  
		$Template->render();
		
		
	}
	
	
	/**
	 * diese funktion kann nur aufgerufen werden wenn das php über die konsole gestartet wurden ist
	 *
	 * @return mixed This is the return value description
	 *
	 */
	public function calculateMapPositions()
	{
		if(!isset($_SERVER['argv'])){echo "kann nur in Komandozeilen modus ausgeführt werden \n";return false;}// wenn nicht konsole dann raus 
		
		if(!isset($_SERVER['argv'][1]))	{echo "der ausführungs pfad wurde nicht angegeben (string)\n";return false;}// wenn nicht konsole dann raus
		if(!isset($_SERVER['argv'][2]))	{echo "die datenbank wurde nicht angegeben erfordert (int) \n";return false;}// wenn nicht konsole dann raus 
		
		require($_SERVER['argv'][1]."/cfg/db".$_SERVER['argv'][2].".php");// db setzen	
		@include($_SERVER['argv'][1]."cfg/cfg.php");// config laden
		$ServerId=$_SERVER['argv'][2];
		$this->setDataBaseId($_SERVER['argv'][2]);
		$Controler= new Controler_Map();
		while(true)
		{
			$this->StartTime=microtime(true);
			echo $this->getTime()." berechne Map Koordinaten  (".$ServerId.")\n";
			$Controler->setUnitsKoords();
			echo $this->getTime()." Koordinaten wurden berechnet in ".$this->getEndTime()." (".$ServerId.")\n";
			UnitFinder::reset();// all user aus dem unit finder löschen
			MySqldb::getInstance()->close();
			sleep(5);// 5 sekunden schlafen
		}
		//$Controler->calculateMap();
		//echo $this->getEndTime();	
	}
	
	
	public function calculateBattles()
	{
		if(!isset($_SERVER['argv'])){echo "kann nur in Komandozeilen modus ausgeführt werden \n";return false;}// wenn nicht konsole dann raus 
		
		if(!isset($_SERVER['argv'][1]))	{echo "der ausführungs pfad wurde nicht angegeben (string)\n";return false;}// wenn nicht konsole dann raus
		if(!isset($_SERVER['argv'][2]))	{echo "die datenbank wurde nicht angegeben erfordert (int) \n";return false;}// wenn nicht konsole dann raus 
		require($_SERVER['argv'][1]."/cfg/db".$_SERVER['argv'][2].".php");// db setzen	
		include($_SERVER['argv'][1]."/cfg/cfg.php");// config laden
		$ServerId=$_SERVER['argv'][2];
		$this->setDataBaseId($_SERVER['argv'][2]);
		//$StateManager->deleteExpiredStates();// alle states die abgelaufen sind löschen
		while(true)
		{
			$this->StartTime=microtime(true);
			$ResourceControler=new Controler_Resource();
			$Controler= new Controler_Map();
			$StateManager= new StateManager();
			
			echo $this->getTime()." Berechne Kolonisation (".$ServerId.")\n";
			$Controler->findKolo(); // kolos finden
			echo $this->getEndTime()."\n\n";
			
			$this->StartTime=microtime(true);
			
			echo $this->getTime()." Finde brennpunkte (".$ServerId.")\n";
			$Controler->findBattles();	// kämpfe generieren
			echo $this->getEndTime()."\n\n";
			$this->StartTime=microtime(true);
			
			echo $this->getTime()." Berechne Kämpfe (".$ServerId.")\n";
			$Controler->claculateBattles();	// kämpfe berechnen	
			echo $this->getEndTime()."\n\n";
			$this->StartTime=microtime(true);
			
			echo $this->getTime()." Berechne Detonatoren (".$ServerId.")\n";
			$Controler->calculateMartyr();
			echo $this->getEndTime()."\n\n";
			$this->StartTime=microtime(true);
			echo $this->getTime()." setze planeten rohstoffe (".$ServerId.")\n";
			$ResourceControler->setAllRessource();
			echo $this->getTime()." Berechnung abgeschlossen ".$this->getEndTime()."  (".$ServerId.")\n\n";
			
			$StateManager->deleteExpiredStates(); // alle states die abgelaufen sind löschen
			echo $this->getTime()." Stati wurden ressetet ".$this->getEndTime()."  (".$ServerId.")\n\n";
			UnitFinder::reset();// all user aus dem unit finder löschen
			MySqldb::getInstance()->close();
			// alle objekte zerstören
			
			// ressource controler leeren
			$ResourceControler=null; 
			unset($ResourceControler);
			
			// map controler leeren
			$Controler=null; 
			unset($Controler);
			
			sleep(5);// 5 sekunden schlafen
			
		}
		//$Controler->calculateMap();
		//echo $this->getEndTime();	
	}
	
	PUBLIC function getTime()
	{
		return  date("d.m.y")."<br />".date("H:i:s");
	}
	
	public function showLogin()
	{	
	}

	
	
	public function  changeActivePlanet()
	{
		// planeten setzen
		$Request= new Request();
		$PlanetId=$Request->getAsInt("cb_Planet");
		$PlanetFinder= new PlanetFinder();
		$MyPlanet= $PlanetFinder->findById($PlanetId);
		if($this->User->getId()==$MyPlanet->getUser()->getId())
		{
			$this->Planet=$MyPlanet;
			$_SESSION['i_PlanetId']=$MyPlanet->getId();
		}
		$this->addPermanentOutPut();
		$Request->setPost("Section",$Request->getAsString("D"));
		if($Request->getAsString("D")=="Login")// wenn der Login Controler ausgewählt wurde dann muss manuel auf den Planeten controler gelinkt werden
		{
			$Request->setPost("Section","Planet");
		}
		
		
		$this->start();
	}
	
	
	/**
	 * gibt eine messageCollection des userers zurück
	 *
	 * @param string $UserName 
	 * @return UserCollection 
	 *
	 */
	public static function getMessageByUserName($UserName)
	{
		$MessageFinder= new MessageFinder();
		return $MessageFinder->findUnReadByResiver($UserName);	
	}
	
	
	
	private function showImpressumExtern()
	{
		$Template=Template::getInstance("tpl_ImpressumExtern.php");  
		$Template->render();	
	}
	
	private function showImpressum()
	{
		$Template=Template::getInstance("tpl_Impressum.php");  
		$Template->render();	
	}
	
	
	/**
	* gibt ein zufälliges passwort mit der angegeben länge zurück
	*
	* @param int $Length
	* @return string
	*/
	function getRandomPass($Length=6)
	{
		$Pool = "qwertzupasdfghkyxcvbnm";
		$Pool .= "23456789";
		$Pool .= "WERTZUPLKJHGFDSAYXCVBNM";
		srand ((double)microtime()*1000000);
		for($Index = 0; $Index < $Length; $Index++)
		{
			$PassWord .= substr($Pool,(rand()%(strlen ($Pool))), 1);
		}
		return $PassWord;
	}
	
	
	
}

?>