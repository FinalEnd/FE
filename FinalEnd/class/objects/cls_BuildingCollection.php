<?php

class BuildingCollection extends Collection 
{
	
	public function add(Building $Element)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
		$this->ElementCounter++;
	}
	
	
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		return Building::getEmptyInstance();
	}
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
		{
			return Building::getEmptyInstance();
		}
		return $this->Elements[$Index];
	}
	
	
	
	public function getByResource($Resource)
	{
		$BuildingCollection= new BuildingCollection();
		foreach($this->Elements as $Element)
		{
			if($Element->getResource()==$Resource)
			{
				return $Element;
			}	
		}
		return Building::getEmptyInstance();
	}
	
	
	/**
	 * rechnet die kompletten level der gebäude die sich in_array dieser Collection befinden zusammen
	 *
	 * @return înt das gesamt level der gebäude
	 *
	 */
	public function getLevel()
	{
		$TempCount=0;
		foreach($this->Elements as $Element)
		{
			$TempCount+=$Element->getLevel();
		}
		return $TempCount;
	}
	
	/**
	 * gibt an hand des typs das gebäude zurück
	 *
	 * @param int $i_Type 1-22
	 * @return Building kann ein Noll Building sein
	 *
	 */
	public function getByTypeId($i_Type)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getType()==$i_Type)
			{
				return $Element;
			}
		}
		return Building::getEmptyInstance();
	}
	
	/**
	 * löscht leere daten sätze aus der collection
	 *
	 * @return void 
	 *
	 */
	public function deleteNull()
	{
		$BuildingCollection= new BuildingCollection();
		foreach($this->Elements as $Element)
		{
			if($Element->getId()!=0)
			{
				$BuildingCollection->add($Element);
			}	
		}
		$this->Elements=$BuildingCollection->getAll();
		$this->ElementCounter=$BuildingCollection->getCount();
	}
	
	
	public function countInbuild()
	{
		$Count=0;
		foreach($this->Elements as $Element)
		{
			if($Element->getInbuild())
			{
				$Count++;
			}	
		}
		return $Count;
	}
	
	/**
	* setzt in % wie viel schneller das gebäude gebat wird
	*
	* @param float $Percent 0.20 = 20%
	* @return void 
	*
	*/
	public function setBuildFaster($Percent)
	{
		foreach($this->Elements as $Element)
		{
			$Element->setPerCentFaster($Percent);
		}
	}
	 
	/**
	 * entfernt die gebäude die das maximal level erreicht haben
	 *
	 * @return void 
	 *
	 */
	public function deleteMaxLevel()
	{
		$BuildingCollection= new BuildingCollection();
		foreach($this->Elements as $Element)
		{
			if($Element->getMaxLevel()>$Element->getLevel())
			{
				$BuildingCollection->add($Element);
			}	
		}
		$this->Elements=$BuildingCollection->getAll();
		$this->ElementCounter=$BuildingCollection->getCount();
	}
	
										
	/**
	 * zählt die level aller gebäude zusammen
	 *
	 * @return int 
	 *
	 */
	public function countBuildingLevels()
	{
		$Count=0;
		foreach($this->Elements as $Element)
		{
			$Count+=  $Element->getLevel();
		}
		return $Count;
	}
	
}


?>