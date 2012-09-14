<?php



class AllianzRankCollection extends Collection 
{
	public function add(AllianzRank $Element)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
		$this->ElementCounter++;
	}
	
	
	/**
	 * gibt das schiff mit der id zurück wenn vorhanden wenn nicht gibts ein null objekt
	 *
	 * @param int $Id 
	 * @return Allianz	 
	 *
	 */
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		return AllianzRank::getEmptyInstance();
	}
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
		{
			return AllianzRank::getEmptyInstance();
		}
		return $this->Elements[$Index];
	}
	
	
}


?>