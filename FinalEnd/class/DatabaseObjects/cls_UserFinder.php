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
		foreach ($RecordSet as $Row)
		{
			$UserCollection->add(new User($Row['i_Id'],$Row['s_Name'],$Row['s_Pass'],$Row['s_Email'],$Row['i_Login'],$Row['i_Level'],$Row['i_Experience'],$Row['i_Status'],$Row['i_Credits'],$Row['i_Refresh'],$Row['AlianzName'],$Row['s_MemberState'],$Row['d_InsertDate'],$Row['i_AllianzId'],$Row['b_Looked'],$Row['d_RegisterDate'],$Row['b_Premium'],$Row['i_FriendID'],$Row['s_PictureString']));
		}
		return $UserCollection;
	}
	
	
	 
	/**
	 * gibt einen zufälligen spieler zurück der das mindest level hat das angegeben wurde und nicht in der angegebenen allianz sind
	 *
	 * @param int $Level es werden nur User zurück gegeben die mindestens diese level haben
	 * @param int $AllianzId gibt nur welche zurück die nicht die gleiche alli haben
	 * @return User kann ein leeres Objekt sein wenn keine spieler mit der angegeben level beschränkung gefunden wurden
	 *
	 */
	public function findRandomUserOverLevel($Level,$AllianzId)
	{
		$Sql="SELECT tbl_user . * , tbl_allianzuser.i_Id, tbl_allianzuser.i_AllianzId ,tbl_allianzuser.s_MemberState, tbl_allianzuser.d_InsertDate, (
		SELECT s_AllianzName
		FROM `tbl_allianz` 
		WHERE `tbl_allianz`.i_Id = tbl_allianzuser.i_AllianzId
		LIMIT 1 
		) AS AlianzName
		FROM tbl_user AS U, tbl_allianzuser
		RIGHT JOIN tbl_user ON tbl_user.i_Id = tbl_allianzuser.i_UserId
		where 
		 tbl_user.i_Level>=".$Level."  
		and 
		  tbl_allianzuser.i_AllianzId != ".$AllianzId."
		GROUP BY tbl_user.i_Id
		ORDER BY RAND()	 limit 1";
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
	}
	
	
	
	/**
	 * sucht alle user in der datenbank und gibt sie in 
	 *
	 * @return UserCollection
	 */
	public function findAllUser()
	{
		$Sql="SELECT tbl_user . * , tbl_allianzuser.i_Id, tbl_allianzuser.i_AllianzId ,tbl_allianzuser.s_MemberState, tbl_allianzuser.d_InsertDate, (

SELECT s_AllianzName
FROM `tbl_allianz` 
WHERE `tbl_allianz`.i_Id = tbl_allianzuser.i_AllianzId
LIMIT 1 
) AS AlianzName
FROM tbl_user AS U, tbl_allianzuser
RIGHT JOIN tbl_user ON tbl_user.i_Id = tbl_allianzuser.i_UserId
GROUP BY tbl_user.i_Id";
		return $this->doLoad($this->MySql->executeQuery($Sql));
	}
	
	/**
	 * gibt zurück ob der premium key in der datenbank ist UND ob der schon von jemand verwendet wird
	 *
	 * @return int 
	 *
	 */
	public function checkPremiumKey($Key)
	{
		$Sql="SELECT COUNT( i_ID ) as Count FROM `tbl_premiumkeys` WHERE `s_Key` = '".$Key."' AND `i_UserID` = 0";
		$Temp=$this->MySql->executeQuery($Sql);
		return $Temp[0]['Count'];
	}
	
	public function getKeyLength($Key)
	{
		$Sql="SELECT `i_DaysValid` as Length FROM `tbl_premiumkeys` WHERE `s_Key` = '".$Key."'";
		$Temp=$this->MySql->executeQuery($Sql);
		return $Temp[0]['Length'];
	}
	
	
	
	public function getKeyTimeLeftInDays($UserId)
	{
		$Sql="SELECT 
				datediff( date_add(`d_UseDate`, interval `i_DaysValid` day),current_date) as Days
				FROM `tbl_premiumkeys` 
				WHERE `i_UserID` = '".$UserId."'";
		$Temp=$this->MySql->executeQuery($Sql);
		return $Temp[0]['Days'];
	}
	

	/**
	 * zählt alle spieler und gibt die Anzahl zurück
	 *
	 * @return int 
	 *
	 */
	public function countAllUsers()
	{
		$Sql="SELECT count( i_Id ) as Count 
FROM `tbl_user`";
		  $Temp=$this->MySql->executeQuery($Sql);

		return $Temp[0]['Count'];
		
	}
	
	
	/**
	 * gibt die anzahl der momentan eingeloggten speiler zurück
	 *
	 * @return int 
	 *
	 */
	public function countAllOnlineUsers()
	{
		//echo microtime(true);
		$Sql="SELECT count( i_Id ) as Count 
FROM `tbl_user`
where i_Login >(".microtime(true)."- (15 *60)) ";
		  $Temp=$this->MySql->executeQuery($Sql);

		return $Temp[0]['Count'];
		
	}
	
	/**
	 * sucht die spieler geordnet nach der erfahrung die sie haben
	 *
	 * @param int $Start gibt den start punkt an ab  wo gesucht wird
	 * @param int $Count wieviele daten sätze sollen geladen werden
	 * @return UserCollection 
	 *
	 */
	public function findAllUserOrderByEXP($Start,$Count)
	{
		$Sql="SELECT tbl_user . * , tbl_allianzuser.i_Id, tbl_allianzuser.i_AllianzId ,tbl_allianzuser.s_MemberState, tbl_allianzuser.d_InsertDate, (
SELECT s_AllianzName
FROM `tbl_allianz` 
WHERE `tbl_allianz`.i_Id = tbl_allianzuser.i_AllianzId
LIMIT 1 
) AS AlianzName
FROM tbl_user AS U, tbl_allianzuser
RIGHT JOIN tbl_user ON tbl_user.i_Id = tbl_allianzuser.i_UserId
GROUP BY tbl_user.i_Id
order by tbl_user.i_Experience DESC 
LIMIT ".$Start.", ".$Count;
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
		$Sql="SELECT tbl_user. * , tbl_allianzuser.i_Id AS LinkId, tbl_allianzuser.i_AllianzId, tbl_allianzuser.s_MemberState, tbl_allianzuser.d_InsertDate, (
SELECT s_AllianzName
FROM `tbl_allianz` 
WHERE `tbl_allianz`.i_Id = tbl_allianzuser.i_AllianzId
LIMIT 1 
) AS AlianzName
 FROM tbl_user AS U, tbl_allianzuser
 RIGHT JOIN tbl_user ON tbl_user.i_Id = tbl_allianzuser.i_UserId
 WHERE tbl_user.i_Id =".$Id."
 GROUP BY tbl_user.i_Id";
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
	}
	
	public function findAllianzById($Id)
	{
		$Sql="SELECT tbl_user. * , tbl_allianzuser.i_Id AS LinkId, tbl_allianzuser.i_AllianzId, tbl_allianzuser.s_MemberState, tbl_allianzuser.d_InsertDate, (
SELECT s_AllianzName
FROM `tbl_allianz` 
WHERE `tbl_allianz`.i_Id = tbl_allianzuser.i_AllianzId
LIMIT 1 
) AS AlianzName
 FROM tbl_user AS U, tbl_allianzuser
 RIGHT JOIN tbl_user ON tbl_user.i_Id = tbl_allianzuser.i_UserId
 WHERE tbl_allianzuser.i_AllianzId =".$Id."
 GROUP BY tbl_user.i_Id";
		return $this->doLoad($this->MySql->executeQuery($Sql));
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
		$Sql="SELECT tbl_user. * , tbl_allianzuser.i_Id AS LinkId, tbl_allianzuser.i_AllianzId, tbl_allianzuser.s_MemberState, tbl_allianzuser.d_InsertDate, (

SELECT s_AllianzName
FROM `tbl_allianz` 
WHERE `tbl_allianz`.i_Id = tbl_allianzuser.i_AllianzId
LIMIT 1 
) AS AlianzName
FROM tbl_user AS U, tbl_allianzuser
RIGHT JOIN tbl_user ON tbl_user.i_Id = tbl_allianzuser.i_UserId
WHERE tbl_user.s_Name ='".$Name."'
GROUP BY tbl_user.i_Id";
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
	}
	
	public function findByMail($Mail)
	{
		$Sql="SELECT tbl_user. * , tbl_allianzuser.i_Id AS LinkId, tbl_allianzuser.i_AllianzId, tbl_allianzuser.s_MemberState, tbl_allianzuser.d_InsertDate, (

SELECT s_AllianzName
FROM `tbl_allianz` 
WHERE `tbl_allianz`.i_Id = tbl_allianzuser.i_AllianzId
LIMIT 1 
) AS AlianzName
FROM tbl_user AS U, tbl_allianzuser
RIGHT JOIN tbl_user ON tbl_user.i_Id = tbl_allianzuser.i_UserId
WHERE tbl_user.s_Email ='".$Mail."'
GROUP BY tbl_user.i_Id";
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
	}
	
	
	/**
	 * findet alle user die in den letzten 5 min einen seiten refresh gemacht haben
	 *
	 * @return UserCollection kann leer sein
	 *
	 */
	public function findOnlineUser()
	{
		$TempTime= time()-(60*5);
		$Sql="SELECT tbl_user. * , tbl_allianzuser.i_Id AS LinkId, tbl_allianzuser.i_AllianzId, tbl_allianzuser.s_MemberState, tbl_allianzuser.d_InsertDate, (
SELECT s_AllianzName
FROM `tbl_allianz` 
WHERE `tbl_allianz`.i_Id = tbl_allianzuser.i_AllianzId
LIMIT 1 
) AS AlianzName
FROM tbl_user AS U, tbl_allianzuser
RIGHT JOIN tbl_user ON tbl_user.i_Id = tbl_allianzuser.i_UserId
WHERE tbl_user.i_Login =>'".$TempTime."'
GROUP BY tbl_user.i_Id";
		return $this->doLoad($this->MySql->executeQuery($Sql));
	}
	
	/**
	 * sucht in der user tabelle nach dem angegeben user
	 *
	 * @param string $Name der name des Users
	 * @param string $Pass das md5 gehashte passwort des benutzers
	 * @return User kann ein null user sein
	 *
	 */
	public function findByNameAndPass($Name, $Pass)
	{
		$Sql="SELECT tbl_user. * , tbl_allianzuser.i_Id AS LinkId, tbl_allianzuser.i_AllianzId, tbl_allianzuser.s_MemberState, tbl_allianzuser.d_InsertDate, (

SELECT s_AllianzName
FROM `tbl_allianz` 
WHERE `tbl_allianz`.i_Id = tbl_allianzuser.i_AllianzId
LIMIT 1 
) AS AlianzName
FROM tbl_user AS U, tbl_allianzuser
RIGHT JOIN tbl_user ON tbl_user.i_Id = tbl_allianzuser.i_UserId
WHERE tbl_user.`s_Name` ='".$Name."' and 
			tbl_user.`s_Pass` ='".$Pass."'
GROUP BY tbl_user.i_Id";
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
		
	}
	
}


?>