<?php


class Task implements i_CollectionElement 
{
	private $Id; 	
	private $X; 	
	private $Y; 	
	private $Refresh; 	
	private $UnitId; 	
	private $Action;
	private $Message;
	
	public function __construct($Id=0,$X=0,$Y=0,$Refresh="",$UnitId=0,$Action="",$Message=1) 
	{
		$this->Id=$Id;
		$this->X=$X;
		$this->Y=$Y;
		$this->Refresh=$Refresh;
		$this->UnitId=$UnitId;
		$this->Action=$Action;
		$this->Message=$Message;
	}
	
	public static function getEmptyInstance()
	{
		return new Task(0,0,0,0,0,"",0);
	}

	/**
	 * gibt an ob der task neine nachricht verschicken soll oder nicht 
	 *
	 * @return bool 
	 *
	 */
	public function getMessage()
	{
		return $this->Message;
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
	
	public function setAction($Action)
	{
		$this->Action=$Action;
	} 
	
	public function setUnitId($UnitId)
	{
		$this->UnitId=$UnitId;
	} 
	
	/**
	*   getter UnitId
	*
	* return string
	*/
	public function getUnitId()
	{
		return $this->UnitId;
	} 
	
	
	public function setRefresh($RefreshTime)
	{
		$this->Refresh=$RefreshTime;
	}
	
	
	/**
	*   getter Refresh
	*
	* return string
	*/
	public function getRefresh()
	{
		return $this->Refresh;
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
	
	public function setY($Y)
	{
		$this->Y=$Y;
	} 
	
	
	public function setX($X)
	{
		$this->X=$X;
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
	
	
	/**
	*   getter Id
	*
	* return string
	*/
	public function getId()
	{
		return $this->Id;
	}
	
	public function setId($Id)
	{
		$this->Id=$Id;
	} 

}


?>