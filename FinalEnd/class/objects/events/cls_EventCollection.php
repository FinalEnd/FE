<?php



class EventCollection extends Collection 
{
	public function add(SystemEvent $Element)
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
		return SystemEvent::getEmptyInstance();	
	}
	
	public function setUserLevel($UserLevel)
	{
		for($i=0;$i<$this->getCount();$i++)
		{
			$this->Elements[$i]->setUserLevel($UserLevel);
		}
		return true;	
	}
	
	

	
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
		{
			return SystemEvent::getEmptyInstance();
		}
		return $this->Elements[$Index];
	}
	
	
}


?>