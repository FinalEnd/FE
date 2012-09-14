<?php


class Ship
{
	
	private $Id; 		
	private $Name; 		
	private $Speed; 		
	private $Amor; 		
	private $Dmg; 		
	private $Health; 		
	private $Credits;		
	private $Metall; 		
	private $Cristal; 		
	private $Hydrogen; 		
	private $BuildTime;
	private $Storage;
	private $Crew;
	
	
	function __construct($Id,$Name,$Speed,$Amor,$Dmg,$Health,$Credits,$Metall,$Cristal,$Hydrogen,$BuildTime,$Storage,$Crew=0) 
	{
		$this->Id=$Id; 		
		$this->Name=$Name; 		
		$this->Speed=$Speed; 		
		$this->Amor=$Amor; 		
		$this->Dmg=$Dmg; 		
		$this->Health=$Health; 		
		$this->Credits=$Credits;		
		$this->Metall=$Metall; 		
		$this->Cristal=$Cristal; 		
		$this->Hydrogen=$Hydrogen; 		
		$this->BuildTime=$BuildTime;	
		$this->Storage=$Storage;
		$this->Crew=$Crew;
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
		$this->BuildTime=$this->BuildTime-$this->BuildTime*($Percent/100);
	}
	
	public function getCrew()
	{
		return $this->Crew;
	}
	
	
	/**
	*   getter Storage
	*
	* return string
	*/
	public function getStorage()
	{
		return $this->Storage;
	}
	
	
/**
	*   getter Buildtime
*
* return string
*/
	public function getBuildTime()
{
		return $this->BuildTime;
}
	
	
	/**
	 * gibt die Bauzeit im hh:mm:ss format zurück
	 *
	 * @return string 
	 *
	 */
	public function getBuildTimeFormated()
	{
		return Date::dateFormat($this->BuildTime);
	}
	   
/**
	*   getter Hydrogen
*
* return string
*/
public function getHydrogen()
{
  return $this->Hydrogen;
}
	
	   
/**
	*   getter Cristal
*
* return string
*/
public function getCristal()
{
  return $this->Cristal;
}
	
	
/**
	*   getter Metall
*
* return string
*/
public function getMetall()
{
  return $this->Metall;
}
	
	
	 
/**
	*   getter Credits
*
* return string
*/
public function getCredits()
{
  return $this->Credits;
}
	
	
	   
/**
*   getter Health
*
* return string
*/
public function getHealth()
{
  return $this->Health;
}
	
	 
/**
	* getter Dmg
*
* return string
*/
public function getDmg()
{
  return $this->Dmg;
}
	
	
	
/**
	* getter Amor
*
* return string
*/
public function getAmor()
{
  return $this->Amor;
}
	
	
	public function getSpeed()
	{
		return $this->Speed;	
	}
	
	public function getId()
	{
		return $this->Id;	
	}
	
	public function getName()
	{
		return $this->Name;	
	}
	
}


?>