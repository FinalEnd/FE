<?php

/**
 * class cls_Hit
 *
 * Description for class cls_Hit
 *
 * @author:
*/
class Click  implements i_CollectionElement 
{

	private $Id;
	private $Ip;
	private $Date;
	private $Paramstring;
	private $User;
	private $Reffer;


	/**
	 * cls_Hit constructor
	 *
	 * @param 
	 */
	function __construct($Id,$Ip,$Date,$Paramstring,$User,$Reffer) 
	{
		$this->Id=$Id;
		$this->Ip=$Ip;
		$this->Date=$Date;
		$this->Paramstring=$Paramstring;
		$this->User=$User;
		$this->Reffer=$Reffer;
	}
	
	public function getReffer()
	{
		return $this->Reffer;	
	}
	
	public static function getEmptyInstance()
	{
		return new Click(0,0,"","",User::getEmptyInstance());
	}
	
	public function getUser()
	{
		return $this->User;	
	}
	
	public function getParamString()
	{
		return $this->Paramstring;	
	}
	
	public function getDate()
	{
		return $this->Date;	
	}
	
	public function getId()
	{
		return $this->Id;	
	}
	
	public function getIp()
	{
		return $this->Ip;	
	}
	
}



class ClickCollection extends Collection 
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	public function getByIndex($Index)
	{
		if($this->ElementCounter>=$Index && $this->ElementCounter>0)
		{
			return $this->Elements[$Index];
		}
		return new Click(0,"","","",new User(0,"","","",0));
	}
	
}




?>