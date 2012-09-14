<?php


/**
 * für alle zeitangaben wird die PHP funktion time() benutzt 
 *
 */
class SkillManager extends SystemManager 
{

	
	public function insertSkillCoolDown(Skill $Skill,User $User)
	{
		$Sql="INSERT INTO `tbl_userskills` (
		`i_Id` ,
		`i_UserId` ,
		`i_SkillId` ,
		`i_Time` 
		)
		VALUES (
		NULL , '".$User->getId()."', '".$Skill->getType()."', '".$Skill->getNextCoolDownTime()."'
		)";
		return $this->baseNoneGuery($Sql);
		
	}
	
	/**
	 * entfernt alle skills die abgelaufen sind
	 *
	 * @return bool 
	 *
	 */
	public function deleteOldSkills()
	{
		$Sql="DELETE FROM `tbl_userskills` WHERE `tbl_userskills`.`i_Time` <= ".time();
		return $this->baseNoneGuery($Sql);
	}
	

}



?>