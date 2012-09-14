<?php

class ReSearchFinder extends SystemFinder 
{
	
	/**
	 * mappt die ergebnissmengeauf eine NewsCollection 
	 *
	 * @param array $RecordSet
	 * @return NewsCollection
	 */
	private function doLoad($RecordSet)
	{
		$ReSearchCollection = new ReSearchCollection();
		
		foreach ($RecordSet as $Row)
		{
			$ReSearchCollection->add($this->load($Row));
		}
		return $ReSearchCollection;
	}
	
	protected function load($Result)
	{
		$ReSearch= new ReSearch($Result['i_Id'],$Result['s_Name'],$Result['t_Desctiprion'],$Result['s_Picture'],$Result['f_Multiplicator'],$Result['i_BuildTime']  ,
			$Result['ResearchId'],$Result['i_PlanetId'],$Result['i_Level'],$Result['i_Inbuild'],$Result['i_BuildCredits'],$Result['i_BuildMetall'],$Result['i_BuildCrystal'],
			$Result['i_BuildHydrogen']   ,$Result['i_BuildBioMass'],$Result['i_Type']  ,$Result['i_NeedLevel'],$Result['i_Need'],$Result['i_MaxLevel'] );
		return $ReSearch;
	}
	
	
	/**
	 * findet das objekt mit der angegebenen ID	ohne verknüpfung zu einem planeten
	 *
	 * @param int $Id 
	 * @return ReSearch 
	 *
	 */
	public function findById($Id)
	{
		$Sql="SELECT tbl_research.i_Id AS ResearchId, s_Name, t_Desctiprion, s_Picture, i_Type, i_BuildTime, f_Multiplicator, i_BuildCredits, i_BuildMetall, i_BuildCrystal, i_BuildHydrogen, i_BuildBioMass, i_NeedLevel, i_Need, i_MaxLevel
		FROM tbl_research
		WHERE i_Id =".$Id;
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	
	
	
	
	/**
	 * zählt die forschungen die gerade geforscht werden
	 *
	 * @param int $PlanetId
	 * @return int kann null sein
	 *
	 */
	public function countReSearchsInBuild($PlanetId)
	{
		$Sql="SELECT count( * ) AS Count
			FROM tbl_planetresearch 
			WHERE `i_PlanetId` =".$PlanetId."
			AND i_Inbuild !=0";	
		$Temp=$this->executeQuery($Sql);
		return $Temp['0']['Count'];
	}
	
	
	
	public function findByPlanetId($PlanetId)
	{
		$Sql="SELECT tbl_planetresearch.i_Id AS i_Id,tbl_research.i_Id AS ResearchId, s_Name, t_Desctiprion,s_Picture, i_Type,i_BuildTime,f_Multiplicator,i_BuildCredits,
		i_BuildMetall,i_BuildCrystal,i_BuildHydrogen ,i_BuildBioMass,i_NeedLevel,i_Need,i_PlanetId,i_Level,i_Inbuild,i_MaxLevel
				FROM tbl_research
				RIGHT JOIN tbl_planetresearch ON tbl_research.i_Id = tbl_planetresearch.i_ResearchId
				where i_PlanetId=".$PlanetId;
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	/**
	 * findet alle gebäude die gebaut werden können, diese gebäude sind nicht verknüpft !!!
	 *
	 * @return BuildingCollection 
	 *
	 */
	public function findAllAvavibelReSearch()
	{
		$Sql="SELECT i_Id ,tbl_research.i_Id AS ResearchId,s_Name,t_Desctiprion,s_Picture,i_Type ,i_BuildTime ,f_Multiplicator,i_BuildCredits,i_BuildMetall ,i_BuildCrystal,i_BuildHydrogen,i_BuildBioMass,i_NeedLevel,i_Need,i_MaxLevel
FROM tbl_research";
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}

		
}



?>