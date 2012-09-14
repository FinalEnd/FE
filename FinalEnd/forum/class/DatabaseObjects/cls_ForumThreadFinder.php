<?php

/**
 * class php
 *
 * Description for class php
 *
 * @author:
*/
class ForumThreadFinder extends SystemFinder  
{

	function __construct() 
	{
		parent::__construct();
	}
	
	protected  function doLoad($RecordSet,$Start=0,$Count=99999)
	{
		if(empty($RecordSet)){return new ForumThreadCollection();}
		$ForumThreadCollection = new ForumThreadCollection();
		foreach ($RecordSet as $ForumThread)
		{
			$ForumThreadCollection->add($this->load($ForumThread,$Start,$Count));
		}
		return $ForumThreadCollection;
	}
	
	
	protected  function load($RecordSet,$Start=0,$Count=99999)
	{
		$UserFinder= new UserFinder();
		$User=$UserFinder->findById($RecordSet['i_CreatorId']);
		$ForumThreadFinder = new ForumThreadFinder();
		$ThreadCount= $this->findThreadCount($RecordSet['i_Id']);
		$ForumContentFinder= new ForumContentFinder();
		$ForumContentCount=$ForumContentFinder->findContentCount($RecordSet['i_Id']);
		$ForumContentFinder= new ForumContentFinder();
		$ForumContentCollection= new ForumContentCollection();
		if($RecordSet['b_Struct']==0)
		{
			$ForumContentCollection=$ForumContentFinder->findByThreadId($RecordSet['i_Id'],$Start,$Count);
		}
		$LastContent=$ForumContentFinder->findLastContent($RecordSet['i_Id']);
		
		return new ForumThread($RecordSet['i_Id'],$RecordSet['s_Name'],$RecordSet['i_ThreadId'],$RecordSet['s_Description'],$RecordSet['d_CreateDate'],$User,$RecordSet['i_Modus'],$RecordSet['i_Views'],$ForumContentCollection,$RecordSet['b_Struct'],$ThreadCount,$ForumContentCount,$LastContent,$RecordSet['i_Sort']);
	}
	
	/**
	 * gibt die anzahl der gefundenen threads zurück die unter dem angegeben thread hängen
	 *
	 * @param int $ThreadId die Íd des Threads unter dem gesucht werden soll Wichtig such in allen ebenen
	 * @return int 
	 *
	 */
	private function findThreadCount($ThreadId)
	{
		$Sql="SELECT i_Id,i_ThreadId 
				FROM `tbl_forumthread` where i_ThreadId=".$ThreadId;
		$TempCount=$this->executeQuery($Sql);	
		$i=0;
		foreach($this->executeQuery($Sql) as $Result)
		{
			$i++;
			$i+=$this->findThreadCount($Result['i_Id']);
		}	
			return $i;		
	}
	
	
	/**
	 * gibt den thread mit dieser ID zurück
	 *
	 * @param int $ThreadId 
	 * @return ForumThread 
	 *
	 */
	public function findById($ThreadId,$Start=0,$Count=99999)
	{
		$Sql="SELECT i_Id,i_ThreadId,s_Name,s_Description,d_CreateDate,i_CreatorId,i_Modus,i_Views,b_Struct,i_Sort 
				FROM `tbl_forumthread` where i_Id=".$ThreadId;
		return $this->doLoad($this->executeQuery($Sql),$Start,$Count)->getByIndex(0);
	}
	
	public function findByThreadId($ThreadId)
	{
		$Sql="SELECT i_Id,i_ThreadId,s_Name,s_Description,d_CreateDate,i_CreatorId,i_Modus,i_Views,b_Struct,i_Sort
				FROM `tbl_forumthread` where i_ThreadId=".$ThreadId." order by i_Sort DESC";
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	/**
	 * sucht den obersten thread heraus und gibt ihn zurück
	 *
	 * @param int $ThreadId die threadId des darüberliegenden threads
	 * @return ForumThread 
	 *
	 */
	public function findHighestThread($ThreadId)
	{
		$Sql="SELECT i_Id,i_ThreadId,s_Name,s_Description,d_CreateDate,i_CreatorId,i_Modus,i_Views,b_Struct,i_Sort
				FROM `tbl_forumthread` where i_ThreadId=".$ThreadId." order by i_Sort DESC
				limit 1";
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	
	public function findLowestThread($ThreadId)
	{
		$Sql="SELECT i_Id,i_ThreadId,s_Name,s_Description,d_CreateDate,i_CreatorId,i_Modus,i_Views,b_Struct,i_Sort
				FROM `tbl_forumthread` where i_ThreadId=".$ThreadId." order by i_Sort ASC
				limit 1";
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	

	public function findThreadByThreadIdAndSort($ThreadId,$Sort)
	{
		$Sql="SELECT i_Id,i_ThreadId,s_Name,s_Description,d_CreateDate,i_CreatorId,i_Modus,i_Views,b_Struct,i_Sort
				FROM `tbl_forumthread` where i_ThreadId=".$ThreadId." and i_Sort =".$Sort." 
				limit 1";
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}

	public function findSortIndex($ThreadId)
	{
		$Sql="SELECT i_Id,i_Sort
				FROM `tbl_forumthread` where i_ThreadId=".$ThreadId;
		$TempCount=$this->executeQuery($Sql);	
		$SortIndex=0;
		foreach($TempCount as $Result)
		{
			if($SortIndex<$Result['i_Sort'])
			{
				$SortIndex=$Result['i_Sort'];
			}
		}	
		return $SortIndex;		
	}
	
	
	
	/**
	 * gibt die letzten threads zurück die neue kommentare enthlten
	 *
	 * @return mixed This is the return value description
	 *
	 */
	public function findFiveLastComentet()
	{
		$ContentFinder= new ForumContentFinder();
		$ContentCollecion= $ContentFinder->findLastInsert(30);
		$ThreadCollection=new ForumThreadCollection();
		foreach($ContentCollecion as $Content)
		{
			if($ThreadCollection->getById($Content->getThreadId())->getId()==0)
			{
				$ThreadCollection->add($this->findById($Content->getThreadId(),0,1));
			}
			if($ThreadCollection->getCount()>=5)
			{
				return $ThreadCollection;	
			}	
		}
		return $ThreadCollection;
		
		
	}
	
	
	
}

?>