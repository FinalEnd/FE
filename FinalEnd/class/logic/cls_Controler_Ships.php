<?php

class Controler_Ships 
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
			
			case "ShowDock":
			{
				$this->showDock();
			}break;
			
			case "ShowGroups":
			{
				$this->showGroups();
			}break; 
			
			case "BuildShipsPremium":
			{
				$this->buildShipsPremium();
			}break;
			
			case "BuildShips":
			{
				$this->buildShips();
			}break;
			 
			case "ShowGroupsCreate":
			{
				$this->showGroupsCreate();
			}break;
			
			case "ShowShipBuildPremium":
			{
				$this->showBuildPremium();
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
				$this->showDock();
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
		$UnitId=$Request->getAsInt("UnitId");
		$UnitFinder= new UnitFinder();
		$Unit=$UnitFinder->findById($UnitId);
		$Planet= Controler_Main::getInstance()->getPlanet();
		$Salefinder=new SaleFinder();
		$Sale=$Salefinder->findShipSaleByUnitId($UnitId);
		if($Sale->getId()!=0)
		{
			$StateManager = new StateManager();
			$StateManager->deleteStatesByUnitAndByState($Sale->getUnit(), 21);
			$SaleManager = new SaleManager();
			$SaleManager->deleteShipSale($Sale->getUnit()->getId());
		}
		if($Unit->getUser()->getId()==$Planet->getUser()->getId()) // darf die flotte von diesem User gelöscht werden ?
		{
			$UnitManager= new UnitManager();
			$UnitManager->deleteUnit($Unit);
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
		$MetallNeeded=$Unit->getMissingHealth();

// wenn gegnerische Flotten in der nähe sind darf die Flotte nicht reperiert werden können


// wieviel lebensmittel werden für die reperatur benötigt

// sind genügend lebensmittel da ?


		if($Planet->getMetal()<$MetallNeeded)
		{
			$ErrorString.=":T_SHIP_METAL:<br />";		
		}

// lebensmittel vom planeten abziehen

		if($Unit->getState()>=1)
		{	 
			$ErrorString.=":T_SHIP_DIDALREADY:<br />";
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
			$ErrorString.=":T_RES_NOTEM:";		
		}
		if(($Planet->getHydrogen() +$Unit->getStoredElement("t",true))<$Request->getAsInt("i_PlanetDeuterium"))
		{
			$ErrorString.=":T_RES_NOTED: <br />";		
		}
		if(($Planet->getCrystal() +$Unit->getStoredElement("c",true))<$Request->getAsInt("i_PlanetKrystal"))
		{
			$ErrorString.=":T_RES_NOTEK:<br />";		
		}
		if(($Planet->getBiomass() +$Unit->getStoredElement("b",true)) <$Request->getAsInt("i_PlanetBioMass"))
		{
			$ErrorString.=":T_RES_NOTEL:<br />";		
		}
		if(($Request->getAsInt("i_PlanetBioMass")+$Request->getAsInt("i_PlanetKrystal")+$Request->getAsInt("i_PlanetDeuterium")+$Request->getAsInt("i_PlanetMetall"))>$Unit->getStorage())
		{
			$ErrorString.=":T_SHIP_CAPACITY:<br />";	
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
		$UnitManager->updateUnit($Unit);
		$this->showGroups();
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
		$ShipCollectionPlanet= $Planet->getShipCollection();
		$DroneCount=$Request->getAsInt("i_Unit_2");  // drohnen Count
		
		if(strlen($Request->getAsString("t_Name"))==0)
		{
			$Error=":T_SHIP_NAME:<br/>";		
		}
		
		if($DroneCount>$ShipCollectionPlanet->getShipCountByShipId(2))
		{
			$Error.=":T_SHIP_DRONE: <br/>";	
		}
		$SmallHunterCount=$Request->getAsInt("i_Unit_3"); 
		if($SmallHunterCount>$ShipCollectionPlanet->getShipCountByShipId(3))
		{
			$Error.=":T_SHIP_HUNTER:<br/>";	
		}
		$HunterCount=$Request->getAsInt("i_Unit_4"); 
		if($HunterCount>$ShipCollectionPlanet->getShipCountByShipId(4))
		{
			$Error.=":T_SHIP_HHUNTER:<br/>";	
		}
		$BomberCount=$Request->getAsInt("i_Unit_5");
		if($BomberCount>$ShipCollectionPlanet->getShipCountByShipId(5))
		{
			$Error.=":T_SHIP_BOMBER:<br/>";	
		}
		$BattleShipCount=$Request->getAsInt("i_Unit_6");
		if($BattleShipCount>$ShipCollectionPlanet->getShipCountByShipId(6))
		{
			$Error.=":T_SHIP_BATTLE:<br/>";	
		}
		
		$SmallTransPorterShipCount=$Request->getAsInt("i_Unit_7");
		if($SmallTransPorterShipCount>$ShipCollectionPlanet->getShipCountByShipId(7))
		{
			$Error.=":T_SHIP_STRANS:<br/>";	
		}
		
		$BigTransPorterShipCount=$Request->getAsInt("i_Unit_8");
		if($BigTransPorterShipCount>$ShipCollectionPlanet->getShipCountByShipId(8))
		{
			$Error.=":T_SHIP_BTRANS:<br/>";	
		}
		
		if($BomberCount==0 && $BattleShipCount==0 && $HunterCount==0 && $SmallHunterCount==0 && $DroneCount==0 && $SmallTransPorterShipCount==0 && $BigTransPorterShipCount==0)	// guckt ob überhaupt einheiten ausgewählt wurden
		{
			$Error.=":T_SHIP_UNITAMOUNT:<br/>";	
		}
		
		$Building=$Planet->getBuildingCollection()->getByTypeId(UNIT_COMMUNICATIONCENTRAL_ID);
		$MaxShipsInUnit=UNIT_MAX_SHIPS_IN_UNIT+25*$Building->getLevel();
		
		
		if(($BomberCount+$BattleShipCount+$HunterCount+$SmallHunterCount+$DroneCount+$SmallTransPorterShipCount+$BigTransPorterShipCount)>$MaxShipsInUnit)	// Maximale anzahl der schiffe in einer einheit begrenzen
		{
			$Error.=":T_SHIP_MAXAMOUNT1: ".$MaxShipsInUnit." :T_SHIP_MAXAMOUNT2:<br/>";	
		}
		// nur Kampfschiffe können mit dem besatzungstrupp ausgerüstet werden
		
		if($BattleShipCount==0 && $Request->getAsInt("i_ExtentionTwo")==17)	
		{
			$Error.=":T_SHIP_OVERTAKER:<br/>";	
		}
		
		$UnitFinder= new UnitFinder();
		$UnitCollection= $UnitFinder->findByUserId($User->getId());
		// prüfen wieviele einheiten gebaut sind
		if($this->getMaxUnits()<=$UnitCollection->getCount())	
		{
			$Error.=":T_SHIP_MAXUNITS:.<br/>";	
		}
		
		
		if(strlen($Error))
		{
			$TempLate->assign("ErrorString",$Error);
			$this->showGroupsCreate();
			return true;
		}
		
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

		$TempString=$this->getUnitString($DroneCount,$SmallHunterCount,$HunterCount,$BomberCount,$BattleShipCount);
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
		
		Controler_Event::getInstance()->addEvent(new UnitCreatedeEvent($NewUnit));
		
		
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
	private function getUnitString($DroneCount,$SmallHunterCount,$HunterCount,$BomberCount,$BattleShipCount)
	{
		$TempString=  "d:".$DroneCount;
		$TempString.=  ";sh:".$SmallHunterCount;
		$TempString.=  ";hh:".$HunterCount;
		$TempString.=  ";b:".$BomberCount;
		$TempString.=  ";bs:".$BattleShipCount;
		return	$TempString;
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
			$TowString.='<option value="13" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\'Panzerung\'">:T_TAG_ARMOR:</option>';
		}
		if($ReSearchCollection->getByReSearchId(15)->getLevel()>0)
		{
			$TowString.='<option value="15" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\'Panzerung\'>:T_TAG_SHIELD:</option>';
		}
		if($ReSearchCollection->getByReSearchId(16)->getLevel()>0)
		{
			$TowString.='<option value="16" onclick="document.getElementById(\'tb_ExtTwo\').innerHTML=\'Panzerung\'>:T_TAG_COVERINGS:</option>';
		}
		if($ReSearchCollection->getByReSearchId(14)->getLevel()>0)
		{
			$TowString.='<option value="14">:T_TAG_STEALTH:</option>';
		}
		if($ReSearchCollection->getByReSearchId(17)->getLevel()>0)
		{
			$TowString.='<option value="17">:T_TAG_TROOPS:</option>';
		}
		if($ReSearchCollection->getByReSearchId(19)->getLevel()>0)
		{
			$TowString.='<option value="19">:T_TAG_LOADINGBAY:</option>';
		}
		
		if($ReSearchCollection->getByReSearchId(7)->getLevel()>0)
		{
			$OneString.='<option value="7">:T_TAG_LASER:</option>';
		}
		if($ReSearchCollection->getByReSearchId(8)->getLevel()>0)
		{
			$OneString.='<option value="8">:T_TAG_PARICLE:</option>';
		}
		if($ReSearchCollection->getByReSearchId(9)->getLevel()>0)
		{
			$OneString.='<option value="9">:T_TAG_TORPEDO:</option>';
		}
		if($ReSearchCollection->getByReSearchId(10)->getLevel()>0)
		{
			$OneString.='<option value="10">:T_TAG_SCANNER:</option>';
		}
		if($ReSearchCollection->getByReSearchId(11)->getLevel()>0)
		{
			$OneString.='<option value="11">:T_TAG_ENGINES:</option>';
		}
		
		if($ReSearchCollection->getByReSearchId(20)->getLevel()>0)
		{
			$OneString.='<option value="20">:T_TAG_RAIDBAY:</option>';
		}
		
		if($ReSearchCollection->getByReSearchId(25)->getLevel()>0)
		{
			$OneString.='<option value="20">:DB_R_JUMPENGINE:</option>';
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
			if($ShipsInBuild>=2 && $DockLevel<=4 || $ShipsInBuild>=5)
			{
				$this->showDock(":T_DOCK_BUILD:.");
				return false;
			}

			if(($Ship->getCredits()*$Count)>=$Planet->getUser()->getCredits(true))
			{
				$ErrorString=":T_BUILDING_CREDITSNEED:.<br />";
			}
			if(($Ship->getMetall()*$Count)>=$Planet->getMetal(true))
			{
				$ErrorString=":T_BUILDING_METALLNEED:.<br />";
			}
			if(($Ship->getCristal()*$Count)>=$Planet->getCrystal(true))
			{
				$ErrorString=":T_BUILDING_KRISTNEED:.<br />";
			}
			if(($Ship->getHydrogen()*$Count)>=$Planet->getHydrogen(true))
			{
				$ErrorString=":T_BUILDING_DEUTNEED:.<br />";
			}
			
			if($Count<=0)
			{
				$ErrorString=":T_SHIP_GIVEAMOUNT:.<br />";
			}
			
			if(strlen($ErrorString)!=0)
		{
			// fehler ausgeben
			if($Request->getAsBool("SendOutput") && $User->isPremium())
			{
					// wenn vom premium schiffsbau gekommen NICHT wieder das DOCK anzeigen
			} else
			{
				$this->showDock($ErrorString);
			}
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
			
		Controler_Main::getInstance()->mappPlanetCollection();
		Controler_Main::getInstance()->addPermanentOutPut();
			
		if(!$Request->getAsBool("SendOutput") && $User->isPremium())
		{
			$this->showDock();	
			return true;
		}	
		
		if(!$User->isPremium())
		{
			$this->showDock();	
		}	
		
	}
	
	public function showDock($ErrorString="")
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$Dock=$Planet->getBuildingCollection()->getByTypeId(7);
		if($Dock->getLevel()<=0)
		{
			$TempLate=Template::getInstance("tpl_SystemMessage.php");
			$TempLate->assign("Message",":T_SHIP_NEED_DOCK:");
			$TempLate->render();
			return false;
		}
		$User=$Planet->getUser();
		
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
		$ShipUserCollection=$ShipFinder->findAllShipsByPlanet($Planet->getId());
		
		
		$TempLate=Template::getInstance("tpl_ShipBuild.php");
		if($User->isPremium() == true)
		{
			$TempLate->assign("IsPremium",true);
		}
		else
		{
			$TempLate->assign("IsPremium",false);
		}
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->assign("ShipCollection",$ShipCollection);
		$TempLate->assign("ShipUserCollection",$ShipUserCollection);
		$TempLate->assign("ShipsInBuild",$ShipsInBuild);
		$TempLate->assign("MaxShips",$MaxShips);
		
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->assign("ShipBuildCollection",$ShipBuildCollection);
		$TempLate->render();
	} 
	
	private function buildShipsPremium()
	{
		$Request = new Request();
		$Planetfinder=new PlanetFinder();
		$Planet=$Planetfinder->findById($Request->getAsInt("PlanetId"));
		Controler_Main::getInstance()->setPlanet($Planet);
		$Request->setPost("SendOutput",true);
		
		if($Request->getAsInt("tb_drone")>0)
		{
			$Request->setPost("ShipId","2");
			$Request->setPost("i_Count",$Request->getAsInt("tb_drone"));
			$this->buildShips();
		}
		if($Request->getAsInt("tb_hunter")>0)
		{
			$Request->setPost("ShipId","3");
			$Request->setPost("i_Count",$Request->getAsInt("tb_hunter"));
			$this->buildShips();
		}
		if($Request->getAsInt("tb_hhunter")>0)
		{
			$Request->setPost("ShipId","4");
			$Request->setPost("i_Count",$Request->getAsInt("tb_hhunter"));
			$this->buildShips();
		}
		if($Request->getAsInt("tb_bomber")>0)
		{
			$Request->setPost("ShipId","5");
			$Request->setPost("i_Count",$Request->getAsInt("tb_bomber"));
			$this->buildShips();
		}
		if($Request->getAsInt("tb_battleship")>0)
		{
			$Request->setPost("ShipId","6");
			$Request->setPost("i_Count",$Request->getAsInt("tb_battleship"));
			$this->buildShips();
		}
		if($Request->getAsInt("tb_tsmall")>0)
		{
			$Request->setPost("ShipId","7");
			$Request->setPost("i_Count",$Request->getAsInt("tb_tsmall"));
			$this->buildShips();
		}
		if($Request->getAsInt("tb_tbig")>0)
		{
			$Request->setPost("ShipId","8");
			$Request->setPost("i_Count",$Request->getAsInt("tb_tbig"));
			$this->buildShips();
		}
		$this->showBuildPremium();		
	}
	
	private function showBuildPremium()
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$User=$Planet->getUser();
		
		$PlanetFinder = new PlanetFinder();
		$PlanetCollection = $PlanetFinder->findByUserId($User->getId());
		$TempLate=Template::getInstance("tpl_ShipBuildPremium.php");
		if($User->isPremium() == true)
		{
			$TempLate->assign("IsPremium",true);
		}
		else
		{
			$TempLate->assign("IsPremium",false);
		}
		$TempLate->assign("PlanetCollection",$PlanetCollection);
		$TempLate->assign("ErrorString",$ErrorString);
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