<?php

class UserFinder extends SystemFinder 
{
	
	/**
	 * Enter description here...
	 *
	 * @param array $RecordSet
	 * @return UserCollection
	 */
	private function doLoad($RecordSet)
	{
		$UserCollection = new UserCollection();
		$GroupFinder= new GroupFinder();
		foreach ($RecordSet as $Row)
		{
			$Group=	$GroupFinder->findById($Row['i_GroupId']);
			$UserCollection->add(new User($Row['i_Id'],$Row['s_Name'],$Row['s_Pass'],$Row['s_Email'],$Row['i_Login'],$Row['i_Level'],$Row['i_Experience'],$Row['i_Status'],$Row['i_Credits'],$Row['i_Refresh'],$Row['AlianzName'],$Row['s_MemberState'],$Row['d_InsertDate'],$Row['i_AllianzId'],$Row['b_Looked'],$Row['d_RegisterDate'],$Row['b_Premium'],$Row['i_GroupId'],$Group,$Row['i_Server']));
		}
		return $UserCollection;
	}
	
	/**
	 * sucht alle user in der datenbank und gibt sie in 
	 *
	 * @return UserCollection
	 */
	public function findAllUser()
	{
		$Sql="SELECT s_Name ,s_Email ,s_Pass,	i_Login ,i_Id ,i_Level ,i_Experience ,i_Status ,i_Credits ,i_Refresh,i_Storage ,b_Looked ,d_RegisterDate,	b_Premium,i_GroupId,i_Server
		FROM tbl_user";
		return $this->doLoad($this->MySql->executeQuery($Sql));
	}
	
	

	
	
	/**
	 * gibt die anzahl der spieler zurück die im system hinterlegt sind
	 *
	 * @return int 
	 *
	 */
	public function findUserCount()
	{
		$Sql="SELECT count( i_id ) AS i_Count
		FROM `tbl_user`";
		$Temp=$this->MySql->executeQuery($Sql);
		return $Temp[0]['i_Count'];
	}
	
			   
	/**
	 * findet den angegebene user
	 *
	 * @param int $Id die id des zu suchenden users
	 * @return User This is the return value description
	 *
	 */
	public function findById($Id)
	{
		$Sql="SELECT s_Name ,s_Email ,s_Pass,	i_Login ,i_Id ,i_Level ,i_Experience ,i_Status ,i_Credits ,i_Refresh,i_Storage ,b_Looked ,d_RegisterDate,	b_Premium,i_GroupId,i_Server
		FROM tbl_user
 WHERE i_Id =".$Id;
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
	}
	

	
	/**
	 * findet den angegeben user anhand seines namen
	 *
	 * @param string $Name der name des users
	 * @return User This is the return value description
	 *
	 */
	public function findByName($Name)
	{
		$Sql="SELECT s_Name ,s_Email ,s_Pass,	i_Login ,i_Id ,i_Level ,i_Experience ,i_Status ,i_Credits ,i_Refresh,i_Storage ,b_Looked ,d_RegisterDate,	b_Premium,i_GroupId,i_Server
		FROM tbl_user
 WHERE s_Name ='".$Name;
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
	}
	
	public function findByMail($Mail)
	{
		$Sql="SELECT s_Name ,s_Email ,s_Pass,	i_Login ,i_Id ,i_Level ,i_Experience ,i_Status ,i_Credits ,i_Refresh,i_Storage ,b_Looked ,d_RegisterDate,	b_Premium,i_GroupId,i_Server
		FROM tbl_user
 WHERE s_Email ='".$Mail;
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
	}
	

	
	/**
	 * sucht in der user tabelle nach dem angegeben user
	 *
	 * @param string $Name der name des Users
	 * @param string $Pass das md5 gehashte passwort des benutzers
	 * @return User kann ein null user sein
	 *
	 */
	public function findByNameAndPass($Name, $Pass,$ServerId)
	{
		$Sql="SELECT s_Name ,s_Email ,s_Pass,	i_Login ,i_Id ,i_Level ,i_Experience ,i_Status ,i_Credits ,i_Refresh,i_Storage ,b_Looked ,d_RegisterDate,	b_Premium,i_GroupId,i_Server
		FROM tbl_user
 WHERE `s_Name` ='".$Name."' and 
`s_Pass` ='".$Pass."'
and 
i_Server =".$ServerId;

		//echo   $Sql;

		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
		
	}
	
}


?>