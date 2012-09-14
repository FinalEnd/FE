<?php

class Controler_Dock
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
		switch($Request->getAsString('Action'))
		{
			
			case "DestroyUnit":
			{
				$this->destroyUnit();
			}break;
	
			case "ShowGroups":
			{
				$this->showGroups();
			}break;
			
			case "ShowShipsPremium":
			{
				$this->showShipsPremium();
			}break;

			case "ShowGroupsCreate":
			{
				$this->showGroupsCreate();
			}break;
			
			case "AddGroup":
			{
				$this->addGroup();
			}break;
			
			
			case "ShowLoading":
			{
				$this->showLoading();
			}break;
			
			
			case "Loading":
			{
				$this->loading();
			}break;
			
			case "RepairUnit":
			{
				$this->repairUnit();
			}break;
			
			
			default:
				$this->showGroups();
		}
	}








	
	/**
	 * gibt die maximal anzahl der Flotten die von diesem spieler gebaut werden können zurück
	 *
	 * @return int >=0
	 *
	 */
	public function getMaxUnits()
	{
		$User= Controler_Main::getInstance()->getUser(); 
		$PlanetFinder= new PlanetFinder();
		$PlanetCollection= $PlanetFinder->findByUserId($User->getId());
		$CCLevel=$PlanetCollection->getBuildingKommunicationCenter()->getLevel();
		return ($CCLevel*MAX_UNITS_PER_CC+MAX_UNITS_PER_PLANET*$PlanetCollection->getCount());
	}
	
	
	
	public function destroyUnit()
	{
		$Request= new Request();
		$ShipManager= new ShipManager();
		$UnitId=$Request->getAsInt("UnitId");
		$UnitFinder= new UnitFinder();
		$Unit=$UnitFinder->findById($UnitId);
		$Planet= Controler_Main::getInstance()->getPlanet();
		
		if($Unit->getUser()->getId()==$Planet->getUser()->getId()) // darf die flotte von diesem User gelöscht werden ?
		{
			$UnitManager= new UnitManager();
			$UnitManager->deleteUnit($Unit);
		}
		
		// schiffe die intakt sind gutschreiben
		foreach(explode(";",$Unit->getUnits()) as $UnitString)
		{
			$Temp=explode(":",$UnitString);
			if(!$this->getShipIdByShipString($Temp[0])){continue;}// wenn keine Id gefunden wurde
			if(!floor($Temp[1]*$Unit->getState())){continue;}// wenn kein schiff zum einfügen da ist dann nix in die db einfügen
			$ShipManager->insertShips($Planet->getId(),$this->getShipIdByShipString($Temp[0]),floor($Temp[1]*$Unit->getState()));
		}
		$this->showGroups();
	}
	public function repairUnit()
	{
		$Request= new Request();
		$UnitId=$Request->getAsInt("UId");
		$UnitFinder= new UnitFinder();
		$Unit=$UnitFinder->findById($UnitId);
		$Planet= Controler_Main::getInstance()->getPlanet();
		$ShipFinder= new ShipFinder();
		$ShipCollection=$ShipFinder->findAll();
		$MetallNeeded=(1-$Unit->getState()) *	$Unit->getHealts();

		// wieviel lebensmittel werden für die reperatur benötigt

		// sind genügend lebensmittel da ?


		if($Planet->getMetal()<$MetallNeeded)
		{
			$ErrorString.=":T_FLEET_REPAIRFAIL:<br />";		
		}

		// lebensmittel vom planeten abziehen

		if($Unit->getState()>=1 && $Unit->getStatecollection()->getCount()==0)
		{	 
			$ErrorString.=":T_FLEET_REPAIRED:<br />";
		}

		if($Unit->getStatecollection()->getCount()>0)
		{	 
			$StateManager= new StateManager();
			$StateManager->deleteStatesByUnit($Unit);
			$this->showGroups();
			return true;
		}

		if(strlen($ErrorString))
		{
			$this->showGroups($ErrorString);
			return false;	
		}
		$PlanetManager= new PlanetManager();   //planeten updaten
		$Planet->setMetal($Planet->getMetal()-$MetallNeeded);
		$PlanetManager->updateResources($Planet);

		$UnitManager= new UnitManager();
		$Unit->setState(1);
		$UnitManager->updateUnit($Unit);
		$this->showGroups();
	}

	public function loading()
	{ 	
		$Request= new Request();
		$Planet= Controler_Main::getInstance()->getPlanet();
		$TempLate=Template::getInstance("tpl_LoadingGroups.php");
		$UnitFinder= new UnitFinder();
		$UnitManager= new UnitManager();
		$Unit=$UnitFinder->findById($Request->getAsInt("UnitId"));
		if(($Planet->getMetal()+$Unit->getStoredElement("m",true)) <$Request->getAsInt("i_PlanetMetall"))
		{
			$ErrorString.=":T_BUILDING_METALLNEED:";		
		}
		if(($Planet->getHydrogen() +$Unit->getStoredElement("t",true))<$Request->getAsInt("i_PlanetDeuterium"))
		{
			$ErrorString.=":T_BUILDING_DEUTNEED:<br />";		
		}
		if(($Planet->getCrystal() +$Unit->getStoredElement("c",true))<$Request->getAsInt("i_PlanetKrystal"))
		{
			$ErrorString.=":T_BUILDING_KRISTNEED:<br />";		
		}
		if(($Planet->getBiomass() +$Unit->getStoredElement("b",true)) <$Request->getAsInt("i_PlanetBioMass"))
		{
			$ErrorString.=":T_BUILDING_FOODNEED:<br />";		
		}
		if(($Request->getAsInt("i_PlanetBioMass")+$Request->getAsInt("i_PlanetKrystal")+$Request->getAsInt("i_PlanetDeuterium")+$Request->getAsInt("i_PlanetMetall"))>$Unit->getStorage())
		{
			$ErrorString.=":T_FLEET_CAPACITY:<br />";	
		}

		if(strlen($ErrorString))
		{
			$TempLate->assign("ErrorString",$ErrorString);
			$TempLate->assign("Unit",$Unit);
			$TempLate->assign("Planet",$Planet);
			$TempLate->render();
			return false;	
		}
		
		$PlanetManager= new PlanetManager();
		if($Request->getAsInt("i_PlanetKrystal")>$Unit->getStoredElement("c"))
		{
			$Planet->setCrystal($Planet->getCrystal()-($Request->getAsInt("i_PlanetKrystal")-$Unit->getStoredElement("c")));
		}else
		{
			$Planet->setCrystal($Planet->getCrystal()+($Unit->getStoredElement("c")-$Request->getAsInt("i_PlanetKrystal")));
		}
		
		if($Request->getAsInt("i_PlanetDeuterium")>$Unit->getStoredElement("t"))
		{
			$Planet->setHydrogen($Planet->getHydrogen()-($Request->getAsInt("i_PlanetDeuterium")-$Unit->getStoredElement("t")));
		}else
		{
			$Planet->setHydrogen($Planet->getHydrogen()+($Unit->getStoredElement("t")-$Request->getAsInt("i_PlanetDeuterium")));
		}	
		
		if($Request->getAsInt("i_PlanetMetall")>$Unit->getStoredElement("m"))
		{
			$Planet->setMetal($Planet->getMetal()-($Request->getAsInt("i_PlanetMetall")-$Unit->getStoredElement("m")));
		}else
		{
			$Planet->setMetal($Planet->getMetal()+($Unit->getStoredElement("m")-$Request->getAsInt("i_PlanetMetall")));
		}
		
		if($Request->getAsInt("i_PlanetBioMass")>$Unit->getStoredElement("b"))
		{
			$Planet->setBiomass($Planet->getBiomass()-($Request->getAsInt("i_PlanetBioMass")-$Unit->getStoredElement("b")));
		}else
		{
			$Planet->setBiomass($Planet->getBiomass()+($Unit->getStoredElement("b")-$Request->getAsInt("i_PlanetBioMass")));
		}
		
		$PlanetManager->updateResources($Planet);
		
		$Unit->setStoredElement("t",$Request->getAsInt("i_PlanetDeuterium"));
		$Unit->setStoredElement("m",$Request->getAsInt("i_PlanetMetall"));
		$Unit->setStoredElement("b",$Request->getAsInt("i_PlanetBioMass"));
		$Unit->setStoredElement("c",$Request->getAsInt("i_PlanetKrystal"));
		$UnitManager->updateRessource($Unit);
		$this->showGroups();
	}


	
	/**
	 * belädt die flotte mit den angegeben ressis vom Planeten 
	 *
	 * @param Unit $Unit This is a description
	 * @param Planet $Planet This is a description
	 * @param mixed $Resource m= metall, c= Kristall, b= Lebensmitttel, t = Deuterium
	 * @param mixed $Count wieviel Soll geladen werden count muss positiv sein	
	 * @return bool
	 *
	 */
	public function loadRessource(Unit $Unit,Planet $Planet,$Resource,$Count)
	{
		$PlanetManager= new PlanetManager();
		$UnitManager= new UnitManager();
		
		$ResourceCountPLanet=$Planet->getResource($Resource);
		
		$MaxRessLoadCount=$Count;
		
		if($Count>$Unit->getFreeStoredSpace()) // prüfen wieviel in die flotte reingeht
		{
			$MaxRessLoadCount=$Unit->getFreeStoredSpace();
		}
		if($MaxRessLoadCount>$Planet->getResource($Resource))// prüfen wieviel auf dem Planeten ress vorhanden ist
		{
			$MaxRessLoadCount=$Planet->getResource($Resource);
		}
		$MaxRessLoadCount=(int)$MaxRessLoadCount;
		$Unit->setStoredElement($Resource,$MaxRessLoadCount+$Unit->getStoredElement($Resource,true));
		$UnitManager->updateRessource($Unit);
		$Planet->setResource($Resource,($MaxRessLoadCount*-1));// vom planeten abziehen setress fkt addiert das hinzu
		switch($Resource)
		{
			case "m":
			{
				$PlanetManager->updateMetal($Planet,$MaxRessLoadCount*-1);
			}break;
			
			case "c":
			{
				$PlanetManager->updateCrystal($Planet,$MaxRessLoadCount*-1);
			}break;
			
			case "b":
			{
				$PlanetManager->updateBioMass($Planet,$MaxRessLoadCount*-1);
			}break;
			
			case "t":
			{
				$PlanetManager->updateHydrogen($Planet,$MaxRessLoadCount*-1);
			}break;
		}
		//$PlanetManager->updateResources($Planet);	
	}

	/**
	 * entlädt die flotte mit den angegeben ressis und schreibt sie dem Planeten gut
	 *
	 * @param Unit $Unit This is a description
	 * @param Planet $Planet This is a description
	 * @param mixed $Resource m= metall, c= Kristall, b= Lebensmitttel, t = Deuterium
	 * @param mixed $Count wieviel Soll geladen werden count muss positiv sein	
	 * @return bool
	 *
	 */
	public function unLoadRessource(Unit $Unit,Planet $Planet,$Resource,$Count)
	{
		$PlanetManager= new PlanetManager();
		$UnitManager= new UnitManager();
		
		$ResourceCount=$Unit->getStoredElement($Resource,true);
		$MaxRessLoadCount=$Count;
		if($ResourceCount<$MaxRessLoadCount)
		{
			$MaxRessLoadCount=$ResourceCount;
		}
		
		if($MaxRessLoadCount>$Planet->getFreeStoredSpace($Resource))// prüfen wieviel auf dem Planeten ress vorhanden ist
		{
			$MaxRessLoadCount=$Planet->getResource($Resource);
		}
		$Planet->setResource($Resource,$MaxRessLoadCount);	// wird mit der vorhandenen menge addiert
		//$PlanetManager->updateResources($Planet);
		$Unit->setStoredElement($Resource,$Unit->getStoredElement($Resource,true)-$MaxRessLoadCount);	 // wird nicht mit der vorhandenen menge adiert
		$UnitManager->updateRessource($Unit);
		switch($Resource)
		{
			case "m":
			{
				$PlanetManager->updateMetal($Planet,$MaxRessLoadCount);
			}break;
			
			case "c":
			{
				$PlanetManager->updateCrystal($Planet,$MaxRessLoadCount);
			}break;
			
			case "b":
			{
				$PlanetManager->updateBioMass($Planet,$MaxRessLoadCount);
			}break;
			
			case "t":
			{
				$PlanetManager->updateHydrogen($Planet,$MaxRessLoadCount);
			}break;
		}	
	}


	public function showLoading()
	{
		$Request= new Request();
		$Planet= Controler_Main::getInstance()->getPlanet();
		$TempLate=Template::getInstance("tpl_LoadingGroups.php");
		$UnitFinder= new UnitFinder();
		$Unit=	$UnitFinder->findById($Request->getAsInt("UnitId"));
		$TempLate->assign("Unit",$Unit);
		$TempLate->assign("Planet",$Planet);
		$TempLate->render();
		
		
		
		
	}


	/**
	 * erstellt trupps die auf der karte positioniert werden können
	 *
	 * @return void 
	 *
	 */
	private function addGroup()
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$User=$Planet->getUser();
		$TempLate=Template::getInstance("tpl_Groups.php");
		$Request= new Request();
		$UnitFinder= new UnitFinder();
		$ShipCollectionPlanet= $Planet->getShipCollection();
		$DroneCount=$Request->getAsInt("i_Unit_2");  // drohnen Count
		
		if(strlen($Request->getAsString("t_Name"))==0)
		{
			$Error=":T_FLEET_NAMEING:<br/>";		
		}
		
		if($DroneCount>$ShipCollectionPlanet->getShipCountByShipId(2))
		{
			$Error.=":T_FLEET_DROHNES:<br/>";	
		}
		$SmallHunterCount=$Request->getAsInt("i_Unit_3"); 
		if($SmallHunterCount>$ShipCollectionPlanet->getShipCountByShipId(3))
		{
			$Error.=":T_FLEET_HUNTER:<br/>";	
		}
		$HunterCount=$Request->getAsInt("i_Unit_4"); 
		if($HunterCount>$ShipCollectionPlanet->getShipCountByShipId(4))
		{
			$Error.=":T_FLEET_HHUNTER:<br/>";	
		}
		$BomberCount=$Request->getAsInt("i_Unit_5");
		if($BomberCount>$ShipCollectionPlanet->getShipCountByShipId(5))
		{
			$Error.=":T_FLEET_BOMBER:<br/>";	
		}
		$BattleShipCount=$Request->getAsInt("i_Unit_6");
		if($BattleShipCount>$ShipCollectionPlanet->getShipCountByShipId(6))
		{
			$Error.=":T_FLEET_DESTROYER:<br/>";	
		}
		
		$SmallTransPorterShipCount=$Request->getAsInt("i_Unit_7");
		if($SmallTransPorterShipCount>$ShipCollectionPlanet->getShipCountByShipId(7))
		{
			$Error.=":T_FLEET_KLFREIGHT:<br/>";	
		}
		
		$BigTransPorterShipCount=$Request->getAsInt("i_Unit_8");
		if($BigTransPorterShipCount>$ShipCollectionPlanet->getShipCountByShipId(8))
		{
			$Error.=":T_FLEET_BIFREIGHT:<br/>";	
		}
		
		if($BomberCount==0 && $BattleShipCount==0 && $HunterCount==0 && $SmallHunterCount==0 && $DroneCount==0 && $SmallTransPorterShipCount==0 && $BigTransPorterShipCount==0)	// guckt ob überhaupt einheiten ausgewählt wurden
		{
			$Error.=":T_FLEET_UNITS:<br/>";	
		}
		
		$Building=$Planet->getBuildingCollection()->getByTypeId(UNIT_COMMUNICATIONCENTRAL_ID);
		$MaxShipsInUnit=UNIT_MAX_SHIPS_IN_UNIT+25*$Building->getLevel();
		
		
		if(($BomberCount+$BattleShipCount+$HunterCount+$SmallHunterCount+$DroneCount+$SmallTransPorterShipCount+$BigTransPorterShipCount)>$MaxShipsInUnit)	// Maximale anzahl der schiffe in einer einheit begrenzen
		{
			$Error.=":T_FLEET_MAX1:".$MaxShipsInUnit.":T_FLEET_MAX2:<br/>";	
		}
		// nur Kampfschiffe können mit dem besatzungstrupp ausgerüstet werden
		
		if($BattleShipCount==0 && $Request->getAsInt("i_ExtentionTwo")==17)	
		{
			$Error.=":T_FLEET_UPGRADE1:<br/>";	
		}
		
		if($BattleShipCount==0 && $Request->getAsInt("i_ExtentionOne")==23)	
		{
			$Error.=":T_FLEET_UPGRADE2:<br/>";	
		}
		
		
		if($BattleShipCount==0 && $Request->getAsInt("i_ExtentionOne")==23)	
		{
			$Error.=":T_FLEET_UPGRADE2:<br/>";	
		}
		
		if($Request->getAsInt("i_ExtentionOne")==23 && $Request->getAsInt("i_ExtentionTwo")==25 || $Request->getAsInt("i_ExtentionOne")==25 && $Request->getAsInt("i_ExtentionTwo")==23)	
		{
			$Error.=":T_FLEET_UPGRADE2:<br/>";	
		}
		
		
		
		$UnitFinder= new UnitFinder();
		$UnitCollection= $UnitFinder->findByUserId($User->getId());
		// prüfen wieviele einheiten gebaut sind
		if($this->getMaxUnits()<=$UnitCollection->getCount())	
		{
			$Error.=":T_FLEET_COMCENTER:<br/>";	
		}
		
		// prüfen wieviele Todessterne bereit exsistieren
		$DeathStarCount= $UnitFinder->countDeathStarByUser($User);
		
		if($DeathStarCount>=UNIT_MAX_DEATHSTARS && $Request->getAsInt("i_ExtentionTwo")==24)
		{
			$Error.=":T_FLEET_NO_MORE_DEATHSTAR:<br/>";	
		}
		
		// die bevölkerung berechnen die als crew eingesetzt wird
		$CrewMen=0;
		$CrewMen+=$ShipCollectionPlanet->getShipCountByShipId(2)*$DroneCount;
		$CrewMen+=$ShipCollectionPlanet->getShipCountByShipId(3)*$SmallHunterCount;
		$CrewMen+=$ShipCollectionPlanet->getShipCountByShipId(4)*$HunterCount;
		$CrewMen+=$ShipCollectionPlanet->getShipCountByShipId(5)*$BomberCount;
		$CrewMen+=$ShipCollectionPlanet->getShipCountByShipId(6)*$BattleShipCount;
		$CrewMen+=$ShipCollectionPlanet->getShipCountByShipId(6)*$BattleShipCount;
		
		// hier weiter machen
		//die bev prüfen und dann abziehen
		if((int)($Planet->getPeopleCount(true)-1)<$CrewMen)
		{
			$Error.=":T_FLEET_NO_PEOPLE:<br/>";	
		}
		
		if(strlen($Error))
		{
			$TempLate->assign("ErrorString",$Error);
			$this->showGroupsCreate();
			return true;
		}
		
		$PlanetManager= new PlanetManager();
		$PlanetManager->updatePeople($Planet,$CrewMen*-1);
		$Planet->setPeopleCount($Planet->getPeopleCount(true)-$CrewMen);
		Controler_Main::getInstance()->setPlanet($Planet);
		Controler_Main::getInstance()->addPermanentOutPut();// das panel updaten
		
		$ShipManager= new ShipManager();		   // db bestand updaten
		$ShipManager->subductShips(2,$Planet->getId(),$DroneCount);
		$ShipManager->subductShips(3,$Planet->getId(),$SmallHunterCount);
		$ShipManager->subductShips(4,$Planet->getId(),$HunterCount);
		$ShipManager->subductShips(5,$Planet->getId(),$BomberCount);
		$ShipManager->subductShips(6,$Planet->getId(),$BattleShipCount);
		
		$ShipManager->subductShips(7,$Planet->getId(),$SmallTransPorterShipCount);
		$ShipManager->subductShips(8,$Planet->getId(),$BigTransPorterShipCount);
		
		$ShipFinder= new ShipFinder();
		$ShipCollection=$ShipFinder->findAllShipsByPlanet($Planet->getId());
		$ShipCollection->merge();
		$ShipCollection->setCountById(2,$DroneCount);
		$ShipCollection->setCountById(3,$SmallHunterCount);
		$ShipCollection->setCountById(4,$HunterCount);
		$ShipCollection->setCountById(5,$BomberCount);
		$ShipCollection->setCountById(6,$BattleShipCount);
		$ShipCollection->setCountById(7,$SmallTransPorterShipCount);
		$ShipCollection->setCountById(8,$BigTransPorterShipCount);

		$TempString=$this->getUnitString($DroneCount,$SmallHunterCount,$HunterCount,$BomberCount,$BattleShipCount,$SmallTransPorterShipCount,$BigTransPorterShipCount);
		$TempDMG=$ShipCollection->getDMG();
		$Amor=$ShipCollection->getAmor();
		$Speed=$ShipCollection->getSpeed();
		$Storage=$ShipCollection->getStorage();
		//$Speed=$ShipCollection->getSpeed();
		$Healts=$ShipCollection->getHealth();

		$NewUnit= new Unit(0,$Request->getAsString("t_Name"),$TempString,$TempDMG,$Amor,$Speed,$Healts,$User,$Request->getAsString("i_ExtentionOne"),$Request->getAsString("i_ExtentionTwo"),$Planet->getX(),$Planet->getY(),1,$Storage,"",0,0,new Task());
		// neunen trupp eintragen
		$UnitManager= new UnitManager();
		$UnitManager->insertUnit($NewUnit);
		$ShipManager->deleteInvalidShip();// löscht alle schiffs einträge die 0 oder weniger sind
		$this->showGroups();
		Controler_Event::getInstance()->addEvent(new UnitCreatedEvent($NewUnit));
		return true;
	}

	/**
	 * gibt den Unitbeschreibungs text zurück für die angegeben schiffe in der Einheit
	 *
	 * @param int $DroneCount 
	 * @param int $SmallHunterCount 
	 * @param int $HunterCount 
	 * @param int $BomberCount 
	 * @param int $BattleShipCount 
	 * @return string 
	 *
	 */
	public function getUnitString($DroneCount,$SmallHunterCount,$HunterCount,$BomberCount,$BattleShipCount,$SmallTransporter=0,$BigTransporter=0)
	{
		$TempString=  "d:".$DroneCount;
		$TempString.=  ";sh:".$SmallHunterCount;
		$TempString.=  ";hh:".$HunterCount;
		$TempString.=  ";b:".$BomberCount;
		$TempString.=  ";bs:".$BattleShipCount;
		$TempString.=  ";st:".$SmallTransporter;
		$TempString.=  ";lt:".$BigTransporter;
		return	$TempString;
	}

	/**
	 * gibt die Id des Schiffes zurück, d=1, bs=4, usw je nach den einstellungen in der cfg file!
	 *
	 * @param string $ShipString 

	 * @return int 
	 *
	 */
	public function getShipIdByShipString($ShipString)
	{
		return constant("SHIP_ID_".strtoupper($ShipString));
	}


	private function showGroupsCreate()
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$User=$Planet->getUser();
		
		// forschung vom planeten laden
		$ReSearchFinder= new ReSearchFinder();
		$ReSearchCollection= $ReSearchFinder->findByPlanetId($Planet->getId());
		
		if($ReSearchCollection->getByReSearchId(13)->getLevel()>0)
		{
			$TowString.='<option value="13" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\''.$ReSearchCollection->getByReSearchId(13)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(13)->getName().'</option>';
		}
		if($ReSearchCollection->getByReSearchId(15)->getLevel()>0)
		{
			$TowString.='<option value="15" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\''.$ReSearchCollection->getByReSearchId(15)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(15)->getName().'</option>';
		}
		if($ReSearchCollection->getByReSearchId(16)->getLevel()>0)
		{
			$TowString.='<option value="16" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\''.$ReSearchCollection->getByReSearchId(16)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(16)->getName().'</option>';
		}
		if($ReSearchCollection->getByReSearchId(14)->getLevel()>0)
		{
			$TowString.='<option value="14" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\''.$ReSearchCollection->getByReSearchId(14)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(14)->getName().'</option>';
		}
		if($ReSearchCollection->getByReSearchId(17)->getLevel()>0)
		{
			$TowString.='<option value="17" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\''.$ReSearchCollection->getByReSearchId(17)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(17)->getName().'</option>';
		}
		if($ReSearchCollection->getByReSearchId(19)->getLevel()>0)
		{
			$TowString.='<option value="19" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\''.$ReSearchCollection->getByReSearchId(19)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(19)->getName().'</option>';
		}
		if($ReSearchCollection->getByReSearchId(24)->getLevel()>0)
		{
			$TowString.='<option value="24" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\''.$ReSearchCollection->getByReSearchId(24)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(24)->getName().'</option>';
		}

		
		if($ReSearchCollection->getByReSearchId(7)->getLevel()>0)
		{
			$OneString.='<option value="7" onclick="document.getElementById(\'tb_ExtOne\').innerHTML=\''.$ReSearchCollection->getByReSearchId(7)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(7)->getName().'</option>';
		}
		if($ReSearchCollection->getByReSearchId(8)->getLevel()>0)
		{
			$OneString.='<option value="8" onclick="document.getElementById(\'tb_ExtOne\').innerHTML=\''.$ReSearchCollection->getByReSearchId(8)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(8)->getName().'</option>';
		}
		if($ReSearchCollection->getByReSearchId(9)->getLevel()>0)
		{
			$OneString.='<option value="9" onclick="document.getElementById(\'tb_ExtOne\').innerHTML=\''.$ReSearchCollection->getByReSearchId(9)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(9)->getName().'</option>';
		}
		if($ReSearchCollection->getByReSearchId(10)->getLevel()>0)
		{
			$OneString.='<option value="10" onclick="document.getElementById(\'tb_ExtOne\').innerHTML=\''.$ReSearchCollection->getByReSearchId(10)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(10)->getName().'</option>';
		}
		if($ReSearchCollection->getByReSearchId(11)->getLevel()>0)
		{
			$OneString.='<option value="11" onclick="document.getElementById(\'tb_ExtOne\').innerHTML=\''.$ReSearchCollection->getByReSearchId(11)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(11)->getName().'</option>';
		}
		
		if($ReSearchCollection->getByReSearchId(20)->getLevel()>0)
		{
			$OneString.='<option value="20" onclick="document.getElementById(\'tb_ExtOne\').innerHTML=\''.$ReSearchCollection->getByReSearchId(20)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(20)->getName().'</option>';
		}
		
		if($ReSearchCollection->getByReSearchId(22)->getLevel()>0)
		{
			$OneString.='<option value="22" onclick="document.getElementById(\'tb_ExtOne\').innerHTML=\''.$ReSearchCollection->getByReSearchId(22)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(22)->getName().'</option>';
		}
		
		if($ReSearchCollection->getByReSearchId(23)->getLevel()>0)
		{
			$OneString.='<option value="23" onclick="document.getElementById(\'tb_ExtOne\').innerHTML=\''.$ReSearchCollection->getByReSearchId(23)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(23)->getName().'</option>';
		}
		
		if($ReSearchCollection->getByReSearchId(25)->getLevel()>0)
		{
			$TowString.='<option value="25" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\''.$ReSearchCollection->getByReSearchId(25)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(25)->getName().'</option>';
		}
		
		if($ReSearchCollection->getByReSearchId(26)->getLevel()>0)
		{
			$OneString.='<option value="26" onclick="document.getElementById(\'tb_ExtOne\').innerHTML=\''.$ReSearchCollection->getByReSearchId(26)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(26)->getName().'</option>';
		}
		
		if($ReSearchCollection->getByReSearchId(27)->getLevel()>0)
		{
			$OneString.='<option value="27" onclick="document.getElementById(\'tb_ExtOne\').innerHTML=\''.$ReSearchCollection->getByReSearchId(27)->getDescription().'\'">'.$ReSearchCollection->getByReSearchId(27)->getName().'</option>';
		}
		
		$Building=$Planet->getBuildingCollection()->getByTypeId(UNIT_COMMUNICATIONCENTRAL_ID);
		$MaxShipsInUnit=UNIT_MAX_SHIPS_IN_UNIT+25*$Building->getLevel();
		$TempLate=Template::getInstance("tpl_GroupsCreate.php");
		$TempLate->assign("MaxUnitsCount",$MaxShipsInUnit);
		$TempLate->assign("OneString",$OneString);
		$TempLate->assign("TowString",$TowString);
		$TempLate->assign("ShipCollection",$Planet->getShipCollection());
		$TempLate->render();
	}

	public function showShipsPremium()
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$User=$Planet->getUser();
		if(!$User->isPremium())
		{
			$this->showGroups();
			return false;
		}
		$RouteFinder = new RouteFinder();
		$RouteCollection = $RouteFinder->findByUserId($User->getId());
		$UnitFinder= new UnitFinder();
		$UnitCollection = $UnitFinder->findByUserId($User->getId());
		
		$Planetfinder = new PlanetFinder();
		$PlanetCollection = $Planetfinder->findByUnitCollection($UnitCollection);
		$TempLate=Template::getInstance("tpl_DockPremiumShips.php");
		$TempLate->assign("RouteCollection",$RouteCollection);
		$TempLate->assign("PlanetCollection",$PlanetCollection);
		$TempLate->assign("UnitCollection",$UnitCollection);
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->render();
	}
	
	/**
	 * zeigt alle einheiten an die sich auf diesem planeten befinden
	 *
	 * @return void 
	 *
	 */
	private function showGroups($ErrorString="")
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$User=$Planet->getUser();
		$TempLate=Template::getInstance("tpl_Groups.php");
		$UnitFinder= new UnitFinder();
		$Request= new Request();
		// flotten berechnen
		
		if(!$Request->getAsInt("Start"))
		{
			$Start=0;
		}else
		{
			$Start=$Request->getAsInt("Start");
		}
		
		$Controler_Map	= new Controler_Map();
		//$Controler_Map->setUnitsKoords();
		//$Controler_Map->claculateBattles();
		$UnitCount= $UnitFinder->countAllByPlanetKoordinates($Planet->getX(),$Planet->getY(),UNIT_REPAIR_RANGE);
		$UnitCollection= $UnitFinder->findAllByPlanetKoordinates($Planet->getX(),$Planet->getY(),UNIT_REPAIR_RANGE,$Start);
		$UnitCollection= $UnitCollection->getByUserId($User->getId());

		$EnemyUnitsCollection=$UnitFinder->findAllByKoordinates($Planet->getX(),$Planet->getY(),UNIT_SIEGE_RANGE);// alle einheiten finden
		if(!$EnemyUnitsCollection->areUnitsFormDifferentPlayer() || !$EnemyUnitsCollection->areUnitsFormDifferentAllianz() && $EnemyUnitsCollection->areUnitsFormDifferentPlayer())
		{
			$TempLate->assign("CanWorkOn",true);// die einheiten dürfen gerepptwerden und aufgelöst werden	
		}
		
		if(($Start+15)<((int)$UnitCount))
		{
			$TempLate->assign("Next",true);
			$TempLate->assign("Start",$Start+15);
		}
		$TempLate->assign("ActivePage",$Start);	
		if($Start>=15)
		{
			$TempLate->assign("Back",true);
			$TempLate->assign("BackStart",$Start-15);	
		}
		
		$TempLate->assign("UnitCollection",$UnitCollection);
		$TempLate->assign("ErrorString",$ErrorString);
		if($User->isPremium() == true)
		{
			$TempLate->assign("IsPremium",true);
		}
		else
		{
			$TempLate->assign("IsPremium",false);
		}
		$TempLate->render();
		
	}

	private function buildShips()
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$User=$Planet->getUser();
		$ReSearchFinder= new ReSearchFinder();									// nanobots suchen
		$ReSearchCollection= $ReSearchFinder->findByPlanetId($Planet->getId());
		$ShipFinder= new ShipFinder();
		$ShipCollection =$ShipFinder->findAll();
		$Request= new Request();	
		$UnitId=  $Request->getAsInt("ShipId");
		$Count=  $Request->getAsInt("i_Count");
		$Ship=$ShipCollection->getById($UnitId);
		$DockLevel=$Planet->getBuildingCollection()->getByTypeId(7)->getLevel();

		$ShipsInBuild=  $ShipFinder->countShipsInBuild($Planet->getId());
		if($ShipsInBuild>=2 && $DockLevel<=5 || $ShipsInBuild>=5)
		{
			$this->showDock(":T_DOCK_BUILD:");
			return false;
		}

		if(($Ship->getCredits()*$Count)>=$Planet->getUser()->getCredits(true))
		{
			$ErrorString=":T_BUILDING_CREDITSNEED:<br />";
		}
		if(($Ship->getMetall()*$Count)>=$Planet->getMetal(true))
		{
			$ErrorString=":T_BUILDING_METALLNEED:<br />";
		}
		if(($Ship->getCristal()*$Count)>=$Planet->getCrystal(true))
		{
			$ErrorString=":T_BUILDING_KRISTNEED:<br />";
		}
		if(($Ship->getHydrogen()*$Count)>=$Planet->getHydrogen(true))
		{
			$ErrorString=":T_BUILDING_DEUTNEED:<br />";
		}
		if(strlen($ErrorString)!=0)
		{
			// fehler ausgeben
			$this->showDock($ErrorString);
			return false;
		}
		$UserManager= new UserManager();
		$UserManager->updateUserCredits($User->getCredits(true)-($Ship->getCredits()*$Count), $User->getId());
		$PlanetManager= new PlanetManager();
		$Planet->setMetal($Planet->getMetal() - ($Ship->getMetall()*$Count));
		$Planet->setHydrogen($Planet->getHydrogen() - ($Ship->getHydrogen()*$Count));
		$Planet->setCrystal($Planet->getCrystal() - ($Ship->getCristal()*$Count));
		$PlanetManager->updateResources($Planet);
		$ShipManager= new ShipManager();
		
		$NanobotsLevel= $ReSearchCollection->getByReSearchId(21)->getLevel();
		if($NanobotsLevel!=0)
		{
			$TimeCorrection= $NanobotsLevel*10;
			
		}else{
			$TimeCorrection=0;
		}
		$Ship->setTimeCoorection($TimeCorrection);
		$ShipManager->addShipBuilding($Planet->getId(),$UnitId,$Count,microtime(true),$Ship->getBuildTime());
		$ShipBuildCollection=$ShipFinder->findShipBuildingByPlanetId($Planet->getId());
		$ShipCollection=$this->canBuild($ShipCollection);
		
		$ReSearchFinder= new ReSearchFinder();									// nanobots suchen
		$ReSearchCollection= $ReSearchFinder->findByPlanetId($Planet->getId());
		
		$NanobotsLevel= $ReSearchCollection->getByReSearchId(21)->getLevel();
		if($NanobotsLevel!=0)
		{
			$TimeCorrection= $NanobotsLevel*10;
			
		}else{
			$TimeCorrection=0;
		}
		$ShipCollection->setTimeCoorection($TimeCorrection);
		/*$TempLate=Template::getInstance("tpl_ShipBuild.php");
		$TempLate->assign("ShipCollection",$ShipCollection);
		$TempLate->assign("ShipBuildCollection",$ShipBuildCollection);
		$TempLate->render();  */
		$this->showDock();
	}

	public function showDock($ErrorString="")
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$Dock=$Planet->getBuildingCollection()->getByTypeId(7);
		if($Dock->getLevel()<=0)
		{
			$TempLate=Template::getInstance("tpl_ShipBuild.php");
			$TempLate->assign("Message",":T_DOCK_NEED:");
			$TempLate->render();
			return false;
		}
		$ShipFinder= new ShipFinder();
		
		$ReSearchFinder= new ReSearchFinder();									// nanobots suchen
		$ReSearchCollection= $ReSearchFinder->findByPlanetId($Planet->getId());
		
		$NanobotsLevel= $ReSearchCollection->getByReSearchId(21)->getLevel();
		if($NanobotsLevel!=0)
		{
			$TimeCorrection= $NanobotsLevel*10;
			
		}else{
			$TimeCorrection=0;
		}	 
		
		$DockLevel=$Planet->getBuildingCollection()->getByTypeId(7)->getLevel();

		$ShipsInBuild=  $ShipFinder->countShipsInBuild($Planet->getId());
		if($DockLevel<5)
		{
			$MaxShips=2;
		}else
		{
			$MaxShips=5;
		}
		

		
		$ShipCollection =$ShipFinder->findAll();
		$ShipBuildCollection=$ShipFinder->findShipBuildingByPlanetId($Planet->getId());
		$ShipCollection=$this->canBuild($ShipCollection);
		$ShipCollection->setTimeCoorection($TimeCorrection);
		$TempLate=Template::getInstance("tpl_ShipBuild.php");
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->assign("ShipCollection",$ShipCollection);
		
		$TempLate->assign("ShipsInBuild",$ShipsInBuild);
		$TempLate->assign("MaxShips",$MaxShips);
		$User=$Planet->getUser();
		
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->assign("ShipBuildCollection",$ShipBuildCollection);
		$TempLate->render();
	} 
	
	
	
	/**
	 * gibt die berechtigung ob die einheit gebaut werden darf oder nicht
	 *
	 * @param int $Id die ID der einheit
	 * @return bool true or false
	 *
	 */
	public function canBuild($ShipCollection)
	{
		$Planet= Controler_Main::getInstance()->getPlanet();
		
		$Dock= $Planet->getBuildingCollection()->getByTypeId(7);
		$TempShipCollection= new ShipCollection();
		foreach($ShipCollection as $Ship)
		{
			if($Ship->getID()==8 && $Dock->getLevel()>7)
			{
				$TempShipCollection->add($Ship);
			}
			
			if($Ship->getID()==7 && $Dock->getLevel()>1)
			{
				$TempShipCollection->add($Ship);
			}
			if($Ship->getID()==6 && $Dock->getLevel()>9)
			{
				$TempShipCollection->add($Ship);
			}
			
			if($Ship->getID()==5 && $Dock->getLevel()>=5)
			{
				$TempShipCollection->add($Ship);
			}
			
			if($Ship->getID()==4 && $Dock->getLevel()>2)
			{
				$TempShipCollection->add($Ship);
			}
			
			if($Ship->getID()==3 && $Dock->getLevel()>0)
			{
				$TempShipCollection->add($Ship);
			}
			if($Ship->getID()==2 && $Dock->getLevel()>0)
			{
				$TempShipCollection->add($Ship);
			}
		}
		return $TempShipCollection;
	}



}

?>