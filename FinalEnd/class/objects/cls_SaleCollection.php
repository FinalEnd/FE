<?php



class SaleCollection extends Collection 
{
	public function add(Sale $Element)
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
	 * @return Sale 
	 *
	 */
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		return Sale::getEmptyInstance();	
	}
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
		{
			return Sale::getEmptyInstance();
		}
		return $this->Elements[$Index];
	}
	
	
}


?>