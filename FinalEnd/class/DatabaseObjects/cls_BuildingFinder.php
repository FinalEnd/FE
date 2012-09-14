<?php

class BuildingFinder extends SystemFinder 
{
	
	/**
	 * mappt die ergebnissmengeauf eine NewsCollection 
	 *
	 * @param array $RecordSet
	 * @return NewsCollection
	 */
	private function doLoad($RecordSet)
	{
		$BuildingCollection = new BuildingCollection();
		
		foreach ($RecordSet as $Row)
		{
			$BuildingCollection->add($this->load($Row));
		}
		return $BuildingCollection;
	}
	
	protected function load($Result)
	{
		switch($Result['i_Type'])
		{
			
			case 1:
			{
				$Building= new HeadQuarterBuilding($Result['i_Id'],$Result['s_Name'],$Result['t_Description'],$Result['s_Picture'],$Result['f_Multiplicator'],
					$Result['s_Resource'],$Result['i_BuildTime'],0,$Result['i_PlanetId'],$Result['i_Level'],$Result['i_Inbuild'],
					$Result['i_BuildCredits'],$Result['i_BuildMetall'],$Result['i_BuildCrystal'],$Result['i_BuildHydrogen'],$Result['i_BuildBioMass'],$Result['i_Type'],$Result['i_NeedLevel'],$Result['i_Need'],$Result['i_MaxLevel']);
			}break;
			
			
			case 23:
				{
					$Building= new PlanetProtectionBuilding($Result['i_Id'],$Result['s_Name'],$Result['t_Description'],$Result['s_Picture'],$Result['f_Multiplicator'],
						$Result['s_Resource'],$Result['i_BuildTime'],0,$Result['i_PlanetId'],$Result['i_Level'],$Result['i_Inbuild'],
						$Result['i_BuildCredits'],$Result['i_BuildMetall'],$Result['i_BuildCrystal'],$Result['i_BuildHydrogen'],$Result['i_BuildBioMass'],$Result['i_Type'],$Result['i_NeedLevel'],$Result['i_Need'],$Result['i_MaxLevel']);
				}break;

				
				
				default:
				$Building= new Building($Result['i_Id'],$Result['s_Name'],$Result['t_Description'],$Result['s_Picture'],$Result['f_Multiplicator'],
					$Result['s_Resource'],$Result['i_BuildTime'],0,$Result['i_PlanetId'],$Result['i_Level'],$Result['i_Inbuild'],
					$Result['i_BuildCredits'],$Result['i_BuildMetall'],$Result['i_BuildCrystal'],$Result['i_BuildHydrogen'],$Result['i_BuildBioMass'],$Result['i_Type'],$Result['i_NeedLevel'],$Result['i_Need'],$Result['i_MaxLevel']);

		}
		return $Building;
	}
	
	public function findById($Id)
	{
		$Sql="SELECT tbl_planetbuildings.i_Id AS i_Id,tbl_buildings.i_Id AS i_Type, s_Name, t_Description, s_Picture, f_Multiplicator, s_Resource, i_BuildTime, i_PlanetId, i_Level,
		 i_Inbuild,i_BuildCredits, i_BuildMetall, i_BuildCrystal, i_BuildHydrogen, i_BuildBioMass,i_NeedLevel,i_Need,i_MaxLevel
				FROM tbl_buildings
				RIGHT JOIN tbl_planetbuildings ON tbl_buildings.i_Id = tbl_planetbuildings.i_BiuldId
				where i_Id=".$Id;
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	/**
	 * gibt den namen des gesuchten gebäudes zurück 
	 * es kann ein leerstring zurück kommen 
	 * 
	 */
	public function findNameById($Id)
	{
		$Sql="SELECT s_Name
				FROM tbl_buildings
				where i_Id=".$Id;
		 $Temp=$this->executeQuery($Sql);
		return $Temp[0]['s_Name'];
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	public function findByPlanetId($PlanetId)
	{
		$Sql="SELECT tbl_planetbuildings.i_Id AS i_Id,tbl_buildings.i_Id AS i_Type, s_Name, t_Description, s_Picture, f_Multiplicator, s_Resource, i_BuildTime, i_PlanetId, i_Level, i_Inbuild,i_BuildCredits,i_BuildMetall,i_BuildCrystal,i_BuildHydrogen,i_BuildBioMass,i_NeedLevel,i_Need,i_MaxLevel
				FROM tbl_buildings
				RIGHT JOIN tbl_planetbuildings ON tbl_buildings.i_Id = tbl_planetbuildings.i_BiuldId
				where i_PlanetId=".$PlanetId." ORDER BY `tbl_buildings`.`i_sort` ASC";
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	/**
	 * gibt die anzahl der gebäude zurück die sich momentan im bau befinden
	 *
	 * @param int $PlanetId die Id des Planeten
	 * @return int 
	 *
	 */
	public function countBuildingsInBuild($PlanetId)
	{
		$Sql="SELECT count( * ) AS Count
			FROM `tbl_planetbuildings` 
			WHERE `i_PlanetId` =".$PlanetId."
			AND i_Inbuild !=0";	
		$Temp=$this->executeQuery($Sql);
		return $Temp['0']['Count'];
	}
	
	
	
	/**
	 * findet alle gebäude die gebaut werden können, diese gebäude sind nicht verknüpft !!!
	 *
	 * @return BuildingCollection 
	 *
	 */
	public function findAllAvavibelBuildings()
	{
		$Sql="SELECT tbl_buildings.i_Id AS i_Id, tbl_buildings.i_Id AS i_Type, s_Name, t_Description, s_Picture, f_Multiplicator, s_Resource, i_BuildTime,  i_BuildCredits, i_BuildMetall, i_BuildCrystal, i_BuildHydrogen, i_BuildBioMass,i_NeedLevel,i_Need,i_MaxLevel
FROM tbl_buildings";
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}


	
	 
	/**
	 * gibt true zurück wenn eine Zeile bereits in der DB exsistiert oder false wenn nicht
	 *
	 * @param int $PlanetId die Id des Planeten
	 * @param int $BuildingId die Id Des gebäudes
	 * @return bool 
	 *
	 */
	public function findBuildingsByPlanetIdAndBuildingId($PlanetId,$BuildingId)
	{
		$Sql="SELECT Count(i_Id) as Count FROM `tbl_planetbuildings` WHERE i_PlanetId=".$PlanetId." and i_BiuldId=".$BuildingId;
		$Temp=$this->executeQuery($Sql);
		
		return $Temp[0]['Count'];
		
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	/**
	 * gibt das level des gebäudes an
	 *
	 * @param int $PlanetId 
	 * @param int $BuildingId 
	 * @return int kann null sein
	 *
	 */
	public function findLevelByPlanetAndBuildingId($PlanetId,$BuildingId)
	{
		$Sql="SELECT i_Level 
		FROM `tbl_planetbuildings` 
		WHERE `i_BiuldId` =".$BuildingId."
		AND `i_PlanetId` =".$PlanetId;
		$Temp=$this->executeQuery($Sql);
		
		return $Temp[0]['i_Level'];
	}	
}



?>