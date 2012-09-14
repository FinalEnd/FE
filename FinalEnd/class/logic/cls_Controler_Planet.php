<?php

/**
 * class cls_Controler_Click
 *
 * Description for class cls_Controler_Click
 *
 * @author:
*/
class Controler_Planet 
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
			
			case "ReNamePlanet":
			{
				$this->reNamePlanet();
			}break;
			
			
			case "ShowPlanetReName":
			{
				$this->showPlanetReName();
			}break;
			
			case "ShowPlanet":
			{
				$this->showPlanet();
			}break;
			
			case "ShowBuildings":
			{
				$this->showBuildings();
			}break;
			
			case "ShowPlanet":
			{
				$this->showPlanet();
			}break;
			
			case "CancelUpdateBuildings":
			{
				$this->cancelUpdateBuildings();
			}break;
			   
			
			
			case "UpdateBuildings":
			{
				$this->updateBuildings();
				return true;
				
			}
			
			
			case "DestroyPlanet":
			{
				$this->destroyPlanet();
				//return true;
				
			}
			
			default:
				$this->showPlanet();
		}
	}
	
	public function destroyPlanet($ErrorString="")
	{
		// alle gebäude laden 
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$BuildingManager= new BuildingManager();
		$BuildingManager->deleteBuildingsByPlanetId($Planet->getId());
		
		// gebäude löschen
		//echo "Gebäude gelöscht";
		
		// forschungen löschen 
		$ResearchManager= new ReSearchManager();
		$ResearchManager->deleteReSearchsByPlanetId($Planet->getId());
		//echo "Forschung gelöscht";
		
		// schiffe löschen
		$ShipManager= new ShipManager();
		$ShipManager->deleteShipByPlanet($Planet->getId());
		//echo "schiffe gelöscht";
		// müll verteilen
		$MapControler= new Controler_Map();
		for($i=rand(10,20);$i>0;$i--)
		{
			$MapControler->addWast($Planet->getX()+mt_rand(-100,100),$Planet->getY()+mt_rand(-100,100));
		}
		//echo "Müll verteilt";
		// gucken obs der letzte plane war wenn ja neuen geben
		
		
		
		//Planet löschen
		$PlanetManager= new PlanetManager();
		$PlanetManager->delete($Planet);
		
		//echo "planet gelöscht";
		
		$PlanetFinder=new PlanetFinder();
		$PlanetCount=$PlanetFinder->countPlanetsByUser(Controler_Main::getInstance()->getUser());
		
		
		if($PlanetCount==0)
		{
			$LoginControler= new Controler_Login();	
			$LoginControler->setUserToMap(Controler_Main::getInstance()->getUser());
		}
		
		// nachrichten an spieler mit zerstörten schiffen senden
		$UnitFinder= new UnitFinder();
		$UnitCollection=$UnitFinder->findByKoordinatesInRange($Planet->getX(),$Planet->getY(),300);
		
		
		$ControlerMessage= new Controler_Message();
		if($UnitCollection->getCount())
		{
			$UnitManager= new UnitManager();
			$UnitManager->deleteUnitCollection($UnitCollection);
			$ControlerMessage->sendMessageToUserFromUnitCollection(SYSTEM_NAME,$UnitCollection,":T_MESSAGE_SELFDESTR1: <a href=\"index.php?Section=Map&amp;X=".$Planet->getX()."&amp;Y=".$Planet->getY()."\">:T_LINK_TOMAP:<a>",":T_MESSAGE_SELFDESTR_TITLE:");
		}
		//echo "nachrichten wurden verschickt";
		Controler_Main::getInstance()->updateControler(); // alle ausgaben aktualisieren
	}
	
	
	
	
	private function checkResourceForBuilding(Building $Building,Planet $Planet,User $User)
	{
		if($Building->getLevel()>=$Building->getMaxLevel())
		{// wenn das gebäude bereits level 25 erreicht hat dann hier raus gehen
			
			return ":T_BUILDING_LEVELMAX:";
		}
		// gucken ob genügend resourcen zur verfügung stehen 
		if($Planet->getMetal()<=$Building->getBuildMetallNextLevel()-1 ||
			$Planet->getHydrogen()<=$Building->getBuildHydrogenNextLevel()-1 ||
			$Planet->getBiomass() <= $Building->getBuildBiomassNextLevel()-1||
			$Planet->getCrystal()<=$Building->getBuildCrystalNextLevel()-1 ||
			$User->getCredits(true) <= $Building->getBuildCreditsNextLevel()-1
		)
		{// nich genügend resourcen zur verfügung
			
			if($Planet->getMetal()<=$Building->getBuildMetallNextLevel()-1)
			{
				$ErrorString=":T_BUILDING_METALLNEED:<br />";
			}
			if($Planet->getHydrogen()<=$Building->getBuildHydrogenNextLevel()-1)
			{
				$ErrorString.=":T_BUILDING_DEUTNEED:<br />";
			}
			if($Planet->getBiomass() <= $Building->getBuildBiomassNextLevel()-1)
			{
				$ErrorString.=":T_BUILDING_FOODNEED:<br />";
			}
			if($Planet->getCrystal()<=$Building->getBuildCrystalNextLevel()-1)
			{
				$ErrorString.=":T_BUILDING_KRISTNEED:<br />";
			}
			if($User->getCredits(true) <= $Building->getBuildCreditsNextLevel()-1)
			{
				$ErrorString.=":T_BUILDING_CREDITSNEED:<br />";
			}
			//$this->showBuildings($ErrorString);
			return $ErrorString;
		}	
		
	}
	
	
	/**
	 * entfernt den bauauftrag für ein gebäude
	 *
	 * @return void 
	 *
	 */
	public function cancelUpdateBuildings()
	{
		$Request= new Request();
		$BuildingId=$Request->getAsInt("BuildingId");
		$BuildingFinder= new BuildingFinder();
		
		$Planet = Controler_Main::getInstance()->getPlanet(); 
		$BuildingCollectionPlanet = $Planet->getBuildingCollection();
		$Building = $BuildingCollectionPlanet->getByTypeId($BuildingId);
		$TempLate=Template::getInstance("tpl_Buildings.php");
		$User= Controler_Main::getInstance()->getUser();
		
		if($Building->getInbuild()==0)
		{
			$this->showBuildings();
			return false;	
		}
		
		$BuildingCount=$BuildingFinder->countBuildingsInBuild($Planet->getId());
		$Building->setInbuild(0);
		$BuildingManager= new BuildingManager();
		$BuildingManager->buildBuilding($Planet->getId(),$Building->getType(),0);   // gebäude zurück setzen
		
		// planeten resourcen updaten
		$PlaneManager= new PlanetManager();
		$Planet->setMetal($Planet->getMetal()+$Building->getBuildMetallNextLevel());
		$Planet->setHydrogen($Planet->getHydrogen()+$Building->getBuildHydrogenNextLevel());
		$Planet->setBiomass($Planet->getBiomass()+$Building->getBuildBiomassNextLevel());
		$Planet->setCrystal($Planet->getCrystal()+$Building->getBuildCrystalNextLevel());
		$PlaneManager->updateResources($Planet);
		
		// user Credits updaten
		$UserManager= new UserManager();
		$User->setCredits($User->getCredits()+$Building->getBuildCreditsNextLevel());
		$UserManager->updateUserCredits($User->getCredits(),$User->getID());
		Controler_Main::getInstance()->setUser($User);

		$BuildingFinder= new BuildingFinder();
		$BuildingCollection=$BuildingFinder->findByPlanetId($Planet->getId());
		$BuildingCollection=$this->getAllBuildings($BuildingCollection);
		$Planet->setBuildingCollection($BuildingCollection);
		$TempLate->assign("Planet",$Planet);
		$TempLate->assign("User",$User);
		
		$BuildingFinder= new BuildingFinder();
		$BuildingCount=$BuildingFinder->countBuildingsInBuild($Planet->getId());
		$HQLevel=$BuildingCollectionPlanet->getByTypeId(1)->getLevel();
		$MaxBuildedBuildings=0;
		if($HQLevel<5 )
		{
			$MaxBuildedBuildings=2;
		}else
		{
			$MaxBuildedBuildings=3;
		}
		$TempLate->assign("BuildedCount",$BuildingCount);
		$TempLate->assign("MaxBuildedBuildings",$MaxBuildedBuildings);
		
		$TempLate->render();
	}
	
	public function updateBuildings()
	{
		$Request= new Request();
		$BuildingId=$Request->getAsInt("BuildingId");
		$BuildingFinder= new BuildingFinder();
		$BuildingCollection=$BuildingFinder->findAllAvavibelBuildings();
		$Planet = Controler_Main::getInstance()->getPlanet(); 
		$BuildingCollectionPlanet = $Planet->getBuildingCollection();
		$Building = $BuildingCollectionPlanet->getByTypeId($BuildingId);
		$TempLate=Template::getInstance("tpl_Buildings.php");
		$User= Controler_Main::getInstance()->getUser();
		$BuildingCount=$BuildingFinder->countBuildingsInBuild($Planet->getId());
		
		$HQLevel=$BuildingFinder->findLevelByPlanetAndBuildingId($Planet->getId(),1);
		if($HQLevel<5 && $BuildingCount>=2 ||  $BuildingCount>=3)
		{
			$this->showBuildings(":T_BUILDING_NOTANOTHERONE:");
			return false;
		}
		 	
		$BuildinManager= new BuildingManager();
		if(!$Building->getId())// neu baut
		{
			$Building=$BuildingCollection->getByTypeId($BuildingId);
			$TempString=$this->checkResourceForBuilding($Building,$Planet,$User);
			if($TempString)
			{
				$this->showBuildings($TempString);
				return false;
			}
			$Value=$this->canBuild($Building,$BuildingCollectionPlanet);
			if($Value)// checken ob gebaut werden darf vom level her
			{
				$BuildinManager->buildNewBuilding($Planet->getId(),$Building->getType(),$Building->getBuildTimeNextLevel()+time());
			}
		}else
		{
			$TempString=$this->checkResourceForBuilding($Building,$Planet,$User);
			if($TempString)
			{
				$this->showBuildings($TempString);
				return false;
			}
			$BuildinManager->buildBuilding($Planet->getId(),$Building->getType(),$Building->getBuildTimeNextLevel()+time());
		}
		
		// planeten resourcen updaten
		$PlaneManager= new PlanetManager();
		$Planet->setMetal($Planet->getMetal()-$Building->getBuildMetallNextLevel());
		$Planet->setHydrogen($Planet->getHydrogen()-$Building->getBuildHydrogenNextLevel());
		$Planet->setBiomass($Planet->getBiomass()-$Building->getBuildBiomassNextLevel());
		$Planet->setCrystal($Planet->getCrystal()-$Building->getBuildCrystalNextLevel());
		$PlaneManager->updateResources($Planet);
		
		// user Credits updaten
		$UserManager= new UserManager();
		$User->setCredits($User->getCredits()-$Building->getBuildCreditsNextLevel());
		$UserManager->updateUserCredits($User->getCredits(),$User->getID());
		Controler_Main::getInstance()->setUser($User);

		$BuildingFinder= new BuildingFinder();
		$BuildingCollection=$BuildingFinder->findByPlanetId($Planet->getId());
		$BuildingCollection=$this->getAllBuildings($BuildingCollection);
		$Planet->setBuildingCollection($BuildingCollection);
		$TempLate->assign("Planet",$Planet);
		$TempLate->assign("User",$User);
		
		$BuildingFinder= new BuildingFinder();
		$BuildingCount=$BuildingFinder->countBuildingsInBuild($Planet->getId());
		$HQLevel=$BuildingCollectionPlanet->getByTypeId(1)->getLevel();
		$MaxBuildedBuildings=0;
		if($HQLevel<5 )
		{
			$MaxBuildedBuildings=2;
		}else
		{
			$MaxBuildedBuildings=3;
		}
		$TempLate->assign("BuildedCount",$BuildingCount);
		$TempLate->assign("MaxBuildedBuildings",$MaxBuildedBuildings);
		$TempLate->render();
		/*$this->showBuildings();  */
	}
	
	
	private function getAllBuildings(BuildingCollection $BuildingCollectionPlanet)
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		if(!$BuildingCollectionPlanet->getCount())
		{
			$BuildingCollectionPlanet=$Planet->getBuildingCollection();
		}
		$BuildingFinder= new BuildingFinder();
		$BuildingCollection=$BuildingFinder->findAllAvavibelBuildings();
		// und mit zur ausgabe hinzu fügen
		for($i=0;$i<$BuildingCollection->getCount();$i++)	
		{
			$Building=$BuildingCollection->getByIndex($i);
			if($BuildingCollectionPlanet->getByTypeId($Building->getType())->getId()==0) // wenn das gebäude noch fehlt dann hinzufügen
			{
				// gucken ob das gebäude gebaut werden darf
				if($this->canBuild($Building,$BuildingCollectionPlanet))
				{
					$BuildingCollectionPlanet->add($Building);
				}
			}
		}
		
		$BuildingCollectionPlanet->deleteMaxLevel();
		return $BuildingCollectionPlanet;
	}
	
	public function showBuildings($ErrorString="")
	{
		// alle gebäude laden 
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		$BuildingCollectionPlanet=$this->getAllBuildings(new BuildingCollection());
		$Planet->setBuildingCollection($BuildingCollectionPlanet);
		$BuildingFinder= new BuildingFinder();
		$BuildingCount=$BuildingFinder->countBuildingsInBuild($Planet->getId());
		$HQLevel=$BuildingFinder->findLevelByPlanetAndBuildingId($Planet->getId(),1);
		$MaxBuildedBuildings=0;
		if($HQLevel<5 )
		{
			$MaxBuildedBuildings=2;
		}else
		{
			$MaxBuildedBuildings=3;
		}
		
		
		$TempLate=Template::getInstance("tpl_Buildings.php");
		$TempLate->assign("Planet",$Planet);
		$TempLate->assign("BuildedCount",$BuildingCount);
		$TempLate->assign("MaxBuildedBuildings",$MaxBuildedBuildings);
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->render();
	}
	
	public function canBuild(Building $Building,BuildingCollection $BuildingCollection)
	{
		$Needet=$Building->getNeed();
		if($BuildingCollection->getByTypeId($Needet)->getLevel()>=$Building->getNeedLevel())
		{
			return true;	
		}
		return false;	
	
	}
	
	
		
	public function reNamePlanet()
	{
		$Request= new Request();
		$PlanetManager = new PlanetManager();
		
		$MainControler= Controler_Main::getInstance();
		// planetenholen 
		$Planet=$MainControler->getPlanet();
		// name rein 
		if(strlen($Request->getAsString("tb_Name"))<2)
		{
			$this->showPlanet();
		}
		$Planet->setName($Request->getAsString("tb_Name"));
		// update
		$PlanetManager->updateName($Planet);
		// wieder ins tpl und cls schieben
		$Template= Template::getInstance();
		$Template->assign("Planet",$Planet);
		$this->showPlanet();
	}
	
	public function showPlanetReName()
	{
		$Request= new Request();
		$TempLate=Template::getInstance("tpl_PlanetWorkon.php"); 
		$TempLate->render();
	}
	
	public function showPlanet()
	{
		$Request= new Request();
		$TempLate=Template::getInstance("tpl_Planet.php"); 
		$TempLate->render();
	}
	
	/**
	 * gibt einen random Planeten zurück
	 *
	 * @return Planet ein Random planet
	 *
	 */
	public function getRandomPlanet()
	{
		$Counter=0;
		$Coorection=1;
		// alle Planeten finden
		$PlanetFinder= new PlanetFinder();
		$PlanetCollection=$PlanetFinder->findNewPlanet(50);
		$i=0;
		do {		
			$NewPlanet=$PlanetCollection->getByIndex($Counter);
			$X=mt_rand($NewPlanet->getX()-$i,$NewPlanet->getX()+$i);
			$Y=mt_rand($NewPlanet->getY()-$i,$NewPlanet->getY()+$i);
			$TempCollection=$PlanetCollection->getPLanetsInRange($X,$Y,1200);
			$i+=50;
			$Counter=$Counter + 1;
		} while ($TempCollection->getByIndex(0)->getId()!=0);
		$Planet=new Planet(0,"Unbekannt",new User(0,"","","","",0,0,0,0),0,0,1,"",0,PLANET_START_METALL,PLANET_START_HYDROGEN,PLANET_START_BIOMASS,PLANET_START_CRISTAL,0,0,new BuildingCollection(),new ShipCollection(),new ReSearchCollection(),PLANET_START_PEOPLE,0,0);
		$Size= mt_rand(200,9999);// durchmesser
		$Weight= mt_rand(200,9999)." *10 <sup>".mt_rand(2,50)."</sup>";
		$Picture="Planet".mt_rand(0,62).".png";
		$Planet->setSize($Size);
		$Planet->setPicture($Picture);
		$Planet->setWeight($Weight);
		$Planet->setX($X); // x setzen
		$Planet->setY($Y);// y Setzen	
		return $Planet;
	}	
	

	
	
}

?>