<?php
class User	implements i_CollectionElement
{
	protected $Id;
	protected $Name;
	protected $Pass;
	protected $Login;
	protected $Mail;
	protected $Level;
	protected $Experience;
	protected $Status;// ob admin oder bezahlt oder sonstwas
	protected $Credits;
	protected $Refresh;
	protected $AllianzName;
	protected $AllianzMemberState;
	protected $AllianzJoinDate; 
	protected $AllianzId;
	protected $Looked; 
	protected $RegisterDate;
	protected $PremiumUser;
	protected $GroupID;
	protected $Group;
	protected $Server;

	public function __construct($Id=0,$Name="None",$Pass="",$Mail="",$Login="",$Level=1,$Experience=0,$Status=0,$Credits=0,$Refresh=0,$AllianzName="",$AllianzMemberState="",$AllianzJoinDate="",$AllianzId=0,$Looked=0,$RegisterDate="",$PremiumUser="",$GroupID=0,$Group="",$Server="")
	{
		$this->Id=$Id;
		$this->Name=$Name;
		$this->Pass=$Pass;
		$this->Mail=$Mail;
		$this->Login=$Login;
		$this->Level=$Level;
		$this->Experience=$Experience;
		$this->Status=$Status;
		$this->Credits=$Credits;
		$this->Refresh=$Refresh;
		$this->AllianzName  =$AllianzName;
		$this->AllianzMemberState=$AllianzMemberState;
		$this->AllianzJoinDate=$AllianzJoinDate;
		$this->AllianzId=$AllianzId;
		$this->Looked=$Looked;
		$this->RegisterDate=$RegisterDate;
		$this->PremiumUser=$PremiumUser;
		$this->GroupID=$GroupID;
		if($Group=="")
		{
			$this->Group= new Group(0,"Gast","",0,0,new UserCollection());
		}else
		{
			$this->Group=$Group;
		}
		
		$this->Server=$Server;
		//var_dump($this->Group);
	}
	
	public function getServer()
	{
		return $this->Server;
	}
	
	public function getServerName()
	{
		switch($this->Server)
		{
			case 1:
			{
				return "BetaVersum";
			}break;	
			case 2:
			{
				return "Milchstraße";
			}break;	
			default:
				return $this->Server;	
		}
		
	}
	
	
	public function getGroup()
	{
		return $this->Group;
	}
	
	public function isPremium()
	{
		return $this->PremiumUser;
	}
	
	
	/**
	 * gibt an ob der User ein premium User ist oder nicht
	 *
	 * @return bool true ist premium false ist keiner 
	 *
	 */
	public function getPremiumUser()
	{
		return $this->PremiumUser;
	}
	
	/**
	 * gibt an ob der User gesperrt ist oder nicht
	 *
	 * @return bool wenn er gesperrt ist dann wird true zurück gegeben
	 *
	 */
	public function getLooked()
	{
		return $this->Looked;
	}
	
	
	/**
	 * das datum und die uhrzeit zu dem der User sich registriert hat
	 *
	 * @return string 
	 *
	 */
	public function getRegisterDate()
	{
		return $this->RegisterDate;
	}
	
	
	public static function getEmptyInstance()
	{
		return new User(0,"","","","",   0,0,0,0,0,"","","",0,0);
	}
	
	
	
	/**
	 * gibt an ob der spieler eine allianz hat oder nicht
	 *
	 * @return bool 
	 *
	 */
	public function hasAllianz()
	{
		if($this->AllianzId!=0)
		{
			return true;	
		}
		return false;	
	}
	
	
	public function getAllianzId()
	{
		return $this->AllianzId;
	}
	
	public function getAllianzJoinDate()
	{
		return $this->AllianzJoinDate;
	}
	
	public function getAllianzMemberState()
	{
		return $this->AllianzMemberState;
	}
	
	
	public function getAllianzName()
	{
		return $this->AllianzName;
	}
	
	public function setId($Id)
	{
		$this->Id=$Id;	
	}
	
	public function getCredits($Parsed=false)
	{
		if($Parsed)
		{
			return (int) $this->Credits;	
		}
		return $this->Credits;
	}	
	
	public function setCredits($Credits)
	{
		 $this->Credits=$Credits;
	}
	
	public function getRefresh()
	{
		return $this->Refresh;
	}
	
	public function getName()
	{
		return $this->Name;
	}
	public function getExperience()
	{
		return (int) $this->Experience;
	}
	public function getId()
	{
		return $this->Id;
	}

	
	public function getStatus()
	{
		return $this->Status;
	}
	
	public function getMail()
	{
		return $this->Mail;
	}
	
	public function getLogin()
	{
		return $this->Login;
	}
	
	public function getLevel()
	{
		return $this->Level;
	}
	
	public function getPass()
	{
		return $this->Pass;
	}
	
	public function addExperience($Exp)
	{
		$this->Experience+=$Exp;
		if($this->Experience>(2030.6122449 * ( ($this->Level  +1)  *  ($this->Level +1) ) -1530.612244 *  ($this->Level +1)))
		{
			$this->Level++;
		}
	} 
	
	
	/**
	 * gibt die nöch nötige erfahrung zum nächsten level zurück
	 *
	 * @return string 
	 *
	 */
	public function getUserNextLevelExp()
	{
		$Exp=2030.6122449 * ( ($this->Level  +1)  *  ($this->Level +1) ) -1530.612244 *  ($this->Level +1) ;
		return round((int)$Exp-$this->getExperience(),0);
	}
	
	
	/**
	 * gibt die EXP des aktuellen levels zurück
	 *
	 * @return float 
	 *
	 */
	public function getThisLevelExp()
	{
		return 2030.6122449 * ( ($this->Level  )  *  ($this->Level ) ) -1530.612244 *  ($this->Level ) ;
	}


	/**
	 * gibt die benötigten ep für das nächste level zurück  eval diese funktion funktioniert nicht richtig ka warum aber es kommen falsche werte 
	 *
	 * @return int 
	 *
	 */
	public function getExpForNextLevel()
	{
		$Temp=   ((2030.6122449 * ( ($this->Level  +1)  *  ($this->Level +1) ) -1530.612244 *  ($this->Level +1)) - (2030.6122449 * ( ($this->Level  )  *  ($this->Level ) ) -1530.612244 *  ($this->Level )))+501 ;
		return	(int) $Temp;
	}


	/**
	* gibt die EXP des letzten levels zurück
	*
	* @return float 
	*
	*/
	public function getLastLevelExp()
	{
		return 2030.6122449 * ( ($this->Level  -1)  *  ($this->Level -1) ) -1530.612244 *  ($this->Level -1) ;
	}
	public function check($Level)
	{
		if($this->Group->getSecurityLevel()>=$Level)
		{
			return true;	
		}
		return false;
	}
	
	public function getLevelAsString()
	{
		return $this->Group->getName();
	}
	
	public function getSignature()
	{
		return "";
	}
	
		
}?>