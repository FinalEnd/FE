<?php

class UserCollection extends Collection 
{
	public function add(User $Element)
	{
		if(isset($Element))
		{
			$this->Elements[]=$Element;
		}
	}
	
	
	/**
	 * sucht nach der ID
	 *
	 * @param int $Id
	 * @return User
	 */
	public function getById($Id)
	{
		foreach ($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
			{
				return $Element;
			}
		}
		return User::getEmptyInstance();
	}
	
	
	public function getByIndex($Index)
	{
		if (!isset($this->Elements[$Index]) || $this->countElements() <  0)
		{
			return User::getEmptyInstance();
		}
		
		return $this->Elements[$Index];
		
		
	}
	
	public function isAllianzAdmin($UserId)
	{
		foreach ($this->Elements as $Element)
		{
			if($Element->getAllianzMemberState()=="admin" && $Element->getId()==$UserId)
			{
				return true;
			}
		}
		return false;
		
		
	}
	
	
	/**
	 * gibt alle allioanz admins aus der UserCollection zurück
	 *
	 * @return UserCollection 
	 *
	 */
	public function getAllianzAdmins()
	{
		$TempCollection = new UserCollection();
		foreach ($this->Elements as $Element)
		{
			if($Element->getAllianzMemberState()=="admin" )
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
	
	public function getAllianzMembers()
	{
		$TempCollection = new UserCollection();
		foreach ($this->Elements as $Element)
		{
			if($Element->getAllianzMemberState()=="member" )
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
	
	
	
	
}


?>