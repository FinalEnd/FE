<?php

class Unit implements i_CollectionElement
{
	protected $Id;
	protected $Name;
	protected $Units;
	protected $DMG;
	protected $Amor;
	protected $Speed;
	protected $Healts;
	protected $User;
	protected $ExtentionOne;
	protected $ExtentionTow;
	protected $X; 	
	protected $Y;
	protected $State;
	protected $Storage;
	protected $Stored;
	protected $Experience;
	protected $Level;
	protected $Task;
	protected $IsDeathStar;
	protected $IsDeathStarInBuild;
	protected $Statecollection;
	
	
	/**
	 * die orginalen
	 *
	 * @var mixed 
	 *
	 */
	protected $DMGOrgianl;
	protected $AmorOrgianl;
	protected $SpeedOrgianl;
	protected $HealtsOrgianl;
	protected $StorageOrginal;
	protected $ExtentionOneOrginal;
	protected $ExtentionTowOrginal;

	public function __construct($Id,$Name,$Units,$DMG,$Amor,$Speed,$Healts,$User,$ExtentionOne,$ExtentionTow,$X,$Y,$State,$Storage=0,$Stored="",$Experience=0,$Level=1,$Task,$Statecollection=null) 
	{
		$this->Id=$Id;
		$this->Name=$Name;
		$this->Units=$Units;
		$this->DMG=$DMG;
		$this->Amor=$Amor;
		$this->Speed=$Speed;
		$this->Healts=$Healts;
		
		// die orginalen 
		$this->DMGOrgianl=$DMG;
		$this->AmorOrgianl=$Amor;
		$this->SpeedOrgianl=$Speed;
		$this->HealtsOrgianl=$Healts;
		$this->StorageOrginal=$Storage;
		
		$this->User=$User;
		$this->ExtentionOne=$ExtentionOne;
		$this->ExtentionTow=$ExtentionTow;
		
		$this->ExtentionOneOrginal=$ExtentionOne;
		$this->ExtentionTowOrginal=$ExtentionTow;
		
		$this->X=$X; 	
		$this->Y=$Y;
		$this->State=$State;
		$this->Storage=$Storage;
		$this->Stored=$Stored;
		$this->Experience=$Experience;
		$this->Level=$Level;
		$this->Task=$Task;	
		$this->IsDeathStar=false;
		$this->IsDeathStarInBuild=false;
		$this->HighesUnit="";
		
		if($this->getShipCountByType("ds")>0 || $this->getShipCountByType("bds")>0 ) // Todesstern
		{
			$this->IsDeathStar=true;
			$this->HighesUnit="ds";
		}
		
		if($this->getShipCountByType("bds")>0) // Todesstern im bau
		{
			$this->IsDeathStarInBuild=true;
			$this->HighesUnit="bds";
		}	
		
		$this->Statecollection=$Statecollection ? $Statecollection:new StateCollection();
		$this->Statecollection->calculate($this);
	}
	
	public function setStatecollection(Statecollection $Statcollection)
	{
		$this->Statecollection=$Statcollection;	
	}
	
	
	/**
	 * gibt die Icons der stati zurück
	 *
	 * @return string 
	 *
	 */
	public function getStateCollectionHTML()
	{
		return $this->Statecollection->getHTMLPictures();	
	}
	
	public function getStatecollection()
	{
		return $this->Statecollection;	
	}
	
	
	public function getHighesUnit()
	{
		return $this->HighesUnit;	
	}

	public function getIsDeathStar()
	{
		return $this->IsDeathStar;	
	}
	
	public function getIsDeathStarInBuild()
	{
		return $this->IsDeathStarInBuild;	
	}
	
	/**
	 * gibt die fehlenden trefferpunkter der Flotte zurück
	 *
	 * @return int 
	 *
	 */
	public function getMissingHealth()
	{
		return (1-$this->State) *	$this->Healts;	
	}


	/**
	 * gibt eine leere instance der klasse zurück
	 *
	 * @return Unit 
	 *
	 */
	public static function getEmptyInstance()
	{
		return new Unit(0,"","",0,0,0,0,new User(0,"","","","","","","","",""),0,0,0,0,0,"","",0,0,new Task(0,0,0,0,0,""));
	}


/**
 * gibt den treibstoff den die Flotte geladen hat zurück
 *
 * @return float 
 *
 */
	public function getStoredHydrogen()
	{
		if($this->getStoredElement("t",true) )
		{
			return $this->getStoredElement("t",true);
		}	
		return 0;
	}


	/**
	 * gibt den Sold für diese Flotte zurück
	 *
	 * @return float 
	 *
	 */
	public function getPay()
	{
		return $this->DMG/100;	
	}


   /**
    * gibt das Bild für diese einheit zurück
    *
    * @return void 
    *
    */
   public function getPicture()
	{
		$Pic="Transporter";
		if($this->getShipCountByType("d")>0)
		{
			$Pic="Drone";
		}
		if($this->getShipCountByType("sh")>0)  // kleiner jäger
		{
			$Pic="Hunter";
		}
		if($this->getShipCountByType("hh")>0) // großer jäger
		{
			$Pic="HunterBig";
		}

		if($this->getShipCountByType("b")>0) // bomber
		{
			$Pic="Bomber";
		}
		if($this->getShipCountByType("bs")>0) // battleship
		{
			$Pic="BattleShip";
		}
		
		if($this->getShipCountByType("st")>=$this->getShipCount()*0.5) // battleship
		{
			$Pic="TransporterSmall";
		}
		
		if($this->getShipCountByType("lt")>=$this->getShipCount()*0.5) // Großer transporter
		{
			$Pic="Transporter";
		}
		
		if($this->getShipCountByType("bds")>0) // Todesstern
		{
			$Pic="DeathStarBuild";
		}
		
		if($this->getShipCountByType("ds")>0) // Todesstern
		{
			$Pic="DeathStar";
		}
		
		return $Pic;
	}


	public function isUnitInRange(Unit $Unit,$Range)
	{
		$C=	sqrt(pow($Unit->getX()-$this->getX(),2)+pow($Unit->getY()-$this->getY(),2));
		if($C>$Range)
		{
			return true;
		}
		return false;
	}


	public function	calculateDMG($DMG,$Laser=0,$Partikel=0,$Torpedos=0)
	{
		if($this->ExtentionTow==15)   // 25 % weniger schaden durch schilde
		{
			$DMG=$DMG-$DMG*0.25;
		}
		if($Partikel==1 && $this->ExtentionTow==15) // PLUS 50 % schaden
		{
			$DMG=$DMG+$DMG*0.5;
		}
		if($Laser==1 && $this->ExtentionTow==15) //weitere minuss 25 % schaden  bei lasern 
		{
			$DMG=$DMG-$DMG*0.5;
		}
		if($Laser==1 && $this->ExtentionTow!=15) //weitere + 50 % schaden  bei lasern  wenn kein schild vorhanden
		{
			$DMG=$DMG+$DMG*0.5;
		}
		$TempAmor=$this->Amor;
		if($Torpedos==1)	   // wenn die gegner einheit torpedos hat dann die maximal panzerung herunter setzen
		{
			if($TempAmor>25)
			{
				$TempAmor=25;
			}
		}

		// berechnet den dmg minus der durch die panzerung entfernt wird 500 ist maximal panzerung
		$DMG=$DMG-$DMG*$TempAmor/500; 
		
		  // dmg mit der panzerung verrechnen
		return $DMG;
	}
	/**
	 * setzt eine eilement anhand des elementes	es findet kein auf summieren stat
	 * keines der elemente kann negativ werden
	 *
	 * @param string $ElementString t,b,c,m, oder später dann boden truppen
	 * @param int $Count wieviel soll gespeichert werden
	 * @return void 
	 *
	 */
	public function setStoredElement($ElementString,$Count)
	{
		if($Count<0)
		{
			$Count=0;
		}
		$TempArray=explode(";",$this->Stored);
		$TempString="";
		$TempString2="";
		$TempFound=false;
		foreach($TempArray as $Temp)
		{
			if(strrpos($Temp,$ElementString)!==false)
			{
				$Temp2=explode(":",$Temp);
				$Temp2[1]=$Count;
				$TempString.=$Temp2[0].":".$Temp2[1].";";
				$TempFound=true;
				continue ; 
			}
			if($Temp)
			{
				$TempString.= $Temp.";";
			}
		}
		
		if($TempFound==false)
		{
			$TempString.=$ElementString.":".$Count.";";
		}
		$this->Stored=$TempString;
	}

   /**
    * gibt den gespeicherten wert zurück
    *
    * @param string $ElementString m , t , b , c
	* @param bool	$Mode gibt an ob der wert als int oder gleit komma zahl zurück gegeben werden soll
    * @return int 
    *
    */
   public function getStoredElement($ElementString,$Mode=false)
   {
		$TempArray=explode(";",$this->Stored);
		 foreach($TempArray as $Temp)
		{
			if(strrpos($Temp,$ElementString)!==false)
			   {
					$Temp2=explode(":",$Temp);
					if($Mode)
					{
						return (int)$Temp2[1];
					}else
					{
						return $Temp2[1];
					}
				}
		}
		return 0;
	}


	public function clearStoredElement()
	{
		$this->Stored="";
		return true;
	}

   /**
    * gibt den verfügbaren freien speicher platz zurück
    *
    * @return int 
    *
    */
   public function getFreeStoredSpace()
	{
		$TempFilledStorage=0;
		$TempFilledStorage+=$this->getStoredElement("t",true);
		$TempFilledStorage+=$this->getStoredElement("m",true);
		$TempFilledStorage+=$this->getStoredElement("b",true);
		$TempFilledStorage+=$this->getStoredElement("c",true);
		return $this->getStorage()-$TempFilledStorage;
	}

	public function getFreeStoredSpaceInPerCent()
	{
		$TempFilledStorage=$this->getFreeStoredSpace();
		if($TempFilledStorage==0)
		{
			return "0";	
		}
		return (round(($TempFilledStorage/$this->Storage),2)*100);
	}

	   
	/**
	 * zählt wieviele schiffe in dieser einheit stecken
	 *
	 * @return int 
	 *
	 */
	public function getShipCount()
	{
		$TempArray=explode(";",$this->Units);
		$Counter=0;
		foreach($TempArray as $Temp)
		{
			$Temp2=explode(":",$Temp);
			$Counter+=$Temp2[1];
		}
		return $Counter;
	}


	/**
	 * setzt den schip count string
	 *
	 * @param mixed $ShipCountString This is a description
	 * @return mixed This is the return value description
	 *
	 */

	public function setShipCount($ShipCountString)
	{
		$this->Units=$ShipCountString;

	}


	/**
	 * gibt die anzahl der schiffe zurück 
	 *
	 * @param string $Type kann mehrers sein d ,sh, hh, b, bs,st,lt
	 * @return int 
	 *
	 */
	public function getShipCountByType($Type)
	{
		$TempArray=explode(";",$this->Units);
		$Counter=0;
		foreach($TempArray as $Temp)
		{
			$Temp2=explode(":",$Temp);
			if($Temp2[0]==$Type)
			{	
				return $Temp2[1];
			}
		}
		return 0;
	}

	/**
	 * gibt den task der einheit zurck
	 *
	 * @return Task 
	 *
	 */
	public function getTask()
	{
		return $this->Task;
	} 

	public function getLevel()
	{
		return $this->Level;
	} 

	public function getExperience()
	{
		return $this->Experience;
	} 
   
	public function addExperience($Exp)
	{
		$this->Experience+=$Exp;
		if($this->Experience>($this->Level+1)*5000 && $this->Level<6)
		{
			$this->Level++;
		}
	} 

	/**
	 * gibt den inhalt des speicherraums zurück
	 *
	 * @return string This is the return value description
	 *
	 */
	public function getStored()
	{
		return $this->Stored;
	} 
	 
  /**
   * gibt den maximalen speicherplatz zurück
   *
   * @return mixed This is the return value description
   *
   */
	public function getStorage($Orginal=false)
	{
		if($Orginal) {return $this->StorageOrginal;}
		if($this->ExtentionTow==19)
		{
			return $this->Storage+$this->Storage*0.5;
		}
	  return $this->Storage;
	} 
		
	
/**
*   getter State
*
* return string
*/
public function getState()
{
  return $this->State;
} 

	public function getStateInPercent()
	{
		$Temp=$this->State*100;
		if($this->State<1)
		{
			if($this->State<0.1)
			{
				return substr($Temp,0,1)." %";
			}
			return substr($Temp,0,2)." %";
		}
		return $Temp." %";
	} 


	public function setState($State)
	{
		$this->State=$State;
	} 


	public function getStateString()
	{
		if($this->State==1)
		{
			return  $this->State *100 ."%";
		}
		return substr($this->State *100 ,0,5)."%";
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
		*   getter ExtentionTow
	*
	* return string
	*/
	public function getExtentionTow($Original=false)
	{
		if($Original)
		{
			return $this->ExtentionTowOrginal;	
		}
	  return $this->ExtentionTow;
	}
	
	public function setExtentionTow($Original=false)
	{
		$this->ExtentionTow = $Original;
	}
			
	/**
		*   getter ExtentionOne
	*
	* return string
	*/
	public function getExtentionOne($Original=false)
	{
		if($Original)
		{
			return $this->ExtentionOneOrginal;	
		}
	  return $this->ExtentionOne;
	}
	
	public function setExtentionOne($Original=false)
	{
		$this->ExtentionOne = $Original;
	}
	
	public function setUser($User)
	{
		$this->User = $User;
	}
	
	
	
public function getExtensionName($Id)
{
    switch($Id)
    {
        case 7:
        {
				return ":DB_R_LASER:";
        }break;
        case 8:
        {
				return ":DB_R_PARTICLE:";
        }break;
        case 9:
        {
				return ":DB_R_TORPE:";
        }break;
        case 10:
        {
				return ":DB_R_SCAN:";
        }break;   
        case 11:
        {
				return ":DB_R_ENGI:";
        }break;
        case 13:
        {
				return ":DB_R_ARMOR:";
        }break;      
        case 15:
        {
				return ":DB_R_SHIELD:";
        }break;  
        case 16:
        {
				return ":DB_R_SKIN:";
        }break;      
        case 14:
        {
				return ":DB_R_STEALTH:";
        }break;
        case 17:
        {
				return ":DB_R_TROOPS:";
        }break;
        
        case 19:
        {
				return ":DB_R_BAY:";
        }break;
        case 20:
        {
				return ":DB_R_RAID:";
        }break; 
		
		case 20:
		{
				return ":DB_R_RAID:";
		}break; 
			
		case 22:
		{
				return ":DB_R_RECYCLER:";
		}break; 
		
		case 23:
		{
				return ":DB_R_MARTYR:";
		}break; 
        
		case 24:
		{
				return ":DB_R_DEATHSTAR:";
		}break;
		
		case 25:
		{
			return ":DB_R_JUMP:";
		}break;
				
		case 26:
		{
			return ":DB_R_EMP:";
		}break;
			
		case 27:
		{
			return ":DB_R_LOWENGINE:";
		}break;
		
		
    default:
    return "-------------";
    }

}
	
	
	/**
	*   getter User
	*
	* return string
	*/
	public function getUser()
	{
	  return $this->User;
	}

	public function getUserId()
	{
		return $this->User->getId();
	}
	
/**
	*   getter Healts
*
* return string
*/
	public function getHealts($Orginal=false)
	{
		if($Orginal) {return $this->HealtsOrgianl;}
		$TempAmor=$this->Healts;
		if($this->ExtentionTow==16) //	+30% Health 
		{
			$TempAmor= $this->Healts*0.3+$this->Healts;
		}
		if($this->ExtentionTow==17) //	-7500000000000% Health wenn kolo	    
		{
			$TempAmor= $this->Healts-$this->Healts*0.75;
		}
		
		if($this->ExtentionOne==23) //	märtyrer	    
		{
			$TempAmor= $this->Healts-$this->Healts*0.5;
		}
		
		return $TempAmor+$TempAmor*($this->Level*UNIT_HEALTH_PER_LEVEL);
}
	
	public function setHealts($Healts)
	{
		$this->Healts=$Healts;
	} 
	
/**
	*   getter Speed die geschwindigkeit wird berechnet aus der erweiterung die in der unit steckt an der ausgangs geschwindigkit und an dem vorhandenen treibstoff
	* ist der treibstoff alle wird die geschwindigkeit auf 50% herab geregelt
*
* return string
*/
	public function getSpeed($Orginal=false)
	{
		if($Orginal) {return $this->SpeedOrgianl;}
		$TempSpeed=$this->Speed;
		if($this->ExtentionOne==11)//+ 50% geschwindigkeit für triebwerke
		{
			$TempSpeed=  $this->Speed+$this->Speed*UNIT_DRIVE_DEVICE_SPEED; 
		}
		
		if($this->ExtentionOne==27)//+ 25% geschwindigkeit für triebwerke
		{
			$TempSpeed=  $this->Speed+$this->Speed*UNIT_DRIVE_DEVICE_SPEEDLOW;
		}
		
		// gucken ob treibstoff da ist
		$Deuterium= $this->getStoredHydrogen();
		if($Deuterium<=0)  // wenn kein treibstoff mehr vorhanden dann wird der penis auf 0 gesetzt
		{
			$TempSpeed=$TempSpeed*0.5;
		}

		if($this->ExtentionTow==17) //	+75% Health wenn kolo	    
		{
			$TempSpeed= $this->Speed-$this->Speed*UNIT_KOLO_SPEED;
		}
		if($this->ExtentionOne==23) //	märtyrer	    
		{
			$TempSpeed= $this->Speed-$this->Speed*UNIT_MARTYR_SPEED;
		}
		$TempSpeed=$TempSpeed+$TempSpeed*($this->Level*UNIT_SPEED_PER_LEVEL);
		
		return $TempSpeed;
	} 


	public function setSpeed($Speed)
	{
		$this->Speed=$Speed;
	} 
	
	public function setAmor($Amor)
	{
		$this->Amor=$Amor;
	} 
	
	
/**
	*   getter Amor
*
* return string
*/
	public function getAmor($Orginal=false)
	{
		if($Orginal) {return $this->AmorOrgianl;}
		$TempAmor=$this->Amor;
		if($this->ExtentionTow==13) //	+20% Panzerung 
		{
			$TempAmor= $this->Amor*0.2+$this->Amor;
		}
	
		if($this->ExtentionTow==17) //	+75% Health wenn kolo	    
		{
			$TempAmor= $this->Amor-$this->Amor*0.75;
		}	
							
		if($this->ExtentionOne==23) //	märtyrer	    
		{
			$TempAmor= $this->Amor-$this->Amor*0.5;
		}
	
	
		return $TempAmor+$TempAmor*($this->Level*UNIT_AMOR_PER_LEVEL);
	}
	
	
		/**
		*   getter DMG
		*
		* return string
		*/
		public function getDMG($Orginal=false)
		{
		if($Orginal) {return $this->DMGOrgianl;}
			$TempDMG=$this->DMG;	
			if($this->ExtentionTow==17) //	-75% DMG wenn Besatzungtrupp	    
			{
				$TempDMG= $this->DMG-$this->DMG*0.75;
			}	
			
			if($this->ExtentionOne==23) //märtyrer    
			{
				return $this->DMG-$this->DMG*0.5;
			}
					
			return $TempDMG+$TempDMG*($this->Level*UNIT_DMG_PER_LEVEL);
		}
	
	public function setDMG($DMG)
	{
		$this->DMG=$DMG;
	} 
	
	
/**
	*   getter Units
*
* return string
*/
public function getUnits()
{
  return $this->Units;
}
	
/**
	*   getter Name
*
* return string
*/
public function getName()
{
  return $this->Name;
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