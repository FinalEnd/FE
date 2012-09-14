<?php

class AllianzRank extends ParseAbleObject implements i_CollectionElement
{
	protected $Name;
	protected $Id;
	
	public function __construct($Name,$AllianzID)
	{
	    $this->Name=$Name;
		$this->Id=$AllianzID;
	}
	
	public function getId()
	{
		return $this->Id;
	}

	public static function getEmptyInstance()
	{
		return new AllianzRank("",false,0);
	}
	
	public function setName($Name)
	{
		$this->Name=$Name;
	}


	public function getName()
	{
		return $this->Name;
	}
	
	
	

	
}





?>