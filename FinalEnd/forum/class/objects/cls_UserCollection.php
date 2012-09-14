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
		return new User(-1);
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
	
	
	
	
	
	
	
	
}


?>