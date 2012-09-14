<?php


class NewsManager extends SystemManager 
{
	
	public function insertNews($Content,$UserId)
	{
		$Sql="INSERT INTO `news` (`Id` ,`Content` ,`Date` ,`CreatorId` 
								)VALUES (NULL , '".$Content."', '".date("d.m.Y")."', '".$UserId."')";			
		return $this->MySql->executeQuery($Sql);
	}
	
		public function updateNewsById($Content,$Id)
	{
		$Sql="UPDATE `news` SET `Content` = '".$Content."' WHERE `news`.`Id` =".$Id." LIMIT 1";
		return $this->MySql->executeQuery($Sql);
	}
	
	
	
	
	public function deleteById($Id)
	{
		$Sql="DELETE FROM `news` WHERE `news`.`Id` = ".$Id." LIMIT 1";
		return $this->MySql->executeQuery($Sql);
	}
	
	
	
}


?>