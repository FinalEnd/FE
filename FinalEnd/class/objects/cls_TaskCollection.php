<?php



class TaskCollection extends Collection 
{
	public function add(Task $Element)
	{
		if(!isset($Element))
			return Task::getEmptyInstance();		
		$this->Elements[]=$Element;
		$this->ElementCounter++;
	}
	
	
	/**
	 * gibt das schiff mit der id zurck wenn vorhanden wenn nicht gibts ein null objekt
	 *
	 * @param int $Id 
	 * @return Unit 
	 *
	 */
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		return Task::getEmptyInstance();
	}
	 
	public function getByIndex($Index)
	{
		if($this->Elements[$Index])
		{
			return $this->Elements[$Index];
		}
		return Task::getEmptyInstance();
	}
	
	public function getJs()
	{
		$TempJs="var MyTaskCollection= new TaskCollection();
		";
		$TempJs.="MyTaskCollection.clear();";
		foreach ($this->Elements as $Element)
		{
			$TempJs.='var MyTask'.$Element->getId().'= new Task('.$Element->getId().',"'.$Element->getAction().'",'.$Element->getX().','.$Element->getY().','.$Element->getUnitId().');';
			
			$TempJs.='MyTaskCollection.add(MyTask'.$Element->getId().');
			';
		}
		$TempJs.='';
		return $TempJs;
	}
	
	
}


?>