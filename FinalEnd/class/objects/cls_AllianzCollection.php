<?php



class AllianzCollection extends Collection 
{
	public function add(Allianz $Element)
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
		return Allianz::getEmptyInstance();
	}
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
		{
			return Allianz::getEmptyInstance();
		}
		return $this->Elements[$Index];
	}
	
	
}


?>