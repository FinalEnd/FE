<?php

class RoutePointCollection extends Collection 
{
	
	public function add(RoutePoint $Element)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
		$this->ElementCounter++;
	}
	
	public function getByOrder($Order)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getOrder()==$Order)
				return $Element;
		}
		return RoutePoint::getEmptyInstance();
	}
	
	
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		return RoutePoint::getEmptyInstance();
	}
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
			return RoutePoint::getEmptyInstance();
		return $this->Elements[$Index];
	}
	

}


?>