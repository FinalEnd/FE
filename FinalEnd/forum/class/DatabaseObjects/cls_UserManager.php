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
	
	
	
	public function insertUser(User $User)
	{
		$Sql="INSERT INTO `tbl_user` (
`i_Id` ,
`s_Name` ,
`s_Pass` ,
`s_Mail` ,
`s_Login` ,
`d_RegDate` ,
`i_LastLogin` ,
`i_LastReFresh` ,
`d_BirthDate` ,
`s_ICQ` ,
`s_Website` ,
`t_Interrests` ,
`s_Town` ,
`b_AllowMailContakt` ,
`b_AllowPMContakt` ,
`s_OwnTitle` ,
`s_XFire` ,
`s_Avatar` ,
`s_Signature` ,
`i_GroupID` 
)
VALUES (
NULL , '".$User->getName()."' '".$User->getPass()."', '".$User->getMail()."', '".$User->getLogin()."', now(), now(), now(), '".$User->getBirthDate()."', '".$User->getICQ()."', '".$User->getWebsite()."', '".$User->getInterrests()."', '".$User->getTown()."',
 '".$User->getAllowMailContakt()."', '".$User->getAllowPMContakt()."', '".$User->getOwnTitle()."', '".$User->getXFire()."', '".$User->getAvatar()."', '".$User->getSignature()."', '".$User->getGroupID()."'
)";
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function updateLoginTime($UserId)
	{
		$Sql="UPDATE `tbl_user` SET `i_Login` = '".time()."' WHERE `i_Id` =".$UserId." LIMIT 1 ;";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	

	
	
	
	public function settLoginTimeNULL($UserId)
	{
		$Sql="UPDATE `tbl_user` SET `i_Login` = '0' WHERE `i_Id` =".$UserId." LIMIT 1 ;";
		//var_dump($Sql);
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	
	public function setRefreshTime($UserId)
	{
		$Sql="UPDATE `tbl_user` SET i_Refresh = '".microtime(true)."' WHERE `i_Id` =".$UserId." LIMIT 1 ;";
		return $this->MySql->executeNoneQuery($Sql);
	}
}


?>