<?php

class HeadQuarterBuilding extends Building
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
	

	

	
	
	
	public static function getEmptyInstance()
	{
		return new HeadQuarterBuilding(Building::getEmptyInstance());
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
			$OutPut.= "<td align='center' width='150px' rowspan='1'  ><table width='160px' border='0'><tr><td align='center'>".$this->getCountDown()." <a href='index.php?Section=Building&amp;Action=CancelUpdateBuildings&amp;BuildingId=".$this->i_Type."'>:T_BUILDING_CANCEL:</a><br /></td></tr></table>";
		}else
		{
			$OutPut.= "<td width='150px' rowspan='1'  > 
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
		
		if($this->getLevel()==$this->getMaxLevel())
		{
			$OutPut.= "<tr><td >
			:T_BUILDING_HQ_DESTROY_PLANET_DESCRIPTION:
			<td align='center'>
			<a href='index.php?Section=Planet&amp;Action=DestroyPlanet' onclick='return destroyPlanetBuilding(\":T_BUILDING_HQ_DESTROY_PLANET_JS:\");'>:T_BUILDING_HQ_DESTROY_PLANET_BUTTON_CAPTION:</a>
			</td>
			</tr>
			";
		}
		
		
		
		
		
		$OutPut.=$this->getResourcenHTML();
		
		$OutPut.='</table>
	</td></tr>';	
		return $OutPut;
	}
	
	
	
}
