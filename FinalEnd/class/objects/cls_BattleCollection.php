<?php



class BattleCollection extends Collection 
{
	public function add(Battle $Element)
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
	 * @return Battle 
	 *
	 */
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		new Battle(0,"",new UnitCollection(),0,0);
		
	}
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
		{
			return new Battle(0,"",new UnitCollection(),0,0);
		}
		return $this->Elements[$Index];
	}
	
	
}


?>