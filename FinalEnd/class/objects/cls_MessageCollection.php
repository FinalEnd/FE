<?php

class MessageCollection extends Collection 
{
	public function add(Message $PlayerMessage)
	{
		if(isset($PlayerMessage))
		{
			$this->Elements[]=$PlayerMessage;
			return true;
		}
		return false;
	}
	
	
	
	/**
	 * Parst die Collection
	 *
	 */
	public function Parse()
	{
		foreach( $this->Elements as $Element)
		{
			$Element->Parse();
		}
	}
	
	
}


?>