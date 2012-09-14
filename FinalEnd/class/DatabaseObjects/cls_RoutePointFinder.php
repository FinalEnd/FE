<?php

class RoutePointFinder extends SystemFinder 
{
	 private $RouteId=0;
	/**
	 * mappt die ergebnissmengeauf eine NewsCollection 
	 *
	 * @param array $RecordSet
	 * @return NewsCollection
	 */
	private function doLoad($RecordSet)
	{
		$RoutePointCollection = new RoutePointCollection();
		
		foreach ($RecordSet as $Row)
		{
			$RoutePointCollection->add($this->load($Row));
		}
		return $RoutePointCollection;
	}
	
	protected function load($Result)
	{
		$RoutePiont= new RoutePoint($Result['i_Id'],$Result['i_X'],$Result['i_Y'],$Result['i_Action'],$Result['t_Extention'],$Result['i_RouteId'],$Result['i_Order']);
		return $RoutePiont;
	}
	
	
	/**
	 * findet das objekt mit der angegebenen ID	ohne verknüpfung zu einem planeten
	 *
	 * @param int $Id 
	 * @return ReSearch 
	 *
	 */
	public function findByRouteId($RouteId)
	{
		$Sql="SELECT i_Id,i_RouteId,i_X,i_Y,i_Action,t_Extention,i_Order
		FROM tbl_routepoint
		WHERE i_RouteId =".$RouteId."
		ORDER BY `i_Order` ASC";
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	public function findById($Id)
	{
		$Sql="SELECT i_Id,i_RouteId,i_X,i_Y,i_Action,t_Extention,i_Order
		FROM tbl_routepoint
		WHERE i_Id =".$Id."
		ORDER BY `i_Order` ASC";
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	

	
}



?>