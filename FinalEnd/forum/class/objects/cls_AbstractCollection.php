<?php

abstract class Collection implements Iterator
{
	protected $Elements=null;
	protected $ElementCounter=0;
	
	/**
	 * gibt ein object an hander seiner id zurück
	 *
	 * @param int $Id
	 * @return objekt
	 */
	public function getById($Id)
	{
		if($this->ElementCounter==0)
		{
			return null;		
		}
		foreach ($this->Elements as $Element)
		{
			if($Element->Id==$Id)
			{
				return $Element;
			}
		}
	}
	
	public function add(i_CollectionElement $Element)
	{
		$this->Elements[]=$Element;
		$this->ElementCounter++;
	}
	
	
	/**
	 * gibt die anzahl der element zurück
	 *
	 * @return int
	 */
	public function getCount()
	{
		return count($this->Elements);
	}
	
	public function __construct()
	{	
		$this->Elements= array();
	}
	
	/**
	 * gibt true zurück wenn die Collection elemente besitzt
	 *
	 * @return bool
	 */
	public function hasElements()
	{
		if(!count($this->Elements)){return false;}
		return true;
	}
	
	public function getAll()
	{
		return $this->Elements ;
	}
	
	
	/**
	 * gibt die anzahl der element zurück
	 *
	 * @return int
	 */
	public function countElements()
	{
		return count($this->Elements);
	}
	
	/**
	 * gibt das element mit dem angegebene index zurück wird kein element gefunden wird false zurück gegeben
	 *
	 * @param int $Index
	 * @return Object
	 */
	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
		return false;
		
		return $this->Elements[$Index];
		
		
	}
	public function rewind()
	{
		if (!isset($this->Elements)){return false;}
		reset($this->Elements);
	}
	
	public function current()
	{
		if (!isset($this->Elements)){return false;}
		$Var = current($this->Elements);
		return $Var;
	}
	
	public function key()
	{
		if (!isset($this->Elements)){return false;}
		$Var = key($this->Elements);
		return $Var;
	}
	
	public function next()
	{
		$Var = next($this->Elements);
		return $Var;
	}
	public function valid() {
		$Var = $this->current() !== false;
		return $Var;
	}
	
	public function mixElements()
	{
		shuffle($this->Elements);
		return true;	
	}
	
}

?>