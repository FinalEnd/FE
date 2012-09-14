<?php

class PlanetCollection extends Collection 
{
	public function add(Planet $Element)
	{
		if(isset($Element))
		{
			$this->Elements[]=$Element;
		}
	}
	
	
	/**
	 * sucht nach der ID
	 *
	 * @param int $Id
	 * @return User
	 */
	public function getById($Id)
	{
		foreach ($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
			{
				return $Element;
			}
		}
		return Planet::getEmptyInstance();
	}
	
	
	public function getByIndex($Index)
	{
		if (!isset($this->Elements[$Index]) || $this->countElements() <  0)
		{
			return Planet::getEmptyInstance();
		}
		
		return $this->Elements[$Index];
	}
	
	public function getCount()
	{
		$Count=0;
		foreach ($this as $Planet)
		{
			$Count= $Count+1;
		}
		return $Count;
	}
	
	public function getBuildingHQ()
	{
		$BuildingCollection = new BuildingCollection();
		foreach ($this->Elements as $Element)
		{
			$BuildingCollection->add($Element->getBuildingCollection()->getByResource("Credits"));
		}
		$BuildingCollection->deleteNull();
		return $BuildingCollection;
	}
	
	
	 
	 /**
	  * gibt die bevölkerung aler Planeten zurück
	  *
	  * @return float 
	  *
	  */
	 public function getPeopleCount()
	{
		$TempCount=0;
		foreach ($this->Elements as $Element)
		{
			$TempCount+=$Element->getPeopleCount(true);
		}
		return $TempCount;
	}
	
	public function getPeopleCountFormatet()
	{
		$TempCount=0;
		foreach ($this->Elements as $Element)
		{
			$TempCount+=$Element->getPeopleCount(true);
		}
		if($TempCount>=1000000)// mio.
		{
			$Temp= round(($TempCount/1000000),1)." mio.";
			return $Temp; 	
		}
		return number_format($TempCount,0,",",".");
	}
	
	
	/**
	 * gibt das kommunikations zentrums level über alle planeten hinweg zurück
	 *
	 * @return BuildingCollection kann leer sein
	 *
	 */
	public function getBuildingKommunicationCenter()
	{
		$BuildingCollection = new BuildingCollection();
		foreach ($this->Elements as $Element)
		{
			$BuildingCollection->add($Element->getBuildingCollection()->getByTypeId(21));
		}
		$BuildingCollection->deleteNull();
		return $BuildingCollection;
	}
	
	public function getJs()
	{
		$TempJS='var MyPlanetCollection= new PlanetCollection();
		';
		$TempJS.='MyPlanetCollection.clear();';
		foreach ($this->Elements as $Element)
		{
			$TempJS.='var Planet'.$Element->getId().'= new Planet('.$Element->getId().',"'.$Element->getName().'",'.$Element->getX().','.$Element->getY().',"'.$Element->getPicture().'","'.$Element->getUser()->getName().'","'.$Element->getUser()->getAllianzName().'",
			';
			if($Element->getUser()->getId()==Controler_Main::getInstance()->getUser()->getId())
			{
				$TempJS.='true,';
			}else
			{
				$TempJS.='false,';
			}
			
			if(Controler_Main::getInstance()->getUser()->getAllianzId()!=0 && $Element->getUser()->getAllianzId()==Controler_Main::getInstance()->getUser()->getAllianzId() )
			{
				$TempJS.='true,';
			}else
			{
				$TempJS.='false,';
			}
			
			if($Element->getUser()->getId()==0)
			{
				$TempJS.='true,';
			}else
			{
				$TempJS.='false,';
			}
			$TempJS.="'".$Element->getUser()->getPictureString()."'";
			
			$TempJS.=');';
			$TempJS.='MyPlanetCollection.add(Planet'.$Element->getId().');
			';
		}
		$TempJS.='';
		return $TempJS;
	}
	
	
	public function getPLanetsInRange($X,$Y,$Range)
	{
		$TempCollection= new PlanetCollection();
		foreach($this->Elements as $Element)
		{
			$C=	sqrt(pow($Element->getX()-$X,2)+pow($Element->getY()-$Y,2));
			if($C<$Range)
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
	
	
	
	
}


?>