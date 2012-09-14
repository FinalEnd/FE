<?php

class MapObject implements i_CollectionElement
{
	private $Id;
	private $Name;
	private $Type;
	private $PictureString;
	private $X;
	private $Y;
	private $Width;
	private $Height;
	private $DeleteTime;
	

	public function __construct($Id,$Name,$Type,$PictureString,$X,$Y,$Width,$Height,$DeleteTime) 
	{
		$this->Id=$Id;
		$this->Name=$Name;
		$this->Type=$Type;
		$this->PictureString=$PictureString;
		$this->X=$X;
		$this->Y=$Y;
		$this->Width=$Width;
		$this->Height=$Height;
		$this->DeleteTime=$DeleteTime;
	}
	
	
	public function getName()
	{
		return $this->Name;
	}	 
/**
	*   getter DeleteTime
*
* return string
*/
public function getDeleteTime()
{
  return $this->DeleteTime;
} 
/**
	*   getter Height
*
* return string
*/
public function getHeight()
{
  return $this->Height;
}
/**
	*   getter Width
*
* return string
*/
public function getWidth()
{
  return $this->Width;
}
/**
	*   getter PictureString
*
* return string
*/
public function getPictureString()
{
  return $this->PictureString;
}
/**
	*   getter Type
*
* return string
*/
public function getType()
{
  return $this->Type;
}
	
	/**
	 * gibt eine leere instance der klasse zurück
	 *
	 * @return User 
	 *
	 */
	public static function getEmptyInstance()
	{
		return new MapObject(0,"",0,0,0,0,0,0,0);
	}

	public function setY($Y)
	{
		$this->Y=$Y;
	}
	
	/**
		*   getter Y
	*
	* return string
	*/
	public function getY()
	{
		return $this->Y;
	}
	
	
	/**
		*   getter X
	*
	* return string
	*/
	public function getX()
	{
		return $this->X;
	}

	public function getXRounded()
	{
		return round($this->X);
	}

	public function getYRounded()
	{
		return round($this->Y);
	}

	public function setX($X)
	{
		$this->X=$X;
	}
	
	/**
		*   getter Id
	*
	* return string
	*/
	public function getId()
	{
		return $this->Id;
	}
	
	
	
	
	
	
	
	
	
}

?>