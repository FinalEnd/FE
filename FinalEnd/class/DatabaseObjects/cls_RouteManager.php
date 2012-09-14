<?php

class RouteManager extends SystemManager 
{

	public function updateResources(Planet $Planet)
	{
		$Sql="UPDATE `tbl_planet` SET `i_Metal` = '".$Planet->getMetal()."',
		`i_Hydrogen` = '".$Planet->getHydrogen()."',
		`i_Biomass` = '".$Planet->getBiomass()."',
		`i_Crystal` = '".$Planet->getCrystal()."',
		`i_RefreshTime` = '".$Planet->getRefreshTime()."'
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1";
		//var_dump($Sql);
		return $this->baseNoneGuery($Sql);
	}
	
	 
	/**
	 * fügt eine Route in die Db ein und gibt die Id der neuen Route zurück
	 *
	 * @param Route $Route This is a description
	 * @return int dies ist die Id der Route oder im fehlerfall 0
	 *
	 */
	public function insertRoute(Route $Route)
	{
		$Sql="INSERT INTO `tbl_route` (
			`i_Id` ,
			`s_Name` ,
			`i_UserId` 
			)
			VALUES (
			NULL , '".$Route->getName()."', '".$Route->getUser()->getId()."'
			)";
		//var_dump($Sql);
		$this->baseNoneGuery($Sql);
		$RouteId=$this->getLastInsertId();
		$RoutePointManager= new RoutePointManager();
		foreach($Route->getRoutePointCollection() as $RoutePoint)
		{
			$RoutePointManager->insertRoutePoint($RoutePoint,$RouteId);
		}
		return $RouteId;
	}
	
	
	
	/**
	 * updatet den zähler der Route 
	 *
	 * @param int $RouteId 
	 * @param int $Count 
	 * @return int 
	 *
	 */
	public function updateRouteUnitOrderCount($RouteId,$Count,$UnitId)
	{
		$Sql="UPDATE `tbl_routeunit` SET `i_CurrentPoint` = '".$Count."' 
		WHERE i_RouteId =".$RouteId."
		and i_UnitId=".$UnitId;
		//var_dump($Sql);
		return $this->baseNoneGuery($Sql);
	}
	
	
	
	
	/**
	 * entfernt alle verbindungen der Flotte zur den Routen
	 *
	 * @param Unit $Unit 
	 * @return bool 
	 *
	 */
	public function deleteUnitRouteLink(Unit $Unit)
	{
		$Sql="DELETE FROM `tbl_routeunit` WHERE i_UnitId = ".$Unit->getId();
		return $this->baseNoneGuery($Sql);
	}
	
	
	/**
	 * löscht die angegebene Route aus der DB mit allen Verknüpfunken zu flotten oder sonstigem
	 *
	 * @param RouteFinder $Route 
	 * @return bool 
	 *
	 */
	public function deleteRoute(Route $Route)
	{
		$Sql="DELETE FROM `tbl_routeunit` WHERE i_RouteId =".$Route->getId();
		$this->baseNoneGuery($Sql);
		$Sql="DELETE FROM `tbl_routepoint` WHERE i_RouteId = ".$Route->getId();
		$this->baseNoneGuery($Sql);
		$Sql="DELETE FROM `tbl_route` WHERE `i_Id` =".$Route->getId();
		$this->baseNoneGuery($Sql);
	}
	
	public function insertUnitRouteLink(Unit $Unit,Route $Route,$Loop)
	{
		$Sql="INSERT INTO `tbl_routeunit` (
		`i_Id` ,
		`i_RouteId` ,
		`i_UnitId` ,
		`i_Loop` ,
		`i_CurrentPoint` 
		)
		VALUES (
		NULL , '".$Route->getId()."', '".$Unit->getId()."', '$Loop', '1'
		)";
		return $this->baseNoneGuery($Sql);
	}
	
	
	/**
	 * bearbeite die verbindung der route zur flotte und setzt den aktuellen stand auf 1
	 *
	 * @param Route $Route die Route auf den der neue link verweisen soll
	 * @param Unit $Unit die flotte die die neue Route benutzen soll
	 * @return bool ob es klar ging oder nicht
	 *
	 */
	public function updateRouteUnitlink($RouteId,Unit $Unit)
	{
		$Sql="UPDATE `tbl_routeunit` SET `i_RouteId` = ".$RouteId." ,
		i_CurrentPoint=1 WHERE i_UnitId =".$Unit->getId();
		return $this->baseNoneGuery($Sql);
	}
	
}



?>