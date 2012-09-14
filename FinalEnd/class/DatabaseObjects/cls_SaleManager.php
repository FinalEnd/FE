<?php




class SaleManager extends SystemManager
{

	

	

	
	public function addSale(Sale $Sale)
	{
		$Sql="INSERT INTO `tbl_sale` (
		`i_Id` ,
		`i_CreatorId` ,
		`s_RessourceName` ,
		`i_Count` ,
		`f_Price` ,
		`i_End`	 ,
		i_PlanetId   ,
		d_InsertTime
		)
		VALUES (
		NULL , '".$Sale->getCreator()->getId()."', '".$Sale->getRessource()."', '".$Sale->getCount()."', '".$Sale->getPrice()."', '".$Sale->getEnd()."', '".$Sale->getPlanetId()."',now()
		)";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	
	public  function deleteSale(Sale $Sale)
	{
		$Sql="DELETE FROM `tbl_sale` WHERE `tbl_sale`.`i_Id` = ".$Sale->getId()." limit 1";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	public  function addShipSale($User, $Unit, $Price)
	{
		$Sql="INSERT INTO `tbl_saleunit` (`i_Id`, `i_UnitId`, `i_UserId`, `i_Price`, `d_InsertDate`, `d_EndDate`) 
		VALUES (
		NULL , '".$Unit."', '".$User."', '".$Price."', CURRENT_TIMESTAMP, '0000-00-00 00:00:00'
		)";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	public  function deleteShipSale($UnitId)
	{
		$Sql="DELETE FROM `tbl_saleunit` WHERE `tbl_saleunit`.`i_UnitId` = ".$UnitId." limit 1";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}

	

	
	
}



?>