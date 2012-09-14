<?php

class PlanetFinder extends SystemFinder 
{
	
	/**
	 * mappt die ergebnissmengeauf eine NewsCollection 
	 *
	 * @param array $RecordSet
	 * @return NewsCollection
	 */
	private function doLoad($RecordSet)
	{
		$NewsCollection = new PlanetCollection();
		
		foreach ($RecordSet as $Row)
		{
			$NewsCollection->add($this->load($Row));
		}
		return $NewsCollection;
	}
	
	protected function load($Result)
	{
		$Userfinder= new UserFinder();
		$TempUser= $Userfinder->findById($Result['i_UserId']);
		$BuildingFinder= new BuildingFinder();
		$ShipFinder= new ShipFinder();
		$ShipCollection=$ShipFinder->findAllShipsByPlanet($Result['i_Id'])   ;
		$ShipCollection=$ShipCollection->merge();   // schiffe zusammen führen die in seperaten datensätzen aus der db kommen
		$BuildingCollection= $BuildingFinder->findByPlanetId($Result['i_Id']);
		$ReSearchFinder= new ReSearchFinder();
		$ReSearchCollection= $ReSearchFinder->findByPlanetId($Result['i_Id']);
		
		$ShipBuildCount=$ShipFinder->countShipBuildingByPlanetId($Result['i_Id']);// die schiffe die momentan gebaut werden
		
		$Planet= new Planet($Result['i_Id'],$Result['s_Name'],$TempUser,$Result['i_Size'],$Result['s_Weight'],$Result['i_Type'],$Result['s_Picture'],$Result['i_RefreshTime'],$Result['i_Metal'],$Result['i_Hydrogen'],$Result['i_Biomass'],$Result['i_Crystal'],$Result['i_X'],$Result['i_Y'],$BuildingCollection,$ShipCollection,$ReSearchCollection
			,$Result['i_PeopleCount'],$Result['f_Satisfaction'],$Result['f_Tax']);
		$Planet->setShipBuildCount($ShipBuildCount);
		return $Planet;
	}
	
	
	/**
	 * gibt ein array mit i_X,i_Y und Alpha zurück auf das alpha muss noch cosinus ^-1 gemacht werden um den winkelbestimmen zu können da mysql kein cos ^-1 besitzt
	 *
	 * @return array	
	 *
	 */
	public function findFallesAway()
	{
		$Sql="SELECT i_X,i_Y, 
			(i_X/(
			SQRT(POW(i_X,2)+POW(i_Y,2))
			))as Alpha
			,SQRT( pow( 100000-i_X , 2 ) + pow( 100000-i_Y , 2 ) )  as MaxRange
			FROM `tbl_planet`
			where SQRT( pow( 100000-i_X , 2 ) + pow( 100000-i_Y , 2 ) ) =(select max(SQRT( pow( 100000-i_X , 2 ) + pow( 100000-i_Y , 2 ) ) ) from tbl_Planet)";
		$Temp= $this->executeQuery($Sql);
		return $Temp[0];
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	
	 
	/**
	 * !!!eval!!! gibt die komplette bevölkerung aller planeten an diese funktion funktioniert nicht richtig mysql macht müll wenn die bevölkerung zu groß ist
	 *
	 * @param User $User This is a description
	 * @return int 
	 *
	 */
	public function countAllPeopleByUser(User $User)
	{
		$Sql="SELECT SUM( i_PeopleCount ) AS Count
			FROM `tbl_planet` 
			WHERE i_UserId =".$User->getId();
		$Temp= $this->executeQuery($Sql);
		return $Temp[0]['Count'];
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	
	/**
	 * findet alle Planeten des Users
	 *
	 * @param mixed $UserId This is a description
	 * @return mixed This is the return value description
	 *
	 */
	public function findArrayByUserId(User $User)
	{
		$Sql="SELECT i_Id, s_Name, i_UserId, (

SELECT count( i_Id ) 
FROM `tbl_planetbuildings` 
WHERE i_PlanetId = `tbl_planet`.i_Id
AND i_Inbuild !=0
) AS BuildingCount, (

SELECT count( i_Id ) 
FROM `tbl_planetresearch` 
WHERE i_PlanetId = `tbl_planet`.i_Id
AND i_Inbuild !=0
) AS ResearchCount, (

SELECT count( i_Id ) 
FROM `tbl_shipsbuild` 
WHERE i_PlanetId = `tbl_planet`.i_Id
) AS ShipBuildCount
FROM `tbl_planet` 
WHERE i_UserId =".$User->getId()."
ORDER BY s_Name";
		return $this->executeQuery($Sql);

		//return $this->doLoad($this->MySql->getResult());
	}
	/**
	 * findet die Credits des Spielers
	 *
	 * @param User $User 
	 * @return float 
	 *
	 */
	public function findCreditsByUser(User $User)
	{
		$Sql="SELECT sum( ( ".CREDITS_PRE." * ( LN( i_PeopleCount /".PEOPLE_MAX_STORE_PRE." ) / LN( ".PEOPLE_MAX_STORE_SUF." ) ) * ( LN( i_PeopleCount /".PEOPLE_MAX_STORE_PRE." ) / LN( ".PEOPLE_MAX_STORE_SUF." ) ) ) + (".CREDITS_SUF.") * ( LN( i_PeopleCount /".PEOPLE_MAX_STORE_PRE." ) / LN( ".PEOPLE_MAX_STORE_SUF." ) ) ) AS Credits
		FROM `tbl_planet` 
		WHERE i_UserId =".$User->getId();
		$Temp= $this->executeQuery($Sql);
		return $Temp[0]['Credits'];
	}
	
	public function findCreditsByUserAndPlanet(User $User,Planet $Planet)
	{
		$Sql="SELECT sum( ( ".CREDITS_PRE." * ( LN( i_PeopleCount /".PEOPLE_MAX_STORE_PRE." ) / LN( ".PEOPLE_MAX_STORE_SUF." ) ) * ( LN( i_PeopleCount /".PEOPLE_MAX_STORE_PRE." ) / LN( ".PEOPLE_MAX_STORE_SUF." ) ) ) + (".CREDITS_SUF.") * ( LN( i_PeopleCount /".PEOPLE_MAX_STORE_PRE." ) / LN( ".PEOPLE_MAX_STORE_SUF." ) ) ) AS Credits
		FROM `tbl_planet` 
		WHERE i_UserId =".$User->getId()."
		and i_Id=".$Planet->getId();
		$Temp= $this->executeQuery($Sql);
		return $Temp[0]['Credits'];
	}
	
	public function findByUserId($Id)
	{
		$Sql="SELECT i_Id,s_Name,i_UserId,i_Size,s_Weight,i_Type,s_Picture,i_RefreshTime,i_Metal,i_Hydrogen,i_Biomass,i_Crystal,i_X,i_Y,i_PeopleCount ,f_Satisfaction,f_Tax
				FROM `tbl_planet` 
				where i_UserId=".$Id."
ORDER BY s_Name";
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	public function findById($Id)
	{
		$Sql="SELECT i_Id,s_Name,i_UserId,i_Size,s_Weight,i_Type,s_Picture,i_RefreshTime,i_Metal,i_Hydrogen,i_Biomass,i_Crystal,i_X,i_Y,i_PeopleCount ,f_Satisfaction,f_Tax
				FROM `tbl_planet` 
				where i_Id=".$Id;
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
		//return $this->doLoad($this->MySql->getResult());
	}
	
	/**
	 * läd alle news die in der db vorhanden sind
	 *
	 * @return PlanetCollection
	 */
	public function findNewPlanet($Limit)
	{
		$Sql="SELECT i_Id,s_Name,i_UserId,i_Size,s_Weight,i_Type,s_Picture,i_RefreshTime,i_Metal,i_Hydrogen,i_Biomass,i_Crystal,i_X,i_Y,i_PeopleCount ,f_Satisfaction,f_Tax
				FROM `tbl_planet`
			    ORDER BY i_Id DESC
			    LIMIT ".$Limit;	
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	public function findAll()
	{
		$Sql="SELECT i_Id,s_Name,i_UserId,i_Size,s_Weight,i_Type,s_Picture,i_RefreshTime,i_Metal,i_Hydrogen,i_Biomass,i_Crystal,i_X,i_Y,i_PeopleCount ,f_Satisfaction,f_Tax
				FROM `tbl_planet`";
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	public function findAllBetweenKoordinates($StartX,$StartX2,$StartY,$StartY2)
	{
		$Sql="SELECT i_Id, s_Name, i_UserId, i_Size, s_Weight, i_Type, s_Picture, i_RefreshTime, i_Metal, i_Hydrogen, i_Biomass, i_Crystal, i_X, i_Y,i_PeopleCount ,f_Satisfaction,f_Tax
			FROM `tbl_planet` 
			WHERE i_X
			BETWEEN ".$StartX." 
			AND ".$StartX2." 
			AND i_Y
			BETWEEN ".$StartY." 
			AND ".$StartY2."
ORDER BY s_Name";
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	/**
	 * Findet alle Planeten in Unmittelbarer näher aller units der collection
	 *
	 * @param UnitCollection $UnitCollection This is a description
	 * @return mixed This is the return value description
	 *
	 */
	public function findByUnitCollection(UnitCollection $UnitCollection)
	{
		$TempPlanetCollection = new PlanetCollection();
		foreach($UnitCollection as $Unit)
		{
			$TempPlanetCollection->add($this->findAllByKoordinates($Unit->getX(), $Unit->getY(), UNIT_REPAIR_RANGE)->getByIndex(0));
			
		}
		return $TempPlanetCollection;
	}
	
	public function findAllBetweenKoordinatesAndUserId($UserId,$StartX,$StartX2,$StartY,$StartY2)
	{
		$Sql="SELECT i_Id, s_Name, i_UserId, i_Size, s_Weight, i_Type, s_Picture, i_RefreshTime, i_Metal, i_Hydrogen, i_Biomass, i_Crystal, i_X, i_Y,i_PeopleCount ,f_Satisfaction,f_Tax
			FROM `tbl_planet` 
			WHERE
			i_Id=".$UserId."
			and
			 i_X
			BETWEEN ".$StartX." 
			AND ".$StartX2." 
			AND i_Y
			BETWEEN ".$StartY." 
			AND ".$StartY2."
ORDER BY s_Name";
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	/**
	 * findet um den angegeben koords den planeten wenn es einen gibt
	 *
	 * @param int $X This is a description
	 * @param int $Y This is a description
	 * @param int $Range in welchem umkreis soll gesucht werden
	 * @return Planet kann Null Objekt sein		
	 *
	 */
	public function findAllByKoordinates($X,$Y,$Range)
	{
		$Sql="SELECT i_Id, s_Name, i_UserId, i_Size, s_Weight, i_Type, s_Picture, i_RefreshTime, i_Metal, i_Hydrogen, i_Biomass, i_Crystal, i_X, i_Y,i_PeopleCount ,f_Satisfaction,f_Tax
			FROM `tbl_planet` 
			WHERE SQRT( pow( i_X - ".$X.", 2 ) + pow( i_Y - ".$Y.", 2 )  ) <".$Range."
ORDER BY s_Name";
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	/**
	 * findet leere Planeten die innerhalb der range keinen gegner aufweisen
	 *
	 * @param int $Range innerhalb dieses radiuses sind keine gegnerischen spieler
	 * @return PlanetCollection 
	 *
	 */
	public function findEmptyPlanetByRange($Range)
	{
		$Sql="SELECT i_Id, s_Name, i_UserId, i_Size, s_Weight, i_Type, s_Picture, i_RefreshTime, i_Metal, i_Hydrogen, i_Biomass, i_Crystal, i_X, i_Y, i_PeopleCount, f_Satisfaction, f_Tax
			FROM `tbl_planet` AS ALLPanets
			WHERE i_UserId =0
			AND (

			SELECT sum( i_UserId ) 
			FROM `tbl_planet` 
			WHERE SQRT( pow( i_X - ALLPanets.i_X, 2 ) + pow( i_Y - ALLPanets.i_Y, 2 ) ) <".$Range."
			) =0";
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	
	/**
	 * gibt die anzahl der Planeten zurück
	 *
	 * @return int 
	 *
	 */
	public function countPlanets()
	{
		$Sql="SELECT count( i_Id ) as Count 
		FROM tbl_planet";
		$Temp=$this->MySql->executeQuery($Sql);
		return $Temp[0]['Count'];	
	}
	
	public function countPlanetsByUser(User $User)
	{
		$Sql="SELECT count( i_Id ) as Count 
		FROM tbl_planet
		where  	i_UserId=".$User->getId();
		$Temp=$this->MySql->executeQuery($Sql);
		return $Temp[0]['Count'];	
	}
}



?>