<?php

class ShipCollection extends Collection 
{
	private $ShipCounter;
	
	public function add(Ship $Element,$Count=0)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
		$this->ShipCounter[$this->ElementCounter]=$Count;
		$this->ElementCounter++;
	}
	
	
	 public function getShipCountByShipId($ShipId)
	{
		$TempCount=0;
		for($i=0;$i<count($this->Elements);$i++)
		{
			$TempElement=$this->Elements[$i];
			if($TempElement->getId()==$ShipId)
			{
				$TempCount+= $this->ShipCounter[$i];
			}
		}	
		return $TempCount;
	}
	 
	
	/**
	 * berechnet den DMG die diese schiffe machen können
	 *
	 * @return int 
	 *
	 */
	public function getDMG()
	{
		$TempDMG=0;
		for($i=0;$i<count($this->Elements);$i++)
		{
			$Element=  $this->Elements[$i];
			$TempDMG+=$Element->getDMG()*  $this->ShipCounter[$i];
		}
		return $TempDMG;
	}
	
			 
	/**
	 * setzt eine bauzeit koorektur 
	 *
	 * @param float $Percent die koorektur in % => 50 entspricht 50%
	 * @return void 
	 *
	 */
	public function setTimeCoorection($Percent)
	{
		for($i=0;$i<count($this->Elements);$i++)
		{
			$this->Elements[$i]->setTimeCoorection($Percent);
		}
	}
	
	 
	public function getStorage()
	{
		$TempStorage=0;
		for($i=0;$i<count($this->Elements);$i++)
		{
			$Element=  $this->Elements[$i];
			$TempStorage+=$Element->getStorage()*  $this->ShipCounter[$i];
		}
		return $TempStorage;
	}
	
	/**
	 * ermittel die durchschnitts panzerung des trupps
	 *
	 * @return float 
	 *
	 */
	public function getAmor()
	{
		$TempAmor=0;
		$ElementCounter=0;
		for($i=0;$i<count($this->Elements);$i++)
		{
			$Element=  $this->Elements[$i];
			$TempAmor+=$Element->getAmor()*  $this->ShipCounter[$i];
			$ElementCounter+=$this->ShipCounter[$i];
		}
		if($ElementCounter==0 ||$TempAmor ==0){return 0;}
		return $TempAmor/$ElementCounter;
	}
	
	 
	/**
	 * gibt die geschwindigkeit der einheiten zurück dabei wird immer der kleinste geschwindigkeits wert angegeben
	 *
	 * @return int die Geschwindigkeit
	 *
	 */
	public function getSpeed()
	{
		$TempSpeed=9999;
		$TempElement=0;
		foreach($this->Elements as $Element)
		{
			if($Element->getSpeed()<$TempSpeed && $this->ShipCounter[$TempElement]>0)
				$TempSpeed=	$Element->getSpeed();
			$TempElement++;
		}
		return $TempSpeed;
	} 
	
	/**
	* berechnet den Health die diese schiffe haben
	*
	* @return int 
	*
	*/
	public function getHealth()
	{
		$TempDMG=0;
		for($i=0;$i<count($this->Elements);$i++)
		{
			$Element=  $this->Elements[$i];
			$TempDMG+=$Element->getHealth()*  $this->ShipCounter[$i];
		}
		return $TempDMG;
	} 
	
	public function setCountById($Id,$Count)
	{
		for($i=0;$i<count($this->Elements);$i++)
		{
			$TempElement=  $this->Elements[$i];
			if($TempElement->getId()==$Id)
			{
				$this->ShipCounter[$i]=$Count;
			}
		}	
	}
	
	/**
	 * gibt das schiff mit der id zurück wenn vorhanden wenn nicht gibts ein null objekt
	 *
	 * @param int $Id 
	 * @return Ship 
	 *
	 */
	public function getById($Id)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Id)
			return $Element;
		}
		new Ship(0,"",0,0,0,0,0,0,0,0,0,0);
	}
	
	
	public function getByIndex($Index)
	{
		if($this->Elements[$Index])
			return $this->Elements[$Index];
		
		new Ship(0,"",0,0,0,0,0,0,0,0,0,0);
	}
	   
	/**
	 * fügt einträge zusammen drohne (2),drohne (5), Bomber(1) zu Drohne(7), Bomber(1)  
	 *
	 * @return void 
	 *
	 */
	public function merge()
	{
		$TempCollection= new ShipCollection();
		foreach($this->Elements as $Element)
		{
			if($TempCollection->isShipIn($Element)==false)
			{
				$TempCollection->add($Element,$this->getShipCountByShipId($Element->getId()));
			}
		}
		return $TempCollection;
	}
	
	
	 
	/**
	 * gibt die anzahl der schiffe im array zurück
	 *
	 * @return array 
	 *
	 */
	public function getShipCounter()
	{
		return $this->Counter;
	}
	
	public function isShipIn(Ship $Ship)
	{
		foreach($this->Elements as $Element)
		{
			if($Element->getId()==$Ship->getId())
			{
				return true;
			}
		}
		return false;
	}
	

	
	

	

	
}


?>