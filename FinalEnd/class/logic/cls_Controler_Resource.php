<?php

/**
 * class cls_Controler_Click
 *
 * Description for class cls_Controler_Click
 *
 * @author:
*/
class Controler_Resource  
{

	
	public function start()
	{
		//$this->setCredits(Controler_Main::getInstance()->getPlanetCollection(),Controler_Main::getInstance()->getUser());
		//var_dump(Controler_Main::getInstance());
		if(Controler_Main::getInstance()->getPlanet()->getId()>0)
		{
			$PlanetCollection=new PlanetCollection();
			$PlanetCollection->add(Controler_Main::getInstance()->getPlanet());
			//$PlanetCollection=$this->calculatePeopleAndFood($PlanetCollection);// bev und LM berechnen
			//$this->savePeopleAndFoodInDataBase($PlanetCollection);

			$this->setResource($PlanetCollection->getByIndex(0));	
			$PlanetManager= New PlanetManager();
			//$PlanetManager->updateRefeshTime($PlanetCollection->getByIndex(0));
			Controler_Main::getInstance()->setPlanet($PlanetCollection->getByIndex(0));
			//$this->setResource(Controler_Main::getInstance()->getPlanet());
		}
	}

	
	/**
	 * berechnet die neuen credits des spielers und macht die dem entsprechenden datenbank und main controller einträge
	 *
	 * @param PlanetCollection $PlanetCollection 
	 * @param User $User 
	 * @return void 
	 *
	 */
	public function setCredits(PlanetCollection $PlanetCollection,User $User)
	{
		$User=Controler_Main::getInstance()->getUser();
		if($User->getId()==0){return false;}// wenn kein User reinkam
		if($PlanetCollection->getCount()==0){return false;}	 // wenn es keine planeten gibt
		$UserManger= new UserManager();
		$PlanetFinder= new PlanetFinder();
		$UnitFinder= new UnitFinder();
		$Lastrefresh=((microtime(true)-$User->getRefresh())/60)/60; // in stunden	

		$Credits=$User->getCredits();
		$Credits+=$PlanetFinder->findCreditsByUser($User)*$Lastrefresh;  
	
		//$BuildingLevel=$BuildingCollection->getLevel();
		//$Credits+=$User->getCredits()+($BuildingLevel*$Lastrefresh*$BuildingCollection->getByIndex(0)->getMultiplicator());
		$DMG=$UnitFinder->findDMGByUser($User);// kosten für die Flotten abziehen
		if($DMG!=0)
		{
			$Pay=$DMG/100*$Lastrefresh;
			$Credits=$Credits-$Pay;
			//echo ($BuildingLevel*$Lastrefresh*$BuildingCollection->getByIndex(0)->getMultiplicator())." ".$Pay;
		}
		if($Credits>$User->getLevel()*CREDITS_PER_LEVEL)// maximal begrenzung für die credits 
		{
			$Credits=$User->getLevel()*CREDITS_PER_LEVEL;
		}
		
		if($Credits<0)// wenn kredits kleiner null werden, das soll nicht möglich sein
		{
			$Credits=0;
		}
		$UserManger->setRefreshTimeAndCredits($User->getId(),$Credits);
		$User->setCredits($Credits);
		Controler_Main::getInstance()->setUser($User);
	}
	
	
	public function setCreditsByUser(User $User)
	{
		if($User->getId()==0){return false;}// wenn kein User reinkam

		$UserManger= new UserManager();
		$PlanetFinder= new PlanetFinder();
		$UnitFinder= new UnitFinder();
		$Lastrefresh=((microtime(true)-$User->getRefresh())/60)/60; // in stunden	
		$Credits=$User->getCredits();
		$Credits+=$PlanetFinder->findCreditsByUser($User)*$Lastrefresh;  
		
		//$BuildingLevel=$BuildingCollection->getLevel();
		//$Credits+=$User->getCredits()+($BuildingLevel*$Lastrefresh*$BuildingCollection->getByIndex(0)->getMultiplicator());
		$DMG=$UnitFinder->findDMGByUser($User);// kosten für die Flotten abziehen
		if($DMG!=0)
		{
			$Pay=$DMG/100*$Lastrefresh;
			$Credits=$Credits-$Pay;
			//echo ($BuildingLevel*$Lastrefresh*$BuildingCollection->getByIndex(0)->getMultiplicator())." ".$Pay;
		}
		if($Credits>$User->getLevel()*CREDITS_PER_LEVEL)// maximal begrenzung für die credits 
		{
			$Credits=$User->getLevel()*CREDITS_PER_LEVEL;
		}
		
		if($Credits<0)// wenn kredits kleiner null werden, das soll nicht möglich sein
		{
			$Credits=0;
		}
		$UserManger->setRefreshTimeAndCredits($User->getId(),$Credits);
		$User->setCredits($Credits);
		Controler_Main::getInstance()->setUser($User);
	}
	
	
	/**
	 * berechnet die ressourcen des Planeten
	 *
	 * @param Planet $Planet This is a description
	 * @return void 
	 *
	 */
	public function setResource(Planet $Planet)
	{
		$TempTime=microtime(true);
		$Lastrefresh=(($TempTime-$Planet->getRefreshTime())/60)/60; // in stunden
		$Mine=$Planet->getBuildingCollection()->getByResource("Metall");
		
		$Metall=($Mine->getLevel()*$Lastrefresh*$Mine->getMultiplicator());	
		$Mine=$Planet->getBuildingCollection()->getByResource("Hydrogen");
		$Hydrogen=($Mine->getLevel()*$Lastrefresh*$Mine->getMultiplicator());
		
		$BioMass=0;// den lebensmittel werden extra berechnet
		$Mine=$Planet->getBuildingCollection()->getByResource("Cristal");

		$Crystal=($Mine->getLevel()*$Lastrefresh*$Mine->getMultiplicator());
		
		if($Metall+$Planet->getMetal()>$Planet->getStorLevel()*RESOURCE_PER_LEVEL)// maximal begrenzung für die credits ein führen
		{
			$Metall=$Planet->getStorLevel()*RESOURCE_PER_LEVEL-$Planet->getMetal();
		}

		
		if($Hydrogen+$Planet->getHydrogen()>$Planet->getStorLevel()*RESOURCE_PER_LEVEL)// maximal begrenzung für die credits ein führen
		{
			$Hydrogen=$Planet->getStorLevel()*RESOURCE_PER_LEVEL-$Planet->getHydrogen();
		}

		
		if($BioMass+$Planet->getBiomass()>$Planet->getStorLevel()*RESOURCE_PER_LEVEL)// maximal begrenzung für die credits ein führen
		{
			$BioMass=$Planet->getStorLevel()*RESOURCE_PER_LEVEL-$Planet->getBiomass();
		}

		
		if($Crystal+$Planet->getCrystal()>$Planet->getStorLevel()*RESOURCE_PER_LEVEL)// maximal begrenzung für die credits ein führen
		{
			$Crystal=$Planet->getStorLevel()*RESOURCE_PER_LEVEL-$Planet->getCrystal();
		}

		$PlanetManager= new PlanetManager();
		$PlanetManager->updateMetal($Planet,$Metall);
		$PlanetManager->updateBioMass($Planet,$BioMass);
		$PlanetManager->updateCrystal($Planet,$Crystal);
		$PlanetManager->updateHydrogen($Planet,$Hydrogen);
		$PlanetCollection= new PlanetCollection();
		$PlanetCollection->add($Planet);
		
		$this->calculatePeopleAndFood($PlanetCollection);// lm und bev berechnen
		
		//$PlanetManager->updateRefeshTime($Planet);
	}
	
	
	/**
	 * berechnet die nahrungsmittel und die bevölkerung der planeten Collection
	 *
	 * @param PlanetCollection $PlanetCollection 
	 * @return bool 
	 *
	 */
	public function calculatePeopleAndFood(PlanetCollection $PlanetCollection)
	{
		// nahrung ermitteln die benötigt werden
		$TempPlanetCollection=new PlanetCollection(); 
		$PlanetManager= new PlanetManager();
		foreach($PlanetCollection as $Planet)
		{
			$TempTime=microtime(true);
			$Lastrefresh=(($TempTime-$Planet->getRefreshTime())/60)/60; // in stunden
			 // bevölkerungs zuwachs oder schwund berechnen
			if($Planet->getBiomass()>0)
			{   // bevölkerunge glücklich mit lebensmittel versorgt
				$Town=$Planet->getBuildingCollection()->getByTypeId(22);// die stadt geben lassen
				$People=$Planet->getPeopleCount();
				$People= $Lastrefresh * PEOPLE_MAX_NEW_PEOPLE_PRE*pow(PEOPLE_MAX_NEW_PEOPLE_SUF,$Town->getLevel());
				if($People + $Planet->getPeopleCount()  >$Town->getMaxPeople())
				{
					$People=$Town->getMaxPeople()-$Planet->getPeopleCount();
				}

				$PlanetManager->updatePeople($Planet,$People);
				//$Planet->setPeopleCount($People);
			}
			else
			{  // keine lebensmittel mehr oder planet wird besetzt
				// der  schwund ist doppelt so groß als der zuwachs der bevölkerung
				
				$Town=$Planet->getBuildingCollection()->getByTypeId(22);// die stadt geben lassen
				$People=$Planet->getPeopleCount();
				$People= $Lastrefresh * PEOPLE_MAX_NEW_PEOPLE_PRE*pow(PEOPLE_MAX_NEW_PEOPLE_SUF,$Town->getLevel())*-2;
				if($People + $Planet->getPeopleCount() > $Town->getMaxPeople())
				{
					$People=$Town->getMaxPeople()-$Planet->getPeopleCount();
				}
				$PlanetManager->updatePeople($Planet,$People);
			}
			$Planet->setPeopleCount($Planet->getPeopleCount()+$People);
			// nahrungsmittel bedarf berechnen
			$FoodHour=$Planet->getBioMassConsumtion(); // nahrungsmittel bedarf der bevölkerung ermitteln	
			$Mine=$Planet->getBuildingCollection()->getByResource("Biomass");
			$BioMass=($Mine->getLevel()*$Lastrefresh*$Mine->getMultiplicator());	// die LM die Produziert wurden berechnen  + die alten
			$BioMass= $BioMass - ($Lastrefresh*$FoodHour);
			
			if($BioMass+$Planet->getBiomass()>$Planet->getStorLevel()*RESOURCE_PER_LEVEL)// maximal begrenzung für die credits ein führen
			{
				$BioMass=$Planet->getStorLevel()*RESOURCE_PER_LEVEL-$Planet->getBiomass();
				$Planet->setBiomass($Planet->getBiomass()+$BioMass);
			}
			if($BioMass+$Planet->getBiomass()<0)
			{
				//$BioMass=$BioMass;
				$Planet->setBiomass(0);// null setzen für die anzeige :)
			}
			
			
			//$Planet->setBiomass($Planet->getBiomass()+$BioMass);
			$TempPlanetCollection->add($Planet);
			
			
			$PlanetManager->updateBioMass($Planet,$BioMass);
			$PlanetManager->updateRefeshTime($Planet);
			//$PlanetManager->updatePeopleCount($Planet);
			//$PlanetManager->addBioMass($Planet,0);// den vorher berechneten lebendmittel stand abspeichern
		}
		return $TempPlanetCollection;
	}
	
	/**
	 * speichert die aktuellen bevölkerungszahlen und die berechneten Lebensmittel der Planeten
	 *
	 * @param PlanetCollection $PlanetCollection 
	 * @return bool 
	 *
	 */
	public function savePeopleAndFoodInDataBase(PlanetCollection $PlanetCollection)
	{
		$TempTime=date("Y-d-m G:i:s");
		$PlanetManager= new PlanetManager();
		// nahrung ermitteln die benötigt werden 
		foreach($PlanetCollection as $Planet)
		{
			$PlanetManager->updatePeopleCount($Planet);
			$PlanetManager->addBioMass($Planet,0);// den vorher berechneten lebendmittel stand abspeichern
		}
		return 1;
	}
	
	
	/**
	 * setzt alle resourcen von allen planeten und berechnet alle bevölkerungszahlen und credits
	 *
	 * @return void 
	 *
	 */
	public function setAllRessource()
	{
		$PlanetFinder= new PlanetFinder();
		$PlanetCollection= $PlanetFinder->findAll();
		//$PlanetCollection=$this->calculatePeopleAndFood($PlanetCollection);	// wird jetzt von set resource aufgerufen	
		//$this->savePeopleAndFoodInDataBase($PlanetCollection);
		foreach($PlanetCollection as $Planet)
		{
			$this->setResource($Planet);	
		}
	}
	
	
	
	
}

?>