<?php

/**
 * class cls_Controler_Research
 *
 * Description for class cls_Controler_Research
 *
 * @author:
*/
class Controler_Research  
{

	
	public function start()
	{
		$Request= new Request();

		switch($Request->getAsString("Action"))
		{

			case "CancelUpdateReSearch":
			{
				$this->cancelUpdateReSearch();
			}break;
			
			case "UpdateReSearchs":	// erforschen
			{
				$this->updateReSearch();
			}break;

			default:
				// zeigt das Forschungs dingens an
				$this->showResearch();
		}
	}


	public function cancelUpdateReSearch()
	{
		$Request= new Request();
		$ReseachId=$Request->getAsInt("ReSearchId");

		$ReSearchManager= new ReSearchManager();
		$ReSearchFinder= new ReSearchFinder();
		$Planet = Controler_Main::getInstance()->getPlanet(); 
		$ReSearchCollectionPlanet = $Planet->getReSearchCollection();
		$Reseach = $ReSearchCollectionPlanet->getById($ReseachId);

		$User= Controler_Main::getInstance()->getUser();
		
		if($Reseach->getInbuild()==0)
		{
			$this->showResearch();
			return false;	
		}

		$Reseach->setInbuild(0);

		$ReSearchManager->setReSearchTime($ReseachId,0);   // Forschung zurück setzen
		
		// planeten resourcen updaten
		$PlaneManager= new PlanetManager();
		if($Reseach->getBuildMetallNextLevel()>=0)
		{
			$Planet->setMetal($Planet->getMetal()+$Reseach->getBuildMetallNextLevel()/2);
		}
		if($Reseach->getBuildHydrogenNextLevel()>=0)
		{
			$Planet->setHydrogen($Planet->getHydrogen()+$Reseach->getBuildHydrogenNextLevel()/2);
		}
		if($Reseach->getBuildBiomassNextLevel()>=0)
		{
			$Planet->setBiomass($Planet->getBiomass()+$Reseach->getBuildBiomassNextLevel()/2);
		}
		if($Reseach->getBuildCrystalNextLevel()>=0)
		{
			$Planet->setCrystal($Planet->getCrystal()+$Reseach->getBuildCrystalNextLevel()/2);
		}
		$PlaneManager->updateResources($Planet);
		
		// user Credits updaten
		$UserManager= new UserManager();
		$User->setCredits($User->getCredits()+$Reseach->getBuildCreditsNextLevel());
		$UserManager->updateUserCredits($User->getCredits(),$User->getID());
		Controler_Main::getInstance()->setUser($User);
		Controler_Main::getInstance()->mappPlanetCollection();
		Controler_Main::getInstance()->addPermanentOutPut();

		$this->showResearch();

	}



	public function updateReSearch()
	{
		$Request= new Request();
		$ReSearchId=$Request->getAsInt("SId");
		$ReSearchManager= new ReSearchManager();
		$ReSearchFinder= new ReSearchFinder();
		// research aus dem Planeten holen
		$Planet=Controler_Main::getInstance()->getPlanet();
		$ReSearch=$Planet->getReSearchCollection()->getByReSearchId($ReSearchId);

		
		if($ReSearch->getId()==0)
		{// forschungsobjkekt aus db laden weil es eine neu forschung ist
			$ReSearch= $ReSearchFinder->findById($ReSearchId);
			
		}
		 
		
		if(Controler_Main::getInstance()->getUser()->isPremium())// wenn premium dann muss es schneller gebaut werden können
		{
			$ReSearch->setPerCentFaster(PREMIUM_BUILD_PERCENT_FASTER);
		}
		// Checken ob es erforscht werden 
		$ReSearchCollection= $Planet->getReSearchCollection();  // planeten holen
		if(!$this->canBuild($ReSearch,$ReSearchCollection))	 // ob er das gebäude ausbauen darf
		{
			$ErrorString=":T_ERROR_1:.<br />";
		}
		
		$ErrorString.= $this->checkResource($ReSearch,$Planet);	// ob genügend resourcen vorhanden sind
		if(strlen($ErrorString)>0)
		{
			$this->showResearch($ErrorString);
			
			return false;
		}
		$ReSearchInBuild=  $ReSearchFinder->countReSearchsInBuild($Planet->getId());
		if($ReSearchInBuild>=1)
		{
			$this->showResearch(":T_RESEARCH_NOPE:.");
			return false;
		}
		
			
		//wenn ja eintragen
		// neu eintragen oder Updaten
		if($ReSearchCollection->getByReSearchId($ReSearch->getReSearchId())->getId()==0)
		{
			// neu eintragen	
			$ReSearchManager->addReSearch($Planet->getId(),$ReSearchId);
		}
		
		// bauzeit setzen
		$ReSearchManager->buildReSearch($Planet->getId(),$ReSearchId,$ReSearch->getBuildTimeNextLevel()+microtime(true));// ausbauen
		
		 // dem Planeten die Resourcen abziehen
		$PlanetManager= new PlanetManager();

		$Planet->setMetal($Planet->getMetal()-$ReSearch->getBuildMetallNextLevel());
		$Planet->setHydrogen($Planet->getHydrogen()-$ReSearch->getBuildHydrogenNextLevel());
		$Planet->setBiomass($Planet->getBiomass()-$ReSearch->getBuildBiomassNextLevel());
		$Planet->setCrystal($Planet->getCrystal()-$ReSearch->getBuildCrystalNextLevel());
		$PlanetManager->updateResources($Planet);
		
		$User= Controler_Main::getInstance()->getUser();
		$UserManager= new UserManager();
		$User->setCredits($User->getCredits()-$ReSearch->getBuildCreditsNextLevel());
		$UserManager->updateUserCredits($User->getCredits(),$User->getID());
		Controler_Main::getInstance()->setUser($User);
		Controler_Main::getInstance()->mappPlanetCollection();
		Controler_Main::getInstance()->addPermanentOutPut();
		$this->showResearch();
	}


	private function checkResource(ReSearch $ReSearch,Planet $Planet)
	{

			if($ReSearch->getLevel()>=$ReSearch->getMaxLevel())
			{// wenn das gebäude bereits level 25 erreicht hat dann hier raus gehen
				
			return ":T_RESEARCH_REACH:";
			}
	
		$User= Controler_Main::getInstance()->getUser();
		// gucken ob genügend resourcen zur verfügung stehen 
		if($Planet->getMetal()<=$ReSearch->getBuildMetallNextLevel()-1 ||
			$Planet->getHydrogen()<=$ReSearch->getBuildHydrogenNextLevel()-1 ||
			$Planet->getBiomass() <= $ReSearch->getBuildBiomassNextLevel()-1||
			$Planet->getCrystal()<=$ReSearch->getBuildCrystalNextLevel()-1 ||
			$User->getCredits(true) <= $ReSearch->getBuildCreditsNextLevel()-1
		)
		{// nich genügend resourcen zur verfügung
			
			if($Planet->getMetal()<=$ReSearch->getBuildMetallNextLevel()-1)
			{
				$ErrorString=":T_BUILDING_METALLNEED:<br />";
			}
			if($Planet->getHydrogen()<=$ReSearch->getBuildHydrogenNextLevel()-1)
			{
				$ErrorString.=":T_BUILDING_DEUTNEED:<br />";
			}
			if($Planet->getBiomass() <= $ReSearch->getBuildBiomassNextLevel()-1)
			{
				$ErrorString.=":T_BUILDING_FOODNEED:<br />";
			}
			if($Planet->getCrystal()<=$ReSearch->getBuildCrystalNextLevel()-1)
			{
				$ErrorString.=":T_BUILDING_KRISTNEED:<br />";
			}
			if($User->getCredits(true) <= $ReSearch->getBuildCreditsNextLevel()-1)
			{
				$ErrorString.=":T_BUILDING_CREDITSNEED:<br />";
			}
			return $ErrorString;
		}	
		
	}




	public function showResearch($ErrorString="")
	{
		// checken ob Forschungs labor vorhanden ist
		$Planet= Controler_Main::getInstance()->getPlanet();  // planeten holen
		
		$Lab=$Planet->getBuildingCollection()->getByTypeId(19);
		if($Lab->getLevel()<=0)
		{
			$TempLate=Template::getInstance("tpl_SystemMessage.php");
			$TempLate->assign("Message",":T_RESEACH_NEED:");
			$TempLate->render();
			return false;
		}

		$PlanetFinder= new PlanetFinder();
		$Planet=$PlanetFinder->findById($Planet->getId());
		$ReSearchCollection= $this->getAllReSearchs($Planet->getReSearchCollection());
		$TempLate=Template::getInstance("tpl_Research.php");
		$ReSearchCollection->deleteMaxLevel();
		
		if(Controler_Main::getInstance()->getUser()->isPremium())
		{
			$ReSearchCollection->setBuildFaster(PREMIUM_BUILD_PERCENT_FASTER);
		}
		
		$TempLate->assign("ReSearchCollection",$ReSearchCollection);
		$TempLate->assign("Planet",$Planet);
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->render();
		
	}

	private function getAllReSearchs(ReSearchCollection $ReSearchCollection)
	{
		$Planet= Controler_Main::getInstance()->getPlanet(); 
		if(!$ReSearchCollection->getCount())
		{
			$ReSearchCollection=$Planet->getReSearchCollection();
		}
		$ReSearchFinder= new ReSearchFinder();
		$ReSearchCollectionAll=$ReSearchFinder->findAllAvavibelReSearch();
		// und mit zur ausgabe hinzu fügen
		for($i=0;$i<$ReSearchCollectionAll->getCount();$i++)	
		{
			$ReSearch=$ReSearchCollectionAll->getByIndex($i);
			if($this->canBuild($ReSearch,$ReSearchCollection)&& $ReSearchCollection->getByReSearchId($ReSearch->getId())->getId()==0)
			{
				$ReSearchCollection->add($ReSearch);
			}		
		}
		return $ReSearchCollection;
	}


	 
	/**
	 * prüft ob die forschung erforscht werden darf
	 *
	 * @param ReSearch $ReSearch 
	 * @param ReSearchCollection $ReSearchCollection 
	 * @return bool 
	 *
	 */
	public function canBuild(ReSearch $ReSearch,ReSearchCollection $ReSearchCollection)
	{
		$Needet=$ReSearch->getNeed();// die gebäude id 
		if($ReSearchCollection->getByReSearchId($Needet)->getLevel()>=$ReSearch->getNeedLevel())
		{
			return true;	
		}
		return false;
	}
	

}

?>