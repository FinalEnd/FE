<?php


// Statistiken

class StateManager extends SystemManager
{
	public function insertStateToUnit(State $State,Unit $Unit)
	{
		$Sql="INSERT INTO `tbl_unionstate` (
		`i_Id` ,
		`i_StateId` ,
		`i_UnionId` ,
		`i_Expired` 
		)
		VALUES (
		NULL , 
		'".$State->getId()."',
		 '".$Unit->getId()."',
		 '".$State->getEndTime()."'
		)";
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * löscht alle stati die abgelaufen sind aus der db
	 *
	 * @return void 
	 *
	 */
	public function deleteExpiredStates()
	{
		$Sql="DELETE FROM `tbl_unionstate` WHERE `tbl_unionstate`.`i_Expired` < ".time()." 
		and `tbl_unionstate`.`i_Expired`>0 ";
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * löscht alle statie der Flotte
	 *
	 * @param Unit $Unit This is a description
	 * @return void 
	 *
	 */
	public function deleteStatesByUnit(Unit $Unit)
	{
		$Sql="DELETE FROM `tbl_unionstate` WHERE `tbl_unionstate`.`i_UnionId` =".$Unit->getId();
		return $this->executeNonQuery($Sql);
	}
	
	public function deleteStatesByUnitAndByState(Unit $Unit,$State)
	{
		$Sql="DELETE FROM `tbl_unionstate` WHERE `tbl_unionstate`.`i_UnionId` =".$Unit->getId()." AND `tbl_unionstate`.`i_StateId` =".$State;
		return $this->executeNonQuery($Sql);
	}
	
}
?>