<?php

/**
 * class cls_ForumContentManager
 *
 * Description for class cls_ForumContentManager
 *
 * @author:
*/
class ForumContentManager extends SystemManager 
{

	public function insertContent(ForumContent $ForumContent)
	{
		$Sql="INSERT INTO `tbl_forumcontent`(
				`i_ThreadId` ,
				`i_UserId` ,
				`t_Content` ,
				`d_CreateDate` 
				)
				VALUES (
				'".$ForumContent->getThreadId()."','".$ForumContent->getUser()->getId()."', '".$ForumContent->getContent()."', now()
				)";
		return $this->executeNonQuery($Sql);	
	}

	public function deleteThreadById($ThreadId)
	{
		$Sql="DELETE FROM `tbl_forumcontent` WHERE `i_ThreadId` = ".$ThreadId." LIMIT 1";
		return $this->executeNonQuery($Sql);	
	}

	public function deleteById($ContentId)
	{
		$Sql="DELETE FROM `tbl_forumcontent` WHERE `i_Id` = ".$ContentId." LIMIT 1";
		return $this->executeNonQuery($Sql);	
	}


	public function updateContent(ForumContent $ForumContent)
	{
		$Sql="UPDATE `tbl_forumcontent` SET `i_ThreadId` = '".$ForumContent->getThreadId()."',
				`i_UserId` = '".$ForumContent->getUser()->getId()."',
				`t_Content` = '".$ForumContent->getContent()."' WHERE `i_Id` =".$ForumContent->getId()." LIMIT 1";
		return $this->executeNonQuery($Sql);	
	}


}

?>