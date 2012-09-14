<?php
class SaleFinder extends SystemFinder 
{
	/**
	 * läd eine zeile aus der db in ein konkretess object
	 *
	 * @param sql RecordSet $Result
	 * @return PlayerMessage
	 */
	protected  function doLoad($Result)
	{
		$SaleCollection= new SaleCollection();
		foreach($Result as $Row)
		{
			$SaleCollection->add($this->load($Row));
		}
		return $SaleCollection;
	}	
	
	protected  function doLoadUnitSale($Result)
	{
		$SaleCollection= new SaleCollection();
		foreach($Result as $Row)
		{
			$SaleCollection->add($this->loadUnitSale($Row));
		}
		return $SaleCollection;
	}	
	
	
	protected function loadUnitSale($Row)
	{
		$UserFinder=new UserFinder();
		$User= $UserFinder->findById($Row['i_UserId']);
		$UnitFinder=new UnitFinder();
		$Unit=$UnitFinder->findById($Row['i_UnitId']);
		return new UnitSale($Row['i_Id'],$User,$Row['i_Price'],$Row['d_EndDate'],$Row['d_InsertDate'],$Unit);
	}
	
	protected function load($Row)
	{
		$UserFinder=new UserFinder();
		return new Sale($Row['i_Id'],$UserFinder->findById($Row['i_CreatorId']),$Row['s_RessourceName'],$Row['i_Count'],$Row['f_Price'],$Row['i_End'],$Row['i_PlanetId'],$Row['d_InsertTime']);
	}
	
	/**
	 * sicht die Allianz des Spielers
	 *
	 * @param User $Resiver
	 * @return SaleCollection
	 */
	public function findByUser(User $User)
	{
		$Sql="SELECT i_Id ,i_CreatorId,s_RessourceName,i_Count,f_Price ,i_End,i_PlanetId,d_InsertTime 
			FROM `tbl_sale`
		WHERE i_CreatorId = ".$User->getId();	
		return  $this->doload($this->executeQuery($Sql));	
	}

	public function findByUserAndPlanetId(User $User,$PlanetId)
	{
		$Sql="SELECT i_Id ,i_CreatorId,s_RessourceName,i_Count,f_Price ,i_End,i_PlanetId ,d_InsertTime
			FROM `tbl_sale`
		WHERE i_CreatorId = ".$User->getId()." 
		and i_PlanetId=".$PlanetId;	
		return  $this->doload($this->executeQuery($Sql));	 
	}	 	 	 	 	 	 	 
 	
	public function findAllShipSale($Start=0,$Count=15)
	{
		$Sql="SELECT `i_Id`,`i_UnitId` ,`i_UserId` ,`i_Price` ,`d_InsertDate`,`d_EndDate` 
			FROM `tbl_saleunit` 
			ORDER BY i_Price DESC
			LIMIT ".$Start.",".$Count;	
		return  $this->doloadUnitSale($this->executeQuery($Sql));		

	}
	
	public function findAllShipSaleByUser($UserId)
	{
		$Sql="SELECT `i_Id`,`i_UnitId` ,`i_UserId` ,`i_Price` ,`d_InsertDate`,`d_EndDate` 
			FROM `tbl_saleunit`
			WHERE i_UserId = ".$UserId;	
		return  $this->doloadUnitSale($this->executeQuery($Sql));		
	}
	
	public function findShipSaleById($Id)
	{
		$Sql="SELECT `i_Id`,`i_UnitId` ,`i_UserId` ,`i_Price` ,`d_InsertDate`,`d_EndDate` 
			FROM `tbl_saleunit`
			WHERE i_Id = ".$Id."
			LIMIT 1";	
		return  $this->doloadUnitSale($this->executeQuery($Sql))->getByIndex(0);		
	}
	
	public function findShipSaleByUnitId($Id)
	{
		$Sql="SELECT `i_Id`,`i_UnitId` ,`i_UserId` ,`i_Price` ,`d_InsertDate`,`d_EndDate` 
			FROM `tbl_saleunit`
			WHERE i_UnitId = ".$Id."
			LIMIT 1";	
		return  $this->doloadUnitSale($this->executeQuery($Sql))->getByIndex(0);		
	}
	
	
	public function countShipSale()
	{
		$Sql="SELECT count( i_Id ) AS i_Count
		FROM `tbl_saleunit`";
		$Temp=$this->executeQuery($Sql);	
		return $Temp[0]['i_Count'];	
	}
	
	
	/**
	 * findet alle alten Acoutionen
	 *
	 * @return SaleCollection 
	 *
	 */
	public function findOldActions()
	{
		$Sql="SELECT i_Id, i_CreatorId, s_RessourceName, i_Count, f_Price, i_End, i_PlanetId, d_InsertTime
FROM `tbl_sale` 
WHERE `d_InsertTime` < DATE_SUB( now( ) , INTERVAL 5 
DAY )";  

		return  $this->doload($this->executeQuery($Sql));	
	}

	
	/**
	 * findet das element aus de db mit der angegebenen id
	 *
	 * @param int $Id 
	 * @return Sale kann ein Null element sein
	 *
	 */
	public function findById($Id)
	{
		$Sql="SELECT i_Id ,i_CreatorId,s_RessourceName,i_Count,f_Price ,i_End,i_PlanetId,d_InsertTime 
			FROM `tbl_sale`
		WHERE i_Id = ".$Id;	
		return  $this->doload($this->executeQuery($Sql))->getByIndex(0);	
	}

	public function findAll($Start=0,$Count=15)
	{
		$Sql="SELECT i_Id ,i_CreatorId,s_RessourceName,i_Count,f_Price ,i_End,i_PlanetId,d_InsertTime  
			FROM `tbl_sale` 
			ORDER BY i_Count ASC , i_Count / f_Price DESC
			LIMIT ".$Start.",".$Count;	
		return  $this->doload($this->executeQuery($Sql));	
	}
	
	 
	public function findAllCount()
	{
		$Sql="SELECT count( i_Id ) AS i_Count
		FROM `tbl_sale`";
		$Temp=$this->executeQuery($Sql);	
		return $Temp[0]['i_Count'];	
	}
	
	
	public function findCountSingleRessource($Type)
	{
		if($Type=="All" || $Type=="")
			return $this->findAllCount();
		$Sql="SELECT count( i_Id ) AS i_Count
		FROM `tbl_sale`
		WHERE `s_RessourceName` = '".$Type."'";
		$Temp=$this->executeQuery($Sql);	
		return $Temp[0]['i_Count'];	
	}
	
	
	public function findSingleRessource($Type,$Start=0,$Count=20)
	{
		if($Type=="All" || $Type=="")
			return $this->findAll($Start,$Count);
		$Sql="SELECT i_Id ,i_CreatorId,s_RessourceName,i_Count,f_Price ,i_End,i_PlanetId,d_InsertTime  
			FROM `tbl_sale` 
			WHERE `s_RessourceName` = '".$Type."'
			ORDER BY i_Count ASC , i_Count / f_Price DESC
			LIMIT ".$Start.",".$Count;	
		return  $this->doload($this->executeQuery($Sql));
	}
	
	
}


?>