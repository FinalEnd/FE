<?php
class AllianzTopic
{
	private $Id;
	private $Name;
	private $CreateUser;
	private $CreateDate;
	private $AllianzCommecntCollection;
	private	 $AllianzId;
	

	public function __construct($Id,$Name,User $CreateUser,$CreateDate,$AllianzCommecntCollection,$AllianzId)
	{
		$this->Id=$Id;
		$this->Name=$Name;
		$this->CreateDate=$CreateDate;
		$this->CreateUser=$CreateUser;
		$this->AllianzCommecntCollection=$AllianzCommecntCollection;
		$this->AllianzId=$AllianzId;
		
	}
   
	
	
	/**
	 * gibt die anzahl der kommentare zurück
	 *
	 * @return int 
	 *
	 */
	public function getCommentsCount()
	{
		return $this->AllianzCommecntCollection->getCount();
		
		
	}


	/**
	 * gibt den namen des Useres zurck der den letzten eintrag gemacht hat
	 *
	 * @return string der User Name
	 *
	 */
	public function getLastCommentUserName()
	{
		$LastUser= $this->AllianzCommecntCollection->getByIndex($this->AllianzCommecntCollection->getCount()-1)->getUser();
		
		return $LastUser->getName();
	}

	public function getLastCommentDate()
	{
		return $this->AllianzCommecntCollection->getByIndex($this->AllianzCommecntCollection->getCount()-1)->getCreateDate();
	}

	public function getAllianzId()
	{
		return $this->AllianzId;
	}
	
	
/**
	*   getter AllianzCommecntCollection
*
* return string
*/
public function getAllianzCommecntCollection()
{
  return $this->AllianzCommecntCollection;
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
public function getName()
{
  return $this->Name;
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