<?php

/**
 * class cls_Controler_Click
 *
 * Description for class cls_Controler_Click
 *
 * @author:
*/
class Controler_Map  
{

	/**
	 * cls_Controler_Click constructor
	 *
	 * @param 
	 */
	function __construct() 
	{

	}
	
	
	public function start()
	{
		$Request= new Request();

		switch($Request->getAsString("Action"))
		{
			case "GetPic":
			{
				$this->getPic();
			}break;

			case "ScanArea":
			{
				$this->scanArea();
			}break; 
			
			case "RaidPlanet":
			{
				$this->raidPlanet();
			}break; 

			case "MoveUnit":
			{
				//$this->setUnitsKoords();
				$this->moveUnit();
			}break;  

			case "FINDCOLO":
			{	  
				$this->findKolo();
			}break;


			case "WorkOnRoute":
			{	  
				$this->workOnRoute();
			}break;

			case "GetByKoord":
			{
				//$this->setUnitsKoords();
				$this->getAllByKoord();
				//$this->findKolo();
			}break; 
			
			case "CALCULATE":
			{	
				$this->findKolo();  
				$this->findBattles();
				$this->claculateBattles();	

			}break;
			
			case "TEMP":	
			{	
				$this->addWast(2,2);  
				//$this->claculateBattles();	
			}break;


			case "GetRoute":	
			{	  
				$this->getRoute();	
			}break;

			case "GetUnitDescription":	
			{	  
				$this->getUnitDescription();	
			}break;


			case "R":	
			{	 
				$UnitFinder= new UnitFinder();
				$Unit= $UnitFinder->findById(241);
				$Unit->setStoredElement("m",50000);	
			}break;
			
			 
			case "StopUnit":	
			{	 
				$this->stopUnit();
			}break;

			case "SetUnitToRoute":	
			{	 
				$this->setUnitToRoute();
			}break;


			case "GetTasks":	
			{	 
				$this->getTasks();
			}break;

			case "DeleteRoute":	
			{	 
				$this->deleteRoute();
			}break;

			case "AddRoute":	
			{	 
				$this->addRoute();
			}break;


			case "RecycleWaste":	
			{	 
				$this->recycleWaste();
			}break;
			case "GetPlanetDescription":	
			{	 
				$this->getPlanetDescription();
			}break;
			
			
			case "GetAllUnitsKoord":	
			{	 
				$this->getAllUnitsByKoord();
			}break;
			
			
			case "BuildDeathStar":	
			{	 
				$this->buildDeathStar();
			}break;
			
			case "LoadDeathStar":	
			{	 
				$this->loadDeathStar();
			}break;
			
			
			case "DestroyPlanet":	
			{	 
				$this->destroyPlanet();
			}break;
			
			
			case "JumpToPosition":	
			{	 
				$this->jumpToPosition();// der hyperraum antrieb
			}break;
			
			
			
			case "EmpNearbyShips":	
			{	 
				$this->empNearbyShips();// der hyperraum antrieb
			}break;
			
			
			
			default:
				//$this->setUnitsKoords();
				//$this->findBattles();
				//$this->claculateBattles();
				$this->showMap();
				//$this->findKolo();		
		}
	}
	
	public function workOnRoute()
	{
		//$this->getRoute();
		$ReQuest= new Request();
		// route laden
		$RouteFinder= new RouteFinder();
		$Route=$RouteFinder->findById($ReQuest->getAsInt("Rid")); 
		
		// ausgabe Formulieren und die karte dementsprechend einstellen
		
		//var_dump($ReQuest->getAsInt("Rid")); 
		$OutPut='
		var MyRoute= new Route();

		var MyRoutPointCollection= new RoutPointCollection();
		MyRoutPointCollection.clear();';
		foreach($Route->getRoutePointCollection() as $RoutPoint)
		{
			$OutPut.='MyRoutPointCollection.add(new RoutPoint('.$RoutPoint->getId().','.$RoutPoint->getAction().','.$RoutPoint->getX().','.$RoutPoint->getY().',"'.$RoutPoint->getExtentionCount().'",'.$Route->getId().','.$RoutPoint->getOrder().',"'.$RoutPoint->getExtentionRessource().'"));
			';
		}
		$OutPut.='MyRoute.setRoutPointCollection(MyRoutPointCollection);
		MyRoute.setLanguage(getMap().getLanguage());
		getMap().setRoute(MyRoute);
		getMap().getRoute().setName("'.$Route->getName().'");
		getMap().getRoute().render();
		';
		echo $OutPut;
	}
	
	public function addRoute()
	{
		$Request= new Request();
		$RouteFinder= new RouteFinder();
		$User= Controler_Main::getInstance()->getUser();
		$Name=$Request->getAsString("RouteName");
		
		$RouteFinder= new RouteFinder();// gucken ob es diese route bereits gibt wenn ja muss sie hier schon geladen werden damit diese in der db nicht verloren geht
		$TempRoute=$RouteFinder->findByNameAndUserId($Name,$User->getId());
		
		$Count=$Request->getAsString("ElementCount");
		$RoutePointCollection= new RoutePointCollection();
		$RouteManager= new RouteManager();
		if(strlen($Name)==0){return false;}
		if($Count<=1){return false;}
		for($i=1;$i<=$Count;$i++)
		{
			$RoutePoint=new RoutePoint(0,$Request->getAsInt(($i-1)."EX"),$Request->getAsInt(($i-1)."EY"),$Request->getAsInt(($i-1)."Action"),$Request->getAsString(($i-1)."Extention"),$OuteId,$i);	
			$RoutePointCollection->add($RoutePoint);
		}
		if($Count==0){return false;}
		$Route= new Route(0,$Name,"",$User,$RoutePointCollection);
		$RouteId=$RouteManager->insertRoute($Route);	// route mit waypoints eintragen
		//$this->getUnitDescription();
		
		if($TempRoute->getId())// wenn die route "bearbeitet" werden soll
		{
			// alle flotten holen die diese route benutzen	
			$UnitFinder= new UnitFinder();
			$OldUnitCollection=$UnitFinder->findAllByRoutId($TempRoute->getId());
			$RouteManerger= new RouteManager();
			foreach($OldUnitCollection as $Unit)
			{
				// den link umschreiben 
				$RouteManager->updateRouteUnitlink($RouteId,$Unit);// den alten link umschreiben
			}
			$RouteManerger->deleteRoute($TempRoute);// alte route wegmachen
		}
		
		
		
	}
	
	public function deleteRoute()
	{
		$Request= new Request();
		$RouteFinder= new RouteFinder();
		if(!$Unit)   // keine flotte übergeben also aus regquest auslesen
		{
			$Route=$RouteFinder->findById($Request->getAsInt("RId"));
		}
		$User= Controler_Main::getInstance()->getUser();	
		if($User->getId()!=$Route->getUser()->getId()){return false;}// wenn der User es nicht darf bzw wenn es ein anderer User gemacht hat als der der eingeloggt ist
		
		$RouteManager= new RouteManager();
		$RouteManager->deleteRoute($Route);
		
		//$Unit->getTask()->getId();// taskId holen
		//echo "getMap().deleteTaskById(".$Unit->getTask()->getId().")";
	}
	
	/**
	 * prüft ob die Flotte eine Route hat und wenn ja wird sie weiter abgearbeitet
	 *
	 * @return bool 
	 *
	 */
	public function calculateRoute(Unit $Unit)
	{
		$RouteFinder= new RouteFinder();
		$Route=$RouteFinder->findByUnit($Unit);
		if(!$Route->getId()){return false;}// hat keine Route und raus
		$RouteManager= new RouteManager();
		$UnitManager= new UnitManager();
		$UnitFinder= new UnitFinder();
		$PlanetFinder= new PlanetFinder();
		
		// Flotte hat eine route
		$Dock_Controler= new Controler_Dock();
		
		
		$RoutePointCollection=$Route->getRoutePointCollection();
		// gucken was die Flotte momentan macht und den zähler weiter setzen
		// die aktuelle Position 
		
		$SecurityCounter =0;// wenn die schleife mehr als 10 durchlaufen wurde soll sie selbstständig abbrechen
		for($i=$Route->getCurrentCnt();$i< $RoutePointCollection->getCount()+1;$i++)
		{
			$Order=$RoutePointCollection->getByOrder($i);
			// wenn ein bewegen punkt kommt raus aus der schleife
			if($Unit->getX()!=$Order->getX() || $Unit->getY()!=$Order->getY())
			{
				$TaskCollection=$UnitFinder->findAllTaskByUnit($Unit);
				if($TaskCollection->getCount()==0)
				{
					$NewTask= new Task(0,$Order->getX(),$Order->getY(),0,$Unit->getId(),"move",0);
					$UnitManager->insertTask($NewTask);   // den alten auftrag raushauhen
				}
				// task eintragen
				// und raus aus der schleife	
				//$i++;
				break;
			}
			if($Order->getAction()>=2 && $Order->getAction()<=5 )
			{
				$Planet= $PlanetFinder->findAllByKoordinates($Order->getX(),$Order->getY(),100)->getByIndex(0);	// den planeten aus der Collection Holen
				switch($Order->getAction())
				{
					case 2:// beladen
					{
						$Dock_Controler->loadRessource($Unit,$Planet,$Order->getExtentionRessource(),$Order->getExtentionCount());
					}break;
					case 3:// endladen
					{
						$Dock_Controler->unLoadRessource($Unit,$Planet,$Order->getExtentionRessource(),$Order->getExtentionCount());
					}break;	
					
					case 4:// scannen
					{
						$this->scanArea($Unit);
					}break;	
					
					case 5:// überfallen
					{
						//$this->raidPlanet($Unit);
					}break;	
				}
			}
			
			if($i==$RoutePointCollection->getCount() && $Route->getIsLoop($Unit))// wenn routen ende und es eine endlosschleife ist dann neu starten ansonsten die unit von der route befreien
			{
				$i=0;
			}
			
			$SecurityCounter++;
			if($SecurityCounter>=10) // zur sicherheit wenn nur ein punkt innerhalb der route vorhanden ist
			{
				// die route flotten verbindung entfernen
				if($Route->getRoutePointCollection()->getCount()==1)// nur ein wegpuinkt verknüpfung entfernen
				{
					$RouteManager->deleteUnitRouteLink($Unit);
				}
				
				break;	
			}	
		}
		if($i==$RoutePointCollection->getCount()+1 && $Route->getIsLoop($Unit))// wenn routen ende und es eine endlosschleife ist dann neu starten ansonsten die unit von der route befreien
		{
			$i=1;
		}
		$RouteManager->updateRouteUnitOrderCount($Route->getId(),$i,$Unit->getId());
		if($i==$RoutePointCollection->getCount()+1 && !$Route->getIsLoop($Unit))// wenn routen ende und es eine endlosschleife ist dann neu starten ansonsten die unit von der route befreien
		{
			$RouteManager->deleteUnitRouteLink($Unit);// flotte aus der Route entfernen
		}
		// den Route CNT in der db erhöhen
	}
	
	
	public function stopUnit($Unit=false)
	{
		$Request= new Request();
		$UnitFinder= new UnitFinder();
		if(!$Unit)   // keine flotte übergeben also aus regquest auslesen
		{
			$Unit=$UnitFinder->findById($Request->getAsInt("UId"));
		}
		$User= Controler_Main::getInstance()->getUser();	
		if($User->getId()!=$Unit->getUser()->getId())   {return false;}// wenn der User es nicht darf bzw wenn es ein anderer User gemacht hat als der der eingeloggt ist
		$UnitManager= new UnitManager();
		$UnitManager->deleteTask($Unit->getTask());// task löschen
		$RouteManager= new RouteManager();
		$RouteManager->deleteUnitRouteLink($Unit);
		
		//$Unit->getTask()->getId();// taskId holen
		//echo "getMap().deleteTaskById(".$Unit->getTask()->getId().")";
	}
	
	
	public function setUnitToRoute()
	{
		$Request= new Request();
		$UnitFinder= new UnitFinder();
		$RouteFidner= new RouteFinder();
		$UnitManager= new UnitManager();
		$Unit=$UnitFinder->findById($Request->getAsInt("UId"));
		if(!$Unit->getId())	 {return false;}
		// flotte ziehen
		// Route Ziehen
		$Route=$RouteFidner->findById($Request->getAsInt("RId"));
		if(!$Route->getId()){return false;} // wenn keine Flotte gefunden wurde dann fehler
		// verknüpfung eintragen
		$User= Controler_Main::getInstance()->getUser(); 
		if($User->getId()!=$Unit->getUser()->getId())   {return false;}// wenn der User es nicht darf bzw wenn es ein anderer User gemacht hat als der der eingeloggt ist
		$RouteManager= new RouteManager();
		$RouteManager->deleteUnitRouteLink($Unit);
		$UnitManager->deleteTask($Unit->getTask());
		$Loop=$Request->getAsInt("Loop");
		$RouteManager->insertUnitRouteLink($Unit,$Route,$Loop);
		// eventuellen task der flotte löschen
		// task start
		$RoutePoint=$Route->getRoutePointCollection()->getByOrder(1);// weil die flote der route neu zugewisen wird immer beim ersten punkt beginnen	
		$Tast= new Task(0 ,$RoutePoint->getX(),$RoutePoint->getY(),time(),$Unit->getId(),"move");
		$UnitManager->insertTask($Tast);
		$MyTaskCollection  =$UnitFinder->findAllTaskByUnit($Unit);
		echo $MyTaskCollection->getJs();
		echo "MyMap.setTaskCollection(MyTaskCollection);";
		echo "MyMap.render();";
	}
	



	public function getUnitDescription($Unit=false)
	{
		$Request= new Request();
		$User= Controler_Main::getInstance()->getUser();
		$UnitFinder= new UnitFinder();
		if(!$Unit)
		{
			$Unit= $UnitFinder->findById($Request->getAsInt("UId"));
		}
		$RouteFinder= new RouteFinder();
		$RouteCollection=$RouteFinder->findByUserIdSingleRouts($User->getId());
		$SelectetRoute=$RouteFinder->findByUnit($Unit);		
		switch($Unit->getHighesUnit())
		{
			case "bds":
				{
				$TempLate=Template::getInstance("./map/tpl_Map_BuildDeathStarDescription.php");
				// in der nähe befindliche freundliche flotten finden
				//Fortschritt berechnen
				$CompleteProgress=DEATH_STAR_LIFE+DEATH_STAR_DMG;// entspricht 100 %
				$DeathStarProgress=$Unit->getHealts()+$Unit->getDMG();
				$TempLate->assign("Progress",round(($DeathStarProgress/$CompleteProgress)*100));	
				$TempLate->assign("NeededMetal",DEATH_STAR_LIFE-$Unit->getHealts());
				$TempLate->assign("NeededCristal",DEATH_STAR_DMG-$Unit->getDMG());			
				$UnitCollection= $UnitFinder->findAllByKoordinates($Unit->getX(),$Unit->getY(),25)->getByAllianzId($Unit->getUser()->getAllianzId());
				$UnitCollection->deleteUnit($Unit);
				$TempLate->assign("UnitCollection",$UnitCollection);
				}break;
				
			case "ds":
			{
				$TempLate=Template::getInstance("./map/tpl_Map_DethStarDescription.php");
			}break;
			
			default:	
				$TempLate=Template::getInstance("./map/tpl_Map_UnitDescription.php");
				
				$TempLate->assign("SelectetRoute",$SelectetRoute);
				$TempLate->assign("RouteCollection",$RouteCollection);

		}
		$TempLate->assign("Unit",$Unit);
		if($User->getAllianzId()==$Unit->getUser()->getAllianzId() && $User->getId()!=$Unit->getUser()->getId())  // wenn die Flotte allianz ist
		{
			$TempLate->assign("AllianzUnit",true);
		}
		if($User->getId()==$Unit->getUser()->getId())	// wenn es die eigene allianz ist
		{
			$TempLate->assign("OwneUnit",true);
		}else
		{
			$TempLate->assign("OwneUnit",false);	
		}
		$TempLate->render();
	}

	public function getRoute()
	{
		$Request= new Request();
		$TempLate=Template::getInstance("./map/tpl_Map_Route.php");
		$TempLate->render();
	}

	public function getPlanetDescription()
	{
		$Request= new Request();
		$User= Controler_Main::getInstance()->getUser();	
		$PlanetFinder= new PlanetFinder();
		$Planet=$PlanetFinder->findById($Request->getAsInt("PId"));
		if($User->getId()==$Planet->getUser()->getId())
		{
			$TempLate=Template::getInstance("./map/tpl_PlanetOwne.php");	
		}else
		{
			$TempLate=Template::getInstance("./map/tpl_Map_PlanetOthers.php");
		}
		$TempLate->assign("Planet",$Planet);
		$TempLate->render();
	}


	/**
	 * berechnet die kate, findet Kolo prozesse , berechnet kämpfe, und berechnet die positionen der flotten
	 *
	 * @return void 
	 *
	 */
	public function calculateMap()
	{
		$ReQuest= new Request();
		if($ReQuest->getAsString("Key")!=MAP_REFRESH_KEY){return false;}
		// db wählen
		
		if($ReQuest->getAsInt("S"))	
		{
			$Controler_Main=Controler_Main::getInstance();
			$Controler_Main->setDataBaseId($ReQuest->getAsInt("S"));
		}
		$ResourceControler=new Controler_Resource();
		//$ResourceControler->setAllRessource();
		
		echo "ressourcen wurden berechnet ".Controler_Main::getInstance()->getEndTime()."<br />";
		$this->setUnitsKoords();
		echo "flotten bewegungen wurden gesetzt ".Controler_Main::getInstance()->getEndTime()."<br />";
		$this->findKolo();
		echo "kolonisationen wurden gefunden ".Controler_Main::getInstance()->getEndTime()."<br />";
		$this->findBattles();	
		echo "kämpfe wurden gefunden ".Controler_Main::getInstance()->getEndTime()."<br />";
		$this->claculateBattles();
		echo "kämpfe wurden berechnet ".Controler_Main::getInstance()->getEndTime()."<br />";
		
		$StateManager= new StateManager();
		$StateManager->deleteExpiredStates();
		echo "States wurden gelöscht ".Controler_Main::getInstance()->getEndTime()."<br />";
		
	}

	public function calculateMartyr()
	{
		$UnitFinder= new UnitFinder();
		$UnitManager= new UnitManager();
		$UnitCollection=$UnitFinder->findAllWithTaskAndMartyr();	 // findet alle einheiten die in bewegung sind und kolo tool haben
		$PlanetFinder= new PlanetFinder();
		$PlanetManager= new PlanetManager();
		$MessageControler= new Controler_Message();
		foreach($UnitCollection as $Unit)
		{
			$Planet=$PlanetFinder->findAllByKoordinates($Unit->getX(),$Unit->getY(),30)->getByIndex(0);
			if($Planet->getId() )// Planet verwursten und Flotte löschen
			{
				if($Planet->getUser()->hasAllianz() && $Planet->getUser()->getAllianzId()==$Unit->getUser()->getAllianzId()) // wenn alli mitglied ist
				{
					continue;
				}else
				{// hat keine alli
					if($Planet->getUser()->getId()==$Unit->getUser()->getId())
					{
						continue;
					}
				}
				$this->destrcutPlanet($Planet);
				
				$Buildmanager =new BuildingManager();
				$Buildmanager->resetState($Planet->getId());
				
				
				$Planet->getUser();
				$MessageControler->sendMessage(SYSTEM_NAME,$Planet->getUser()->getName(),":T_MAERTYR_HITBY:",":T_MAERTYR_HITBY2:");
				$UnitManager->deleteUnit($Unit);
			}
		}		
	}


	public function scanArea($Unit=false)
	{
	// Unit  suchen 
		$Request= new Request();
		$UnitFinder= new UnitFinder();
		if(!$Unit)   // keine flotte übergeben also aus regquest auslesen
		{
			$Unit=$UnitFinder->findById($Request->getAsInt("UI"));
		}
		$User= Controler_Main::getInstance()->getUser();	
		if(!$User || !$User->getId())   
		{
			$User=$Unit->getUser();
		}// wenn der User es nicht darf
		
		if(!$User->getId())   
		{
			return false;
		}
		if($Unit->getExtentionOne()!=10)   {return false;}// wenn die einheit keinen scanner hat
		$PlanetFinder= new PlanetFinder();
		$PlanetCollection=$PlanetFinder->findAllByKoordinates($Unit->getX(),$Unit->getY(),100);
		$Planet=$PlanetCollection->getByIndex(0);
		if($Planet->getId()==0 && $Unit->getExtentionOne() == 10){return false;}
		$Controler_Message= new Controler_Message();
		$User= Controler_Main::getInstance()->getUser();
		Controler_Event::getInstance()->addEvent(new PlanetsScannedEvent($User));
		$Controler_Message->sendPlanetViewMessageToPlayer($Unit->getUser()->getName(),$Unit,$Planet);
		$State = new StateScannerOffline(12,"scan",time()+ STATE_SCANNER_OFFLINE,"","");
		$StateManager = new StateManager();
		$StateManager->insertStatetoUnit($State, $Unit);	
	}
		
		
		
		
	public function recycleWaste($Unit=false)
	{
		$Request= new Request();
		$UnitFinder= new UnitFinder();
		if(!$Unit)   // wenn keine flotte übergeben worden ist dann lade diese hier muhahaha
		{
			$Unit=$UnitFinder->findById($Request->getAsInt("UI"));
		}
		$MapObjectFinder= new MapObjectFinder();
		$MapObject= $MapObjectFinder->findAllByKoordinates($Unit->getX(),$Unit->getY(),75)->getByIndex(0);
		if($MapObject->getId()!=0 && $Unit->getExtentionOne()==22)
		{
			$UnitManager= new UnitManager();
			$MapObjectManager= new MapObjectManager();
			$MapObjectManager->deleteMapObject($MapObject);

			$RessourceCount= mt_rand(UNIT_WAST_RESSOURCE_RECYCLE_MIN,UNIT_WAST_RESSOURCE_RECYCLE_MAX);
			
			if($RessourceCount>$Unit->getFreeStoredSpace())
			{
				$RessourceCount=$Unit->getFreeStoredSpace();
			}
			
			$Ressource=mt_rand(0,2);
			switch($Ressource)
			{
				case 0:
				{
					$Unit->setStoredElement("m",$Unit->getStoredElement("m",true)+$RessourceCount);
				}break;	
				case 1:
				{
					$Unit->setStoredElement("c",$Unit->getStoredElement("c",true)+$RessourceCount);
				}break;	
				case 2:
				{
					$Unit->setStoredElement("t",$Unit->getStoredElement("t",true)+$RessourceCount);
				}break;	
			}
			
			// bei jedem 3 recycle einen neuen asteroiden spwanen lassen
			if(mt_rand(0,2)==0)
			{
				$this->addAsteroid(mt_rand(-20000,20000)+$MapObject->getX(),mt_rand(-20000,20000)+$MapObject->getY());
			}
			
			
			$UnitManager->updateUnit($Unit);
			//$this->getUnitDescription($Unit);
			
			echo "getMap().getMapObjectCollection().deleteById(".$MapObject->getId().");
			getMap().showUnitDesciption(".$Unit->getId().");";
			
			
			return true;
		}
		$this->getUnitDescription();
		
		
		
	}	
		
	/**
	 * Zerstört den Planeten wenn ein Todesstern drauf schiesst
	 * */
	public function destroyPlanet($DeathStar=false)
	{
		$Request= new Request();
		$UnitFinder= new UnitFinder();
		$User= Controler_Main::getInstance()->getUser();
		if(!$DeathStar)   // wenn keine flotte übergeben worden ist dann lade diese hier muhahaha
		{
			$DeathStar=$UnitFinder->findById($Request->getAsInt("UI"));
		}
		// ressourcen checken
		$UnitCollection = $UnitFinder->findByUserId($User->getID());
		foreach($UnitCollection as $Ship)
		{
			$State = new StateMoral(1,"moral",time()+ STATE_DEATHSTAR_BONUS,"","");
			$StateManager = new StateManager();
			$StateManager->insertStatetoUnit($State, $Ship);
		}
		
		// einen planeten in der umgebung finden
		//und den kaputt machen
		$PlanetFinder= new PlanetFinder();
		$BuildingManager= new BuildingManager();
		$Planet=$PlanetFinder->findAllByKoordinates($DeathStar->getX(),$DeathStar->getY(),DEATH_STAR_DESTROY_RANGE)->getByIndex(0);
		if(!$Planet) {return false;}
		$PlanetManager= new PlanetManager();
		$Target = $Planet->getUser();
		$UnitCollection = $UnitFinder->findByUserId($Target->getID());
		foreach($UnitCollection as $Ship)
		{
			$State = new StateFrightened(11,"moral",time()+ STATE_DEATHSTAR_MALUS,"","");
			$StateManager = new StateManager();
			$StateManager->insertStatetoUnit($State, $Ship);
		}
		
		if($Planet->getBuildingByType(23)->getLevel()>0)
		{
			$DeathStar->addExperience(5000);
			$UnitManager = new UnitManager();
			$UnitManager->updateUnit($DeathStar);
			$BuildingManager->destructBuilding($Planet->getId(),23,$Planet->getBuildingByType(23)->getLevel()-1);
			$Controler_Message= new Controler_Message();
			$Controler_Message->sendPlanetAttacked($Planet->getUser(),$Planet->getName(),$DeathStar->getUser()); //nachrichten versenden
			$Controler_Message->sendPlanetYouAttacked($Planet->getUser(),$Planet->getName(),$DeathStar->getUser()); //nachrichten versenden
		} else
		{
			$UserManager = new UserManager();
			$UserManager->addExperiance($User->getId(),$Planet->getPeopleCount(true));
			$Controler_Message= new Controler_Message();
			$Controler_Message->sendPlanetDestroyed($Planet->getUser(),$Planet->getName(),$DeathStar->getUser()); //nachrichten versenden
			$PlanetManager->delete($Planet);
			$DeathStar->addExperience(5000);
			$UnitManager = new UnitManager();
			$UnitManager->updateUnit($DeathStar);
			
		}
		
		
		// müll auf der karte platzieren
		for($i=0;$i<DEATH_STAR_DESTROY_CREATE_WAST;$i++)// müll hinzufügen wo vorher der planet war
		{
			$this->addWast($Planet->getX()+mt_rand(-50,50),$Planet->getY()+mt_rand(-50,50));
		}
		if ($PlanetFinder->countPlanetsByUser($Target) == 0)
		{
			$Planet=$PlanetFinder->findNewPlanet(1);
			$Planet->setUser($Target);
			$PlanetManager= new PlanetManager();
			$PlanetManager->insertPlanet($Planet);
			$PlanetId=$PlanetManager->getLastInsertId();
			$BuildingManager->addHQ($PlanetId);
			$BuildingManager->addMetallMine($PlanetId);
			$BuildingManager->addTown($PlanetId);
			$BuildingManager->addPlantation($PlanetId);
		}
		
		
		

		
		return false;	
			
	}
	
	public function loadDeathStar($Unit=false,$DeathStar=false)
	{
		$Request= new Request();
		$UnitFinder= new UnitFinder();
		if(!$Unit)   // wenn keine flotte übergeben worden ist dann lade diese hier muhahaha
		{
			$Unit=$UnitFinder->findById($Request->getAsInt("TransporterId"));
		}
		if(!$DeathStar)   // wenn keine flotte übergeben worden ist dann lade diese hier muhahaha
		{
			$DeathStar=$UnitFinder->findById($Request->getAsInt("UI"));
		}
		// ressourcen checken
		
		$Crystal=$Unit->getStoredElement("c",true);
		$Metal=$Unit->getStoredElement("m",true);
			
		if($Metal+$DeathStar->getHealts() >=DEATH_STAR_LIFE)	
		{
			$Unit->setStoredElement("m",($Metal+$DeathStar->getHealts())-DEATH_STAR_LIFE);
			$DeathStar->setHealts(DEATH_STAR_LIFE);
		}else
		{
			$Unit->setStoredElement("m",0);
			$DeathStar->setHealts($Metal+$DeathStar->getHealts());
		}
		
		if($Crystal+$DeathStar->getDMG() >=DEATH_STAR_DMG)	
		{
			$Unit->setStoredElement("c",($Crystal+$DeathStar->getDMG())-DEATH_STAR_DMG);
			$DeathStar->setDMG(DEATH_STAR_DMG);
		}else
		{
			$Unit->setStoredElement("c",0);
			$DeathStar->setDMG($Crystal+$DeathStar->getDMG());
		}
		$DeathStar->setSpeed(0);// den speed auf 0 setzen weil noch im bau
		$DeathStar->setAmor(DEATH_STAR_ARMOR);
		// wenn dmg und lief max dann aus dem ding ein todesstern machen der fertig ist muuhahahahaha
		if($DeathStar->getDMG() >=DEATH_STAR_DMG && $DeathStar->getHealts() >=DEATH_STAR_LIFE)	
		{
			// das ding ist ein todesstern
			$DeathStar->setSpeed(DEATH_STAR_SPEED);// geschwindigkeit setzen 
			$Unit->clearStoredElement();
			$DeathStar->setShipCount("ds:1");// zum todesstern machen
		}
		$UnitManager= new UnitManager(); // in die db schreiben
		$UnitManager->updateUnit($Unit);	
		$UnitManager->updateUnitNoneOriginal($DeathStar);
		$this->getUnitDescription($DeathStar);
		return false;	
			
		}
	
	public function buildDeathStar($Unit=false)
	{
		$Request= new Request();
		$UnitFinder= new UnitFinder();
		if(!$Unit)   // wenn keine flotte übergeben worden ist dann lade diese hier muhahaha
		{
			$Unit=$UnitFinder->findById($Request->getAsInt("UI"));
		}
		// ressourcen checken
		
		if($Unit->getStoredElement("t",true)>=50000 && $Unit->getStoredElement("m",true)>=50000 && $Unit->getStoredElement("c",true)>=50000 && $Unit->getStoredElement("b",true)>=50000)
		{
			$UnitManager= new UnitManager();
			$Unit->clearStoredElement(); // alle güter wegmachen
			$Unit->setShipCount("bds:1");// zum todestern im bau machen
			$Unit->setSpeed(0);
			$Unit->setAmor(DEATH_STAR_ARMOR);	
			$Unit->setDMG(0);
			$Unit->setExtentionOne(0);
			$Unit->setExtentionTow(0);
			$Unit->setHealts(1000);	
			$UnitManager->updateUnitNoneOriginal($Unit);
			return true;
		}
			
		return false;	
			
		}
		
		
		
		
	/**
	 *  wenn eine einheit einen planeten überfällt
	 *
	 * @return void 
	 *
	 */
	public function raidPlanet($Unit=false)
	{
	// Unit  suchen 
		$Request= new Request();
		$UnitFinder= new UnitFinder();
		if(!$Unit)   // wenn keine flotte übergeben worden ist dann lade diese hier muhahaha
		{
			$Unit=$UnitFinder->findById($Request->getAsInt("UI"));
		}
	// ist die Unit und darf die das stimmt es mit dem User Überein 
		$User= Controler_Main::getInstance()->getUser();
	// 	
		if($User->getId()!=$Unit->getUser()->getId())   {return false;}// wenn der User es nicht darf
		if($Unit->getExtentionOne()!=20)   {return false;}// wenn die einheit keine Laderampe hat
		$PlanetFinder= new PlanetFinder();
		$PlanetCollection=$PlanetFinder->findAllByKoordinates($Unit->getX(),$Unit->getY(),100);
		$Planet=$PlanetCollection->getByIndex(0);
		$UnitManager= new UnitManager();
		
		
		if($Planet->getId()==0 && $Unit->getExtentionOne() == 20){return false;}
			
			// Ressourcen ermitteln 
			// speicherplatz der einheit ermitteln	
			$FreeSpace=$Unit->getFreeStoredSpace();
			
			if(	$FreeSpace>0)
			{
				$PartCount=mt_rand(3,20);
				$Part= (int) $FreeSpace/$PartCount; // wieviel 
			}
			
			for($i=0;$i<$PartCount;$i++)
			{
				$Random1=mt_rand(0,3);	// der freie speicher wird in 3 teile zerteilt und random ausgewürfelt was ein drittel bekommt
				switch($Random1)
				{
					case 0:
					{
						$Metal+=$Part;
					}break;
					case 1:
					{
						$Cristal+=$Part;
					}break;
					case 2:
					{
						$Hydrogen+=$Part;
					}break;
					case 3:
					{
						$BioMass+=$Part;
					}break;
				}
			}
			$PlanetManager= new PlanetManager();
			if($Metal<$Planet->getMetal(true))
			{	 
				$Unit->setStoredElement("m", (int) $Metal + $Unit->getStoredElement("m",true));// auf schiff laden und vom planeten entfernen
				$PlanetManager->addMetal($Planet,$Metal*-1);// vom planeten entfernen
			}else
			{	 // wenn nicht genug ressis auf den planeten vorhanden sind
				$Unit->setStoredElement("m", (int) $Planet->getMetal(true) + $Unit->getStoredElement("m",true));
				$PlanetManager->addMetal($Planet,$Planet->getMetal(true)*-1);
			}
			
			
			if($Cristal<$Planet->getCrystal(true))
			{	 
				$Unit->setStoredElement("c", (int) $Cristal + $Unit->getStoredElement("c",true));// auf schiff laden und vom planeten entfernen
				$PlanetManager->addCristal($Planet,$Cristal*-1);// vom planeten entfernen
			}else
			{	 // wenn nicht genug ressis auf den planeten vorhanden sind
				$Unit->setStoredElement("c",(int) $Planet->getCrystal(true) + $Unit->getStoredElement("c",true));
				$PlanetManager->addCristal($Planet,$Planet->getCrystal(true)*-1);
			}
			
			
			if($Hydrogen<$Planet->getHydrogen(true))
			{	 
				$Unit->setStoredElement("t", (int) $Hydrogen + $Unit->getStoredElement("t",true));// auf schiff laden und vom planeten entfernen
				$PlanetManager->addHydrogen($Planet,$Hydrogen*-1);// vom planeten entfernen
			}else
			{	 // wenn nicht genug ressis auf den planeten vorhanden sind
				$Unit->setStoredElement("t", (int) $Planet->getHydrogen(true) + $Unit->getStoredElement("t",true));
				$PlanetManager->addHydrogen($Planet,$Planet->getHydrogen(true)*-1);
			}
			
			if($BioMass<$Planet->getBiomass(true))
			{	 
				$Unit->setStoredElement("b", (int) $BioMass + $Unit->getStoredElement("b",true));// auf schiff laden und vom planeten entfernen
				$PlanetManager->addBioMass($Planet,$BioMass*-1);// vom planeten entfernen
			}else
			{	 // wenn nicht genug ressis auf den planeten vorhanden sind
				$Unit->setStoredElement("b", (int) $Planet->getBiomass(true) + $Unit->getStoredElement("b",true));
				$PlanetManager->addBioMass($Planet,$Planet->getBiomass(true)*-1);
			}
			// schiff speichern
			
			$UnitManager->updateUnit($Unit);// einheit speichern
			
			$Controler_Message= new Controler_Message();
			$Controler_Message->sendPlanetRaidMessageToPlayer($Unit->getUser()->getName(),$Unit,$Planet,$Metal,$Cristal,$Hydrogen,$BioMass); //nachrichten versenden
			$State = new StateBayOffline(13,"raid",time()+ STATE_BAY_OFFLINE,"","");
			$StateManager = new StateManager();
			$StateManager->insertStatetoUnit($State, $Unit);
			$Request->setPost("UId",$Unit->getId());// die Flottten Id auf einen andern schlüssel legen	
			$this->getUnitDescription();
			Controler_Event::getInstance()->addEvent(new PlanetRaidedEvent($Unit->getUser()));
			return true;
			
		
		
		return false;
		
	}
	
	/**
	 * sucht alle kampfschauplätze und berechnet die healts der einheiten
	 *
	 * @return void 
	 *
	 */
	public function claculateBattles()
	{
		// alle battles finden
		$UnitFinder= new UnitFinder();
		$BattleArray=$UnitFinder->findallBattlesAsIdArray();
		$StateManager= new StateManager();
		$StateManager->deleteExpiredStates();		
		$UnitManager= new UnitManager();
		foreach ($BattleArray as $BattleId)
		{
			$Battle=$UnitFinder->findBattleById($BattleId['i_Id']);
			foreach($Battle->getUnitsOutOfRange() as $Unit)// wenn einheit geflüchtet ist dann wird die einheit aus dem battle entfernt
			{
				$UnitManager->deleteUnitByBattle($Unit);
			}
			
			if($Battle->canDelete())
			{
				$UnitManager->deleteBattle($Battle);
				continue;
			}
			$Battle->calculate();
			$UnitManager->updateBattle($Battle);

		}
		$DestroyedUnitCollection=$UnitFinder->findDestroyedUnit();
		foreach($DestroyedUnitCollection as $Unit)
		{
			$UnitManager->deleteUnit($Unit);// einheit löschen
			// wenn flotten kaputt gehen muss müll dahin gemacht werden hahah :)
			Controler_Event::getInstance()->addEvent(new UnitLostEvent($Unit->getUser()));
			$this->addWast($Unit->getX(),$Unit->getY());
		}
		$UnitManager->updateUnitLevel();

		// leere battles entfernen	
	}
	
	
	/**
	 * fügt müll auf die karte
	 *
	 * @param int $X die X koordinate
	 * @param int $Y die Y koordinate
	 * @return void 
	 *
	 */
	public function addWast($X,$Y)
	{
		$Mapobject= new MapObject(0,"Müll",1,"Destroyed".mt_rand(1,3).".png",$X,$Y,50,50,(time()+MAP_WAST_TIME));
		$MapobjectManager= new MapObjectManager();
		$MapobjectManager->insertMapObject($Mapobject);
	}
	
	
	/**
	 * fügt einen asteriod der karte hinzu
	 *
	 * @return void 
	 *
	 */
	public function addAsteroid($X,$Y)
	{
		$Mapobject= new MapObject(0,"Asteriod",2,"Asteroid".mt_rand(1,3).".png",$X,$Y,35,35,(time()+MAP_WAST_TIME));
		$MapobjectManager= new MapObjectManager();
		$MapobjectManager->insertMapObject($Mapobject);
	}
	
	/**
	 * prüft einheiten ab ob sie eine begegnung mit einer anderen haben von einem anderen spielr oder fügt eine einheit einem bestehenden kampf schau platz zu
	 *
	 * @return void 
	 *
	 */
	public function findBattles()
	{
		// beswegte einheiten suchen
		$UnitFinder= new UnitFinder();
		$UnitCollection=$UnitFinder->findAllWithTask();	 // findet all einheiten die in bewegung sind
		$UnitManager= new UnitManager();
		$Controler_Message= new Controler_Message();
		foreach ($UnitCollection as $Unit)
		{
			// einheiten herum um die einheit finden				$Unit
			//$TempCollection=$UnitFinder->findBetweenKoordinates($Unit->getX()-BATTLE_RANGE,$Unit->getX()+BATTLE_RANGE,$Unit->getY()-BATTLE_RANGE,$Unit->getY()+BATTLE_RANGE);
			$TempCollection=$UnitFinder->findAllByKoordinates($Unit->getX(),$Unit->getY(),BATTLE_NEW_BATTLE_RANGE);
			if($TempCollection->getCount()>0 && $TempCollection->areUnitsFormDifferentPlayer() && $TempCollection->areUnitsFormDifferentAllianz())
			{
				// gucken ob einheiten bereits in einem battle sind
				switch($UnitFinder->areUnitsInbattle($TempCollection))// wenn einheiten noch nicht in einem kampf sind oder in der selben allianz
				{
					case 0:	 // keine einheit drin
					{
						$TempBattle= new Battle(0,microtime(true),$TempCollection,$TempCollection->getAverageX(),$TempCollection->getAverageY());
						$UnitManager->insertBattle($TempBattle);
						//$UnitManager->deleteTaskByBattle($TempBattle);
						// task von den einheiten entfernen
						// nachricht an user schicken 
						$Controler_Message->sendMessageToUserFromUnitCollection(SYSTEM_NAME,$TempCollection,":T_UNDERATTACK: <a title=\":T_LINK_TOMAP:\" href=\"index.php?Section=Map&amp;X=".round($Unit->getX())."&amp;Y=".round($Unit->getY())."\"> ".round($Unit->getX()).":".round($Unit->getY())."</a>",":T_UNDERATTACK_TITLE:");
	
					}break;	// eine oder unbestimmt viele einheiten drinn
					case 1:
					{
						  // einheiten suchen die nicht im battle sind
						$Battle=$UnitFinder->findBattleByKoordinatesAndRange($Unit->getX(),$Unit->getY(),BATTLE_NEW_BATTLE_RANGE+10);
						if($Battle->getId()==0)	// dann ist der kampf nicht in range und es muss ein neuer kampf rein gemacht werden 
						{
							$TempBattle= new Battle(0,microtime(true),$TempCollection,$TempCollection->getAverageX(),$TempCollection->getAverageY());
							$UnitManager->insertBattle($TempBattle);
							foreach($Battle->getUnitCollection() as $MessageUnit)
							{
								if($UnitFinder->isUnitInBattle($MessageUnit->getId()))
								{
									$Controler_Message->sendMessage(SYSTEM_NAME, $MessageUnit->getUser()->getName(),":T_UNDERATTACK: <a title=\":T_LINK_TOMAP:\" href=\"index.php?Section=Map&amp;X=".round($Unit->getX())."&amp;Y=".round($Unit->getY())."\"> ".round($Unit->getX()).":".round($Unit->getY())."</a>",":T_UNDERATTACK_TITLE:");
								}
							}
							continue;// neuen kampf eintragen und fertig	
						}
						$NewCollection=new UnitCollection();
						foreach($TempCollection as $TempUnit)
						{
							if(!$UnitFinder->isUnitInBattle($TempUnit->getId()))
							{
								$NewCollection->add($TempUnit);
							}
						}
						$UnitManager->addUnitsToBattle($Battle->getId(),$NewCollection);
						//$UnitManager->deleteTaskByBattle($Battle);
						$Controler_Message= new Controler_Message();
						
						foreach($Battle->getUnitCollection() as $MessageUnit)
						{
							if($UnitFinder->isUnitInBattle($MessageUnit->getId()))
							{
								$Controler_Message->sendMessage(SYSTEM_NAME, $MessageUnit->getUser()->getName(),":T_UNDERATTACK: <a title=\":T_LINK_TOMAP:\" href=\"index.php?Section=Map&amp;X=".round($Unit->getX())."&amp;Y=".round($Unit->getY())."\"> ".round($Unit->getX()).":".round($Unit->getY())."</a>",":T_UNDERATTACK_TITLE:");
							}
						}
						//$Controler_Message->sendMessageToUserFromUnitCollection(SYSTEM_NAME,$NewCollection,"Eine oder mehrere Einheiten sind in einen kampf verwickelt <a title=\"zur Karte\" href=\"index.php?Section=Map&amp;X=".round($Unit->getX())."&amp;Y=".round($Unit->getY())."\"> ".round($Unit->getX()).":".round($Unit->getY())."</a>","Einheit wird angegriffen");

					}break;
					default: // alle einheiten drinn	
				}
			}
		}
	}

	/**
	 * findet alle planeten kolonisationen 
	 *
	 * @return void 
	 *
	 */
	public function findKolo()
	{
		$UnitFinder= new UnitFinder();
		$UnitCollection=$UnitFinder->findAllWithTaskAndKolo();	 // findet alle einheiten die in bewegung sind und kolo tool haben
		$PlanetFinder= new PlanetFinder();
		$planetManager= new PlanetManager();
		foreach ($UnitCollection as $Unit)
		{
			$Planet=$PlanetFinder->findAllByKoordinates($Unit->getX(),$Unit->getY(),50)->getByIndex(0);
			if($Planet->getId()==0)
			{
				continue;
			}
			// gucken ob in gleicher allianz oder selber spieler
			if($Planet->getUser()->getId()==$Unit->getUser()->getId())
			{
				continue;
			}
			if($Unit->getUser()->hasAllianz() && $Planet->getUser()->hasAllianz())
			{
				if($Planet->getUser()->getAllianzId()==$Unit->getUser()->getAllianzId())
				{
					continue;
				}
			}
			// noob schutz einbauen 
			// wenn lvl unterschied größer 10 ist soll
			$UnitManager= new UnitManager();
			$UnitFinder= new UnitFinder();
			$Controler_Message= new Controler_Message();
			$UnitCollection= $UnitFinder->findByUserId($Planet->getUser()->getId());
			$PlanetCollection=$PlanetFinder->findByUserId($Planet->getUser()->getId());
			if($UnitCollection->getCount()==0 &&
				$Planet->getUser()->getId()!=0 &&
				$PlanetCollection->getCount()==1 &&
				($Planet->getUser()->getRefresh()+UNIT_KOLO_COOLDOWN) > microtime(true))// wenn länger als 6 wochen nicht eingeloggt
			{
				
				$Controler_Message->sendMessage("System", $Unit->getUser()->getName(),":T_PLANET_OVERTAKE_NO1: ".$Planet->getName()." :T_PLANET_OVERTAKE_NO2:",":T_PLANET_OVERTAKE_NO3:");
				return false;
			}
			
			$EnemyUnitsCollection=$UnitFinder->findAllByKoordinates($Planet->getX(),$Planet->getY(),UNIT_SIEGE_RANGE);// alle einheiten finden
			if($EnemyUnitsCollection->getByUserId($Planet->getUser()->getId())->getCount())
			{
				$UnitManager->deleteUnit($Unit);
				$Controler_Message->sendMessage("System", $Unit->getUser()->getName(),":T_PLANET_TAKEOVER_FAIL1: ".$Planet->getName()." :T_PLANET_TAKEOVER_FAIL2:.",":T_PLANET_TAKEOVER_FAIL_TITLE:");
				return false;	
			}
			
			if($Planet->getBuildingCollection()->getByTypeId(23)->getId()>0)
			{
				// auf dem planeten ein gebäude zerstören
				$BuildingManager= new BuildingManager();
				$BuildingManager->destructBuilding($Planet->getId(),23,$Planet->getBuildingCollection()->getByTypeId()->getLevel()-1);
				$UnitManager->deleteUnit($Unit);
				$Controler_Message->sendMessage("System", $Unit->getUser()->getName(),":T_PLANET_TAKEOVER_FAIL1: ".$Planet->getName()." :T_PLANET_TAKEOVER_FAIL2:.",":T_PLANET_TAKEOVER_FAIL_TITLE:");
				return false;	
			}
			
			$UserId= $Unit->getUser()->getId();
			$Planet->setCrystal($Planet->getCrystal()+$Unit->getStoredElement("c"));
			$Planet->setHydrogen($Planet->getHydrogen()+$Unit->getStoredElement("t"));
			$Planet->setMetal($Planet->getMetal()+$Unit->getStoredElement("m"));
			$Planet->setBiomass($Planet->getBiomass()+$Unit->getStoredElement("b"));
			$Unit->setStoredElement("m",0);
			$Unit->setStoredElement("b",0);
			$Unit->setStoredElement("c",0);
			$Unit->setStoredElement("t",0);
			$planetManager->updateResources($Planet);
			$this->destrcutPlanet($Planet);// gebäude zerstören usw.
			$planetManager->updateOwner($Planet,$Unit->getUser());	 //Planet Übernehmen
			$OldUser= $Planet->getUser();
			$PlanetCollection=$PlanetFinder->findByUserId($OldUser->getId());
			// besatzer entfernen - xp geben+-
			$Unit->setExtentionTow(0);
			$Unit->setExtentionOne(0);
			$Unit->addExperience(5000);
			
			
			$UnitManager->updateUnit($Unit);
			$UserManager= new UserManager();
			Controler_Event::getInstance()->addEvent(new PlanetsLostEvent($OldUser));
			
			// Nachrichten Verschicken
			
			$FromUser=$Unit->getUser();// der neue besitzer
			$Controler_Message->sendPlanetOverTake($Planet,$FromUser,$OldUser);
			Controler_Event::getInstance()->addEvent(new PlanetsGottenEvent($FromUser));
			$UserManager->addExperiance($Unit->getUser()->getId(),5000);  // 5k exp dem spieler gutschreiben
			
			if($PlanetCollection->getCount()>=1)
			{
				continue;
			}
			// User einen neuen Planeten geben	
			
			$PlanetControler= new Controler_Planet();   // neuen Planeten erstellen sofern der benutzer nur einen Planeten besitzt
			$Planet=$PlanetControler->getRandomPlanet();
			$Planet->setUser($OldUser);
			
			$PlanetManager= new PlanetManager();
			$PlanetManager->insertPlanet($Planet);
			$PlanetId=$PlanetManager->getLastInsertId();
			$BuildingManager= new BuildingManager();
			$BuildingManager->addHQ($PlanetId);
			$BuildingManager->addMetallMine($PlanetId);
		}
	}
	
	
	/**
	 * zerstört den planeten zersört gebäude und forschungen und zerstört die schiffe auf den Planeten und setzt die bevölkerunge auf 0
	 *
	 * @return void 
	 *
	 */
	private function destrcutPlanet(Planet $Planet)
	{
		$PlanetManager= new PlanetManager();
		$BuildingManager= new BuildingManager();
		$BuildingLevelCount= (int) $Planet->getBuildingCollection()->countBuildingLevels()/2;
		// alle gebäude level zählen 
		// alle Forschungs einträge level zählen
	
		for($i=0;$Planet->getBuildingCollection()->getCount()>$i  ;$i++)
		{	
			$Building=$Planet->getBuildingCollection()->getByIndex(mt_rand(0,$Planet->getBuildingCollection()->getCount()-1));
			if($BuildingLevelCount<=0){continue;}
			if($Building->getLevel()>$BuildingLevelCount)
			{
				$NegLevel=mt_rand(0,$BuildingLevelCount);
			}else
			{
				$NegLevel=mt_rand(0,$Building->getLevel());
			}
			settype($NegLevel,"integer");
			$BuildingLevelCount=$BuildingLevelCount-$NegLevel;
			settype($BuildingLevelCount,"integer");
			if($Building->getLevel()<=$NegLevel)
			{
				// gebäude löschen
				$BuildingManager->deleteBuilding($Planet->getId(),$Building->getType());
			}else
			{
				// das level des gebäudes runter setzen
				$BuildingManager->destructBuilding($Planet->getId(),$Building->getType(),$Building->getLevel()-$NegLevel);
			}
		}
		
		$ReSearchManager=new ReSearchManager();// die hälfte der forschung löschen
		for($i=0;$Planet->getReSearchCollection()->getCount()>$i ;$i++)
		{	
			$ReSearch=$Planet->getReSearchCollection()->getByIndex(mt_rand(0,$Planet->getReSearchCollection()->getCount()-1));
			$ReSearchManager->deleteReSearch($Planet->getId(),$ReSearch->getReSearchId());
		}
		
		if($Planet->getBuildingCollection()->getByTypeId(23)->getId()>0)
		{
			// auf dem planeten ein gebäude zerstören
			$BuildingManager= new BuildingManager();
			$BuildingManager->destructBuilding($Planet->getId(),23,$Planet->getBuildingCollection()->getByTypeId()->getLevel()-1);
		}
		 // alle schiffe löschen
		$ShipManager= new ShipManager();
		$ShipManager->deleteShipByPlanet($Planet->getId());
		$Planet->setPeopleCount(0);	   // bevölkerung auf null setzen
		$PlanetManager->updatePeopleCount($Planet);
	}

	public function getAllByKoord()
	{
		$Request= new Request();
		$StartX=	 $Request->getAsInt("X");
		$StartY=	 $Request->getAsInt("Y");
		$Zoom=	 $Request->getAsInt("Zoom");
		$User= Controler_Main::getInstance()->getUser();
		
		$UnitFinder= new UnitFinder();
		$PlanetFinder= new PlanetFinder();
		$MapObjectFinder= new MapObjectFinder();
		
		$BrowserWidth=Controler_Main::getInstance()->getResX();
		$BrowserHeight=Controler_Main::getInstance()->getResY();
		
		if($Zoom<=15)
		{
			$UserPlanetCollection=$PlanetFinder->findAllBetweenKoordinatesAndUserId($User->getId(),$StartX,$StartX+$BrowserWidth*$Zoom,$StartY,$StartY+$BrowserHeight*$Zoom);
			$MyPlanetCollection=$PlanetFinder->findAllBetweenKoordinates($StartX,$StartX+$BrowserWidth*$Zoom,$StartY,$StartY+$BrowserHeight*$Zoom);
			echo $MyPlanetCollection->getJs();
			echo "MyMap.setPlanetCollection(MyPlanetCollection);";
		}
		if($Zoom<=15)
		{
			$MyUnitCollection= $UnitFinder->findBetweenKoordinates($StartX,$StartX+$BrowserWidth*$Zoom,$StartY,$StartY+$BrowserHeight*$Zoom);
			$UserUnitCollection=  $UnitFinder->findByUserIdAndBetweenKoordinates($User->getId(),$StartX,$StartX+$BrowserWidth*$Zoom,$StartY,$StartY+$BrowserHeight*$Zoom);
			$MyUnitCollection->deleteUnitsOutOfRange($User,$UserPlanetCollection);// einheiten die von der reichweite her zuweit weg sind löschen
			$MyUnitCollection->deleteInvisiableUnits($User); // unsitbare einheiten entfernen
			echo $MyUnitCollection->getJs($User);
			echo "MyMap.setUnitCollection(MyUnitCollection);";
		}
		
		if($Zoom<=5)
		{
			$MyMapObjectCollectionTemp= $MapObjectFinder->findBetweenKoordinatesAndTypeSmaller($StartX,$StartX+$BrowserWidth*$Zoom,$StartY,$StartY+$BrowserHeight*$Zoom,2);
		}else
		{
			$MyMapObjectCollectionTemp= new MapObjectCollection(); 
		}
		
		// sonnen laden
		$MyMapObjectCollection= $MapObjectFinder->findBetweenKoordinatesAndTypeHigher($StartX,$StartX+$BrowserWidth*50,$StartY,$StartY+$BrowserHeight*50,3);
		foreach($MyMapObjectCollectionTemp as $MapObject)
		{
			$MyMapObjectCollection->add($MapObject);
		}
		
		echo $MyMapObjectCollection->getJs();
		echo "MyMap.setMapObjectCollection(MyMapObjectCollection);";
		
		echo "MyMap.render();";
	}



	/**
	 * gibt alle flotten anhand der koordinaten zurück
	 *
	 * @return void 
	 *
	 */
	public function getAllUnitsByKoord()
	{
		$Request= new Request();
		$StartX=	 $Request->getAsInt("X");
		$StartY=	 $Request->getAsInt("Y");
		$Zoom=	 $Request->getAsInt("Zoom");
		if($Zoom<1)// verhindert das nicht der komplette server ausgelesen werden kann
		{
			$Zoom=1;	
		}		
		if($Zoom>10)
		{
			$Zoom=10;	
		}
		
		$BrowserWidth=Controler_Main::getInstance()->getResX();
		$BrowserHeight=Controler_Main::getInstance()->getResX();
		$User= Controler_Main::getInstance()->getUser();
		$UnitFinder= new UnitFinder();
		$PlanetFinder= new PlanetFinder();
		$UserPlanetCollection=$PlanetFinder->findAllBetweenKoordinatesAndUserId($User->getId(),$StartX,$StartX+$BrowserWidth*$Zoom,$StartY,$StartY+$BrowserHeight*$Zoom);
		$MyUnitCollection= $UnitFinder->findBetweenKoordinates($StartX,$StartX+$BrowserWidth*$Zoom,$StartY,$StartY+$BrowserHeight*$Zoom);
		//$UserUnitCollection=  $UnitFinder->findByUserIdAndBetweenKoordinates($User->getId(),$StartX,$StartX+800*$Zoom,$StartY,$StartY+500*$Zoom);
		$MyUnitCollection->deleteUnitsOutOfRange($User,$UserPlanetCollection);// einheiten die von der reichweite her zuweit weg sind löschen
		$MyUnitCollection->deleteInvisiableUnits($User); // unsitbare einheiten entfernen
		echo $MyUnitCollection->getJs($User);
		echo "MyMap.setUnitCollection(MyUnitCollection);";
		echo "MyMap.render();";
	}


	public function moveUnit()
	{
		$Request= new Request();
		$StartX=	 $Request->getAsInt("X");
		$StartY=	 $Request->getAsInt("Y");
		$UnitId=	 $Request->getAsInt("UId");	
		
		$UnitFinder= new UnitFinder();
		$Unit= $UnitFinder->findById($UnitId);
		$UnitManager= new UnitManager();
		$UnitCollection=$UnitFinder->findAllWithTask();
		$Task=$UnitFinder->findTaskByUnitId($UnitId);
		if($Task->getId()==0)
		{
			$UnitManager->insertTask(new Task(0,$StartX,$StartY,0,$UnitId,"move"));
		}else
		{
			$Task->setX($StartX);
			$Task->setY($StartY);
			$Task->setRefresh(microtime(true));
			$UnitManager->updateTask($Task);
		}
		$RouteManager= new RouteManager();
		$RouteManager->deleteUnitRouteLink($Unit);// wenn die Follte in einer Route war dann weg machen
		$MyTaskCollection  =$UnitFinder->findAllTaskByUnit($Unit);
		$Request->setPost("UId",$Unit->getId());
		$this->getUnitDescription();
		/*echo $MyTaskCollection->getJs();
		echo "MyMap.setTaskCollection(MyTaskCollection);";
		echo "MyMap.render();";*/
	}
	
	public function jumpToPosition()
	{
		//echo "in der fkt<br />";
		$Request= new Request();
		$StartX=	 $Request->getAsInt("X");
		$StartY=	 $Request->getAsInt("Y");
		$UnitId=	 $Request->getAsInt("UId");	
		//ein drittel , halber tag laden, 3000 einheiten
		$UnitFinder= new UnitFinder();
		$Unit= $UnitFinder->findById($UnitId);
		if(!($Unit->getExtentionTow() == 25))
		{
			return false;
		}
		//echo "nach der abfrage<br />";
		$Distance=sqrt(pow(($Unit->getX()-$StartX),2)+pow ( ($Unit->getY()-$StartY),2));

			//echo "in der berechnuung drinne<br />";
			$Storage = $Unit->getStorage();
			//echo $Storage."<br />";
			$Stored = $Unit->getStoredElement("t",true);
			//echo $Stored."<br />";
			$Take = (int)($Stored / 3 + 1);
			if($Stored-$Take >= 0)
			{
				//echo "im sprung drinn <br />";
				$Unit->setX($StartX);
				$Unit->setY($StartY);
				$UnitManager= new UnitManager();
				//$UnitManager->updateUnitKoordinatesCalculation($Unit,$StartX,$StartY);
				$UnitManager->updateUnit($Unit);
				//echo "nach dem sprung befehl<br />";
				$Unit->setStoredElement("t",$Stored-$Take);
			$State = new StateBayOffline(14,"JUMP",time()+ STATE_JUMP_OFFLINE+$Distance*100,"","");
				$StateManager = new StateManager();
				$StateManager->insertStatetoUnit($State, $Unit);
			}
		$this->getUnitDescription();
	}
	
	public function empNearbyShips()
	{
		$Request= new Request();
		$UnitId=	 $Request->getAsInt("UId");	
		$UnitFinder= new UnitFinder();
		$Unit= $UnitFinder->findById($UnitId);
		if(!($Unit->getExtentionOne() == 26))
		{
			return false;
		}
		$StateManager = new StateManager();
		$StateSelf = new StateEmpUsed(20,"EMP",time()+ STATE_EMP_OFFLINE,"","");
		$StateManager->insertStatetoUnit($StateSelf, $Unit);
		$StateShieldOffline = new StateShieldOffline(16,"EMP",time()+ STATE_SHIELD_OFFLINE,"","");
		$StateOtherNoShield = new StateEMPed(6,"EMP",time()+ STATE_EMPED,"","");
		$StateWeapon = new StateLowDamage(7,"EMP",time()+ STATE_WEAPONDAMAGE,"","");
		$UnitCollection = $UnitFinder->findAllByKoordinates($Unit->getX(), $Unit->getY(), EMP_RANGE);
		foreach ($UnitCollection as $Other)
		{
			if($Other->getId()==$Unit->getid()){continue;}
				
			if($Other->getExtentionTow() == 15)
			{		
				$StateManager->insertStatetoUnit($StateShieldOffline, $Other);
			} else
			{	
				$StateManager->insertStatetoUnit($StateOtherNoShield, $Other);
				$StateManager->insertStatetoUnit($StateWeapon, $Other);
			}
		}
		$this->getUnitDescription();
	}
	
	
	
	
/**
 * setzt die einheiten die einen auftrag haben
 *
 * @return void 
 *
 */
public function setUnitsKoords()
{
		$UnitFinder= new UnitFinder();
		$UnitManager= new UnitManager();
		$UnitCollection=$UnitFinder->findAllWithTask();
		foreach($UnitCollection as $Unit)
		{
			$Task=$Unit->getTask();
			$TimeDifF=(microtime(true)-$Task->getRefresh())/60/60; // in sekunden 
			$Distance=sqrt(pow(($Unit->getX()-$Task->getX()),2)+pow ( ($Unit->getY()-$Task->getY()),2));
			//Winkel ermitteln
			
			$NewDistance=$Unit->getSpeed()*$TimeDifF;// die neue distance ermitteln
			if($Distance<=$NewDistance)	// wenn die distanz kleiner als der zurück geglegte weg des letzten refreshes
			{
				$Unit->setX($Task->getX());
				$Unit->setY($Task->getY());
				$UnitManager->deleteTask($Task);//task löschen
				 // sprit verbrauch berechnen 1 t für 100 entfernungs einheiten
				$Unit->setStoredElement("t",$Unit->getStoredElement("t",true)-(($Distance)/2));// den verbrauchten treibstoff	abziehen
				$UnitManager->updateUnit($Unit);	
				if($Task->getMessage())
				{
					$Controler_Message= new Controler_Message();
					$Controler_Message->sendMessage("System",  $Unit->getUser()->getName(),":T_UNIT_THE:: <a title=\":T_LINK_TOMAP:\" href=\"index.php?Section=Map&amp;X=".round($Unit->getX())."&amp;Y=".round($Unit->getY())."\">".$Unit->getName()." :T_UNIT_HASTARGET: ".round($Unit->getX()).":".round($Unit->getY())."</a> :T_UNIT_REACHED:",":T_UNIT_REACHED_TITLE:");
				}
				// hier gucken ob es ein task aus einer route war oder nicht. wenn ja dann die route weiter behandeln
				$this->calculateRoute($Unit);  // wenn die Flotte eine route hat dann eventeuell nächstenrouten punkt bearbeiten
			}else
			{	 // wenn distanz größer als der zeitraum des letzten requests
				//$Angle=acos(abs(($Unit->getX()-$Task->getX()))/$Distance);
				// distance ermitteln
				if($Unit->getX()>=$Task->getX())
				{
					$TempX=$Unit->getX()-(($NewDistance/$Distance)*($Unit->getX()-$Task->getX()));
				}else
				{
					$TempX=(($NewDistance/$Distance)*($Task->getX()-$Unit->getX()))+$Unit->getX();
				}
				
				if($Unit->getY()>=$Task->getY())
				{
					$TempY=$Unit->getY()-(($NewDistance/$Distance)*($Unit->getY()-$Task->getY()));
				}else
				{
					$TempY=(($NewDistance/$Distance)*($Task->getY()-$Unit->getY()))+$Unit->getY();
				}
				if($TempX==0 || $TempY==0)// sicherung das die flotte nie auf 0:0 kommen kann
				{
					continue;	
				}
				$Unit->setX($TempX);

				$Unit->setY($TempY);

				$Task->setRefresh(microtime(true));
				$UnitManager->updateTask($Task);
				$Unit->setStoredElement("t",$Unit->getStoredElement("t",true)-(($NewDistance)/2));// den verbrauchten treibstoff	abziehen
				
				$UnitManager->updateUnit($Unit);											  
			}
			
		}
	
}



	/**
	 * gibt eine zufallszahl von 0-9 zurück
	 *
	 * @return mixed This is the return value description
	 *
	 */
	public function getRandom()
	{
		
		return  $_SESSION['Random'][mt_rand (0,30)];
	}


	public function getPic()
	{	
		$Request= new Request();
		$StartX=	 $Request->getAsInt("X");
		$StartY=	 $Request->getAsInt("Y");
	
		if($_SESSION['PicCounter']>29)
		{
			$_SESSION['PicCounter']=0;
		}	
		$_SESSION['PicCounter']++; 

		$Pic = ImageCreate(133, 100);
		$Background=imagecreatefrompng("images/Map/Haven".$_SESSION['Random'][$_SESSION['PicCounter']].".png");
		ImageCopy($Pic,$Background,0,0,$_SESSION['Random'][$_SESSION['PicCounter']],$_SESSION['Random'][$_SESSION['PicCounter']],133,100);
		header ("Content-type: image/png");
		ImagePNG ($Pic);
		return false;
	}




	public function showMap()
	{
		$Request= new Request();
		$StartX=	 $Request->getAsInt("X");
		$StartY=	 $Request->getAsInt("Y");
		$Planet= Controler_Main::getInstance()->getPlanet();
		$User=   $Planet->getUser();
		 // random Zahlen erstellen und fr zukünftige abfragen speichern
		for($i=0;$i<=30;$i++)
		{
			$_SESSION['Random'][$i]=mt_rand(0,9);
		}
		if(!$StartX || !$StartY)
		{
			$StartX =$Planet->getX();
			$StartY =$Planet->getY();
		}
		
		$BrowserWidth=Controler_Main::getInstance()->getResX();
		$BrowserHeight=Controler_Main::getInstance()->getResY();
		
		$UnitFinder= new UnitFinder();
		$PlanetFinder= new PlanetFinder();
		$MapObjectFinder= new MapObjectFinder();
		$MyPlanetCollection=$PlanetFinder->findAllBetweenKoordinates($StartX-($BrowserWidth/2),$StartX+($BrowserWidth/2),$StartY-($BrowserHeight/2),$StartY+($BrowserHeight/2));
		$MyUnitCollection= $UnitFinder->findBetweenKoordinates($StartX-($BrowserWidth/2),$StartX+($BrowserWidth/2),$StartY-($BrowserHeight/2),$StartY+($BrowserHeight/2));
		$MyMapObjectCollection= $MapObjectFinder->findBetweenKoordinates($StartX-($BrowserWidth/2),$StartX+($BrowserWidth/2),$StartY-($BrowserHeight/2),$StartY+($BrowserHeight/2));
		
		$TempLate=Template::getInstance("tpl_Map.php");
		$TempLate->assign("PlanetCollection",$MyPlanetCollection);
		$UserUnitCollection=  $UnitFinder->findByUserId($User->getId());
		$MyTaskCollection  =$UnitFinder->findTaskByUnitsCollection($UserUnitCollection);
		$UserPlanetCollection=   $PlanetFinder->findByUserId($User->getId());
		//$UserUnitCollection->deleteInvisiableUnits($User);
		$MyUnitCollection->deleteUnitsOutOfRange($User,$UserPlanetCollection);// einheiten die von der reichweite her zuweit weg sind löschen
		$MyUnitCollection->deleteInvisiableUnits($User);// nicht sichtbare einheiten  löschen
		
		
		$TempLate->assign("MapObjectCollection",$MyMapObjectCollection);
		$TempLate->assign("UserPlanetCollection",$UserPlanetCollection);
		$TempLate->assign("UserUnitCollection",$UserUnitCollection);
		$TempLate->assign("MyTaskCollection",$MyTaskCollection);
		$TempLate->assign("MyUnitCollection",$MyUnitCollection);
		$TempLate->assign("User",$Planet->getUser());
		$TempLate->assign("X",$StartX-($BrowserWidth/2));
		$TempLate->assign("Y",$StartY-($BrowserHeight/2));
		$TempLate->render();
	}


}

?>