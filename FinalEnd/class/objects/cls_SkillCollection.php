<?php



class SkillCollection extends Collection 
{
	public function add(Skill $Element)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
		$this->ElementCounter++;
	}
	
	
	/**
	 * gibt das schiff mit der id zurück wenn vorhanden wenn nicht gibts ein null objekt
	 *
	 * @param int $Id 
	 * @return Sale 
	 *
	 */
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
				return $Element;
		}
		return Skill::getEmptyInstance();	
	}
	
	public function setUserLevel($UserLevel)
	{
		for($i=0;$i<$this->getCount();$i++)
		{
			$this->Elements[$i]->setUserLevel($UserLevel);
		}
		return true;	
	}
	
	
	
	/**
	 * fügt die Skill Kollection zusammen und überschreibt ellemente in der Collection die nicht übergeben wird !  Vorrausetzung ist das die nicht übergebene Collection mehr element hat als die Übergebene bzw. alle element besitzt
	 *
	 * @param SkillCollection $SkillCollection 
	 * @return void 
	 *
	 */
	public function merge(SkillCollection $SkillCollection)
	{
		$TempCollection= new SkillCollection();
		foreach($this->Elements as $Element)
		{
			$SkillExtern=$SkillCollection->getById($Element->getId());
			//$Element=$this->getById($SkillExtern->getId());
			if($SkillExtern->getId()!=0)// wenn das element nicht drinn ist dann hinzufügen 
			{
				$Element->setCoolDownAction($SkillExtern->getCoolDownAction());
			}
			
			$TempCollection->add($Element);	
		}
		
		$this->Elements=$TempCollection->getAll();
		return Skill::getEmptyInstance();	
	}
	
	
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
		{
			return Skill::getEmptyInstance();
		}
		return $this->Elements[$Index];
	}
	
	
}


?>