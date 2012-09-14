<?php




class AllianzManager extends SystemManager
{
	
	public function addInvite($UserID,$AllianzId)
	{
		$Sql="INSERT INTO `tbl_invite` (
		`i_Id` ,
		`i_UserId` ,
		 i_Temp,
		`d_Date` ,
		`s_Type` 
		)
		VALUES (
		NULL , ".$UserID.",".$AllianzId.", now(), 'allianz'
		)";
		return $this->executeNonQuery($Sql);
	}
	
	
	
	
	/**
	 * updatet die beschreibung und das bild der allianz
	 *
	 * @param Allianz $Allianz 
	 * @return bool gibt den count der betroffenen zeilen zurück
	 *
	 */
	public function updateAllianz(Allianz $Allianz)
	{
		$Sql="UPDATE `tbl_allianz` SET 
		`t_Description` = '".$Allianz->getDescription()."',
		`s_PictureString` = '".$Allianz->getPictureString()."' 
		WHERE `i_Id` =".$Allianz->getId();
		return $this->executeNonQuery($Sql);
	}
	 
	
	/**
	 * entfernt alle einladungen am tagesende
	 *
	 * @return bool 
	 *
	 */
	public function deleteOldInvites()
	{
		$Sql="DELETE FROM `tbl_invite` WHERE d_Date !=CURDATE() and s_Type='allianz' ";
		return $this->executeNonQuery($Sql);
	}
	 
	/**
	 * wenn ein eintrag gelöscht wurde dann 
	 *
	 * @param User $UserID This is a description
	 * @return mixed This is the return value description
	 *
	 */
	public function doInvite(User $User)
	{
		// gucken ob einer drinnen ist wenn ja dann eintragen
		$Sql=" SELECT i_Id,i_UserId,i_Temp,d_Date,s_Type
			FROM `tbl_invite` 
			WHERE `i_UserId` =".$User->getId()." and s_Type='allianz'";
		$Temp=$this->query($Sql);	
		if($Temp[0]['i_Temp']==0)
		{
			return false;	
		}
		$this->deleteMember($User->getId());
		$TempAllianz= Allianz::getEmptyInstance();
		$TempAllianz->setId($Temp[0]['i_Temp']);
		$this->addUserToAllianz($TempAllianz,$User);
		$Sql="DELETE FROM `tbl_invite` WHERE i_UserId = ".$User->getId();
		return $this->executeNonQuery($Sql);
	}
	
	public function setMemberState($UserId,$State)
	{
		$Sql="UPDATE `tbl_allianzuser` SET `s_MemberState` = '".$State."' WHERE `i_UserId` =".$UserId;
		return $this->executeNonQuery($Sql);
	}
	
	public function deleteAllianz(Allianz $Allianz)
	{
		$Sql="DELETE FROM `tbl_allianzuser` WHERE i_AllianzId = ".$Allianz->getId();
		$this->executeNonQuery($Sql);
		$Sql="DELETE FROM `tbl_allianz` WHERE `tbl_allianz`.`i_Id` = ".$Allianz->getId();
		return $this->executeNonQuery($Sql);
	}
		  
	/**
	 * löscht den angegeben user von der allianz
	 *
	 * @param int $UserId die User Id die entfernt werden soll
	 * @return int die anzahl der db sätze die gelöscht wurden
	 *
	 */
	public function deleteMember($UserId)
	{
		$Sql="DELETE FROM `tbl_allianzuser` WHERE `tbl_allianzuser`.`i_UserId` = ".$UserId;
		return $this->executeNonQuery($Sql);
	}
	
	public function addAllianz(Allianz $Allianz)
	{
		$Sql="INSERT INTO `tbl_allianz` (
		`i_Id` ,
		`s_AllianzName` ,
		`t_Description` ,
		`i_FundUserId` ,
		`s_PictureString` 
		)
		VALUES (
		NULL , '".$Allianz->getName()."', '".$Allianz->getDescription()."', '".$Allianz->getFundUser()->getId()."', '".$Allianz->getPictureString()."'
		)";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	public function addAllianzRank(AllianzRank $Allianz)
	{
		$Sql="INSERT INTO `tbl_allianz_rank` (
		`i_AllianzId` ,
		`t_Rank`
		)
		VALUES (
		".$Allianz->getID().", '".$Allianz->getName()."'
		)";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	public function addRankToUser($Rank, $User)
	{
		$Sql="INSERT INTO `tbl_allianzuserranks` (
		`i_UserID`,
		`i_RankId`
		)
		VALUES (
		".$User.", ".$Rank."
		)";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	public function deleteRankByUser($User)
	{
		$Sql="DELETE FROM `tbl_allianzuserranks` WHERE `tbl_allianzuserranks`.`i_UserID` = ".$User;	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	public function deleteRankByNameAndAllianz($Name,$Allianz)
	{
		$Sql="DELETE FROM `tbl_allianz_rank` WHERE `i_AllianzID` = ".$Allianz." AND `t_Rank` ='".$Name."'";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	
	public function deleteAllianzRank(AllianzRank $Allianz)
	{
		$Sql="INSERT INTO `tbl_allianz_rank` (
		`i_AllianzId` ,
		`i_UserID`,
		`t_Rank`,
		`b_Admin`
		)
		VALUES (
		".$Allianz->getAllianzID."', '".$Allianz->UserID."', '".$Allianz->getName."', '".$Allianz->getAdmin()."'
		)";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	
	
	public  function addUserToAllianz(Allianz $Allianz,User $User)
	{
		$Sql="INSERT INTO `tbl_allianzuser` (
		`i_Id` ,
		`i_AllianzId` ,
		`i_UserId` ,
		`s_MemberState` ,
		`d_InsertDate` 
		)
		VALUES (
		NULL , '".$Allianz->getId()."', '".$User->getId()."', 'member', now()
		)";	
		//echo $Sql;
		return $this->executeNonQuery($Sql);
	}
	

	

	
	
}



?>