<?php


class RoutePoint implements i_CollectionElement 
{
	private $Id;
	private $X;
	private $Y;
	private $Action;	
	private $Extention;
	private $RouteId;
	private $Order;
	
	public function __construct($Id,$X,$Y,$Action,$Extention,$RouteId,$Order) 
	{
		$this->Id=$Id;
		$this->X=$X;
		$this->Y=$Y;
		$this->Action=$Action;
		$this->Extention=$Extention;
		$this->RouteId=$RouteId;
		$this->Order=$Order;
	}
	
	
	   
/**
	*   getter RouteId
*
* return string
*/
public function getRouteId()
{
  return $this->RouteId;
}
	
/**
	*   getter Action
*
* return string
*/
public function getAction()
{
  return $this->Action;
}
	
  
/**
*   getter gibt den Kompletten string zurück
*
* return string
*/
public function getExtentionString()
{
  return $this->Extention;
}
	
	/**
	 * gibt die anzahl der Ressource zurück
	 *
	 * @return int 
	 *
	 */
	public function getExtentionCount()
	{
		$Temp=explode(":",$this->Extention);
		if(!$Temp[1])
		{
			return 0;	
		}
		return $Temp[1];
	}
	
	public function getExtentionRessource()
	{
		$Temp=explode(":",$this->Extention);
		if(!$Temp[0])
		{
			return "false;";	
		}
		return $Temp[0];
	}
	
	
/**
*   getter Y
*
* return string
*/
public function getY()
{
  return $this->Y;
}
	
	
	
/**
*   getter X
*
* return string
*/
public function getX()
{
  return $this->X;
}
	
	
	
	public static function getEmptyInstance()
	{
		return new RoutePoint(0,0,0,"","",0,"");
	}
	
	  
/**
	*   getter Order
*
* return string
*/
public function getOrder()
{
  return $this->Order;
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
	
	
}



?>