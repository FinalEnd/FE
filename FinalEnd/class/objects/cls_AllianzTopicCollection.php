<?php

class AllianzTopicCollection extends Collection 
{
	public function add(AllianzTopic $Element)
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
		return new AllianzTopic(0,"","","");
	}
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
			return new AllianzTopic(0,"",new User(),"",new AllianzCommentCollection(),0);
		return $this->Elements[$Index];
	}
	
}


?>