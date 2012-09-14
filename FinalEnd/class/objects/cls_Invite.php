<?php

class Invite implements i_CollectionElement
{
	private $Id;
	private $User;
	private $Temp;
	private $Type;
	public function __construct($Id,$User,$Temp,$Type)
	{
		$this->Id = $Id;
		$this->User = $User;
		$this->Temp = $Temp;
		$this->Type = $Type;
	}
	
	public static function getEmptyInstance()
	{
		return new Invite(0,"","","");
	}
	
	public function getUser()
	{
		return $this->User;	
	}
	
	public function getTemp()
	{
		return $this->Temp;	
	}
	
	public function getType()
	{
		return $this->Type;	
	}
	
	
	public function getId()
	{
		return $this->Id;	
	}
}
?>