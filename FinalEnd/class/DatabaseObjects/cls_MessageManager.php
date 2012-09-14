<?php

class MessageManager extends SystemManager 
{
	

	public function saveNewMessage(Message $Message)
	{
		//$Sql="INSERT INTO `tbl_message` ( s_Sender,s_Resiver,t_Text,d_Date,b_Read,s_Header ) VALUES ('".$Message->getFrom()."', '".$Message->getTo()."', '".$Message->getContent()."', now(),0, '".$Message->getHeader()."')";
		
		$Sql="INSERT INTO `tbl_message` (
		`s_Sender` ,
		`s_Resiver` ,
		`t_Text` ,
		`i_Id` ,
		`d_Date` ,
		`s_Header` ,
		`b_FromView` ,
		`b_FromDelete` ,
		`b_ToView` ,
		`b_ToDelete` 
		)
		VALUES (
		'".$Message->getFrom()."', '".$Message->getTo()."', '".$Message->getContent()."', NULL , now(), '".$Message->getHeader()."', '0', '0', '0', '0'
		)";
		
		
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	   
	
	/**
	 * entfernt die von dem Spieler gelöschten systemnachrichten
	 * @return bool 
	 *
	 */
	public function deleteFromSystemAndDeleted()
	{
		$Sql="DELETE FROM `tbl_message` WHERE s_Sender='System' and b_ToDelete=1";
		return $this->MySql->executeNoneQuery($Sql);
	}
	
		/**
		 * löscht eine nachrich
		 *
		 * @param int $id
		 * @return bool
		 */
		public function deleteById($id)
	{
		if(isset($id)&& empty($id)){throw new UserExeption("Fehler",UserExeptionCodes::message_not_deletet);}
		$Sql="DELETE From tbl_message WHERE `i_Id` = '$id' LIMIT 1";
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	
	public function setViewedByFrom($MessageId)
	{
		$Sql="UPDATE `tbl_message` SET b_FromView = 1 WHERE `i_Id` =".$MessageId;
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function setDeletetByFrom($MessageId)
	{
		$Sql="UPDATE `tbl_message` SET b_FromDelete = 1 WHERE `i_Id` =".$MessageId;
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function setDeletetByTo($MessageId)
	{
		$Sql="UPDATE `tbl_message` SET `b_ToDelete` = 1 WHERE `i_Id` =".$MessageId;
		return $this->MySql->executeNoneQuery($Sql);
	}
	
	public function setViewedByTo($MessageId)
	{
		$Sql="UPDATE `tbl_message` SET `b_ToView` = 1 WHERE `i_Id` =".$MessageId;
		return $this->MySql->executeNoneQuery($Sql);
	}
		
	public function setUnViewedByTo($MessageId)
	{
		$Sql="UPDATE `tbl_message` SET `b_ToView` = 0 WHERE `i_Id` =".$MessageId;
		return $this->MySql->executeNoneQuery($Sql);
	}
}



?>