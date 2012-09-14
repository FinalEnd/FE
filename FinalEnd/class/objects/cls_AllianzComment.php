<?php

class AllianzComment extends ParseAbleObject
{
	private $Id;
	private $Content;
	private $CreateUser;
	private $CreateDate;


	public function __construct($Id,$Content,User $CreateUser,$CreateDate)
	{
		$this->Id=$Id;
		$this->Content=$Content;
		$this->CreateDate=$CreateDate;
		$this->CreateUser=$CreateUser;
	}
	
	
	/**
	*   getter CreateUser
	*
	* return string
	*/
	public function getCreateUser()
	{
		return $this->CreateUser;
	}

	public function getUser()
	{
		return $this->CreateUser;
	}
	
	/**
		*   getter CreateDate
	*
	* return string
	*/
	public function getCreateDate()
	{
		return $this->CreateDate;
	}



	/**
	*   getter Name
	*
	* return string
	*/
	public function getContent($Parsed=true)
	{
		if($Parsed)
		{
			return $this->parseAll($this->Content);
		}
		return $this->Content;
	}

	
	/**
	*   getter Id
	*
	* return string
	*/
	public function getid()
	{
		return $this->Id;
	}
	
	
}




?>