<?php



	
/**
 * macht alle sql Statmens die mit schiffen oder Gruppen zutun hat
 *
 */
class ShipManager extends SystemManager
{
	
	
	public function addShipBuilding($PlanetId,$ShipId,$Count,$StartTime,$BuildTime)
	{
		$Sql="INSERT INTO `tbl_shipsbuild` (
				`i_Id` ,
				`i_PlanetId` ,
				`i_UnitId` ,
				`i_Count` ,
				`i_StartTime` ,
				`i_BuildTime` 
				)
				VALUES (
				NULL ,".$PlanetId.", '".$ShipId."','".$Count."', '".$StartTime."', '".$BuildTime."'
				)";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	public function deleteShipBuilding($Id)
	{
		$Sql="DELETE FROM `tbl_shipsbuild` WHERE `tbl_shipsbuild`.`i_Id` = ".$Id;	
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * löscht alle schiffe eines Planeten und deren bauaufträge
	 *
	 * @param int $PlanetId 
	 * @return bool 
	 *
	 */
	public function deleteShipByPlanet($PlanetId)
	{
		$Sql="DELETE FROM `tbl_shipplanet` WHERE i_PlanetId = ".$PlanetId;	
		$this->executeNonQuery($Sql);
		$Sql="DELETE FROM `tbl_shipsbuild` WHERE i_PlanetId = ".$PlanetId;	
		$this->executeNonQuery($Sql);
	}
	
	/**
	 * entfertn nichtzulässige schiffe von allen planeten d.h. wenn 0 oder weniger schiffe da sind
	 *
	 * @return int die anzahl an zeilen die gelöscht worden sind
	 *
	 */
	public function deleteInvalidShip()
	{
		$Sql="delete from tbl_shipplanet
		where i_Count <= 0";	
		return $this->executeNonQuery($Sql);
	}
	   
	/**
	    * fügt neue schiffe zu einem planeten in die db ein
	    *
	    * @param int $PlanetId 
	    * @param int $ShipId 
	    * @param int $Count die anzahl wie viele Schiffe eingefügt werden sollen
	    * @return bool 
	    *
	    */
	public function insertShips($PlanetId,$ShipId,$Count)
	{
		 $Sql="INSERT INTO `tbl_shipplanet` (
		`i_Id` ,
		`i_PlanetId` ,
		`i_ShipId` ,
		`i_Count` 
		)
		VALUES (
		NULL , '".$PlanetId."', '".$ShipId."', '".$Count."'
		)";
		return $this->executeNonQuery($Sql);

	}
	
	public function deleteShip($ShipId,$PlanetID)
	{
		$Sql="DELETE FROM `tbl_shipplanet` 
			WHERE 
			i_PlanetId = ".$PlanetID." 
			and
			i_ShipId=".$ShipId;	
		return $this->executeNonQuery($Sql);
	}
	
	
	 /**
	  * entfent die angegebene anzahl an schiffen vom planeten
	  *
	  * @param int $ShipId die Id des Schiffes
	  * @param int $PlanetId 
	  * @param int $Count die anzahl die weggenommen werden soll 
	  * @return bool 
	  *
	  */
	 public function subductShips($ShipId,$PlanetId,$Count)
	{
		$ShipFinder= new ShipFinder();
		$ShipCount=$ShipFinder->findCountByPlanetAndShipID($PlanetId,$ShipId);// schiffe count suchen
		$this->deleteShip(	$ShipId,$PlanetId);									// zum entferenen und neu ordnen der db alles entfernen
		$this->insertShips($PlanetId,$ShipId,$ShipCount-$Count);				// neuen schiffs bestand eintragen
	}
	
	
	
}



?>