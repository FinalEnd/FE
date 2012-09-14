<?php

class CateringManager extends SystemManager
{

	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * fgt eine catering gruppe in die datenbank ein 
	 *
	 * @return bool 
	 *
	 */
	public function insertFoodGroup($Name,$Description)
	{
		$Sql="INSERT INTO `cateringgroup`(
				`Id` ,
				`Name` ,
				`Description` 
				)
				VALUES (NULL , '".$Name."', '".$Description."')";
		return 	$this->MySql->executeNoneQuery($Sql) ;
		return false;
	}
	
	
	/**
	 * l�scht ein elemente aus der datenbank
	 *
	 * @param int $Id 
	 * @return bool 
	 *
	 */
	public function deleteGroupById($Id)
	{
		$Sql="DELETE FROM `cateringgroup` WHERE `cateringgroup`.`Id` = ".$Id." LIMIT 1";
		return 	$this->MySql->executeNoneQuery($Sql) ;
		return false;
		
	}
	
	
	public function deleteById($Id)
	{
		$Sql="DELETE FROM catering WHERE  Id = ".$Id." LIMIT 1";
		return 	$this->MySql->executeNoneQuery($Sql) ;
		return false;
		
	}
	
	public function insertFood($FoodName,$FoodDescription,$PriceString,$FoodIncredents,$FoodExtentionsable,$GroupId)
	{
		$Sql="INSERT INTO `catering` (
				`id` ,
				`Name` ,
				`Description` ,
				`Preis` ,
				`Inhaltsstoffe` ,
				`Erweiterbar` ,
				cateringGroupId 
				)
				VALUES (
				NULL , '".$FoodName."', '".$FoodDescription."', '".$PriceString."', '".$FoodIncredents."', '".$FoodExtentionsable."', '".$GroupId."'
				)";
		return 	$this->MySql->executeNoneQuery($Sql) ;
		return false;
	}
	
	
	/**
	 * updatet das element mit den angegebenen werten in der DB
	 *
	 * @param int $FoodId
	 * @param string $FoodName
	 * @param string $FoodDescription
	 * @param string $PriceString
	 * @param int $GroupId
	 * @return Bool erfolgreich eingetragen oder nicht 
	 *
	 */
	public function updateFood($FoodId,$FoodName,$FoodDescription,$PriceString,$GroupId)
	{
		$Sql="UPDATE catering
				SET 
				Name = '".$FoodName."',
				Description = '".$FoodDescription."',
				Preis = '".$PriceString."',
				cateringGroupId = '".$GroupId."'  
				WHERE id =".$FoodId." LIMIT 1";
		return 	$this->MySql->executeNoneQuery($Sql) ;
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}




?>