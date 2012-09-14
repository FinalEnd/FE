<?php




class AllianzCommentManager extends SystemManager
{
	



	
	
	public  function addCommentCollection(AllianzCommentCollection $AllianzCommentCollection,$TopicId)
	{
		foreach($AllianzCommentCollection as $Comment)
		{
			$Sql="INSERT INTO `tbl_allianzcomment` (
`i_Id` ,
`t_Comment` ,
`i_UserId` ,
`d_CreateDate` ,
`i_TopicId` 
)
VALUES (NULL , '".$Comment->getContent()."', '".$Comment->getCreateUser()->getId()."', now(), ".$TopicId.")";	
			//echo $Sql;
			return $this->executeNonQuery($Sql);
		}
	}
	

	public  function addComment(AllianzComment $AllianzComment,$TopicId)
	{

		$Sql="INSERT INTO `tbl_allianzcomment` (
`i_Id` ,
`t_Comment` ,
`i_UserId` ,
`d_CreateDate` ,
`i_TopicId` 
)
VALUES (NULL , '".$AllianzComment->getContent(false)."', '".$AllianzComment->getCreateUser()->getId()."', now(), ".$TopicId.")";	
			//echo $Sql;
			return $this->executeNonQuery($Sql);
		
	}
	
	public  function deleteAllByTopicId($TopicId)
	{
		$Sql="DELETE FROM `tbl_allianzcomment` WHERE `tbl_allianzcomment`.`i_TopicId` = ".$TopicId;	
		return $this->executeNonQuery($Sql);
	}
	
	
}



?>