<?php



class ShipBuildCollection extends Collection 
{
	public function add(ShipBuild $Element)
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
	 * @return Ship 
	 *
	 */
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		new ShipBuild(0,0,new Ship(0,"",0,0,0,0,0,0,0,0,0,0),0,0,0);
	}
	
	
	
	
}


?>