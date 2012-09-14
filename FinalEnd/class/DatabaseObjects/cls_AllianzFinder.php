<?php
class AllianzFinder extends SystemFinder 
{
	/**
	 * läd eine zeile aus der db in ein konkretess object
	 *
	 * @param sql RecordSet $Result
	 * @return PlayerMessage
	 */
	protected  function doLoad($Result)
	{
		$AllianzCollection= new AllianzCollection();
		foreach($Result as $Row)
		{
			$AllianzCollection->add($this->load($Row));
		}
		return $AllianzCollection;
	}	
	
	protected  function doLoadRank($Result)
	{
		$AllianzRankCollection= new AllianzRankCollection();
		foreach($Result as $Row)
		{
			$AllianzRankCollection->add($this->loadRank($Row));
		}
		return $AllianzRankCollection;
	}	
	
	
	protected function load($Row)
	{
		$UserCollection= new UserCollection();
		$UserFinder=new UserFinder();
		$Funder= $UserFinder->findById($Row['i_FundUserId']);
		$UserCollection= $UserFinder->findAllianzById($Row['i_AllianzId']);
		$AllianzTopicFinder= new AllianzTopicFinder();
		$AllianzTopicCollection=	$AllianzTopicFinder->findByAllianzId($Row['i_AllianzId']);
		return new Allianz($Row['i_AllianzId'],$Row['s_AllianzName'],$Row['t_Description'],$UserCollection,$Row['s_PictureString'],$Funder,$AllianzTopicCollection,$UserCollection->getCount()) ;
	}
	
	protected function loadRank($Row)
	{
		return new AllianzRank($Row['t_Rank'],$Row['i_AllianzID']) ;
	}
	
	public function findRanksByAllianz($ID)
	{
		$Sql="SELECT i_AllianzId ,t_Rank
		FROM `tbl_allianz_rank` 
		WHERE i_AllianzId = ".$ID;	
		return  $this->doLoadRank($this->executeQuery($Sql));	
	}
	
	public function findRankByUser($ID)
	{
		$Sql="SELECT `t_Rank` as Name FROM `tbl_allianz_rank` 
INNER JOIN `tbl_allianzuserranks` ON tbl_allianzuserranks.i_RankId = tbl_allianz_rank.i_Id
WHERE `i_UserID` = ".$ID;	
		$Temp=$this->MySql->executeQuery($Sql);
		return $Temp[0]['Name'];	
	}
	
	public function findRanksByNameAndAllianz($Name,$Allianz)
	{
		$Sql="SELECT *
		FROM `tbl_allianz_rank` 
		WHERE i_AllianzId = ".$Allianz." AND t_Rank = '".$Name."'";	
		$Temp=$this->MySql->executeQuery($Sql);
		return $Temp[0]['i_ID'];
	}
	
	/**
	 * suchrt alle nachrichten nach dem empfänger
	 *
	 * @param string $Resiver
	 * @return PlayerMessageCollection
	 */
	public function findByUser(User $User)
	{
		$Sql="SELECT tbl_allianz.i_Id,s_AllianzName ,t_Description,i_FundUserId ,s_PictureString ,tbl_allianz.i_Id as i_AllianzId
		FROM `tbl_allianz` 
		RIGHT JOIN tbl_allianzuser ON tbl_allianzuser.i_AllianzId = tbl_allianz.i_Id
		WHERE tbl_allianzuser.i_UserId = ".$User->getId();	
		return  $this->doload($this->executeQuery($Sql));	
	}

	public function findByName($AllianzName,$Limit=10)
	{
		$Sql="SELECT tbl_allianz.i_Id,s_AllianzName ,t_Description,i_FundUserId ,s_PictureString 	,tbl_allianz.i_Id as i_AllianzId
		FROM `tbl_allianz` 
		WHERE `s_AllianzName` LIKE '%".$AllianzName."%'
		LIMIT ".$Limit;	
		return  $this->doload($this->executeQuery($Sql));	
	}
	
	public function findAllAllianzOrderByPlayerCount($Start,$Count)
	{
		$Sql="SELECT tbl_allianz.i_Id, s_AllianzName, t_Description, i_FundUserId, s_PictureString,tbl_allianz.i_Id as i_AllianzId, (
		SELECT count( i_AllianzId ) 
		FROM `tbl_allianzuser` 
		WHERE i_AllianzId = tbl_allianz.i_Id
		) AS PlayerCount
		FROM `tbl_allianz` 
		ORDER BY PlayerCount DESC 
		LIMIT ".$Start.", ".$Count;
		return $this->doLoad($this->MySql->executeQuery($Sql));
	}
	
	
	
	/**
	 * ählt die allianzne in der DB
	 *
	 * @return int 
	 *
	 */
	public function countAllAllianz()
	{
		$Sql="SELECT count( i_Id ) as Count 
		FROM `tbl_allianz`";
		$Temp=$this->MySql->executeQuery($Sql);
		return $Temp[0]['Count'];
	}
	

	
	
}


?>