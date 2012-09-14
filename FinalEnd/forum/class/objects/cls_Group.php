<?php

class Group implements i_CollectionElement
{
	private $Id;
	private $Name;
	private $Color;
	private $MinPosts;	  // die Posts die ein User gemacht haben muss bis er eine Gruppe aufsteigt
	private $SecurityLevel;
	private $UserCollection;

	function __construct($Id,$Name,$Color,$MinPosts,$SecurityLevel,UserCollection $UserCollection) 
	{
		$this->Id=$Id;
		$this->Name=$Name;
		$this->Color=$Color;
		$this->MinPosts=$MinPosts;
		$this->SecurityLevel=$SecurityLevel;
		$this->UserCollection=$UserCollection;
	}
	
	public static function getEmptyInstance()
	{
		return new Group(0,"","",0,-1,new UserCollection());
	}
	
	
	
/**
	*   getter UserCollection
*
* return string
*/
public function getUserCollection()
{
  return $this->UserCollection;
}
	
/**
		*   getter SecurityLevel
*
* return string
*/
public function getSecurityLevel()
{
  return $this->SecurityLevel;
}
	  
/**
	*   getter MinPosts
*
* return string
*/
public function getMinPosts()
{
  return $this->MinPosts;
}
	
	
/**
	*   getter Color
*
* return string
*/
public function getColor()
{
  return $this->Color;
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