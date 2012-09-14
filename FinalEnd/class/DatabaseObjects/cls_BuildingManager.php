<?php




class BuildingManager extends SystemManager
{
	
	
	
	/**
	 * fügt ein neues gebäude zum planeten hinzu WICHTIG prüft ob bereits ein gebäude vorhanden ist und ja wird kein neues gebäude eingefügt
	 *
	 * @param int $PlanetId die Id des Planeten
	 * @param int $BuildingId die Id Des Gebäudes
	 * @return bool obs klar ging oder nicht
	 *
	 */
	private function addBuilding($PlanetId,$BuildingId)
	{
		// checken ob das gebäude bereits in der db ist
		$BuilgFinder= new BuildingFinder();
		$BuildingState=   $BuilgFinder->findBuildingsByPlanetIdAndBuildingId($PlanetId,$BuildingId);	
		if($BuildingState){return false;}   // wenn bereits einen zeile in der db ist dann keine zeile wieder hinzufügen
		$Sql="INSERT INTO `tbl_planetbuildings` (
				`i_Id` ,
				`i_BiuldId` ,
				`i_PlanetId` ,
				`i_Level` ,
				`i_Inbuild` 
				)
				VALUES (
				NULL , '".$BuildingId."', '".$PlanetId."', '1', '0'
				)";	
		//echo $Sql;
				return $this->executeNonQuery($Sql);
	}
	
	
	public  function buildNewBuilding($PlanetId,$BuildingId,$BuildTime)
	{
		$Sql="INSERT INTO `tbl_planetbuildings` (
				`i_Id` ,
				`i_BiuldId` ,
				`i_PlanetId` ,
				`i_Level` ,
				`i_Inbuild` 
				)
				VALUES (
				NULL , '".$BuildingId."', '".$PlanetId."', '0', '".$BuildTime."'
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
	public  function buildBuilding($PlanetId,$BuildingId,$BuildTime)
	{
		$Sql="UPDATE `tbl_planetbuildings` SET `i_Inbuild` = '".$BuildTime."' WHERE 
		`i_PlanetId` =".$PlanetId."
		and
		`i_BiuldId`=".$BuildingId."
		  LIMIT 1";
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	
	
	/**
	 * löscht ein gebäude auf einem Planeten
	 *
	 * @param int $PlanetId die Id
	 * @param int $BuildingId die Id des gebäudes => type des Buildings bennutzen
	 * @return bool 
	 *
	 */
	public  function deleteBuilding($PlanetId,$BuildingId)
	{
		$Sql="DELETE FROM `tbl_planetbuildings`  WHERE 
		`i_PlanetId` =".$PlanetId."
		and
		`i_BiuldId`=".$BuildingId."
		  LIMIT 1";
		return $this->executeNonQuery($Sql);
	}
	
	public  function deleteBuildingsByPlanetId($PlanetId)
	{
		$Sql="DELETE FROM `tbl_planetbuildings`  WHERE `i_PlanetId` =".$PlanetId;
		return $this->executeNonQuery($Sql);
	}
	
	
	public  function resetState($PlanetId)
	{
		$Sql="UPDATE `tbl_planetbuildings` SET 
		`i_Inbuild` = '0',
		 WHERE 
		`i_PlanetId` =".$PlanetId;
		return $this->executeNonQuery($Sql);
	}
	
	
	
	/**
	 * setzt das level des gebäudes nach unten bitte beachte das das level des gebäudes nicht unter 1 gehen sollte da dieses dann gelöscht werden sollte
	 *
	 * @param int $PlanetId 
	 * @param int $BuildingId 
	 * @param int $Level das neue level de gebäudes
	 * @return bool 
	 *
	 */
	public  function destructBuilding($PlanetId,$BuildingId,$Level)
	{
		$Sql="UPDATE `tbl_planetbuildings` SET 
		`i_Inbuild` = '0',
		i_Level=".$Level."
		 WHERE 
		`i_PlanetId` =".$PlanetId."
		and
		`i_BiuldId`=".$BuildingId;
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * setzt die gebäude ein level hinauf wenn sie ausgebaut worden sind 
	 *
	 * @param int $PlanetId 
	 * @return bool 
	 *
	 */
	public  function updateBuildings($PlanetId)
	{
		$Sql="UPDATE `tbl_planetbuildings` SET 
		`i_Inbuild` = '0',
		i_Level=i_Level+1
		 WHERE 
		`i_PlanetId` =".$PlanetId."
		and
		`i_Inbuild`<=".time()."
		and
		i_Inbuild!=0 ";
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	public  function updateBuildingsFromAllUser()
	{
		$Sql="UPDATE `tbl_planetbuildings` SET 
		`i_Inbuild` = '0',
		i_Level=i_Level+1
		 WHERE 
		`i_Inbuild`<=".time()."
		and
		i_Inbuild!=0 ";
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}

	public  function addHQ($PlanetId)
	{
		return $this->addBuilding($PlanetId,1);
	}	
	
	public  function addMetallMine($PlanetId)
	{
		return $this->addBuilding($PlanetId,2);
	}	
	
	
	public  function addTown($PlanetId)
	{
		return $this->addBuilding($PlanetId,22);
	}
	
	public  function addPlantation($PlanetId)
	{
		return $this->addBuilding($PlanetId,4);
	}
	
	public  function addStore($PlanetId)
	{
		return $this->addBuilding($PlanetId,18);
	}
	
	public  function addCrystalMine($PlanetId)
	{
		return $this->addBuilding($PlanetId,5);
	}
	
	public  function addBarracks($PlanetId)
	{
		return $this->addBuilding($PlanetId,6);
	}
	
	
}



?>