<?php

class Planet implements i_CollectionElement
{
	private $Id;
	private $Name;
	private $User;
	private $Size;
	private $Weight;
	private $Type;
	private $Picture;
	private $RefreshTime;
	private $Metal;
	private $Hydrogen;
	private $Biomass;
	private $Crystal;
	private $X;
	private $Y;
	private $BuildingCollection;
	private $ShipCollection;
	private $ReSearchCollection;
	private	$PeopleCount;
	private	$Satisfaction;	// zu friedenheit der einwohner
	private	$Tax;   // steuerrate 
	private $ShipBuildCount;
		
	public function __construct($Id,$Name,User $User,$Size,$Weight,$Type,$Picture,$RefreshTime,$Metal,$Hydrogen,$Biomass,$Crystal,$X,$Y,$BuildingCollection,
		$ShipCollection,$ReSearchCollection,$PeopleCount,$Satisfaction,$Tax)
	{
		$this->Id=$Id;
		$this->Name=$Name;
		$this->User=$User;
		$this->Size=$Size;
		$this->Weight=$Weight;
		$this->Type=$Type;
		$this->Picture=$Picture;
		$this->RefreshTime=$RefreshTime;
		$this->Metal=$Metal;
		$this->Hydrogen=$Hydrogen;
		$this->Biomass=$Biomass;
		$this->Crystal=$Crystal;
		$this->Y=$Y;
		$this->X=$X;
		$this->BuildingCollection=$BuildingCollection;
		$this->ShipCollection= $ShipCollection;
		$this->ReSearchCollection= $ReSearchCollection;
		$this->PeopleCount=$PeopleCount;
		$this->Satisfaction= $Satisfaction;
		$this->Tax= $Tax;
		$this->ShipBuildCount=0;
		
	}
	
	
	public function setShipBuildCount($ShipBuildCount)
	{
		$this->ShipBuildCount=$ShipBuildCount;
	}
	public function getShipBuildCount()
	{
		return $this->ShipBuildCount;
	}
	
	/**
	 * gibt die anzahl der gebäude zurück die sich im bau befinden
	 *
	 * @return int 
	 * 
	 */
	public function getBuildingsInBuild()
	{
		return $this->BuildingCollection->countInbuild();
	}
	
	
	/**
	 * gibt die maximal anzahl der gleich zeitig gebauten gebäude zurück
	 *
	 * @return int 
	 *
	 */
	public function getMaxBuildingsInBuild()
	{
		if($this->BuildingCollection->getByTypeId(1)->getLevel()>=5)
		{
			return 3;
		}
		return 2;
	}
	
	public function isReSearchInBuild()
	{
		return $this->ReSearchCollection->isReSearchInBuild();	
	}


/**
 * gibt die angegebene Ressource zurück
 *
	 * @param string $RessourceType m= metall; t=deuterium, b= Lebbensmittel; c= Kristall 
 * @return int 
 *
 */
public function getResource($RessourceType)
{
		switch($RessourceType)
		{
			case"m":
			{
				return $this->Metal;
			}break;	
			
			case"t":
			{
				return $this->Hydrogen;
			}break;
			case"d":
			{
				return $this->Hydrogen;
			}break;
			
			case"c":
			{
				return $this->Crystal;
			}break;
			case"b":
			{
				return $this->Biomass;
			}break;
		}
}
	
	/**
	 * addiert die anfgegebene count mit dem auf dem planeten vorhandenen
	 * 
	 * */
	public function setResource($RessourceType,$Count)
	{
		switch($RessourceType)
		{
			case"m":
			{
				$this->Metal+=$Count;
			}break;	
			case"t":
			{
				$this->Hydrogen+=$Count;
			}break;
			case"c":
			{
				$this->Crystal+=$Count;
			}break;
			case"b":
			{
				$this->Biomass+=$Count;
			}break;
		}
	}
	
	
	/**
	 * gibt den lebensmittelverbrauch des Planeten pro stunde der momentanen bevölkerung zurück, dieser wert wird gerundet und +1 gerechnet
	 *
	 * @return int kannnicht kleiner 0 sein
	 *
	 */
	public function getBioMassConsumtion()
	{
		$Town=$this->BuildingCollection->getByTypeId(22);
		//$People=$Town->getPeople();
		//$Constumtion=  $People * PEOPLE_FOOD_PER_HOUR;
		//$Constumtion=POEPLE_CONSUMTION_A * $Town->getLevel() + POEPLE_CONSUMTION_B;
		if($this->PeopleCount==0){return 0;}
		$TownLevel=(log($this->PeopleCount/PEOPLE_MAX_STORE_PRE)/log(PEOPLE_MAX_STORE_SUF));
		$Constumtion=POEPLE_CONSUMTION_A * $TownLevel + POEPLE_CONSUMTION_B;
		// den wert runden
		//$RoundError=$this->getBioMassConsumtionMax();
		
		$Constumtion=$Constumtion/10;
		$Constumtion=round($Constumtion);
		$Constumtion=$Constumtion*10;
		
		if($Constumtion<0){return 0;}
		return (int) $Constumtion;
	}
	
	
	
	/**
	 * gibt den maximal verbrauch des Planeten zurück
	 *
	 * @return string 
	 *
	 */
	public function getBioMassConsumtionMax()
	{
		$Town=$this->BuildingCollection->getByTypeId(22);
		//$People=$Town->getPeople();
		//$Constumtion=  $People * PEOPLE_FOOD_PER_HOUR;
		$Constumtion=POEPLE_CONSUMTION_A * $Town->getLevel() + POEPLE_CONSUMTION_B;
		// den wert runden
		$Constumtion=$Constumtion/10;
		$Constumtion=round($Constumtion);
		$Constumtion=$Constumtion*10;	
		if($this->getBioMassConsumtion()>$Constumtion)  {return $this->getBioMassConsumtion();}// wenn die rundungs fehler zu groß werden dann das maximale nehmen
		return (int) $Constumtion;
	}
	
	public function setTax($Tax)
	{
		$this->TaxTax=$Tax;
	}
	/**
	*   getter Tax die steuerrate
	*
	* return string
	*/
	public function getTax()
	{
			return $this->TaxTax;
	}
	/**
	*   getter 0die zufriedenheit der bevölkerung	
	*
	* return string
	*/
	public function getSatisfaction()
	{
	  return $this->Satisfaction;
	}
	
	public function setSatisfaction($Satisfaction)
	{
		$this->Satisfaction=$Satisfaction;
	}
	
	public function getPeopleCount($Parsed=false)
	{
		if($Parsed)
		{
			return (int) $this->PeopleCount;	
		}
		return $this->PeopleCount;
	}
	
	
	/**
	 * gibt die anzahl formatiert zurück
	 *
	 * @param bool $Parsed 
	 * @return string 
	 *
	 */
	public function getPeopleCountFormated()
	{
		if($this->PeopleCount<0)
		{
			return number_format(0,0,",",".");
		}
		return number_format($this->PeopleCount,0,",",".");
	}
	/**
	 * gibt die anzahl der Bevölkerung abgekürzt zurück
	 *
	 * @return string 
	 *
	 */
	public function getPeopleCountAsString()
	{
		if($this->PeopleCount<0)
		{
			return 0;
		}
		
		if($this->PeopleCount>=1000000)// mio.
		{
			$Temp= round(($this->PeopleCount/1000000),1)." mio.";
			return $Temp; 	
		}
		return number_format($this->PeopleCount,0,",",".");
	}
	
	/**
	 * gibt die Credits zurück die innerhalb einer Stunde generiert werden
	 *
	 * @param bool $Parsed gerundet oder nicht
	 * @return float 
	 *
	 */
	public function getCreditsPerHour($Parsed=false)
	{
		$TownLevel=(log($this->PeopleCount/PEOPLE_MAX_STORE_PRE)/log(PEOPLE_MAX_STORE_SUF));
		$Credits=CREDITS_PRE * $TownLevel*$TownLevel + CREDITS_SUF*$TownLevel;
		if($Credits <0)
		{
			return 0;
		}
		if($Parsed)
		{
			return (int) $Credits;	
		}
		return $Credits;
	}
	
	public function setPeopleCount($PeopleCount)
	{
		if($this->PeopleCount+$PeopleCount <0)
		{
			$this->PeopleCount=0;
		}
		$this->PeopleCount=$PeopleCount;
	}
	
	public function getReSearchCollection()
	{
		return $this->ReSearchCollection;
	}
	
	
	public static function getEmptyInstance()
	{
		return new Planet(0,"",User::getEmptyInstance(),0,0,0,"",0,0,0,0,0,0,0,new BuildingCollection(),new ShipCollection(),new ReSearchCollection(),0,0,0);
	}
	
	
	public function getShipCollection()
	{
		return $this->ShipCollection;
	}
	
	public function setRefreshTime($RefreshTime)
	{
		$this->RefreshTime=$RefreshTime;
	}
	
	/**
	 * gibt das level des lagers zurück
	 *
	 * @return int 1-26
	 *
	 */
	public function getStorLevel()
	{
		$Store=$this->BuildingCollection->getByTypeId(18);
		return ($Store->getLevel()+1);
	}
	
	
	/**
	 * gibt an wieviel der ressource noch auf dem planeten gespeichert werden kann
	 *
	 * @param String $Ressource This is a description
	 * @return Float This is the return value description
	 *
	 */
	public function getFreeStoredSpace($Ressource)
	{
		return (int) ($this->getStorLevel()*RESOURCE_PER_LEVEL-$this->getResource($Ressource));
	}
	
	
	public function setName($Name)
	{
		$this->Name=$Name;
	}
	
	public function setMetal($Metal)
	{
		$this->Metal=$Metal;
	}
	
	public function setHydrogen($Hydrogen)
	{
		$this->Hydrogen=$Hydrogen;
	}
	
	public function setBiomass($Biomass)
	{
		$this->Biomass=$Biomass;
	}
	
	public function setCrystal($Crystal)
	{
		$this->Crystal=$Crystal;
	}
	
	
	public function getBuildingCollection()
	{
		return $this->BuildingCollection;
	}
	
	public function getBuildingByType($Type)
	{   
		return $this->BuildingCollection->getByTypeId($Type);
	}
	

	public function setBuildingCollection($BuildingCollection)
	{
		$this->BuildingCollection=$BuildingCollection;
	}
	
	public function setUser($User)
	{
		$this->User=$User;
	}
	
	public function setX($X)
	{
		$this->X=$X;
	}
	
	public function setY($Y)
	{
		$this->Y=$Y;
	}
	
	public function setPicture($Picture)
	{
		$this->Picture=$Picture;
	}
	
	public function setSize($Size)
	{
		$this->Size=$Size;
	}
	
	public function setWeight($Weight)
	{
		$this->Weight=$Weight;
	}
	
	public function getWeight()
	{
		return $this->Weight;
	}
	
	public function getY()
	{
		return $this->Y;
	}
	
	public function getX()
	{
		return $this->X;
	}
	
	
	public function getCrystal($Parsed=false)
	{
		if($Parsed)
		{
			return (int) $this->Crystal;	
		}
		return $this->Crystal;
	}
	
	public function getCrystalFormated()
	{
		if(!$this->Crystal){return 0;}
		return number_format($this->Crystal,0,",",".");
	}
	
	public function getBiomass($Parsed=false)
	{
		if($Parsed)
		{
			return (int) $this->Biomass;	
		}
		return $this->Biomass;
	}
	
	public function getBiomassFormated()
	{
		if(!$this->Biomass){return 0;}
		return number_format($this->Biomass,0,",",".");
	}
	
	public function getHydrogen($Parsed=false)
	{
		if($Parsed)
		{
			return (int) $this->Hydrogen;	
		}
		return $this->Hydrogen;
	}
	
	public function getHydrogenFormated()
	{
		if(!$this->Hydrogen){return 0;}
		return number_format($this->Hydrogen,0,",",".");
	}
	
	public function getMetal($Parsed=false)
	{
		if($Parsed)
		{
			return (int) $this->Metal;	
		}
		return $this->Metal;
	}
	
	
	public function getMetalFormated()
	{
		if(!$this->Metal){return 0;}
		return number_format($this->Metal,0,",",".");
	}
	
	public function getRefreshTime()
	{
		return $this->RefreshTime;
	}

	public function getPicture()
	{
		return $this->Picture;
	}
	
	public function getType()
	{
		return $this->Type;
	}
	
	public function getSize()
	{
		return $this->Size;
	}

	public function getUser()
	{
		return $this->User;
	}
	
	public function getName()
	{
		return $this->Name;
	}
	
	public function getId()
	{
		return $this->Id;
	}
	
}




?>