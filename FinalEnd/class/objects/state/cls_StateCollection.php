<?php

class StateCollection extends Collection 
{
	
	public function add(State $Element)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
		$this->ElementCounter++;
	}
	
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
			return State::getEmptyInstance();
		return $this->Elements[$Index];
	}
	
	public function getHTMLPictures()
	{
		$Temp="";
		foreach($this->Elements as $Element)
		{
			$Temp.=$Element->getHTMLPicture();
		}
		return $Temp;
	}

	
	
	
	/**
	 * berechet alle boni und negariven aspekte der flotte
	 *
	 * @param Unit $Unit This is a description
	 * @return void This is the return value description
	 *
	 */
	public function calculate(Unit &$Unit)
	{
		foreach($this->Elements as $Element)
		{
			$Element->calculate($Unit);
		}
	}
	
}


?>