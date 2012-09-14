<?php

class ReSearchCollection extends Collection 
{
	
	public function add(ReSearch $Element)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
		$this->ElementCounter++;
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
	
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		return ReSearch::getEmptyInstance();
	}
	
	public function getByReSearchId($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getReSearchId()==$Id)
				return $Element;
		}
		return ReSearch::getEmptyInstance();
	}
	
	
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
			return ReSearch::getEmptyInstance();
		return $this->Elements[$Index];
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
	 * @param int $i_Type 1-20
	 * @return Building kann ein Null Building sein
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
		return ReSearch::getEmptyInstance();
	}
	
	public function deleteMaxLevel()
	{
		$ReSearchCollection= new ReSearchCollection();
		foreach($this->Elements as $Element)
		{
			if($Element->getMaxLevel()>$Element->getLevel())
			{
				$ReSearchCollection->add($Element);
			}	
		}
		$this->Elements=$ReSearchCollection->getAll();
		$this->ElementCounter=$ReSearchCollection->getCount();
	}
	
	
	/**
	 * guckt ob eine Forschung geforsch wird und gibt bool zurück
	 *
	 * @return bool 
	 *
	 */
	public function isReSearchInBuild()
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getInbuild())
			{
				return 1;
			}	
		}
		return 0;
		
	}
	
	
}


?>