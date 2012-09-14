<?php

class Building extends ParseAbleObject implements i_CollectionElement 
{
	protected $i_Id;
	protected $s_Name; 
	protected $t_Description;
	protected $s_Picture; 
	protected $f_Multiplicator; 
	protected $s_Resouce;
	protected $i_BuildTime;
	protected $i_BuildId;
	protected $i_PlanetId;
	protected $i_Level;
	protected $i_Inbuild;
	protected $i_BuildCredits;
	protected $i_BuildMetall;
	protected $i_BuildCrystal;
	protected $i_BuildHydrogen;
	protected $i_BuildBioMass;
	protected $i_Type;
	protected $i_NeedLevel;
	protected $i_Need;
	protected $i_MaxLevel;
	protected $b_CanBuild; // wenn das gebäude noch nicht auf dem Planeten gebaut werden darf
	protected $PerCentFaster;
	
	
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
	
	public function getPicture()
	{
		return $this->Picture;
	}
	/**
	 * gibt an ob das gebäude gebaut werden darf
	 *
	 * @return void 
	 *
	 */
	public function getCanBuild()
	{
		return $this->b_CanBuild;
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
	
	public function setCanBuild($CanBuild)
	{
		$this->b_CanBuild=$CanBuild;
	}
	
	public function getHTML()
	{
		$OutPut= "<tr>
	<td style='padding-bottom:20px'>
		<table width='100%' border='0' >
			
			<tr>
	 			<td width='100%' colspan='2'  class='header'>".$this->s_Name;
		
		if($this->i_Level!=0)
		{
			$OutPut.= "(".$this->i_Level.")";
		}
		$OutPut.= "</td>
			 </tr>
			 <tr>
	 			<td width='100%'>".$this->getDescription()." </td>  ";
		
		if($this->i_Inbuild)
		{
			$OutPut.= "<td align='center' width='150px' rowspan='4'  ><table width='160px' border='0'><tr><td align='center'>".$this->getCountDown()." <a href='index.php?Section=Building&amp;Action=CancelUpdateBuildings&amp;BuildingId=".$this->i_Type."'>:T_BUILDING_CANCEL:</a><br /></td></tr></table>";
		}else
		{
			$OutPut.= "<td width='150px' rowspan='4'  > 
		   <table width='160px' height='100%' style='height:100%;' cellspacing='10' border='0' >
<tr>";
			if($this->b_CanBuild)
				{
					if($this->getLevel()<$this->getMaxLevel())
					$OutPut.= "<td align='center' style='width;150px;'><a href='index.php?Section=Building&amp;Action=UpdateBuildings&amp;BuildingId=".$this->i_Type."' title=':T_BUILDING_BUILD_TITLE:'>:T_BUILDING_BUILD:</a><br /> </td>";
				
				}else
				{
					$BuildingFinder= new BuildingFinder();
					$NeedetBuildingName=$BuildingFinder->findNameById($this->i_Need);
				$OutPut.= "<td align='center' style='width;150px;padding-top:20px;' ><b><a style='color:red;' title=':T_BUILDING_NEEDED_TITLE:'>:T_BUILDING_NEEDED: ".$NeedetBuildingName." :T_GROUP_LEVEL: ".$this->i_NeedLevel."</a></b> </td>";
				}
$OutPut.= "</tr>  ";
			if($this->i_Level>1)
			{
				$OutPut.= "<tr>
		 <td align='center' width='150px' ><a  onclick='return deleteBuilding();' title=':T_BUILDING_DESTROY_TITLE:' href='index.php?Section=Building&amp;Action=DestroyBuilding&amp;BuildingId=".$this->i_Type."'>:T_BUILDING_DESTROY:</a> </td>
		</tr>  ";
			}
			$OutPut.= "</table>		
		</td>";
		}
		$OutPut.= " </tr>";
		
		$OutPut.=$this->getResourcenHTML();
			
		$OutPut.='</table>
	</td></tr>';	
		return $OutPut;
	}
	
	
	/**
	 * gibt einen html String zurück der die Standart Ressourcen enthält
	 *
	 * @return string kann "" sein
	 *
	 */
	protected function getResourcenHTML()
	{
		$OutPut="";
		if($this->getLevel()<$this->getMaxLevel())
			$OutPut.= ' <tr>
	 			<td>		
					<img src="./images/credits.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_CREDITS:" title=":T_HEADER_CREDITS:" />:'.$this->getBuildCreditsNextLevel().'
					<img src="./images/metal.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_METAL:" title=":T_HEADER_METAL:" />:'.$this->getBuildMetallNextLevel().'
					<img src="./images/kristal.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_CRYSTAL:" title=":T_HEADER_CRYSTAL:" />:'.$this->getBuildCrystalNextLevel().'
					<img src="./images/Treibstoff.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_HYDROGEN:" title=":T_HEADER_HYDROGEN:" />:'.$this->getBuildHydrogenNextLevel().'
					<img src="./images/fleisch.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_BIOMAS:" title=":T_HEADER_BIOMAS:" />:'.$this->getBuildBioMassNextLevel().'
					 </td>
					</tr>
					<tr> 
					<td>
					
					:T_BUILDING_BUILD_TIME: '.$this->getCountDown(true).'
				</td> 
			</tr>';
		return $OutPut;
	}
	
	
	
	
	/**
	 * gibt die Maximalen einwohner der Stadt zurück
	 *
	 * @return int kann 0 wenn der gebäude level 0 ist oder wenn das gebäude keine stadt ist
	 *
	 */
	public function getPeople()
	{
		if($this->getType()==22)
		{	
			$Temp=PEOPLE_MAX_STORE_PRE * pow(PEOPLE_MAX_STORE_SUF,$this->i_Level);
			$Temp = ((int)(($Temp+500)/1000))*1000;
			return $Temp;	
		}
	}
	
	public function getPeopleNextLevel()
	{
		if($this->getType()==22)
		{	
			$Temp=PEOPLE_MAX_STORE_PRE * pow(PEOPLE_MAX_STORE_SUF,($this->i_Level+1));
			$Temp = ((int)(($Temp+500)/1000))*1000;
			return $Temp;	
		}
	}
	
	
	public function getRessourcePerHour()
	{
		if($this->getType()==18 && $this->getMaxLevel()!=$this->getLevel())
		{	
			return ":T_BUILDING_DESCRIPTION_CAPAZITY: ".number_format((($this->i_Level*1+1)*RESOURCE_PER_LEVEL),0,",",".")." :T_BUILDING_DESCRIPTION_PER_RESSOURCE: >> ".number_format((($this->i_Level+1+1)*RESOURCE_PER_LEVEL),0,",",".")." :T_BUILDING_DESCRIPTION_PER_RESSOURCE:";	
		}
		
		
		if($this->getType()==18)
		{	
			return ":T_BUILDING_DESCRIPTION_CAPAZITY: ".number_format((($this->i_Level*1+1)*RESOURCE_PER_LEVEL),0,",",".")." :T_BUILDING_DESCRIPTION_PER_RESSOURCE:";	
		}

		if($this->getType()==22 && $this->getMaxLevel()!=$this->getLevel())
		{	
			return ":T_BUILDING_DESCRIPTION_CAPAZITY: ".number_format($this->getPeople(),0,",",".")." :T_BUILDING_DESCRIPTION_FOOD:".$this->getBioMassConsumtion()." >>".number_format($this->getPeopleNextLevel(),0,",",".")." :T_BUILDING_DESCRIPTION_FOOD:".$this->getBioMassConsumtionNextLevel()."";	
		}


		if($this->getType()==22)
		{	
			return ":T_BUILDING_DESCRIPTION_CAPAZITY: ".number_format($this->getPeople(),0,",",".")." :T_BUILDING_DESCRIPTION_PEOPLE:";	
		}
		
		 if($this->i_Level==0)
		{
			return "";	
		}
			
		if($this->getResource()!="None" && $this->getMaxLevel()!=$this->getLevel()) // wenn es irgend was produziert  dann gehts hier rein 
		{
			return $this->getLevel()*$this->getMultiplicator()." :T_BUILDING_DESCRIPTION_PER_HOURE: >> ".($this->getLevel()+1)*$this->getMultiplicator()." :T_BUILDING_DESCRIPTION_PER_HOURE:";
		}	
			
			
		if($this->getResource()!="None") //wenn es irgend was produziert dann gehts hier rein 
		{
			return $this->getLevel()*$this->getMultiplicator()." :T_BUILDING_DESCRIPTION_PER_HOURE:  ";
		}	
		return "";
	}
	
	public function getBioMassConsumtion()
	{
		if($this->getType()!=22)// nur wenn es eine stadt ist
		{	
			return 0;	
		}
		$Constumtion=POEPLE_CONSUMTION_A * $this->getLevel() + POEPLE_CONSUMTION_B;
		$Constumtion=$Constumtion/10;
		$Constumtion=round($Constumtion);
		$Constumtion=$Constumtion*10;
		if($Constumtion<0){return 0;}
		return (int) $Constumtion;
	}
	
	
	public function getBioMassConsumtionNextLevel()
	{
		if($this->getType()!=22)// nur wenn es eine stadt ist
		{	
			return 0;	
		}
		$Constumtion=POEPLE_CONSUMTION_A * ($this->getLevel()+1) + POEPLE_CONSUMTION_B;
		$Constumtion=$Constumtion/10;
		$Constumtion=round($Constumtion);
		$Constumtion=$Constumtion*10;
		if($Constumtion<0){return 0;}
		return (int) $Constumtion;
	}
	
	
	/**
	 * gibt die maximal anzahl der einwohner des planeten zurück
	 *
	 * @return int 
	 *
	 */
	public function getMaxPeople()
	{
		if($this->getType()!=22)
		{
			return 0;	
		}	
		$Temp=PEOPLE_MAX_STORE_PRE * pow(PEOPLE_MAX_STORE_SUF,$this->i_Level);
		$Temp = ((int)(($Temp+500)/1000))*1000;
		return $Temp;
	}
	
	
	/**
	 * gibt die maximale zuwanderung in einer stunde zurück
	 *
	 * @return int 
	 *
	 */
	public function getMaxNewPeopleInHour()
	{
		if($this->getType()!=22)
		{
			return 0;	
		}	
		$Temp=PEOPLE_MAX_NEW_PEOPLE *$this->i_Level*$this->i_Level;
		return $Temp;
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
		return new Building(0,"","","",0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	}
	
	public function getCountDown($BuildTime=false)
	{
		if($BuildTime)
		{
			return Date::dateFormat($this->getBuildTimeNextLevel());
		}
		$TempDate= Date::dateFormat($this->i_Inbuild-time());
		$Split=explode(":",$TempDate);
		return '
		<div id="CountDownId'.$this->getId().'">'.$TempDate.'</div>
		<script type="text/javascript">
		var MyCountDown'.$this->getId().'= new CountDown('.$Split[0].','.$Split[1].','.$Split[2].',"CountDownId'.$this->getId().'","MyCountDown'.$this->getId().'");
		MyCountDown'.$this->getId().'.start();
		</script>';
	}

	public function getInbuild()
	{
		return $this->i_Inbuild;
	}
	
	
	/**
	 * setzt die bauzeit des gebäudes
	 *
	 * @param int $Time 
	 * @return void 
	 *
	 */
	public function setInbuild($Time)
	{
		$this->i_Inbuild=$Time;
	}
	
	public function getBuildTime()
	{
		return $this->i_BuildTime;
	}
	
	
	/**
	 * gibt die benötigte bauzeit zurück für das aktuelle gebäude
	 *
	 * @return int die zeit für den ausbau des gebäudest
	 *
	 */
	public function getBuildTimeNextLevel()
	{
		/*if($this->i_Level==0)
		{
			return  (int) 3+ pow($this->i_BuildTime,$this->i_Level+1);
		}*/
		$Temp=(int) (3+($this->i_Level+1) * pow($this->i_BuildTime,($this->i_Level+1)))*60;
		if($this->PerCentFaster)
		{
			return $Temp-$Temp*$this->PerCentFaster;
		}
		return  $Temp;
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
		return $this->parseAll($this->t_Description."<br /><br />".$this->getRessourcePerHour());
	}
	
	public function getType()
	{
		return $this->i_Type;
	}
	
	
	public function getMultiplicator()
	{
		return $this->f_Multiplicator;
	}

	public function getResource()
	{
		return $this->s_Resource ;
	}
	
	public function getId()
	{
		return $this->i_Id ;
	}
	public function getName()
	{
		return $this->s_Name ;
	}
	public function getLevel($Integer=false)
	{
		if($Integer)
			return (int) $this->i_Level;
		return  $this->i_Level;
	}
	
	
	
	
	
	
	
	
}



?>