<?php

class AllianzCommentCollection extends Collection 
{
	public function add(AllianzComment $Element)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
		$this->ElementCounter++;
	}
	
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		return new AllianzComment(0,"",User::getEmptyInstance(),"");
	}
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
			return new AllianzComment(0,"",User::getEmptyInstance(),"");
		return $this->Elements[$Index];
	}
	
}


?>