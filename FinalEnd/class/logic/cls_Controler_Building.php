<?php

/**
 * class cls_Controler_Click
 *
 * Description for class cls_Controler_Click
 *
 * @author:
*/
class Controler_Building 
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
			
			case "DestroyBuilding":
			{
				$this->destroyBuilding();
			}break;
			
			case "UpdateBuildings":
			{
				$this->updateBuildings();
				return true;
				
			}
			
			case "ShowBuildingsPremium":
			{
				$this->showBuildingsPremium();
				return true;
				
			}
			
			default:
				$this->showBuildings();
		}
	}
	
	
	/**
	 * zeigt alle gebäudes des spielers in einem View an
	 *
	 * @return void 
	 *
	 */
	private function showBuildingsPremium($ErrorString="")
	{
		// planeten collection laden 
		// tpl laden 
		// und rein hauhen
		$User= Controler_Main::getInstance()->getUser();
		$PLanetFinder= new PlanetFinder();
		$PlanetCollection= $PLanetFinder->findByUserId($User->getId());
		$Template=Template::getInstance("tpl_BuildingsPremium.php");
		$BuildingFinder= new BuildingFinder();
		$BuildingCollection=$BuildingFinder->findAllAvavibelBuildings();// alle gebäude finden
		$TempPLanetCollection=new PlanetCollection();
		foreach($PlanetCollection as $Planet)
		{
			$BuildingCollectionPlanet=clone $Planet->getBuildingCollection();
			for($i=0;$i<$BuildingCollection->getCount();$i++)	
			{
				$Building=$BuildingCollection->getByIndex($i);
				if($BuildingCollectionPlanet->getByTypeId($Building->getType())->getId()==0) // wenn das gebäude noch fehlt dann hinzufügen
				{
					$BuildingCollectionPlanet->add($Building);
				}
			}
			$Planet->setBuildingCollection($BuildingCollectionPlanet);
			$TempPLanetCollection->add($Planet);
		}

		$Template->assign("PlanetCollection",$TempPLanetCollection);
		$Template->assign("ErrorString",$ErrorString);
		$Template->render();
	}
	
	
	private function checkResourceForBuilding(Building $Building,Planet $Planet,User $User)
	{
		if($Building->getLevel()>=$Building->getMaxLevel())
		{// wenn das gebäude bereits level 25 erreicht hat dann hier raus gehen
			
			return ":T_BUILDING_LEVELMAX:";
		}
		// gucken ob genügend resourcen zur verfügung stehen 
		if($Planet->getMetal(true)<$Building->getBuildMetallNextLevel()-1 ||
			$Planet->getHydrogen(true)<$Building->getBuildHydrogenNextLevel()-1 ||
			$Planet->getBiomass(true) < $Building->getBuildBiomassNextLevel()-1||
			$Planet->getCrystal(true)<$Building->getBuildCrystalNextLevel()-1 ||
			$User->getCredits(true) <= $Building->getBuildCreditsNextLevel()-1
		)
		{// nich genügend resourcen zur verfügung
			
			if($Planet->getMetal(true)<=$Building->getBuildMetallNextLevel()-1)
			{
				$ErrorString=":T_BUILDING_METALLNEED:<br />";
			}
			if($Planet->getHydrogen(true)<=$Building->getBuildHydrogenNextLevel()-1)
			{
				$ErrorString.=":T_BUILDING_DEUTNEED:<br />";
			}
			if($Planet->getBiomass(true) < $Building->getBuildBiomassNextLevel()-1)
			{
				$ErrorString.=":T_BUILDING_FOODNEED:<br />";
			}
			if($Planet->getCrystal(true)<=$Building->getBuildCrystalNextLevel()-1)
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
	 * setzt das level des Geböäudes eins nach unten
	 *
	 * @return void 
	 *
	 */
	public function destroyBuilding()
	{
		$Request= new Request();
		$BuildingId=$Request->getAsInt("BuildingId");
		$BuildingFinder= new BuildingFinder();
		$Planet = Controler_Main::getInstance()->getPlanet(); 
		$BuildingCollectionPlanet = $Planet->getBuildingCollection();
		$Building = $BuildingCollectionPlanet->getByTypeId($BuildingId);
		$TempLate=Template::getInstance("tpl_Buildings.php");
		$User= Controler_Main::getInstance()->getUser();
		
		if($Building->getInbuild()!=0)
		{
			$this->showBuildings(":T_BUILDING_DESTROYFAIL:");
			return false;	
		}
		
		if($Building->getLevel()==0)
		{
			$this->showBuildings(":T_BUILDING_DESTROYFAILNOTTHERE:");
			return false;	
		}
		$BuildingManager= new BuildingManager();
		$BuildingManager->destructBuilding($Planet->getId(),$Building->getType(),$Building->getLevel()-1);   // gebäude zurück setzen
		$BuildingFinder= new BuildingFinder();
		$BuildingCollection=$BuildingFinder->findByPlanetId($Planet->getId());
		$BuildingCollection=$this->getAllBuildings($BuildingCollection);
		$Planet->setBuildingCollection($BuildingCollection);
		$TempLate->assign("Planet",$Planet);
		$TempLate->assign("User",$User);
		
		$BuildingFinder= new BuildingFinder();
		$TempBuildingCollection=$BuildingFinder->findByPlanetId($Planet->getId());
		$Planet->setBuildingCollection($TempBuildingCollection);
		Controler_Main::getInstance()->setPlanet($Planet);

		$this->showBuildings();
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
		$BuildingManager->destructBuilding($Planet->getId(),$Building->getType(),$Building->getLevel());   // gebäude zurück setzen
		
		Controler_Main::getInstance()->mappPlanetCollection();
		Controler_Main::getInstance()->addPermanentOutPut();
		
		$this->showBuildings();
		//$TempLate->render();
	}
	
	public function updateBuildings()
	{
		$Request= new Request();
		$BuildingId=$Request->getAsInt("BuildingId");
		$PlanetId=$Request->getAsInt("PlanetId");
		$BuildingFinder= new BuildingFinder();
		$BuildingCollection=$BuildingFinder->findAllAvavibelBuildings();
		if(!$PlanetId)
		{
		$Planet = Controler_Main::getInstance()->getPlanet(); 
		}else
		{
			$PLanetFinder= new PlanetFinder();
			$Planet =$PLanetFinder->findById($PlanetId);
		}
		$BuildingCollectionPlanet = $Planet->getBuildingCollection();
		$Building = $BuildingCollectionPlanet->getByTypeId($BuildingId);
		$TempLate=Template::getInstance("tpl_Buildings.php");
		$User= Controler_Main::getInstance()->getUser();
		$BuildingCount=$BuildingFinder->countBuildingsInBuild($Planet->getId());
		
		$HQLevel=$BuildingFinder->findLevelByPlanetAndBuildingId($Planet->getId(),1);
		if($HQLevel<5 && $BuildingCount>=2 ||  $BuildingCount>=3)
		{
			if(!$Request->getAsString("PremiumView"))
			{
				$this->showBuildings(":T_BUILDING_NOTPOSSIBLE:");
			}else
			{
				$this->showBuildingsPremium(":T_BUILDING_NOTPOSSIBLE:");	
			}
			return false;
		}
		if(Controler_Main::getInstance()->getUser()->isPremium())
		{
			$Building->setPerCentFaster(PREMIUM_BUILD_PERCENT_FASTER);
		}
		
		
		$BuildinManager= new BuildingManager();
		if(!$Building->getId())// neu baut
		{
			$Building=$BuildingCollection->getByTypeId($BuildingId);
			$TempString=$this->checkResourceForBuilding($Building,$Planet,$User);
			if($TempString)
			{
				if(!$Request->getAsString("PremiumView"))
				{
					$this->showBuildings($TempString);
				}else
				{
					$this->showBuildingsPremium($TempString);	
				}
				return false;
			}
			$Value=$this->canBuild($Building,$BuildingCollectionPlanet);
			if($Value)// checken ob gebaut werden darf vom level her
			{
				$BuildinManager->buildNewBuilding($Planet->getId(),$Building->getType(),$Building->getBuildTimeNextLevel()+time());
			}else
			{
				if(!$Request->getAsString("PremiumView"))
				{
					$this->showBuildings(":T_BUILDING_NEEDED_TITLE:");
				}else
				{
					$this->showBuildingsPremium(":T_BUILDING_NEEDED_TITLE:");	
				}
				return false;
			}
		}else
		{
			$TempString=$this->checkResourceForBuilding($Building,$Planet,$User);
			if($TempString)
			{
				if(!$Request->getAsString("PremiumView"))
				{
					$this->showBuildings($TempString);
				}else
				{
					$this->showBuildingsPremium($TempString);	
				}
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
		
		// in db updaten
		$PlaneManager->updateMetal($Planet,$Building->getBuildMetallNextLevel()*-1);
		$PlaneManager->updateHydrogen($Planet,$Building->getBuildHydrogenNextLevel()*-1);
		$PlaneManager->updateBioMass($Planet,$Building->getBuildBiomassNextLevel()*-1);
		$PlaneManager->updateCrystal($Planet,$Building->getBuildCrystalNextLevel()*-1);
		
		
		// user Credits updaten
		$UserManager= new UserManager();
		$User->setCredits($User->getCredits()-$Building->getBuildCreditsNextLevel());
		$UserManager->updateUserCredits($User->getCredits(),$User->getID());
		Controler_Main::getInstance()->setUser($User);

		$TempLate->assign("Planet",$Planet);
		$TempLate->assign("User",$User);

		$BuildingFinder= new BuildingFinder();
		$TempBuildingCollection=$BuildingFinder->findByPlanetId($Planet->getId());
		$Planet->setBuildingCollection($TempBuildingCollection);
		Controler_Main::getInstance()->setPlanet($Planet);
		Controler_Main::getInstance()->mappPlanetCollection();
		Controler_Main::getInstance()->addPermanentOutPut();
		// wenn der Spiler nur einen plani hat und die stadt auf lvl 6 ausbaut die nachricht verschicken das der spieler neue planeten erobern muss
		$UserPlanetCollection=Controler_Main::getInstance()->getPlanetCollection();
		if($BuildingId== 22 && $UserPlanetCollection->getCount()==1 && $Planet->getBuildingCollection()->getByTypeId(22)->getLevel()==5)
		{ //die stadt wurde ausgebaut auf lvl 6
			$MessageControler= new Controler_Message();
			$MessageControler->sendGetNewPlanetsToPlayer($User->getName());
			Controler_Main::getInstance()->refreshMessageIcon();
		}
		
		$Event = new BuildingConstructed($Planet, $Building);
		Controler_Event::getInstance()->addEvent($Event);
		
		if(!$Request->getAsString("PremiumView"))
		{
			$this->showBuildings();
		}else
		{
			$this->showBuildingsPremium();	
		}
	}
	
	
	private function getAllBuildings(BuildingCollection $BuildingCollectionPlanet)
	{
		$TempPlanet= Controler_Main::getInstance()->getPlanet(false); 
		$Planet= clone $TempPlanet;
		if(!$BuildingCollectionPlanet->getCount())
		{
			$BuildingCollectionPlanet=clone $Planet->getBuildingCollection();
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
					$Building->setCanBuild(true); // wenn das gebäude nicht gebaut werden darf muss dies vermerkt werden
				}else
				{
					$Building->setCanBuild(false);
				}
				$BuildingCollectionPlanet->add($Building);
			}
		}
		//$BuildingCollectionPlanet->deleteMaxLevel();
		return $BuildingCollectionPlanet;
	}
	
	
	private function getAllBuildingsByPlanet(BuildingCollection $BuildingCollectionPlanet,$Planet)
	{
		$TempPlanet= $Planet; 
		$Planet= clone $TempPlanet;
		if(!$BuildingCollectionPlanet->getCount())
		{
			$BuildingCollectionPlanet=clone $Planet->getBuildingCollection();
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
					$Building->setCanBuild(true); // wenn das gebäude nicht gebaut werden darf muss dies vermerkt werden
				}else
				{
					$Building->setCanBuild(false);
				}
				$BuildingCollectionPlanet->add($Building);
			}
		}
		//$BuildingCollectionPlanet->deleteMaxLevel();
		return $BuildingCollectionPlanet;
	}
	
	public function showBuildings($ErrorString="")
	{
		// alle gebäude laden 
		$Planet= Controler_Main::getInstance()->getPlanet(false); 
		$TempPlanet= clone $Planet;
		$BuildingCollectionPlanet=$this->getAllBuildings(new BuildingCollection());
		$Planet->setBuildingCollection($BuildingCollectionPlanet);
		$BuildingFinder= new BuildingFinder();
		$BuildingCount=$BuildingFinder->countBuildingsInBuild($TempPlanet->getId());
		$HQLevel=$BuildingFinder->findLevelByPlanetAndBuildingId($TempPlanet->getId(),1);
		$MaxBuildedBuildings=0;
		if($HQLevel<5 )
		{
			$MaxBuildedBuildings=2;
		}else
		{
			$MaxBuildedBuildings=3;
		}
		if(Controler_Main::getInstance()->getUser()->isPremium())
		{
			$BuildingCollectionPlanet->setBuildFaster(PREMIUM_BUILD_PERCENT_FASTER);
		}
		$TempLate=Template::getInstance("tpl_Buildings.php");
		$TempLate->assign("Planet",$TempPlanet);
		$TempLate->assign("BuildingCollection",$BuildingCollectionPlanet);
		$TempLate->assign("BuildedCount",$BuildingCount);
		$TempLate->assign("MaxBuildedBuildings",$MaxBuildedBuildings);
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->render();
	}
	
	public function canBuild(Building $Building,BuildingCollection $BuildingCollection)
	{
		$Needet=$Building->getNeed();
		if($Building->getLevel()>=$Building->getMaxLevel())
		{
			return false;
		}
		
		if($Needet==0 || $BuildingCollection->getByTypeId($Needet)->getLevel()>=$Building->getNeedLevel())
		{
			return true;	
		}
		return false;	
		
	}


	

	

	
	
}

?>