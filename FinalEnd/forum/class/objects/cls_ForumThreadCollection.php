<?php

/**
 * class cls_ForumThreadCollection
 *
 * Description for class cls_ForumThreadCollection
 *
 * @author:
*/
class ForumThreadCollection extends Collection 
{
	/**
	 * cls_ForumThreadCollection constructor
	 *
	 * @param 
	 */
	function ForumThreadCollection() 
	{

	}
	
	
	public function getByIndex($Index)
	{
		if($this->ElementCounter>=$Index && $this->ElementCounter!=0 )
		{
			return $this->Elements[$Index];
		}
		return ForumThread::getEmptyInstance();
	}
	
	public function getById($Id)
	{
		if($this->ElementCounter==0)
		{
			return ForumThread::getEmptyInstance();		
		}
		foreach ($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
			{
				return $Element;
			}
		}
		return ForumThread::getEmptyInstance();
	}
	
	public function setShowRigths(User $User)
	{
		$User= Controler_Main::getInstance()->getUser();
		foreach($this->Elements as $Element)
		{
			switch($Element->getModus())
			{
				case 0://für alle sichtbar                     | User/Moderator/Admin darf schreiben
				{
					$Element->setAllowShow(true);
				}
				case 1://für alle sichtbar                     | Moderator/Admin darf schreiben
				{
					$Element->setAllowShow(true);
				}
				case 2://für alle sichtbar                     | Admin darf schreiben
				{
					$Element->setAllowShow(true);
				}
				case 3://Nur Für User oder höher sichtbar      | User/Moderator/Admin darf schreiben
				{
					if($User->check(0))
					{
						$Element->setAllowShow(true);
					}  
				}
				
				case 4://Nur Für User oder höher sichtbar      | Moderator/Admin darf schreiben
				{
					if($User->check(0))
					{
						$Element->setAllowShow(true);
					}  
				}
				
				case 5://Nur Für User oder höher sichtbar      | Admin darf schreiben
				{
					if($User->check(0))
					{
						$Element->setAllowShow(true);
					}  
				}
				
				case 6://Nur Für Moderator oder höher sichtbar | Moderator/Admin darf schreiben
				{
					if($User->check(9))
					{
						$Element->setAllowShow(true);
					}
				}
				
				case 7://Nur Für Admin sichtbar                | Admin darf schreiben 
				{
					if($User->check(10))
					{
						$Element->setAllowShow(true);
					}
				}
				
			}
			
			
			
			
		}
			
	}
	
}

?>