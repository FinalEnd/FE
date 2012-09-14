<?php

class ReSearch implements i_CollectionElement 
{
	private $i_Id;
	private $s_Name; 
	private $t_Description;
	private $s_Picture; 
	private $f_Multiplicator; 
	private $i_BuildTime;
	private $i_ReSearchId;
	private $i_PlanetId;
	private $i_Level;
	private $i_Inbuild;
	private $i_BuildCredits;
	private $i_BuildMetall;
	private $i_BuildCrystal;
	private $i_BuildHydrogen;
	private $i_BuildBioMass;
	private $i_Type;
	private $i_NeedLevel;
	private $i_Need;
	private $i_MaxLevel;
	private $PerCentFaster;
	
	public function __construct($Id,$Name,$Description,$Picture,$Multiplicator,$BuildTime,$ReSearchId,$PlanetId,$Level,$Inbuild,$i_BuildCredits,$i_BuildMetall,$i_BuildCrystal,$i_BuildHydrogen,$i_BuildBioMass,$i_Type,$NeedLevel,$Need,$MaxLevel)
	{
		$this->i_Id=$Id;
		$this->s_Name=$Name;
		$this->t_Description=$Description;
		$this->s_Picture=$Picture;
		$this->f_Multiplicator=$Multiplicator;
		$this->i_BuildTime=$BuildTime;
		$this->i_ReSearchId=$ReSearchId;
		$this->i_PlanetId=$PlanetId;
		$this->i_Level=$Level;
		$this->i_Inbuild=$Inbuild;
		$this->i_BuildCredits=$i_BuildCredits;
		$this->i_BuildMetall=$i_BuildMetall;
		$this->i_BuildHydrogen=$i_BuildHydrogen;
		$this->i_BuildCrystal=$i_BuildCrystal;
		$this->i_BuildBioMass=$i_BuildBioMass;
		$this->i_Type=$i_Type;
		$this->i_NeedLevel=$NeedLevel;
		$this->i_Need=$Need;
		$this->i_MaxLevel=$MaxLevel;
		$this->PerCentFaster=0;
	}
	
	
	/**
	* setzt in % wie viel schneller das gebäude gebat wird
	*
	* @param float $PerCentFaster 0.20 = 20%
	* @return void 
	*
	*/
	public function setPerCentFaster($PerCentFaster)
	{
		$this->PerCentFaster=$PerCentFaster;
	}
	
	public function getMaxLevel()
	{
		return $this->i_MaxLevel;
	}
	
	
	/**
	 * gibt die ID von der Forschung die benötigt wird um dies weiter zu erforschen
	 *
	 * @return int 
	 *
	 */
	public function getNeed()
	{
		return $this->i_Need;
	}
	
	
	/**
	 * gibt das level das benötigt wird um das gebäude weiter auszubauen
	 *
	 * @return int 
	 *
	 */
	public function getNeedLevel()
	{
		return $this->i_NeedLevel;
	}
	
	
	
	public static function getEmptyInstance()
	{
		return new ReSearch(0,"","","",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	}
	
	
	public function getCountDown($BuildTime=false)
	{
		if($BuildTime)
		{
			return Date::dateFormat($this->getBuildTimeNextLevel());
		}
		$TempDate= Date::dateFormat($this->i_Inbuild-microtime(true));
		$Split=explode(":",$TempDate);
		return '
		<div id="CountDownId'.$this->getId().'">'.$TempDate.'</div>
		<script type="text/javascript">
		var MyCountDown'.$this->getId().'= new CountDown('.$Split[0].','.$Split[1].','.$Split[2].',"CountDownId'.$this->getId().'","MyCountDown'.$this->getId().'");
		MyCountDown'.$this->getId().'.start();
		</script>';
	}
	
	public function getReSearchId()
	{
		return $this->i_ReSearchId;
	}
	
	public function setInbuild($InBuild)
	{
		$this->i_Inbuild=$InBuild;
	}
	
	
	public function getInbuild()
	{
		return $this->i_Inbuild;
	}
	public function getBuildTime()
	{
		return $this->i_BuildTime;
	}
	
	
	/**
	* gibt die benötigte bauzeit zurück für die aktuelle Forschung
	*
	* @return int die zeit für den ausbau des gebäudest
	*
	*/
	public function getBuildTimeNextLevel()
	{
		settype($this->i_Level,"integer");// falls es NULL ist
		if($this->i_Level==0)
		{
			$Temp=  (int) (($this->i_BuildTime*0.5)*60);
		}else
		{
			$Temp=   (int) (($this->i_BuildTime *$this->i_Level)*60);
		}
		if($this->PerCentFaster)// wenn schneller erforscht werden soll
		{
			return (int) ($Temp-$Temp*$this->PerCentFaster);
		}
		return $Temp;
	}
	
	public function getBuildBioMassNextLevel()
	{
		if($this->i_Level==0)
		{
			return $this->i_BuildBioMass*0.5;
		}
		return $this->i_BuildBioMass*$this->i_Level;
	}
	
	public function getBuildCrystalNextLevel()
	{
		if($this->i_Level==0)
		{
			return $this->i_BuildCrystal*0.5;
		}
		return $this->i_BuildCrystal*$this->i_Level;
	}
	
	public function getBuildHydrogenNextLevel()
	{
		if($this->i_Level==0)
		{
			return $this->i_BuildHydrogen*0.5;
		}
		return $this->i_BuildHydrogen*$this->i_Level;
	}
	
	public function getBuildMetallNextLevel()
	{
		if($this->i_Level==0)
		{
			return $this->i_BuildMetall*0.5;
		}
		return $this->i_BuildMetall*$this->i_Level;
	}
	
	public function getBuildCreditsNextLevel()
	{
		if($this->i_Level==0)
		{
			return $this->i_BuildCredits*0.5;
		}
		return $this->i_BuildCredits*$this->i_Level;
	}
	
	public function getBuildBioMass()
	{
		return $this->i_BuildBioMass;
	}
	
	public function getBuildCrystal()
	{
		return $this->i_BuildCrystal;
	}
	
	public function getBuildHydrogen()
	{
		return $this->i_BuildHydrogen;
	}
	
	public function getBuildMetall()
	{
		return $this->i_BuildMetall;
	}
	
	public function getBuildCredits()
	{
		return $this->i_BuildCredits;
	}
	
	
	
	public function getDescription()
	{
		return $this->t_Description;
	}
	
	public function getType()
	{
		return $this->i_Type;
	}
	
	
	public function getMultiplicator()
	{
		return $this->f_Multiplicator;
	}
	
	public function getId()
	{
		return $this->i_Id ;
	}
	public function getName()
	{
		return $this->s_Name ;
	}
	public function getLevel()
	{
		return $this->i_Level;
	}
	
	
	
	
	
	
	
	
}



?>