<?php

/**
 * class cls_ForumContentCollection
 *
 * Description for class cls_ForumContentCollection
 *
 * @author:
*/
class GroupCollection extends Collection  
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
	 * gibt den datensatz anhand seiner position zurück
	 *
	 * @param int $Index der index im array
	 * @return Group 
	 *
	 */
	public function getByIndex($Index)
	{
		if (!isset($this->Elements[$Index]) || $this->countElements() <  0)
		{
			return Group::getEmptyInstance();
		}
		return $this->Elements[$Index];
		
		
	}

	
	
}

?>