<?php


class UserManager extends SystemManager 
{	
	public function __construct()
	{
		parent::__construct();
		//$this->MySql =  MySqldb::getInstance();
	}


	public function updateUserPass($Pass,$UserID)
	{
		$Sql="UPDATE tbl_user SET `s_Pass` = '".$Pass."' WHERE `i_Id` =".$UserID." LIMIT 1";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function updateUserCredits($NewCredits,$UserID)
	{
		//echo "updateUserCredits";
		$Sql="UPDATE tbl_user SET `i_Credits` = '".$NewCredits."' WHERE `i_Id` =".$UserID." LIMIT 1";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function setPremium(User $User)
	{
		$Sql="UPDATE tbl_user SET b_Premium = '1' WHERE `i_Id` =".$User->getId()." LIMIT 1";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function unsetPremium(User $User)
	{
		$Sql="UPDATE tbl_user SET b_Premium = '0' WHERE `i_Id` =".$User->getId()." LIMIT 1";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function insertPremiumKey($Length,$Key)
	{
		$Sql="INSERT INTO `tbl_premiumkeys` (`i_UserID` ,`s_Key` ,`i_DaysValid`
		)
		VALUES ('0', '".$Key."', '".$Length."'
		)";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function updatePremiumKey(User $User,$Key)
	{
		$Sql="UPDATE `tbl_premiumkeys` SET i_UserId = ".$User->getId().", d_UseDate=CURDATE()  WHERE `s_Key` ='".$Key."' LIMIT 1";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	//setzt alle leute auf nicht premium die abgelaufene keys haben
	public function unsetPremiumByOldKeys()
	{
		$Sql="UPDATE `tbl_user` LEFT JOIN `tbl_premiumkeys` 
		ON `i_UserID` = `tbl_user`.`i_Id`
		SET b_Premium = '0' 
		WHERE current_date > date_add(`d_UseDate`, interval `i_DaysValid` day)
		";
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	//löscht alle abgelaufenen keys
	public function deleteOldKeys()
	{
		$Sql="DELETE FROM `tbl_premiumkeys` 
			WHERE
			current_date > date_add(`d_UseDate`, interval `i_DaysValid` day)
			AND
			`i_UserID` != 0";
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function deletePremiumKey($Key)
	{
		$Sql="DELETE FROM `tbl_premiumkeys` WHERE `s_Key` =".$Key." LIMIT 1";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function updatePictureString(User $User,$PictureString)
	{
		$Sql="UPDATE tbl_user SET s_PictureString = '".$PictureString."' WHERE `i_Id` =".$User->getId()." LIMIT 1";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function updateFriendID($UserID,$FriendID)
	{
		$Sql="UPDATE tbl_user SET `i_FriendID` = '".$FriendID."' WHERE `i_Id` =".$UserID." LIMIT 1";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function insertUser(User $User)
	{
		$Sql="INSERT INTO `tbl_user` (
		s_Name,s_Email,s_Pass,i_Login,i_Id,i_Level,i_Experience,i_Status,i_Credits,i_Refresh,d_RegisterDate,b_Looked
		)
		VALUES (
		'".$User->getName()."', '".$User->getMail()."', '".md5($User->getPass())."', '0', NULL , '1', '', '0', '5000','".microtime(true)."',now(),0
		)";
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	
	/**
	 * fügt einen Neuen User in die Forum Datenbank ein
	 *
	 * @param User $User This is a description
	 * @param int $ServerId die Id des aktuellen server auf dem Registriert wurde
	 * @return int 
	 *
	 */
	public function insertUserToForumDataBase(User $User,$ServerId)
	{
		$Sql="INSERT INTO `tbl_user` (`s_Name`, `s_Email`, `s_Pass`, `i_Login`, `i_Id`, `i_Level`, `i_Experience`, `i_Status`, `i_Credits`, `i_Refresh`, `i_Storage`, `b_Looked`, `d_RegisterDate`, `b_Premium`, `i_GroupId`, `i_Server`) 
		VALUES ('".$User->getName()."', '".$User->getMail()."', '".md5($User->getPass())."', '0', NULL, '0', '0', '0', '0', '0', '0', '0', now(), '0', '5', '".$ServerId."')";
		$this->MySql->setConnection(0);
		//var_dump($this);
		//echo "davor";
		$Temp= $this->MySql->executeNoneQuery($Sql);
		//echo "danach"; 
		
		//var_dump($Sql);
		$this->MySql->setConnection($ServerId);
		return $Temp;
	}
	
	
	/**
	 * bearbeitet das passwort im Forum
	 *
	 * @param string $Pass 
	 * @param int $UserID This is a description
	 * @param mixed $ServerId This is a description
	 * @return mixed This is the return value description
	 *
	 */
	public function updateUserPassForum(User $User,$ServerId)
	{
		$Sql="UPDATE tbl_user SET `s_Pass` = '".$Pass."' WHERE 
		s_Name=".$User->getName()." and 
		 i_Server=".$ServerId."
		 LIMIT 1";
		$this->MySql->setConnection(0);
		$this->MySql->executeNoneQuery($Sql);
		$this->MySql->setConnection($ServerId);
		return true;
	}
	
	public function updateLoginTime($UserId)
	{
		$Sql="UPDATE `tbl_user` SET `i_Login` = '".time()."' WHERE `i_Id` =".$UserId." LIMIT 1 ;";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	
	/**
	 * erhöht dei erfahrung des Users
	 *
	 * @param int $UserId die UserID
	 * @param int $NewExperiance die erfahrung die er dazu bekommt 
	 * @return bool 
	 *
	 */
	public function addExperiance($UserId,$NewExperiance)
	{
		$Sql="UPDATE `tbl_user` SET `i_Experience` = i_Experience+'".$NewExperiance."' WHERE `i_Id` =".$UserId." LIMIT 1 ;";
		$this->MySql->executeNoneQuery($Sql);
		 // wenn erfahrung genug dann ein level nach oben setzen
		$this->updateUserLevel();
		
		
	}
	
	public function updateUserLevel()
	{
		$Sql="UPDATE `tbl_user` SET `i_Level` = i_Level+1 
			WHERE i_Experience > (898.01 * POW(( i_Level +1 ),2.4771)) and i_Level<".USER_MAX_LEVEL;
		return  $this->MySql->executeNoneQuery($Sql);
	}
	
	public function settLoginTimeNULL($UserId)
	{
		$Sql="UPDATE `tbl_user` SET `i_Login` = '0'  WHERE `i_Id` =".$UserId." LIMIT 1 ;";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function setRefreshTimeAndCredits($UserId,$NewCredits)
	{
		//echo "setRefreshTimeAndCredits";
		$Sql="UPDATE `tbl_user` SET i_Refresh = ".microtime(true).",
		i_Credits=".$NewCredits."
		 WHERE `i_Id` =".$UserId." LIMIT 1 ;";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function setRefreshTime($UserId)
	{
		$Sql="UPDATE `tbl_user` SET i_Refresh = '".microtime(true)."' WHERE `i_Id` =".$UserId." LIMIT 1 ;";
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	
	  
		
	/**
	 * entfernt den user aus der DB
	 *
	 * @param int $UserId der zu löschende User
	 * @return bool 
	 *
	 */
	public function deleteUserById($UserId)
	{
		$Sql="DELETE FROM `tbl_user` WHERE `tbl_user`.`i_Id` = ".$UserId." LIMIT 1 ;";
		return $this->MySql->executeNoneQuery($Sql);
	}
}


?>