<?php

class PlanetProtectionBuilding extends Building
{
	
	public function __construct($Id,$Name,$Description,$Picture,$Multiplicator,$Resource,$BuildTime,$BuildId,$PlanetId,$Level,$Inbuild,$i_BuildCredits,$i_BuildMetall,$i_BuildCrystal,$i_BuildHydrogen,$i_BuildBioMass,$i_Type,$NeedLevel,$Need,$MaxLevel)
	{
		$this->i_Id=$Id;
		$this->s_Name=$Name;
		$this->t_Description=$Description;
		$this->s_Picture=$Picture;
		$this->f_Multiplicator=$Multiplicator;
		$this->s_Resource=$Resource;
		$this->i_BuildTime=$BuildTime;
		$this->i_BuildId=$BuildId;
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
		$this->b_CanBuild=true;
		$this->PerCentFaster=0;
	}
	
	public function getBuildTime()
	{
		if($this->i_Level==0)
		{
			$Temp=((int) ($this->i_Level+1) * ($this->i_Level+1) *$this->i_BuildTime)/2;
		}else
		{
			$Temp=(int) ($this->i_Level) * ($this->i_Level) *$this->i_BuildTime;
		}
		if($this->PerCentFaster)
		{
			return $Temp-$Temp*$this->PerCentFaster;
		}
		return  $Temp;
	}
	
	public function getBuildTimeNextLevel()
	{
		$Temp=(int) ($this->i_Level+1) * ($this->i_Level+1) *$this->i_BuildTime*24*60*60;
		if($this->PerCentFaster)
		{
			return $Temp-$Temp*$this->PerCentFaster;
		}
		return  $Temp;
	}
	
	
	
	public static function getEmptyInstance()
	{
		return new BuildingPlanetProtection(Building::getEmptyInstance());
	}
	
}