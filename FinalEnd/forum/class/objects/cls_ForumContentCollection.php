<?php

/**
 * class cls_ForumContentCollection
 *
 * Description for class cls_ForumContentCollection
 *
 * @author:
*/
class ForumContentCollection extends Collection  
{

	/**
	 * cls_ForumContentCollection constructor
	 *
	 * @param 
	 */
	function __construct() 
	{

	}
	
	
	
	
	/**
	 * gibt den datensat anhand seiner position zurück
	 *
	 * @param int $Index der index im array
	 * @return ForumThread 
	 *
	 */
	public function getByIndex($Index)
	{
		if (!isset($this->Elements[$Index]) || $this->countElements() <  0)
		{
			return ForumContent::getEmptyInstance();
		}
		return $this->Elements[$Index];
		
		
	}
	
	
	public function parse()
	{
		foreach($this->Elements as $Element)
		{
			$Element->parse();
		}
	}
	
	
	
	/**
	 * gibt den neuesten beitrag aus der Collection zurück
	 *
	 * @return ForumContent 
	 *
	 */
	public function getNewest()
	{
		$LanUserCollection = new LanUserCollection();
		
		$TempElement= new ForumContent(0,0,User::getEmptyInstance(),"","9999-99-99 99:99");
		foreach ($this->Elements as $Element)
		{
			if($Element->getStatus()!=1 && $Element->getStatus()!=2 )
			{
				$LanUserCollection->add($Element);
			}
		}
		return $LanUserCollection;	
	}
	
	
}

?>