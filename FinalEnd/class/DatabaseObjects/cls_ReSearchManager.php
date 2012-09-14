<?php




class ReSearchManager extends SystemManager
{
	
	
	public function addReSearch($PlanetId,$ReSearchId)
	{
		$Sql="INSERT INTO `tbl_planetresearch` (
`i_Id` ,
`i_ResearchId` ,
`i_PlanetId` ,
`i_Level` ,
`i_Inbuild` 
)
VALUES (
NULL , '".$ReSearchId."', '".$PlanetId."', '0', '0'
)";	
		//echo $Sql;
				return $this->executeNonQuery($Sql);
	}
	
	
	public  function buildNewReSearch($PlanetId,$ReSearchId,$BuildTime)
	{
		$Sql="INSERT INTO `tbl_planetbuildings` (
				`i_Id` ,
				`i_BiuldId` ,
				`i_PlanetId` ,
				`i_Level` ,
				`i_Inbuild` 
				)
				VALUES (
				NULL , '".$BuildingId."', '".$PlanetId."', 0, 0
				)";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	
	
	/**
	 * setzt ein gebäude in den bauzustand
	 *
	 * @param int $PlanetId die Id des Planeten
	 * @param int $BuildingId das gebäude das gebaut werden soll
	 * @param int $BuildTime die aktuelle zeit + die zeit die gebaut werden soll in milisekunden
	 * @return Bool 
	 *
	 */
	public  function buildReSearch($PlanetId,$ReSearchId,$BuildTime)
	{
		$Sql="UPDATE `tbl_planetresearch` SET `i_Inbuild` = '".$BuildTime."' 
		WHERE 
		`i_PlanetId` =".$PlanetId." 
		and
		`i_ResearchId`=".$ReSearchId."
		  LIMIT 1";
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * setzt die bauzeit der Forschung 
	 *
	 * @param int $ReSearchId 
	 * @param int $BuildTime die zeit in sekunden
	 * @return bool 
	 *
	 */
	public  function setReSearchTime($ReSearchId,$BuildTime)
	{
		$Sql="UPDATE `tbl_planetresearch` SET `i_Inbuild` = '".$BuildTime."' 
		WHERE 
		i_Id =".$ReSearchId." LIMIT 1";
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	public  function updateReSearchs($PlanetId)
	{
		$Sql="UPDATE `tbl_planetresearch` SET 
		`i_Inbuild` = '0',
		i_Level=i_Level+1
		 WHERE 
		`i_PlanetId` =".$PlanetId."
		and
		`i_Inbuild`<=".microtime(true)."
		and
		i_Inbuild!=0 ";
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * löscht eine forschung des angegebenen planeten
	 *
	 * @param int $PlanetId 
	 * @param int $ReSearchId 
	 * @return bool 
	 *
	 */
	public  function deleteReSearch($PlanetId,$ReSearchId)
	{
		$Sql="DELETE FROM `tbl_planetresearch`  WHERE 
		`i_PlanetId` =".$PlanetId."
		and
		`i_ResearchId`=".$ReSearchId."
		  LIMIT 1";
		return $this->executeNonQuery($Sql);
	}
	
	public  function deleteReSearchsByPlanetId($PlanetId)
	{
		$Sql="DELETE FROM `tbl_planetresearch`  WHERE 
		`i_PlanetId` =".$PlanetId;
		return $this->executeNonQuery($Sql);
	}
	

	public  function addHQ($PlanetId)
	{
		return $this->addBuilding($PlanetId,1);
	}	
	

	
}



?>