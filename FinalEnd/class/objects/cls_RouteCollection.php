<?php

class RouteCollection extends Collection 
{
	
	public function add(Route $Element)
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
		return Route::getEmptyInstance();
	}
	
	public function getByUnit(Unit $Unit)
	{
		foreach($this->Elements as $Element)
		{
			if(!$Element->getUnit()){return Route::getEmptyInstance();}
			if($Element->getUnit()->getId()==$Unit->getId())
				return $Element;
		}
		return Route::getEmptyInstance();
	}
	
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
			return Route::getEmptyInstance();
		return $this->Elements[$Index];
	}
	

}


?>