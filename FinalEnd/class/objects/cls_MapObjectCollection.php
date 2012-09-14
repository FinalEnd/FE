<?php



class MapObjectCollection extends Collection 
{
	public function add(MapObject $Element)
	{
		if(!isset($Element))
			return false;		
		$this->Elements[]=$Element;
		$this->ElementCounter++;
	}

	
	
	public function getObjectsInRange($X,$Y,$Range)
	{
		$TempCollection= new UnitCollection();
		foreach($this->Elements as $Element)
		{
			$C=	sqrt(pow($Element->getX()-$X,2)+pow($Element->getY()-$Y,2));
			if($C<=$Range)
			{
				$TempCollection->add($Element);
			}
		}
		return $TempCollection;
	}
	
	public function deleteObjects(MapObjectCollection $MapObjectCollection)
	{
		$TempArray=array();
		
		if($MapObjectCollection->getCount()==0)	{return false;}
		
		foreach($this->Elements as $Element)
		{
			if(!$MapObjectCollection->getById($Element->getId())->getId())
			{
				$TempArray[]= $Element;
			}
		}
		$this->Elements=$TempArray;

	}
	

	
	
	/**
	 * erstezt das alte element mit dem neuen element. Es wird nur der zuerst gefundene element überschrieben
	 *
	 * @param Unit $Element 
	 * @return bool im erfolgsfall true sonst false wenn element nicht gefunden
	 *
	 */
	public function rePlaceElementById($Element)
	{
		for($i=0;$i<count($this->Elements);$i++)
		{	
			$MyElement=$this->getByIndex($i);
			if($MyElement->getId()==$Element->getId())
			{
				$this->Elements[$i]=$Element;
				return true;
			}
		}
		return $TempArray;
	}
	


	
	
	/**
	 * gibt das schiff mit der id zurück wenn vorhanden wenn nicht gibts ein null objekt
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
		return MapObject::getEmptyInstance();
		
	}
	

	
	
	public function getJs()
	{
		$TempTIme=time();
		$TempJs="
		var MyMapObjectCollection= new MapObjectCollection();
		";
		//$TempJs.=" MyMapObjectCollection().clear();
		//";
		foreach ($this->Elements as $Element)
		{
			switch($Element->getType())
			{
				case 1:
				{
					$TempJs.='var MyMapObject'.$Element->getId().'= new Wast('.$Element->getId().',"'.$Element->getX().'","'.$Element->getY().'",'.$Element->getWidth().','.$Element->getHeight().',"'.$Element->getPictureString().'");';
					$TempJs.='MyMapObjectCollection.add(MyMapObject'.$Element->getId().');';
				}
				case 2:
				{
					$TempJs.='var MyMapObject'.$Element->getId().'= new Astroid('.$Element->getId().',"'.$Element->getX().'","'.$Element->getY().'",'.$Element->getWidth().','.$Element->getHeight().',"'.$Element->getPictureString().'");';
					$TempJs.='MyMapObjectCollection.add(MyMapObject'.$Element->getId().');';
				}break;
				
				case 3:
				{
					$TempJs.='var MyMapObject'.$Element->getId().'= new Sun('.$Element->getId().',"'.$Element->getX().'","'.$Element->getY().'",'.$Element->getWidth().','.$Element->getHeight().',"'.$Element->getPictureString().'","'.$Element->getName().'");';
					$TempJs.='MyMapObjectCollection.add(MyMapObject'.$Element->getId().');';
				}break;
				
			}
		}
		$TempJs.='
		';
		return $TempJs;
	}
	
	


	
	 
	/**
	 * gibt den durchschnittlichen x wert der einheiten zurück
	 *
	 * @return int 
	 *
	 */
	public function getAverageX()
	{
		if($this->ElementCounter<=0){return 0;}
		$Counter=0;
		foreach($this->Elements as $Unit)
		{	
			$Counter+=   $Unit->getX();
		}
		return (int) $Counter/$this->ElementCounter;
	}
	
	/**
	* gibt den durchschnittlichen Y wert der einheiten zurück
		   *
	* @return int 
		   *
	*/
	public function getAverageY()
	{
		if($this->ElementCounter<=0){return 0;}
		$Counter=0;
		foreach($this->Elements as $Unit)
		{	
			$Counter+= $Unit->getY();
		}
		return (int) $Counter/$this->ElementCounter;
	}
	
	


	

	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0 || empty($this->Elements[$Index]) )
			return MapObject::getEmptyInstance();
		
		return $this->Elements[$Index];
		
		
	}
	
	
	
}


?>