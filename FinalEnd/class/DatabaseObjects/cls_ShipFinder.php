<?php

class ShipFinder extends SystemFinder 
{

	
		/**
	 * mappt die ergebnissmengeauf eine NewsCollection 
	 *
	 * @param array $RecordSet
	 * @return ShipCollection
	 */
	private function doLoadShips($RecordSet)
	{
		$ShipCollection = new ShipCollection();
		try
		{
			foreach ($RecordSet as $Row)
			{
				$ShipCollection->add($this->loadShip($Row),$Row['i_Count']);
			}
			return $ShipCollection;
		}catch(Exception $e)
		{
			echo $e->message();
			return $ShipCollection;
		}
	}
	
	protected function loadShip($Result)
	{
		return $this->findById($Result['i_ShipId']);
	}	
	
	/**
	 * mappt die ergebnissmengeauf eine NewsCollection 
	 *
	 * @param array $RecordSet
	 * @return ShipCollection
	 */
	private function doLoad($RecordSet)
	{
		$ShipCollection = new ShipCollection();
		
		foreach ($RecordSet as $Row)
		{
			$ShipCollection->add($this->load($Row));
		}
		return $ShipCollection;
	}
	
	protected function load($Result)
	{
		return new Ship($Result['i_Id'],$Result['s_Name'],   $Result['i_Speed'],$Result['i_Amor'],$Result['i_Dmg'],$Result['i_Health'],	$Result['i_Credits'],  $Result['i_Metall'],$Result['i_Cristal'],$Result['t_Hydrogen'],$Result['t_Buildtime'],$Result['i_Storage'],$Result['i_Crew']);
	}	
	
	/**
	 * gibt die bauauftrüge des planeten zurück
	 *
	 * @param array $RecordSet mit den daten aus der sb
	 * @return ShipBuildCollection 
	 *
	 */
	private function doLoadBuild($RecordSet)
	{
		$ShipBuildCollection = new ShipBuildCollection();
		
		foreach ($RecordSet as $Row)
		{
			$ShipBuildCollection->add($this->loadBuild($Row));
		}
		return $ShipBuildCollection;
	}
	
	protected function loadBuild($Result)
	{
		$Ship= $this->findById($Result['i_UnitId']);
		return new ShipBuild($Result['i_Id'],$Result['i_PlanetId'],$Ship,$Result['i_Count'],$Result['i_StartTime'],$Result['i_BuildTime']);
	}
	
	
	
	/**
	 * sucht in der Datenbank nach alle schiffen die vorhanden sind
	 *
	 * @return ShipCollection 
	 *
	 */
	public function findAll()
	{
		$Sql="SELECT i_Id,s_Name,i_Speed,i_Amor,i_Dmg,i_Health,i_Credits,i_Metall,i_Cristal,t_Hydrogen,t_Buildtime,i_Storage,i_Crew FROM `tbl_ships` ORDER BY i_Dmg";
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	/**
	 * sucht in der Datenbank nach alle schiffen die vorhanden sind
	 *
	 * @return ShipCollection 
	 *
	 */
	public function findById($Id)
	{
		$Sql="SELECT i_Id,s_Name,i_Speed,i_Amor,i_Dmg,i_Health,i_Credits,i_Metall,i_Cristal,t_Hydrogen,t_Buildtime,i_Storage,i_Crew FROM `tbl_ships` where i_Id=".$Id;
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	
	/**
	* gibt die bauauftrüge des planeten zurück
	*
	* @param array $RecordSet mit den daten aus der sb
	* @return ShipBuildCollection 
	*
	*/
	public function findShipBuildingByPlanetId($PlanetId)
	{
		$Sql="SELECT i_Id, i_PlanetId  ,i_UnitId  , i_Count	,i_StartTime,i_BuildTime
			FROM `tbl_shipsbuild` where i_PlanetId=".$PlanetId;
		return $this->doLoadBuild($this->executeQuery($Sql));
	}

	public function countShipBuildingByPlanetId($PlanetId)
	{
		$Sql="SELECT count( i_Id ) AS Count
			FROM `tbl_shipsbuild` 
			WHERE i_PlanetId =".$PlanetId;
		$Temp=$this->executeQuery($Sql);
		
		return $Temp[0]['Count'];
	}
	/**
	* zählt die forschungen die gerade geforscht werden
		 *
	* @param int $PlanetId
	* @return int kann null sein
		 *
		 */
	public function countShipsInBuild($PlanetId)
	{
		$Sql="SELECT count( * ) AS Count
			FROM tbl_shipsbuild 
			WHERE `i_PlanetId` =".$PlanetId;
		$Temp=$this->executeQuery($Sql);
		return $Temp['0']['Count'];
	}


															
	/**
	 * gibt alle bauaufträge der schiffe zurück die bearbeitet werden müssen
	 *
	 * @param int $PlanetId die Planeten id
	 * @return ShipBuildCollection 
	 *
	 */
	public function findShipBuildingByPlanetIdWhereMustBuild($PlanetId)
	{
		$TimeNow= microtime(true);	
		$Sql="SELECT i_Id, i_PlanetId  ,i_UnitId  , i_Count	,i_StartTime,i_BuildTime
			FROM `tbl_shipsbuild` where i_PlanetId=".$PlanetId." and	
			i_StartTime <= ".$TimeNow."-(i_BuildTime*i_Count)";
		return $this->doLoadBuild($this->executeQuery($Sql));
	}

	public function findAllShipsByPlanet($PlanetId)
	{
		$Sql="SELECT i_Id,i_PlanetId,i_ShipId,i_Count FROM `tbl_shipplanet` where i_PlanetId=".$PlanetId;
		return $this->doLoadShips($this->executeQuery($Sql));
	}
	
	
	public function findCountByPlanetAndShipID($PlanetId,$ShipId)
	{
		$Sql="SELECT sum( i_Count ) AS Count
				FROM `tbl_shipplanet` 
				WHERE `i_PlanetId` =".$PlanetId."
				AND `i_ShipId` =".$ShipId;
		$TempArry=$this->executeQuery($Sql);
		return	$TempArry[0]['Count'];
		
	}
	
}



?>