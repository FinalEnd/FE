<?php

  class Allianz	extends ParseAbleObject
{
	
	private $Id;
	private $Name;
	private $Description;
	private $UserCollection;
	private $PictureString;	
	private $FundUser;
	private $AllianzTopicColletion;
	private $UserCount;
	
	
	public function __construct($Id,$Name,$Description,$UserCollection,$PictureString,$FundUser,$AllianzTopicColletion="",$UserCount=0)
	{
		$this->Id=$Id;
		$this->Name=$Name;
		$this->Description=$Description;
		$this->UserCollection=$UserCollection;
		$this->PictureString=$PictureString;
		$this->FundUser=$FundUser;
		if($AllianzTopicColletion=="")
		{
			$this->AllianzTopicColletion=new AllianzTopicCollection();
		}else
		{
			$this->AllianzTopicColletion=$AllianzTopicColletion;	
		}	
		$this->UserCount=$UserCount;	
	}

	public static function getEmptyInstance()
	{
		return new Allianz(0,"","",new UserCollection(),"",User::getEmptyInstance(),new AllianzTopicCollection(),0);
	}


	/**
	 * gibt an ob die Allianz ein bild hat oder nicht
	 *
	 * @return bool 
	 *
	 */
	public function hasPicture()
	{
		if(strlen($this->PictureString)>0)
		{
			 return true;
		}
		return false;	
	}


	public function getUserCount()
	{
		return $this->UserCount;
	}

	public function getAllianzTopicColletion()
	{
		return $this->AllianzTopicColletion;
	}


	public function setId($Id)
	{
		$this->Id=$Id;
	}


	public function getFundUser()
	{
		return $this->FundUser;
	}
	
	 
/**
*   getter PictureString
*
* return string
*/
public function getPictureString()
{
  return $this->PictureString;
}
	
	public function setPictureString($PictureString)
	{
		$this->PictureString=$PictureString;
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
	*   getter Description
*
* return string
*/
public function getDescription($Parsed=false)
{
	if($Parsed)
	{
		return $this->parseAll($this->Description);
	}
  return $this->Description;
}


	public function setDescription($Description)
	{
		$this->Description=$Description;
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