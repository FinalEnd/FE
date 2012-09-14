<?php

class Route implements i_CollectionElement 
{
	private $Id;
	private $Name;
	private $Unit;
	private $User; // der User der die Route erstellt hat
	private $CurrentCnt;
	private $RoutePointCollection;
	private $UnitsOnRoute;
	private $Loop;
	
	public function __construct($Id,$Name,$Unit,$User,$RoutePointCollection,$UnitsOnRoute=0,$CurrentCnt=0,$Loop=0) 
	{
		$this->Id=$Id;
		$this->Name=$Name;
		$this->Unit=$Unit;
		$this->User=$User;
		$this->CurrentCnt=$CurrentCnt;
		$this->RoutePointCollection=$RoutePointCollection;
		$this->UnitsOnRoute=$UnitsOnRoute;
		$this->CurrentCnt=$CurrentCnt;
		$this->Loop=$Loop;
	}
	
	public function getUnitsOnRoute()
	{
		return $this->UnitsOnRoute;
	}
	
	/**
	*   getter Order
	*
	* return string
	*/
	public function getOrderByUnit(Unit $Unit)
	{
		foreach($this->Unit as $UnitArrayString)
		{
			if($UnitArrayString['i_UnitId']==$Unit->getId())
			{
				return $UnitArrayString['i_CurrentPoint'];	
			}	
		}	
		return 0;
	}
	
	
	public function getIsLoop(Unit $Unit)
	{
		return $this->Loop;
	}
	
/**
	*   getter CurrentCnt
*
* return string
*/
	public function getCurrentCnt()
	{
		return $this->CurrentCnt;
	}
	
	public static function getEmptyInstance()
	{
		return new Route(0,"",Unit::getEmptyInstance(),User::getEmptyInstance(),0,0,new RoutePointCollection(),0);
	}
	
		 
/**
*   getter RoutePointCollection
*
* return string
*/
public function getRoutePointCollection()
{
  return $this->RoutePointCollection;
}
	
	  
/**
*   getter User
*
* return string
*/
public function getUser()
{
  return $this->User;
}
	
	
	
	 
/**
*   getter Unit
*
* return string
*/
public function getUnit()
{
  return $this->Unit;
}
	
	
/**
*   getter Id
*
* return string
*/
public function getId()
{
  return $this->Id;
}
	
/**
*   getter Name
*
* return string
*/
public function getName()
{
  return $this->Name;
}
	
}



?>