<?php

class RouteFinder extends SystemFinder 
{
	
	/**
	 * mappt die ergebnissmengeauf eine NewsCollection 
	 *
	 * @param array $RecordSet
	 * @return NewsCollection
	 */
	private function doLoad($RecordSet)
	{
		$RouteCollection = new RouteCollection();
		
		foreach ($RecordSet as $Row)
		{
			$RouteCollection->add($this->load($Row));
		}
		return $RouteCollection;
	}
	
	protected function load($Result)
	{
		$RoutePointFinder= new RoutePointFinder();
		$UserFinder= new UserFinder();
		$User=$UserFinder->findById($Result['i_UserId']);
		$UnitsOnRoute=$this->countUnitsOnRoute($Result['i_Id']);
		$UnitFinder=new UnitFinder();
		if(!$Result['i_UnitId'])
		{
			$Unit= Unit::getEmptyInstance();
		}else
		{
			$Unit=$UnitFinder->findById($Result['i_UnitId']);
		}
		$Route= new Route($Result['i_Id'],
			$Result['s_Name'],
			$Unit,
			$User,
			$RoutePointFinder->findByRouteId($Result['i_Id']),
			$UnitsOnRoute,(int) $Result['i_CurrentPoint'],$Result['i_Loop']);
		return $Route;
	}
	
	
	
	public function countUnitsOnRoute($RouteId)
	{
		$Sql="SELECT count(tbl_routeunit.i_Id) as Count
		FROM `tbl_routeunit` where tbl_routeunit.i_RouteId=".$RouteId;
		$Temp=$this->executeQuery($Sql);
		return $Temp[0]['Count'];
	}
	
	
	public function findByUnit(Unit $Unit)//
	{
		$Sql="SELECT R.i_Id, R.s_Name, R.i_UserId, RU.i_UnitId, RU.i_Loop, RU.i_CurrentPoint
FROM tbl_routeunit AS RU, tbl_route AS R
WHERE R.i_Id = RU.i_RouteId
AND i_UnitId =".$Unit->getId();
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	private function findUnitExtention($RouteId)
	{
		$Sql="SELECT i_Id,i_UnitId,i_Loop,i_CurrentPoint
		FROM tbl_routeunit
		WHERE i_RouteId =".$RouteId;
		return $this->executeQuery($Sql);
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
		$Sql="SELECT R.i_Id, R.s_Name, R.i_UserId
FROM tbl_route AS R
WHERE R.i_Id =".$Id;
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	
	public function findByAll()
	{
		$Sql="SELECT i_Id,s_Name,i_UserId
		FROM tbl_route";
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	/**
	 * gibt genau eine Route zurück oder eine null Route !! gibt keine auskunft wieviele Route mit dem namen von diesem Spieler es in der db gibt
	 *
	 * @param strign $Name der name der Route
	 * @param int $UserId die Id des Users
	 * @return Route This is the return value description
	 *
	 */
	public function findByNameAndUserId($Name,$UserId)
	{
		$Sql="SELECT R.i_Id, R.s_Name, R.i_UserId, RU.i_UnitId, RU.i_Loop, RU.i_CurrentPoint
		FROM tbl_routeunit AS RU, tbl_route AS R
		WHERE R.i_Id = RU.i_RouteId
		and R.s_Name='".$Name."'
		AND R.i_UserId =".$UserId;
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	
	
	public function findByUserId($UserId)
	{
		$Sql="SELECT R.i_Id, R.s_Name, R.i_UserId, RU.i_UnitId
FROM tbl_route AS R,tbl_routeunit AS RU
WHERE R.i_UserId =".$UserId;
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	public function findByUserIdSingleRouts($UserId)
	{
		$Sql="SELECT R.i_Id, R.s_Name, R.i_UserId
FROM tbl_route AS R
WHERE R.i_UserId =".$UserId;
		return $this->doLoad($this->executeQuery($Sql));
	}
	

	
}



?>