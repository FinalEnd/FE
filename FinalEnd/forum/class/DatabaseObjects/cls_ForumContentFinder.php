<?php

/**
 * class cls_ForumContentFinder
 *
 * Description for class cls_ForumContentFinder
 *
 * @author:
*/
class ForumContentFinder extends SystemFinder
{

	function __construct() 
	{
		parent::__construct();
	}
	
	protected  function doLoad($RecordSet)
	{
		if(empty($RecordSet)){return new ForumContentCollection();}
		$ForumContentCollection = new ForumContentCollection();
		foreach ($RecordSet as $ForumThread)
		{
			$ForumContentCollection->add($this->load($ForumThread));
		}
		return $ForumContentCollection;
	}
	
	
	protected  function load($RecordSet)
	{
		$UserFinder= new UserFinder();
		$User=$UserFinder->findById($RecordSet['i_UserId']);
		return new ForumContent($RecordSet['i_Id'],$RecordSet['i_ThreadId'],$User,$RecordSet['t_Content'],$RecordSet['d_CreateDate']);
	}
	
	
	public function findByThreadId($ThreadId,$Start=0,$Count=99999)
	{
		$Sql="SELECT i_Id,i_ThreadId,i_UserId,t_Content,d_CreateDate 
				FROM `tbl_forumcontent` where i_ThreadId=".$ThreadId." order by d_CreateDate limit ".$Start." , ".$Count;
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	public function findById($ThreadId,$Start=0,$Count=99999)
	{
		$Sql="SELECT i_Id,i_ThreadId,i_UserId,t_Content,d_CreateDate 
				FROM `tbl_forumcontent` where i_Id=".$ThreadId." order by d_CreateDate limit ".$Start." , ".$Count;
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	
	/**
	 * findet den letzten geschrieben eintrag mit dieser ThreadId 
	 *
	 * @param int $ThreadId 
	 * @return ForumContent 
	 *
	 */
	public function findLastByThreadId($ThreadId)
	{
		$Sql="SELECT i_Id, i_ThreadId, i_UserId, t_Content, d_CreateDate
				FROM `tbl_forumcontent` 
				WHERE i_ThreadId =".$ThreadId."
				ORDER BY d_CreateDate DESC 
				LIMIT 1 ";
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	
	
	public function findByContent($SearchString)
	{
		$Sql="SELECT i_Id, i_ThreadId, i_UserId, t_Content, d_CreateDate
				FROM `tbl_forumcontent` 
				WHERE t_Content like'%".$SearchString."%' 
				ORDER BY d_CreateDate DESC";
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	public function findContentCount($ThreadId)
	{	
		$i=0;
		$Sql="SELECT Count( i_Id ) AS Count
				FROM tbl_forumcontent
				WHERE i_ThreadId =".$ThreadId;
		$TempCount=$this->executeQuery($Sql);
		$i=$TempCount['0']['Count'];
		
		$ForumContent=$this->findByThreadId($ThreadId);
		$Sql="SELECT i_Id,i_ThreadId 
				FROM `tbl_forumthread` where i_ThreadId =".$ThreadId;
		foreach($this->executeQuery($Sql) as $Result)
		{
			// einen Count auf die Comments machen

			$i+=$this->findContentCount($Result['i_Id']);
		}	
		return $i;		
	}


	/**
	 * zählt nur die comments die in gleicher höhe liegen
	 *
	 * @return int kann 0 sein
	 *
	 */
	public function countAllByThreadID($ThreadId)
	{
		$Sql="select count(i_Id) as Count
		FROM tbl_forumcontent
		WHERE i_ThreadId =".$ThreadId;
		$RecordSet=$this->executeQuery($Sql);
		return $RecordSet['0']['Count'];
	}

	public function countAllByUser($UserId)
	{
		$Sql="select count(i_Id) as Count
		FROM tbl_forumcontent
		WHERE i_UserId =".$UserId;
		$RecordSet=$this->executeQuery($Sql);
		return $RecordSet['0']['Count'];
	}


	/**
	 * findet den letzten eintrag der unter dieser threaId geschrieben wurde
	 *
	 * @param int $ThreadId 
	 * @return ForumContent 
	 *
	 */
	public function findLastContent($ThreadId)
	{	
		$ForumContent=$this->findLastByThreadId($ThreadId);

		$Sql="SELECT i_Id,i_ThreadId 
				FROM `tbl_forumthread` where i_ThreadId=".$ThreadId;

		foreach($this->executeQuery($Sql) as $Result)
		{
			// einen Count auf die Comments machen
			$TempForumContent=$this->findLastContent($Result['i_Id']);
			if($ForumContent->isThisDateNewer($TempForumContent))
			{
				$ForumContent=$TempForumContent;
			}
		}	
		return $ForumContent;		
	}

   
	/**
	 * findet die letzten Commentare
	 *
	 * @param int $Count wieviele comentare zurück gegeben werden
	 * @return ForumContent kann null sein
	 *
	 */
	public function findLastInsert($Count)
	{
		$Sql="SELECT i_Id, i_ThreadId, i_UserId, t_Content, d_CreateDate
				FROM `tbl_forumcontent` 
				ORDER BY d_CreateDate DESC 
				LIMIT ".$Count;
		return $this->doLoad($this->executeQuery($Sql));
	}
	
}

?>