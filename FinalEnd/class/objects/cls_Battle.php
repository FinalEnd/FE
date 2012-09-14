<?php



class Battle
{
	private $Id;
	private $Refresh;
	private $UnitCollection;
	private $X;
	private $Y;
	
	public function __construct($Id,$Refresh,$UnitCollection,$X,$Y)
	{
		$this->Id=$Id;
		$this->Refresh=$Refresh;
		$this->UnitCollection=$UnitCollection;
		$this->X=$X;
		$this->Y=$Y;	
	}
	
	
	
	/**
	 * stellt fest ob das battle aus der db entfernt werden kann dies kann der fall sein wenn nur noch einheiten aus der selben allianz oder nur noch von einem spieler vorhanden sind
	 *
	 * @return bool 
	 *
	 */
	public function canDelete()
	{
		 // hat keine einheiten mehr dann gelöscht
		if($this->UnitCollection->getCount()<=1)
		{
			return true;
		}
		
		$LifeUnitCollection=$this->UnitCollection->getLifedUnits();	 // gucken wieviele einheiten von unterschiedlichen benutzern noch vorhanden sind wenn ein dann löschen
		$PlayerArray=$LifeUnitCollection->getDifferentPlayer();
		if(count($PlayerArray)==1)
			{
				return true;
			}
		$AllianzArray=$this->UnitCollection->getDifferentAllianz();// gibt alle allianzen zurück	
		if(count($AllianzArray)==1)
		{
			return true;
		}	
		return false;
	}
	
	
	public function getUnitsOutOfRange()
	{
		// gucken wieviele einheiten von unterschiedlichen benutzern noch vorhanden sind wenn ein dann löschen
		return $this->UnitCollection->getUnitsOut($this->X,$this->Y);
	}
	
	
	
	
    public function calculate()
	{
		// verschidene spieler suchen
		$UnitManager= new UnitManager();
		$PlayerArray=$this->UnitCollection->getDifferentPlayer();
		$AllianzArray=$this->UnitCollection->getDifferentAllianz();
		$PlayerCount= count($PlayerArray);
		$AllianzCount= count($AllianzArray);
		// alle einheiten holen	
		$PlayerArray['$i']=0;
		for($i=0;$i<$this->UnitCollection->getCount();$i++)
		{
			$Unit=$this->UnitCollection->getByIndex($i);
			// gegnerische einheiten um diese finden 
			$this->UnitCollection->setDMG($Unit,$this->Refresh);	
		}	
		$TempUserArray= array("");
		 // nach zerstörten einheiten gucken 
		$TempUnitCollection=$this->UnitCollection->getDestroyedUnits();
		if($TempUnitCollection->getCount()<=0)
		{
			return true;
		}
		// einheiten wurden zerstört
		// healts der zerstörten einheiten aufsummieren
		//den einheiten die erfahrung gut schreiben	
		$Controler_Message= new Controler_Message();
		$USerManager= new UserManager(); 
		$MapControler= new Controler_Map();
		foreach($TempUnitCollection as $Unit)
		{
			// die Einheit Löschen die zersört wurde das nur einmal pro zerstörten flotte erfahrung und nachrichten verschickt werden
			$UnitManager->deleteUnit($Unit);// einheit löschen
			$MapControler->addWast($Unit->getX(),$Unit->getY());
			$UserCollectionTemp=$this->UnitCollection->setEXP($Unit);
			foreach($UserCollectionTemp as $TempUser)
			{
				$USerManager->addExperiance($TempUser->getId(),$Unit->getHealts(true));
				$Controler_Message->sendEnemyUnitDestroyed($TempUser,$Unit);
				/*$Controler_Message->sendMessage(SYSTEM_NAME,  $TempUser->getName(),"Sie haben die Einheit: <a title=\"zur Karte\" href=\"index.php?Section=Map&amp;X=".round($Unit->getX())."&amp;Y=".round($Unit->getY())."\">".round($Unit->getName())." ".round($Unit->getX()).":".round($Unit->getY())."</a> von ".$Unit->getUser()->getName()."
									zerstört <br /><br />
									Sie haben ".$Unit->getHealts(true)." Erfahrung erhalten.
									","Gegnerische Einheiten wurde zerstört");
				Controler_Event::getInstance()->addEvent(new UnitDestroyedEvent($TempUser));	*/			
			}
			
		}
		foreach($TempUnitCollection as $Unit)   // nachrichten das eine flotte zerstört wurde senden
		{
			$Controler_Message->sendMessage(SYSTEM_NAME,  $Unit->getUser()->getName(),"Die Einheit: <a title=\"zur Karte\" href=\"index.php?Section=Map&amp;X=".$Unit->getX()."&amp;Y=".$Unit->getY()."\">".$Unit->getName()." ".$Unit->getX().":".$Unit->getY()."</a> wurde zerstört ","Eine Ihrer Einheiten wurde zerstört");
			Controler_Event::getInstance()->addEvent(new UnitLostEvent($Unit->getUser()));
		}	
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
	 
/**
	*   getter UnitCollection
*
* return string
*/
public function getUnitCollection()
{
  return $this->UnitCollection;
}
	
	
/**
	*   getter Refresh
*
* return string
*/
public function getRefresh()
{
  return $this->Refresh;
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