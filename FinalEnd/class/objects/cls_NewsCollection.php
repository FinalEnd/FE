<?php

class NewsCollection extends Collection 
{
	
	public function add(News $Element)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
	}
	
	
	
	
	
	
	
	
}


?>