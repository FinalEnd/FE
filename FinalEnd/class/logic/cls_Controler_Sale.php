<?php

class Controler_Sale
{
	
	
	public function start()
	{
		$Request= new Request();
		switch($Request->getAsString("Action"))
		{

			case "Buy":
			{
				$this->buy();
			}break;
			
			case "BuyShip":
			{
				$this->buyShip();
			}break;
			
			case "ShowCreateAuction":
			{
				$this->showCreateAuction();
			}break;
		
			case "CreateAuction":
			{
				$this->createAuction();
			}break;
			
			case "CreateShipAuction":
			{
				$this->createShipAuction();
			}break;
			
			case "CancelAuction":
			{
				$this->cancelAuction();
			}break;
			
			case "CancelShipAuction":
			{
				$this->cancelShipAuction();
			}break;
			
			case "ShowCreateShipAuction":
			{
				$this->showCreateShipAuction();
			}break;
			
			case "ShowUnits":
			{
				$this->showShipAuction();
			}break;
		
			default:
				$this->showMarket();
		}
		
	}
	
	
	
	public function cancelAuction($ErrorString="")
	{
		
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		$Planet=Controler_Main::getInstance()->getPlanet();
		if(!$this->checkBuilding()){return false;}
		$SaleFinder= new SaleFinder();
		$Sale= $SaleFinder->findById($Request->getAsInt("i_Id"));
		$TempLate=Template::getInstance("tpl_SaleCreate.php");
		
		if($Sale->getUser()->getId()!=$User->getId() && $Sale->getId()!=0)
		{
			$this->showCreateAuction(":T_SALE_CANTSTOP:!");
			return false;
		}
		
		
		switch($Sale->getRessource())
		{
			
			case "Metall":
			{
				$Planet->setMetal($Planet->getMetal()+$Sale->getCount());
			}break;
			
			case "Cristal":
			{
				$Planet->setCrystal($Planet->getCrystal()+$Sale->getCount());
			}break;
			
			case "Biomass":
			{
				$Planet->setBiomass($Planet->getBiomass()+$Sale->getCount());
			}break;
			
			case "Hydrogen":
			{
				$Planet->setHydrogen($Planet->getHydrogen()+$Sale->getCount());
			}break;
		}
		$PlanetManager= new PlanetManager();
		$PlanetManager->updateResources($Planet);
		
		
		$SaleManager= new SaleManager();
		$SaleManager->deleteSale($Sale);


		$this->showCreateAuction();
	}
	
	
	
	public function createAuction($ErrorString="")
	{
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		$Planet=Controler_Main::getInstance()->getPlanet();
		if(!$this->checkBuilding()){return false;}
			
		$SaleManager= new SaleManager();	
			
		// plneten resourcen checken
		
		switch($Request->getAsString("cb_Ress"))
		{
			
			case "Metall":
			{
				if($Planet->getMetal()>$Request->getAsInt("i_Count"))
				{
					$Planet->setMetal($Planet->getMetal()-$Request->getAsInt("i_Count"));
				}else
				{
					$ErrorString=":T_BUILDING_METALLNEED:.<br />";
				}
			}break;
			
			case "Cristal":
			{
				
				if($Planet->getCrystal()>$Request->getAsInt("i_Count"))
				{
					$Planet->setCrystal($Planet->getCrystal()-$Request->getAsInt("i_Count"));
				}else
				{
					$ErrorString=":T_BUILDING_KRISTNEED:.<br />";
				}
			}break;
			
			case "Biomass":
			{
				if($Planet->getBiomass()>$Request->getAsInt("i_Count"))
				{
					$Planet->setBiomass($Planet->getBiomass()-$Request->getAsInt("i_Count"));
				}else
				{
					$ErrorString=":T_BUILDING_FOODNEED:.<br />";
				}
			}break;
			
			case "Hydrogen":
			{
				
				if($Planet->getHydrogen()>$Request->getAsInt("i_Count"))
				{
					$Planet->setHydrogen($Planet->getHydrogen()-$Request->getAsInt("i_Count"));
				}else
				{
					$ErrorString=":T_BUILDING_DEUTNEED:.<br />";
				}
			}break;
		}
		
		$SaleManager= new SaleManager();
		
		if($Request->getAsInt("i_Count")<=0)
		{
			$ErrorString=":T_SALE_CHOOSEONE:.<br />";
			}
		if($Request->getAsInt("i_Price")<=0)
		{
			$ErrorString=":T_SALE_CHOOSEPRICE:.";
		}
		
		// fehler meldung auswerten
		
		
		if(strlen($ErrorString)>0)
		{
			$this->showCreateAuction($ErrorString);
			return false;		
		}		

		
		$PlanetManager= new PlanetManager();
		$PlanetManager->updateResources($Planet);
		
		
		
		$SaleManager->addSale(new   Sale(0,$User,$Request->getAsString("cb_Ress"),$Request->getAsInt("i_Count"),$Request->getAsInt("i_Price"),0,$Planet->getId()));
		// verkauf eintragen
			
		$this->showCreateAuction();

	}
	
	public function createShipAuction()
	{
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		$Planet=Controler_Main::getInstance()->getPlanet();
		if(!$this->checkBuildingForShips()){return false;}
		$SaleManager= new SaleManager();
		$TempLate=Template::getInstance("tpl_SaleCreateShip.php");
	
		$Unitfinder=new UnitFinder();
		
		$SaleFinder = new SaleFinder();
		$Sale=$SaleFinder->findShipSaleByUnitId($Request->getAsInt("i_Id"));
		if($Sale->getId() == 0)
		{
			$Unit=$Unitfinder->findById($Request->getAsInt("i_Id"));
			$SaleManager->addShipSale($User->getId(), $Unit->getId(), $Request->getAsInt("i_Price"));
			$State = new StateShipForSale(21,"shop",time()+ STATE_SHIPSELLABLE,"","");
			$StateManager = new StateManager();
			$StateManager->insertStateToUnit($State, $Unit);
		}
		$this->showCreateShipAuction();
	}
	
	public function cancelShipAuction()
	{
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		$Planet=Controler_Main::getInstance()->getPlanet();
		if(!$this->checkBuildingForShips()){return false;}
		$SaleFinder= new SaleFinder();
		$Sale= $SaleFinder->findShipSaleById($Request->getAsInt("i_Id"));
		$TempLate=Template::getInstance("tpl_SaleCreateShip.php");
		
		if($Sale->getId() != 0 && $Sale->getUnit()->getUser()->getId() !=$User->getId() )
		{
			$this->showCreateShipAuction(":T_SALE_CANTSTOP:!");
			return false;
		}
		$StateManager = new StateManager();
		$StateManager->deleteStatesByUnitAndByState($Sale->getUnit(), 21);
		$SaleManager = new SaleManager();
		$SaleManager->deleteShipSale($Sale->getUnit()->getId());
		$this->showCreateShipAuction();	
	}
	
	public function buy()
	{
		
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		$Planet=Controler_Main::getInstance()->getPlanet();
		if(!$this->checkBuilding()){return false;}
		
		$TempLate=Template::getInstance("tpl_Sale.php");
		$SaleFinder= new SaleFinder();
		$SaleManager= new SaleManager();
		$Sale=$SaleFinder->findById($Request->getAsInt("i_Id"));
		 // resourcen prüfen
		
		if($Sale->getId()==0)
		{
			$ErrorString=":T_SALE_OFFERLOST:.<br />";
			$this->showMarket($ErrorString);
			return false;
		}
		
		
		if($User->getCredits()<$Sale->getPrice())
		{
			$ErrorString=":T_SALE_NOCREDITS:.<br />";
			$this->showMarket($ErrorString);
			return false;
		}
		
		
		if($User->getId()==$Sale->getCreator()->getId())
		{
			$ErrorString=":T_SALE_FOREVERALONE:.<br />";
			$this->showMarket($ErrorString);
			return false;
		}
		
		if(!$User->getId())
		{
			$ErrorString=":T_SALE_FOREVERALONE:.<br />";
			$this->showMarket($ErrorString);
			return false;
		}
		
		if(strlen($ErrorString)>0)
		{
			$this->showMarket($ErrorString);
			return false;
		}
		
		
		$UserManager= new UserManager();
		$UserManager->updateUserCredits($User->getCredits()-$Sale->getPrice(),$User->getId()); // credits abgezogen
		$User->setCredits($User->getCredits()-$Sale->getPrice());  
		$Seller= $Sale->getUser();
		$UserManager->updateUserCredits($Seller->getCredits()+$Sale->getPrice(),$Seller->getId()); // credits abgezogen
		// nachricht verschicken  
		$Controler_Message= new Controler_Message();                                                                                                                                                                                         
		$Controler_Message->sendMessage("System",  $Seller->getName(),":T_SALE_SOLD1: ".$User->getName()." :T_SALE_SOLD2: ".$Sale->getPrice(true)." :T_HEADER_CREDITS:.",":T_SALE_SOLDTITLE:");
		$PlanetManager= new PlanetManager();
		 switch($Sale->getRessource())
		{
			
			
			case "Metall":
			{
				$Planet->setMetal($Planet->getMetal()+$Sale->getCount());
				$PlanetManager->updateMetal($Planet,$Sale->getCount());
			}break;
			
			case "Cristal":
			{
				$Planet->setCrystal($Planet->getCrystal()+$Sale->getCount());
				$PlanetManager->updateCrystal($Planet,$Sale->getCount());
			}break;
			
			case "Biomass":
			{
				$Planet->setBiomass($Planet->getBiomass()+$Sale->getCount());
				$PlanetManager->updateBioMass($Planet,$Sale->getCount());
			}break;
			
			case "Hydrogen":
			{
				$Planet->setHydrogen($Planet->getHydrogen()+$Sale->getCount());
				$PlanetManager->updateHydrogen($Planet,$Sale->getCount());
			}break;
		}
		
		$PlanetManager->updateResources($Planet);
		// resourcen geben
		// auktion entfernen
		$SaleManager= new SaleManager();
		$SaleManager->deleteSale($Sale);
		// tpl aktialisieren
		
		$TempLate=Template::getInstance("tpl_SystemMessage.php");
		$TempLate->assign("User",$User);
		$TempLate->assign("Planet",$Planet);
		
		Controler_Main::getInstance()->addPermanentOutPut();
		Controler_Event::getInstance()->addEvent(new BuyEvent($Planet->getUser(),$Sale));
		Controler_Event::getInstance()->addEvent(new SellEvent($Sale->getCreator(),$Sale));
		Controler_Event::getInstance()->addEvent(new SaleStatsChange($Sale->getRessource(),$Sale->getCount(),$Sale->getPrice()));
		$this->showMarket();

	}
	
	
	
	
	public function buyShip()
	{
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		if(!$this->checkBuildingForShips()){return false;}
			
		$TempLate=Template::getInstance("tpl_SaleShip.php");
		$Id=$Request->getAsInt("i_Id");
		$Salefinder=new SaleFinder();
		$Sale=$Salefinder->findShipSaleById($Id);
		
		if($Sale->getId()==0)
		{
			$ErrorString=":T_SALE_OFFERLOST:.<br />";
			$this->showShipAuction($ErrorString);
			return false;
		}
		
		$Unitfinder=new UnitFinder();
		$Unit=$Unitfinder->findById($Sale->getUnit()->getId());
		
		if($Unit->getUserId() == $User->getId())
		{
			$ErrorString=":T_SALE_FOREVERALONE:";
			$TempLate->assign("ErrorString",$ErrorString);
		}
		$DeathStarCount= $Unitfinder->countDeathStarByUser($User);
		if($DeathStarCount>=UNIT_MAX_DEATHSTARS && $Unit->getExtentionTow() == 26)
		{
			$ErrorString=":T_FLEET_NO_MORE_DEATHSTAR:<br/>";	
		}
		if($User->getCredits()<$Sale->getPrice())
		{
			$ErrorString=":T_SALE_NOCREDITS:.<br />";
			$this->showShipAuction($ErrorString);
			return false;
		}
		if(!$User->getId())
		{
			$ErrorString=":T_SALE_FOREVERALONE:.<br />";
			$this->showShipAuction($ErrorString);
			return false;
		}
		
		if(strlen($ErrorString)>0)
		{
			$this->showShipAuction($ErrorString);
			return false;
		}
		$Planet=Controler_Main::getInstance()->getPlanet();
		$UserManager= new UserManager();
		$UserManager->updateUserCredits($User->getCredits()-$Sale->getPrice(),$User->getId()); // credits abgezogen
		$User->setCredits($User->getCredits()-$Sale->getPrice());  
		$Seller= $Sale->getUser();
		$UserManager->updateUserCredits($Seller->getCredits()+$Sale->getPrice(),$Seller->getId()); // credits abgezogen
		
		$Unit->setUser($User);
		$Unit->setX($Planet->getX());
		$Unit->setY($Planet->getY());
		$Unitmanager=new UnitManager();
		$Unitmanager->updateUnit($Unit);
		$StateManager = new StateManager();
		$StateManager->deleteStatesByUnitAndByState($Sale->getUnit(), 21);
		$SaleManager = new SaleManager();
		$SaleManager->deleteShipSale($Sale->getUnit()->getId());
		
		$Controler_Message= new Controler_Message();                                                                                                                                                                                         
		$Controler_Message->sendMessage("System",  $Seller->getName(),":T_SALE_SHIP1: ".$Unit->getName()." :T_SALE_SHIP2: ".$User->getName()." :T_SALE_SHIP3: ".$Sale->getPrice(true)." :T_HEADER_CREDITS:.",":T_SALE_SHIPTITLE:");
		
		$this->showShipAuction();
	}
	
	/**
	 * löscht alte auktionen aus der db die über 5 tage im handelszentrum nicht verkauft worden sind	
	 *
	 * @return void 
	 *
	 */
	public function deleteOldActoins()
	{
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		$Planet=Controler_Main::getInstance()->getPlanet();
		$SaleFinder= new SaleFinder();
		$SaleCollection= $SaleFinder->findOldActions();
		$SaleManager= new SaleManager();
		$Controler_Message= new Controler_Message();                                                                                                                                                                                         
		$PlanetManager= new PlanetManager();
		$PlanetFinder=new PlanetFinder();
		foreach($SaleCollection as $Sale)
		{
			$Planet=$PlanetFinder->findById($Sale->getPlanetId());
			$Controler_Message->sendMessage("System",  $Sale->getUser()->getName(),":T_SALE_BACK1: ".$Planet->getName()." ".$Sale->getCount()."".$Sale->getName()." ".$Sale->getPrice()." :T_SALE_BACK2:.",":T_SALE_BACKTITLE:");
			
			switch($Sale->getRessource())
			{
				 case "Metall":
				 {
					$PlanetManager->addMetal($Planet,$Sale->getCount());
				}break;
				case "Biomass":
				 {
					$PlanetManager->addBioMass($Planet,$Sale->getCount());
				}break;
				case "Hydrogen":
				 {
					$PlanetManager->addHydrogen($Planet,$Sale->getCount());
				}break;
				case "Cristal":
				 {
					$PlanetManager->addCristal($Planet,$Sale->getCount());
				}break;
				
			}
			$SaleManager->deleteSale($Sale);
		}		
		return true;
	}
	
	
	
	
	public function showCreateAuction($ErrorString="")
	{
		
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		$Planet=Controler_Main::getInstance()->getPlanet();
		if(!$this->checkBuilding()){return false;}
		$SaleFinder= new SaleFinder();
		$SaleCollection= $SaleFinder->findByUserAndPlanetId($User,$Planet->getId());
		$TempLate=Template::getInstance("tpl_SaleCreate.php");
		$SaleFinder= new SaleFinder();
		
		if($Request->getAsInt("Count")==0)
		{
			$Count=15;
		}	
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->assign("SaleCollection",$SaleCollection);
		$TempLate->render();

	}
	
	public function showCreateShipAuction($ErrorString="")
	{
		
		$Request= new Request();		
		$User= Controler_Main::getInstance()->getUser();
		$Planet=Controler_Main::getInstance()->getPlanet();
		if(!$this->checkBuildingForShips()){return false;}
		$UnitFinder=new UnitFinder();
		if(!$Request->getAsInt("Start"))
		{
			$Start=0;
		}else
		{
			$Start=$Request->getAsInt("Start");
		}
		$SaleUnitCollection= $UnitFinder->findByUserIdAndKoordinatesInRange($User->getId(),$Planet->getX(),$Planet->getY(),UNIT_REPAIR_RANGE);
		$SaleCollection=$SaleUnitCollection->getUnitsAlreadyOffered($SaleUnitCollection,$User);
		$UnitCollection=$UnitFinder->findAllByPlanetKoordinates($Planet->getX(),$Planet->getY(),UNIT_REPAIR_RANGE,$Start);
		$UnitCollection= $UnitCollection->getByUserId($User->getId());
		$UnitCount= $UnitFinder->countAllByPlanetKoordinates($Planet->getX(),$Planet->getY(),UNIT_REPAIR_RANGE);
		if($SaleCollection)	
		{
			$UnitCollection=$UnitCollection->deleteUnitsAlreadyOffered($UnitCollection, $User);
			$UnitCount=$UnitCount+$SaleCollection->getCount();
		}
		$TempLate=Template::getInstance("tpl_SaleCreateShip.php");
		
		
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
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->assign("SaleCollection",$SaleCollection);
		$TempLate->assign("UnitCollection",$UnitCollection);
		$TempLate->render();
	}
	
	
	public function showShipAuction($ErrorString="")
	{
		
		$Request= new Request();	
		$User= Controler_Main::getInstance()->getUser();
		
		$Planet=Controler_Main::getInstance()->getPlanet();
		$Store=$Planet->getBuildingCollection()->getByTypeId(20);
		
		if(!$this->checkBuildingForShips()){return false;}
		$this->deleteOldActoins();
		$TempLate=Template::getInstance("tpl_SaleShip.php");
		$SaleFinder = new SaleFinder();
		
		
		$UnitSale = $SaleFinder->findAllShipSale();
		
		$UnitFinder=new UnitFinder();
		$EnemyUnitsCollection=$UnitFinder->findAllByKoordinates($Planet->getX(),$Planet->getY(),UNIT_SIEGE_RANGE);// alle einheiten finden
		if(!$EnemyUnitsCollection->areUnitsFormDifferentPlayer() || !$EnemyUnitsCollection->areUnitsFormDifferentAllianz() && $EnemyUnitsCollection->areUnitsFormDifferentPlayer())
		{
			$TempLate->assign("CanWorkOn",true);// die einheiten dürfen gerepptwerden und aufgelöst werden	
		}
		
		
		$TempLate->assign("UnitSale",$UnitSale);
		
		
		if($Request->getAsInt("Count")==0)
		{
			$Count=SALE_PAGE_COUNT;
		}
		if($SaleCount>$Request->getAsInt("Start")+$Count)
		{
			$TempLate->assign("NextPage",true);
			$TempLate->assign("NextCount",$Request->getAsInt("Start")+$Count);
		}
		if($Request->getAsInt("Start")>0)
		{
			$TempLate->assign("LastPage",true);
			$TempLate->assign("LastCount",$Request->getAsInt("Start")-$Count);
		}
		


		$TempLate->assign("Start",$Request->getAsInt("Start"));
		
		$TempLate->assign("Count",$Count);		
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->render();
	}
	
	
	private function checkBuilding()
	{
		$Planet=Controler_Main::getInstance()->getPlanet();
		$Store=$Planet->getBuildingCollection()->getByTypeId(20);
		if($Store->getLevel()<=0)
		{
			$TempLate=Template::getInstance("tpl_SystemMessage.php");
			$TempLate->assign("Message",":T_SALE_SHOPNEEDED:");
			$TempLate->render();
			return false;
		}
		return true;
	}
	
	private function checkBuildingForShips()
	{
		$Planet=Controler_Main::getInstance()->getPlanet();
		$Store=$Planet->getBuildingCollection()->getByTypeId(20);
		if($Store->getLevel()<=1)
		{
			$TempLate=Template::getInstance("tpl_SystemMessage.php");
			$TempLate->assign("Message",":T_SALE_SHOPNEEDED2:");
			$TempLate->render();
			return false;
		}
		return true;
	}
	
	public function showMarket($ErrorString="")
	{
		$Request= new Request();	
		$User= Controler_Main::getInstance()->getUser();
		
		$Planet=Controler_Main::getInstance()->getPlanet();
		$Store=$Planet->getBuildingCollection()->getByTypeId(20);
		
		if(!$this->checkBuilding()){return false;}
		$this->deleteOldActoins();
		$TempLate=Template::getInstance("tpl_Sale.php");
		$SaleFinder= new SaleFinder();
		$Ressource="All";
		if($Request->getAsString("cb_FilterRessource"))
		{
			$TempLate->assign("FilterRessource",$Request->getAsString("cb_FilterRessource"));
			$Ressource=$Request->getAsString("cb_FilterRessource");
		}else
		{
			$TempLate->assign("FilterRessource","All");
		}
		
		
		$SaleCount=$SaleFinder->findAllCount();
		
		if($Request->getAsInt("Count")==0)
		{
			$Count=SALE_PAGE_COUNT;
		}
		if($SaleCount>$Request->getAsInt("Start")+$Count)
		{
			$TempLate->assign("NextPage",true);
			$TempLate->assign("NextCount",$Request->getAsInt("Start")+$Count);
		}
		if($Request->getAsInt("Start")>0)
		{
			$TempLate->assign("LastPage",true);
			$TempLate->assign("LastCount",$Request->getAsInt("Start")-$Count);
		}
		

		if($Store->getLevel()>1)
		{
			$TempLate->assign("ShowShipAuction",true);
		}
		$StatsFinder = new StatsFinder();
		$Stats = $StatsFinder->findStatsById(0);
		$TempLate->assign("Stats",$Stats);
		$TempLate->assign("Start",$Request->getAsInt("Start"));
		
		$TempLate->assign("Count",$Count);		
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->assign("SaleCollection",$SaleFinder->findSingleRessource($Ressource,$Request->getAsInt("Start"),$Count));
		$TempLate->render();

	}
	
	

	

	
	


	

	
	
	

	

	
	
	
	
}


?>