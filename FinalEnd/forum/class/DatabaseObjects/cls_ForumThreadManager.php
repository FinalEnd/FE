<?php

/**
 * class cls_ForumThreadManager
 *
 * Description for class cls_ForumThreadManager
 *
 * @author:
*/
class ForumThreadManager extends SystemManager 
{


public function insertThread(ForumThread $ForumThread)
	{
		$ForumThreadFinder= new ForumThreadFinder();
		$SortIndex=$ForumThreadFinder->findSortIndex($ForumThread->getThreadId());
		$Sql="INSERT INTO `tbl_forumthread` (
				`i_Id` ,
				`i_ThreadId` ,
				`s_Name` ,
				`s_Description` ,
				`d_CreateDate` ,
				`i_CreatorId` ,
				`i_Modus` ,
				`i_Views` ,
				`b_Struct`,
				`i_Sort`
				)
				VALUES (
				NULL , '".$ForumThread->getThreadId()."', '".$ForumThread->getName()."', '".$ForumThread->getDescription()."', now(), '".$ForumThread->getUser()->getId()."', '".$ForumThread->getModus()."', '0','".$ForumThread->IsStruct()."',".$SortIndex."+1)";
		return $this->executeNonQuery($Sql);	
	}


	/**
	 * updatet nach thread ID
	 *
	 * @param ForumThread $Thread der geänderte thread
	 * @return bool ging klar oder nicht
	 *
	 */
	public function updateThread($Thread)
	{
		$Sql="UPDATE `tbl_forumthread` 
		SET 
		`s_Name` = '".$Thread->getName()."',
		`s_Description` = '".$Thread->getDescription()."',
		`d_CreateDate` = '".$Thread->getCreateDate()."',
		`i_CreatorId` = '".$Thread->getUser()->getId()."',
		`i_Modus` = '".$Thread->getModus()."',
		`i_Views` = '".$Thread->getViews()."',
		`b_Struct` = '".$Thread->IsStruct()."',
		`i_Sort` = '".$Thread->getSort()."' 
		WHERE `tbl_forumthread`.`i_Id` =".$Thread->getId();
		return $this->executeNonQuery($Sql);
	}
 




	/**
	 * setzt den viewCount des Threads um eins hoch
	 *
	 * @param int $Id die Id des threds der incrementiert werden soll
	 * @return int gibt die anzahl der bearbeiteten zeilen zurück
	 *
	 */
	public function incrementViewById($Id)
	{
		$Sql="UPDATE `tbl_forumthread` SET i_Views = i_Views+1 WHERE i_Id =".$Id." LIMIT 1;";
		return $this->executeNonQuery($Sql);
	}


	public function deleteThreadById($ThreadId)
	{
		$Sql="DELETE FROM `tbl_forumthread` WHERE `i_Id` = ".$ThreadId." LIMIT 1";
		return $this->executeNonQuery($Sql);	
	}


	public function updateSortIndex($ThreadId,$Index)
	{
		$Sql="UPDATE `tbl_forumthread` SET `i_Sort` = ".$Index." WHERE `tbl_forumthread`.`i_Id` = ".$ThreadId;
		$this->executeNonQuery($Sql);
	}

	public function setThreadUpById($ThreadId)
	{
		$ForumThreadFinder= new ForumThreadFinder();
		$Thread=$ForumThreadFinder->findById($ThreadId);
		
		$Sql="UPDATE `tbl_forumthread` SET `i_Sort` = `i_Sort`-1 WHERE `tbl_forumthread`.`i_Sort` = ".($Thread->getSort()+1)." and `i_ThreadId`=".$Thread->getThreadId()." and i_Id!=".$ThreadId." LIMIT 1 ";
		$this->executeNonQuery($Sql);
		$Sql="UPDATE `tbl_forumthread` SET `i_Sort` = `i_Sort`+1 WHERE `tbl_forumthread`.`i_Id` = ".$ThreadId." LIMIT 1 ";
		$this->executeNonQuery($Sql);
	
	}

	public function setThreadDownById($ThreadId)
	{
		$ForumThreadFinder= new ForumThreadFinder();
		$Thread=$ForumThreadFinder->findById($ThreadId);
		
		$Sql="UPDATE `tbl_forumthread` SET `i_Sort` = `i_Sort`+1 WHERE `tbl_forumthread`.`i_Sort` = ".($Thread->getSort()+1)." and `i_ThreadId`=".$Thread->getThreadId()." and i_Id!=".$ThreadId." LIMIT 1 ";
		$this->executeNonQuery($Sql);
		$Sql="UPDATE `tbl_forumthread` SET `i_Sort` = `i_Sort`-1 WHERE `tbl_forumthread`.`i_Id` = ".$ThreadId." LIMIT 1 ";
		$this->executeNonQuery($Sql);
		
	}


}

?>