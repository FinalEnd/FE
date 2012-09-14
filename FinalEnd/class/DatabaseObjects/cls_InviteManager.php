<?php

class InviteManager extends SystemManager
{
	//TUTORIALE
	public function addInvite(User $User,$Type,$Temp)
	{
		$Sql="INSERT INTO `tbl_invite` (
		`i_Id` ,
		`i_UserId` ,
		`i_Temp` ,
		`s_Type`,
		d_Date
		)
		VALUES (
		NULL , '".$User->getId()."', '".$Temp."', '".$Type."',now()
		)";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	
	
	
	public function setNaviTutDone(User $User)
	{	
		$InviteFinder = new InviteFinder();
		$InviteFinder->findByTypeAndUserAndTemp('navigation',$User, 1);
		$Sql="UPDATE `tbl_invite` SET `i_Temp` = '1' WHERE s_Type = 'navigation' AND i_UserId = '".$User->getId();
		//var_dump($Sql);
		return $this->executeNonQuery($Sql);
	}
	
	public function setShipTutDone(User $User)
	{
		$Sql="UPDATE `tbl_invite` SET `i_Temp` = '1' WHERE s_Type = 'ships' AND i_UserId = '".$User->getId();
		//var_dump($Sql);
		return $this->executeNonQuery($Sql);
	}
	
	public function setBattleTutDone(User $User)
	{
		$Sql="UPDATE `tbl_invite` SET `i_Temp` = '1' WHERE s_Type = 'battle' AND i_UserId = '".$User->getId();
		//var_dump($Sql);
		return $this->executeNonQuery($Sql);
	}
	
}

?>