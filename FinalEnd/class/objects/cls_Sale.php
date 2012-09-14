<?php

class Sale implements i_CollectionElement
{
	private $Id;
	private $Creator;
	private $Ressource;
	private $Count;
	private $Price;
	private $End;
	private $PlanetId;
	private $InsertDate;	
	
	public function __construct($Id,$Creator,$Ressource,$Count,$Price,$End,$PlanetId,$InsertDate="")
	{
		$this->Id=$Id;
		$this->Creator=$Creator;
		$this->Ressource=$Ressource;
		$this->Count=$Count;
		$this->Price=$Price;
		$this->End=$End;
		$this->PlanetId=$PlanetId;
		$this->InsertDate=$InsertDate;
	}
	
	public function getInsertDate()
	{
		return $this->InsertDate;
	}
	
	public function getUser()
	{
		return $this->Creator;
	}

	public function getPlanetId()
	{
		return $this->PlanetId;
	}

	/**
	 * gibt den durchschnittspreis formatiert zurück
	 *
	 * @return string 
	 *
	 */
	public function getAveragePriceFormatet()
	{
		return number_format($this->getAveragePrice(),2,",",".");
	}
	
	public function getAveragePrice()
	{
		if(!$this->Price || !$this->Count){return 0;}
		return $this->Price/$this->Count;
	}

	/**
	 * gibt den deutschen namen der Ressource zurück
	 *
	 * @return string 
	 *
	 */
	public function getName()
	{
		 switch($this->Ressource)
		{
			case "Cristal":
			{
				return "Kristall";
			}break;	
			
			case "Metall":
			{
				return "Metall";
			}break;	
			
			case "Hydrogen":
			{
				return "Deuterium";
			}break;	
			
			case "Biomass":
			{
				return "Lebensmittel";
			}break;		
		}
		
	}


	  
/**
*   getter End
*
* return string
*/
public function getEnd()
{
  return $this->End;
}
	
	
	 

/**
 * gibt den preis des verkaufs zurück
 *
 * @param bool $WithOutTax gibt an ob mit gebühr der preis zurück gegeben wird oder ohne
 * @return float 
 *
 */
public function getPrice($WithOutTax=false)
{
		if($WithOutTax)
		{
			return $this->Price-($this->Price *TRADE_TAX); 
		}
  return $this->Price;
}
	
	
/**
*   getter Count
*
* return string
*/
public function getCount()
{
  return $this->Count;
}   
	
	
/**
*   getter Ressource
*
* return string
*/
public function getRessource()
{
  return $this->Ressource;
}
	
	
/**
*   getter Creator
*
* return string
*/
public function getCreator()
{
  return $this->Creator;
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
	
	
	public static function getEmptyInstance()
	{
		return new Sale(0,User::getEmptyInstance(),"",0,0,"",0,"");
	}
	
	
	
}