<?php



class UnitCollection extends Collection 
{
	public function add(Unit $Element)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
		$this->ElementCounter++;
	}
	
	
	 
	/**
	 * stzt allen einheiten den schaden mit ausnahme der angegebenen ID
	 *
	 * @param float $DMG This is a description
	 * @param int $FromUserId die UserId die Keinen Schaden bekommt
	 * @param int $Laser gibt an ob die gegner einheit einen laser benutzt oder nicht	gut gegen panzerung
	 * @param int $Partikel gibt an ob die gegner einheit eine Partikel kanone benutzt oder nicht	// gut gegen schilde mittel mässig gegen panzerung
	 * @param int $Torpedos gibt an ob die gegner einheit eine Partikel kanone benutzt oder nicht   // gut gegen planeten und einheiten mit panzerung über 150
	 * @return void 
	 *
	 */
	public function setDMGToUnitsByUser($DMG,$FromUserId,$Laser=0,$Partikel=0,$Torpedos=0)
	{

		foreach($this->Elements as $Element)
		{
			if($Element->getUserId()!=$FromUserId)
			{
				//Prozentualen Schaden ermitteln
				
				$DMG=$Element->calculateDMG($DMG,$Laser,$Partikel,$Torpedos);
				if($DMG<0)
				{
					return false;
				}
				$State=	$DMG/$Element->getHealts();
				$Element->setState($Element->getState()-$State);
			}
		}
	}
	
	
	
	
	/**
	 * entfernt die einheiten die nicht sichtbarsein sollen sthealt / scanner
	 *
	 * @param User $User 
	 * @return void 
	 *
	 */
	public function deleteInvisiableUnits(User $User)
	{
		$InVisableUnits=$this->getAllWithStealhs();
		$ScannerUnits=$this->getAllWithScanner();

		$DeletetCollection= new UnitCollection();

		foreach($InVisableUnits as $InVisUnit)
		{
			$DoDelete= true;
			$ScannerUnits->getUnitsInRange($InVisUnit->getX(),$InVisUnit->getY(),200);
			
			// wenn in gleicher alllianz oder gleicher spieler   dann nicht entfernen
			if($InVisUnit->getUser()->getId()==$User->getId()  ||  $InVisUnit->getUser()->getAllianzId()==$User->getAllianzId() && $InVisUnit->getUser()->hasAllianz())
			{
				$DoDelete= false;
			}
			$TempCollection=$ScannerUnits->getByAllianzId($User->getAllianzId());// gibt aus deienr allianz zurück
			if($TempCollection->getCount()!=0)			 // gucken ob welche gefudnen wurden
			{
				$DoDelete=false;
			}	
			
			if($DoDelete)
			{
				$DeletetCollection->add($InVisUnit);
			}
		}

		$this->deleteUnits($DeletetCollection);
		
	}
	
	
	/**
	 * entfernt alle gegnerischen einheiten die zuweit von einer einheit oder einem planeten entfernt sind
	 *
	 * @param User $User 
	 * @param UnitCollection $UnitCollectiondie Es werden alle Flotten gelöscht die nicht innerhalt einerflotte diese Collection sind 
	 * @return void 
	 *
	 */
	public function deleteUnitsOutOfRange(User $User,PlanetCollection $MyPlanetCollection)
	{
		$DeletetCollection= new UnitCollection();
		if(!$User->hasAllianz())
		{
			$UserUnitCollection=$this->getByUserId($User->getId());
		}else
		{
			$UserUnitCollection=$this->getByAllianzId($User->getAllianzId());
		}
		$ViewAbleUnitCollection= new UnitCollection();
		foreach($UserUnitCollection as $MYUnit)
		{
			$TempCollection=$this->getUnitsInSigth($MYUnit->getX(),$MYUnit->getY());
			foreach($TempCollection as $EnemyUnit)
			{
				if($ViewAbleUnitCollection->getById($EnemyUnit->getId())->getId()==0)
				{
					$ViewAbleUnitCollection->add($EnemyUnit);	
				}
			}
		}
		
		foreach($MyPlanetCollection as $Planet)
		{
			$TempCollection=$this->getUnitsInRange($Planet->getX(),$Planet->getY(),PLANET_SIGHT_NORMAL);
			foreach($TempCollection as $EnemyUnit)
			{
				if($ViewAbleUnitCollection->getById($EnemyUnit->getId())->getId()==0)
				{
					$ViewAbleUnitCollection->add($EnemyUnit);	
				}
			}
		}
		
		
		
		$this->ElementCounter=$ViewAbleUnitCollection->getCount();
		$this->Elements=  $ViewAbleUnitCollection->getAll();
	}
	
	
	/**
	 * gibt die Einheiten zurück die in sicht sind dabei sind normale einheiten und scanner einheiten unterscheidlich zu handeln
	 *
	 * @param int $X 
	 * @param int $Y 
	 * @return UnitCollection kann leer sein 
	 *
	 */
	public function getUnitsInSigth($X,$Y)
	{
		$TempCollection= new UnitCollection();
		foreach($this->Elements as $Element)
		{
			$Range=UNIT_SIGHT_NORMAL;
			if($Element->getExtentionOne()==10)
			{
				$Range=UNIT_SIGHT_SCANNER;	
				
			}
			$C=	sqrt(pow($Element->getX()-$X,2)+pow($Element->getY()-$Y,2));
			if($C<=$Range)
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
	
	
	
	
	public function getUnitsInRange($X,$Y,$Range)
	{
		$TempCollection= new UnitCollection();
		foreach($this->Elements as $Element)
		{
			$C=	sqrt(pow($Element->getX()-$X,2)+pow($Element->getY()-$Y,2));
			if($C<=$Range)
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
	
	
	
	public function deleteUnits(UnitCollection $UnitCollection)
	{
		$TempArray=array();
		
		if($UnitCollection->getCount()==0)	{return false;}
		
		foreach($this->Elements as $Element)
		{
			if(!$UnitCollection->getById($Element->getId())->getId())
			{
				$TempArray[]= $Element;
			}
		}
		$this->Elements=$TempArray;
	}
	
	/**
	 * gibt eine sale collection zurück, die alle einheiten löscht die angeboten werden
	 *
	 * @param UnitCollection $UnitCollection 
	 * @param User $User This is a description
	 * @return SaleCollection kann leer sein
	 *
	 */
	public function deleteUnitsAlreadyOffered(UnitCollection $UnitCollection,User $User)
	{
		if($UnitCollection->getCount()==0)	{return $UnitCollection;}
		$SaleFinder= new SaleFinder();
		$SaleCollection= $SaleFinder->findAllShipSaleByUser($User->getId());
		foreach($this->Elements as $Element)
		{
			foreach ($SaleCollection as $Sale)
			{
				if($Element->getId() == $Sale->getUnit()->getId())
				{
					$UnitCollection->deleteUnit($Element);
					continue;
				}
			}
		}
		return $UnitCollection;
	}
	
	
	
	/**
	 * gibt eine sale collection zurück, die alle einheiten enthält die angeboten werden
	 *
	 * @param UnitCollection $UnitCollection 
	 * @param User $User This is a description
	 * @return SaleCollection kann leer sein
	 *
	 */
	public function getUnitsAlreadyOffered(UnitCollection $UnitCollection,User $User)
	{
		$TempArray=array();
		$TempSaleCollection= new SaleCollection();
		if($UnitCollection->getCount()==0)	{return $TempSaleCollection;}
		$SaleFinder= new SaleFinder();
		$SaleCollection= $SaleFinder->findAllShipSaleByUser($User->getId());
		foreach($this->Elements as $Element)
		{
			
			foreach ($SaleCollection as $Sale)
			{
				if($Element->getId() == $Sale->getUnit()->getId())
				{
					$TempSaleCollection->add($Sale);
					//$TempArray[]= $Sale;
					continue;
				}
			}
		}
		return $TempSaleCollection;
 	}
	
	public function deleteUnit(Unit $Unit)
	{
		$TempArray=array();
		foreach($this->Elements as $Element)
		{
			if($Unit->getId()!=$Element->getId())
			{
				$TempArray[]= $Element;
			}
		}
		$this->Elements=$TempArray;
	}
	
	
	/**
	 * gibt ein array mit den IDs der verschidenen Allianzen zurück das array kann auch leer sein  wenn mehrere spieler ohne allianz sind können [0]=0,[1]=0 einträge vorkommen
	 * gibt zufällige negatife allianzIDs zurück wenn der User keine allianz hat 
	 *
	 * @return array 
	 *
	 */
	public function getDifferentAllianz()
	{
		$TempArray=array();
		foreach($this->Elements as $Element)
		{
			if(!$Element->getUser()->hasAllianz())
			{
				$TempArray[]=(mt_rand(1,100000)*-1);
				continue;
			}
			if(!in_array($Element->getUser()->getAllianzId(),$TempArray))
			{
				$TempArray[]= $Element->getUser()->getAllianzId();
			}
		}
		return $TempArray;
	}
	
	
	/**
	 * erstezt das alte element mit dem neuen element. Es wird nur der zuerst gefundene element überschrieben
	 *
	 * @param Unit $Element 
	 * @return bool im erfolgsfall true sonst false wenn element nicht gefunden
	 *
	 */
	public function rePlaceElementById($Element)
	{
		for($i=0;$i<count($this->Elements);$i++)
		{	
			$MyElement=$this->getByIndex($i);
			if($MyElement->getId()==$Element->getId())
			{
				$this->Elements[$i]=$Element;
				return true;
			}
		}
		return $TempArray;
	}
	
	
	public function getDifferentPlayer()
	{
		$TempArray=array();
		foreach($this->Elements as $Element)
		{
			if(!in_array($Element->getUserId(),$TempArray))
			{
				$TempArray[]= $Element->getUserId();
			}
		}
		return $TempArray;
	}
	
	 
	public function getLifedUnits()
	{
		$TempCollection= new UnitCollection();
		foreach($this->Elements as $Element)
		{
			if($Element->getState()>0)
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
	
	
	/**
	 * gibt die einheiten zurück die ausßerhalt des bereichs sind der bereich wir mit 40 px um die angegeben Koordinaten gesetzt
	 *
	 * @param int $X 
	 * @param int $Y 
	 * @return UnitCollection 
	 *
	 */
	public function getUnitsOut($X,$Y)
	{
		$TempCollection= new UnitCollection();
		foreach($this->Elements as $Element)   // eval muss noch geprüft werden
		{
			$C=	sqrt(pow($X-$Element->getX(),2)+pow($Y-$Element->getY(),2));
			if($C>40)
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
	
	
	/**
	 * gibt alle einheiten zurück die kolonisieren können
	 *
	 * @return UnitCollection
	 *
	 */
	public function getAllWithKoloTool()
	{
		$TempCollection= new UnitCollection();
		foreach($this->Elements as $Element)   // eval muss noch geprüft werden
		{
			
			if($Element->getExtentionTow()==17)
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
	
	
	/**
	 * gibt alle einheiten die die unsichtbar sind
	 *
	 * @return UnitCollection 
	 *
	 */
	public function getAllWithStealhs()
	{
		$TempCollection= new UnitCollection();
		foreach($this->Elements as $Element)   // eval muss noch geprüft werden
		{
			
			if($Element->getExtentionTow()==14)
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
	
	public function getAllWithScanner()
	{
		$TempCollection= new UnitCollection();
		foreach($this->Elements as $Element)   // eval muss noch geprüft werden
		{
			
			if($Element->getExtentionOne()==10)
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
		
	/**
	 * gitb eine Collection zurück
	 *
	 * @param int $UserId die Id des users die zurück gegeben werden soll
	 * @return UnitCollection 
	 *
	 */
	public function getByUserId($UserId)
	{
		$TempUnitCollection= new UnitCollection();
		foreach($this->Elements as $Element)
		{
			if($Element->getUserId()==$UserId)
			{
				$TempUnitCollection->add($Element);
			}
		}
		return $TempUnitCollection;
	}
	
	
	/**
	 * gibt alle einheiten zurück die den status kleiner 0 erreicht haben
	 *
	 * @return UnitCollection 
	 *
	 */
	public function getDestroyedUnits()
	{
		$TempUnitCollection= new UnitCollection();
		foreach($this->Elements as $Element)
		{
			if($Element->getState()<=0)
			{
				$TempUnitCollection->add($Element);
			}
		}
		return $TempUnitCollection;
	}
	
	public function getHealts()
	{
		$TempHealts=0;
		foreach($this->Elements as $Element)
		{
			$TempHealts+=$Element->getHealts();
		}
		return $TempHealts;
	}
	
	
	public function getAmor()
	{
		$TempAmor=0;
		foreach($this->Elements as $Element)
		{
			$TempAmor+=$Element->getAmor();
		}
		return $TempAmor;
	}
	
	public function getDMG()
	{
		$TempDMG=0;
		foreach($this->Elements as $Element)
		{
			$TempDMG+=$Element->getDMG();
		}
		return $TempDMG;
	}
	
	/**
	 * gibt das schiff mit der id zurück wenn vorhanden wenn nicht gibts ein null objekt
	 *
	 * @param int $Id 
	 * @return Unit 
	 *
	 */
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		return Unit::getEmptyInstance();
		
	}
	
	public function getByAllianzId($AllianzId)
	{
		$TempCollection= new UnitCollection();
		foreach($this->Elements as $Element)
		{
			if($Element->getUser()->getAllianzId()==$AllianzId)
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
		
	}
	
	
	public function getJs($User)
	{
		$TempTIme=time();
		$TempJs="
		var MyUnitCollection= new UnitCollection();
		";

		$TempJs.=" MyUnitCollection.clear();
		";
		
		foreach ($this->Elements as $Element)
		{
			$TempJs.='var MyUnit'.$Element->getId().'= new ';
			
			switch($Element->getHighesUnit())
			{
				 case "bds":
				 {
						$TempJs.='DeathStar';
				}
				break;
				case "ds":
				{
						$TempJs.='DeathStar';
				}break;
				
				default:	
				$TempJs.='Unit';
				
			}
			$TempJs.='('.$Element->getId().',"'.$Element->getName().'","'.$Element->getUnits().'",'.$Element->getDMG().','.$Element->getAmor().','.$Element->getSpeed().','.$Element->getHealts().', '.$Element->getUserId().','.$Element->getExtentionOne().','.$Element->getExtentionTow().','.$Element->getX().','.$Element->getY().',"'.$Element->getState().'",'.$Element->getStorage().',"'.$Element->getStored().'",'.$Element->getExperience().','.$Element->getLevel().',';
			
			if($Element->getUserId()==$User->getId())
			{
				$TempJs.='true,
				';
				
			}else
			{
				$TempJs.='false,
				';	
			}
			$TempJs.='"'.$Element->getUser()->getName().'",';
			
			if($Element->getUser()->hasAllianz() && $User->hasAllianz())
			{
				if($Element->getUser()->getAllianzId()==$User->getAllianzId())
				{
					$TempJs.='true';
				}else
				{
					$TempJs.='false';
				}
			}else
			{
				$TempJs.='false';
			}
			
			$TempJs.=',"'.$Element->getPicture().'","'.$Element->getUser()->getAllianzName().'","'.$Element->getUser()->getPictureString().'");';
			//$TempJS.=",'".$Element->getUser()->getPictureString()."');";
			
			
			
			
			
			$TempJs.='MyUnitCollection.add(MyUnit'.$Element->getId().');
			';
		}
		
		$TempJs.='
		';
		return $TempJs;
	}
	
	 
	/**
	 * gickt nach ob die einheiten von verschiedenen spielern sind
	 *
	 * @return bool true wenn einheiten von mindesten 2 verschiednen spielern sind
	 *
	 */
	public function areUnitsFormDifferentPlayer()
	{
		if($this->getCount()==0){return false;}
		$State=$this->Elements[0]->getUserId();
		 foreach($this->Elements as $Unit)
		{	
				if($State!=$Unit->getUserId())
			{
				return true;
			}
		}
		return false;	
	}
	
	
	/**
	 * prüft ob die einheiten von verschiedenen allianzen kommen
	 *
	 * @return bool gibt true zurück wenn verschiedenen allianzen vorhanden sind
	 *
	 */
	public function areUnitsFormDifferentAllianz()
	{
		$State=false;
		//$this->Elements[0]->getUser()->getAllianzId();
		foreach($this->Elements as $Unit)
		{	
			for($i=1;$i<$this->getCount();$i++)
			{
				$UnitTemp=$this->Elements[$i];
				if($UnitTemp->getUser()->hasAllianz() && $Unit->getUser()->hasAllianz())
				{
					if($UnitTemp->getUser()->getAllianzId()!=$Unit->getUser()->getAllianzId())
					{
						$State=true;
						return $State;
					}			
				}else
				{
					$State=true;// eine oder beide haben keine alli
					return $State;
				}
			}
		}
		return $State;	
	}
	
	/**
	 * guckt nach ob alle einheiten einer allianz angehören wenn ja wird true zurück gegeben
	 *
	 * @return bool wenn einheiten von verschiedenen allianzen drinn sind dann wird false zurük gegeben
	 *
	 */
	public function isSameAllianz()
	{
	   $AllianzId=$this->Elements[0]->getUser()->getAllianzId();
		foreach($this->Elements as $Unit)
		{	
			if($AllianzId != $Unit->getUser()->getAllianzId())
			{
				 return false;
			}
		}
		return true;
	}  
	  /**
	   * gibt den durchschnittlichen x wert der einheiten zurück
	   *
	   * @return int 
	   *
	   */
	public function getAverageX()
	{
		if($this->ElementCounter<=0){return 0;}
		$Counter=0;
		foreach($this->Elements as $Unit)
		{	
			$Counter+=   $Unit->getX();
		}
		return (int) $Counter/$this->ElementCounter;
	}
	
	/**
	* gibt den durchschnittlichen Y wert der einheiten zurück
		   *
	* @return int 
		   *
	*/
	public function getAverageY()
	{
		if($this->ElementCounter<=0){return 0;}
		$Counter=0;
		foreach($this->Elements as $Unit)
		{	
			$Counter+= $Unit->getY();
		}
		return (int) $Counter/$this->ElementCounter;
	}
	
	
	public function getEnemyUnits(Unit $Unit)
	{
		$Count=0;
		foreach($this->Elements as $MyUnit)
		{	
			if($Unit->getId()==$MyUnit->getId())
			{
				continue;	
			}
			
			if($MyUnit->getUser()->hasAllianz() && $Unit->getUser()->hasAllianz())
			{
				if($MyUnit->getUser()->getAllianzId()!=$Unit->getUser()->getAllianzId())
				{
					$Count++;
				}
			}else
			{
				$Count++;
			}
		}
		return $Count;
	}	
	
	 /**
	  * setzt allen einheiten den dmg der übergebenen einheit
	  *
	  * @param UnitCollection $Unit 
	  * @return bool gibt imma true
	  *
	  */
	public function setDMG(Unit $Unit,$LastRefresh)
	{
		$EnemyUnitCount=$this->getEnemyUnits($Unit);   // anzahl gegnerischer einheiten holen
		$DMG= ($Unit->getDMG()/60/60)*(microtime(true)-$LastRefresh)/$EnemyUnitCount; // dmg der einheiten auf alle anderen einheiten berechnen
		foreach($this->Elements as $Element)
		{
			if($Element->getUserId()==$Unit->getUserId())   // wenn gleicher spieler oder gleiche allianz
			{
				continue;	
			}
			
			if($Element->getUser()->hasAllianz() && $Unit->getUser()->hasAllianz())   // ob allianz vorliegt bei beiden
			{
				if($Element->getUser()->getAllianzId()==$Unit->getUser()->getAllianzId())// wenn gleiche alli ann gibts für diese einheit keinen schaden
				{
					continue;
				}	
			}
			$Laser=0;
			$Partikel=0;
			$Torpedos=0;
			switch($Unit->getExtentionOne())
			{
				case 7:
				{
					$Laser=1;
				}break;
				case 8:
				{
					$Partikel=1;
				}break;
				case 9:
				{
					$Torpedos=1;
				}break;
			}
			$DMGTemp=$Element->calculateDMG($DMG,$Laser,$Partikel,$Torpedos);
			$this->setState($Unit);
			if($DMG>0  && $Element->getHealts() >0)
			{
				$State=	$DMGTemp/$Element->getHealts();
				
				$this->setStateByElement($Element,$Element->getState()-$State);
			}else
			{
				$this->setStateByElement($Element,0);
			}
			
		}
	}
	
	public function setState(Unit $Unit)
	{
		$Percentage = mt_rand(1,100);
		if ($Percentage < 10)
		{
			$Statefinder = new StateFinder();
			$StateCollection = $Statefinder->findbyUnitId($Unit->getId());
			if($StateCollection->countElements() == 0)
			{
				switch ($Percentage)
				{
					case 1: //schlechte states
					{
						$State = new StateLowDamage(7,"wpndmg",time()+ STATE_WEAPONDAMAGE,"","");
						$StateManager = new StateManager();
						$StateManager->insertStateToUnit($State, $Unit);
					}break;
					case 2:
					{
						$State = new StateSlowed(3,"engineerror",time()+ STATE_ENGINGEDAMAGETIME,"","");
						$StateManager = new StateManager();
						$StateManager->insertStateToUnit($State, $Unit);
					}break;
					case 3:
					{
						$State = new StateHullDamage(9,"hulldmg",time()+ STATE_HULLDAMAGE,"","");
						$StateManager = new StateManager();
						$StateManager->insertStateToUnit($State, $Unit);
					}break;
					case 4: // gute states
					{
						$State = new StateOverload(8,"overload",time()+ STATE_OVERLOAD,"","");
						$StateManager = new StateManager();
						$StateManager->insertStateToUnit($State, $Unit);
					}break;
					case 5:
					{
						$State = new StateSpeedy(4,"timepressure",time()+ STATE_SPEEDY,"","");
						$StateManager = new StateManager();
						$StateManager->insertStateToUnit($State, $Unit);
					}break;
					case 6:
					{
						$State = new StateArmoured(2,"defense",time()+ STATE_ARMOR,"","");
						$StateManager = new StateManager();
						$StateManager->insertStateToUnit($State, $Unit);
					}break;
					case 7: // richtig fies 1% chance, reparieren muss man dann
					{	
						$BadStuff = mt_rand(1,3);
						switch ($BadStuff)
						{
							case 1:
							{
								$State = new StateFallout(5,"fallout",0,"","");
								$StateManager = new StateManager();
								$StateManager->insertStateToUnit($State, $Unit);
							}break;
							case 2:
							{
								$State = new StateHullBreak(15,"defense",0,"","");
								$StateManager = new StateManager();
								$StateManager->insertStateToUnit($State, $Unit);
							}break;
							case 3:
							{
								$State = new StateNoArmor(19,"defense",0,"","");
								$StateManager = new StateManager();
								$StateManager->insertStateToUnit($State, $Unit);
							}break;
						}
						
					}break;
					case 8:
					{
						switch($Unit->getExtentionOne())
						{
							case 7:
							{
								$State = new StateLaserOffline(17,"laser",time()+ STATE_LASER,"","");
								$StateManager = new StateManager();
								$StateManager->insertStateToUnit($State, $Unit);
							}break;
							case 8:
							{
								$State = new StateParticleOffline(18,"parti",time()+ STATE_PARTI,"","");
								$StateManager = new StateManager();
								$StateManager->insertStateToUnit($State, $Unit);
							}break;
							case 9:
							{
								$State = new StateNoTorpedo(22,"torp",time()+ STATE_TORPE,"","");
								$StateManager = new StateManager();
								$StateManager->insertStateToUnit($State, $Unit);
							}break;
						} 
					}break;
					case 9:
					{
						switch($Unit->getExtentionOne())
						{
							case 7:
							{
								$State = new StateLaserOffline(17,"laser",0,"","");
								$StateManager = new StateManager();
								$StateManager->insertStateToUnit($State, $Unit);
							}break;
							case 8:
							{
								$State = new StateParticleOffline(18,"parti",0,"","");
								$StateManager = new StateManager();
								$StateManager->insertStateToUnit($State, $Unit);
							}break;
							case 9:
							{
								$State = new StateNoTorpedo(22,"torp",0,"","");
								$StateManager = new StateManager();
								$StateManager->insertStateToUnit($State, $Unit);
							}break;
						}
					}break;
				}
			}
		}
		return true;
	}
	
	public function setExpByElement($Element,$Exp)
	{
		for($i=0;$i<count($this->Elements);$i++)
		{	
			$MyElement=$this->getByIndex($i);
			if($MyElement->getId()==$Element->getId())
			{
				$this->Elements[$i]->addExperience($Exp);
				return true;
			}
		}
		return false;
	}
	
	public function setStateByElement($Element,$State)
	{
		for($i=0;$i<count($this->Elements);$i++)
		{	
			$MyElement=$this->getByIndex($i);
			if($MyElement->getId()==$Element->getId())
			{
				$this->Elements[$i]->setState($State);
				return true;
			}
		}
		return false;
	}
	
	
	
	/**
	 * This is method setEXP
	 *
	 * @param Unit $Unit This is a description
	 * @return UserCollection gibt ein array zurück mit den IDs der benutzer die Erfahrung gutgeschrieben bekommen müssen
	 *
	 */
	public function setEXP(Unit $Unit)
	{
		$EXP=$Unit->getHealts(true);
		$UserCollection= new UserCollection();
		$UserArray= array();
		
		foreach($this->Elements as $Element)
		{
			if($Element->getUserId()==$Unit->getUserId())   // wenn gleicher spieler oder gleiche allianz
			{
				continue;	
			}
			
			if($Element->getUser()->hasAllianz()  && $Unit->getUser()->hasAllianz())
			{
				if($Element->getUser()->getAllianzId()==$Unit->getUser()->getAllianzId())
				{
					continue;
				}	
			}
			//WENN KEIN TODESSTERN im bau
			if(!$Unit->getIsDeathStarInBuild())
			{
				$this->setExpByElement($Element,$EXP);	// exp auf das element setzen	
			}
			
			if($UserCollection->getById($Element->getUser()->getId())->getId()==0)
			{
				$UserCollection->add($Element->getUser());
			}
		}
		return $UserCollection;
	}
	
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0 || empty($this->Elements[$Index]) )
			return Unit::getEmptyInstance();
		
		return $this->Elements[$Index];
		
		
	}
	
	
	
}


?>