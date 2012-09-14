<?php




class AllianzTopicManager extends SystemManager
{
	


	

	
	public function addAllianzTopic(AllianzTopic $AllianzTopic)
	{
		$Sql="INSERT INTO `tbl_allianztopic` (
`i_Id` ,
`s_Name` ,
`i_UserId` ,
`d_CreateDate` ,
`i_AllianzId` 
)
VALUES (
NULL , '".$AllianzTopic->getName()."', '".$AllianzTopic->getCreateUser()->getId()."', now(), ".$AllianzTopic->getAllianzId()."
)";	
		//echo $Sql;
		$this->executeNonQuery($Sql);
		
		 // eingetragene Id Holen
		$Id= $this->getLastInsertId();
		$AllianzCommentManager= new AllianzCommentManager();
		$AllianzCommentManager->addCommentCollection($AllianzTopic->getAllianzCommecntCollection(),	$Id);
	}
	
		
	/**
	 * entfernt das Topic und alle kommentare
	 *
	 * @param int $TopicID 
	 * @return void 
	 *
	 */
	public function deleteById($TopicID)
	{
		$Sql="DELETE FROM `tbl_allianztopic` WHERE `i_Id` = ".$TopicID;
		$CommentManager= new AllianzCommentManager();
		$CommentManager->deleteAllByTopicId($TopicID);
		return $this->executeNonQuery($Sql);
	}
	
	
}



?>