<?php

class RoutePointManager extends SystemManager 
{

	public function insertRoutePoint(RoutePoint $RoutePoint,$RouteId)
	{
		$Sql="INSERT INTO `tbl_routepoint` (
		`i_Id` ,
		`i_RouteId` ,
		`i_X` ,
		`i_Y` ,
		`i_Action` ,
		`t_Extention` ,
		`i_Order` 
		)
		VALUES (
		NULL , '".$RouteId."', '".$RoutePoint->getX()."', '".$RoutePoint->getY()."', '".$RoutePoint->getAction()."', '".$RoutePoint->getExtentionString()."', '".$RoutePoint->getOrder()."'
		)";
		return $this->baseNoneGuery($Sql);
	}
	
	
}



?>