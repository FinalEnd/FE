<?php
class MessageFinder extends SystemFinder 
{
	
	protected function doLoad($Result)
	{
		$MessageCollection= new MessageCollection();
		if(!isset($Result[0]) || empty($Result[0])){return $MessageCollection;}
		foreach ($Result as $Row)
		{
			$MessageCollection->add($this->load($Row));
		}
		return $MessageCollection;
	}
	
	
	/**
	 * läd eine zeile aus der db in ein konkretess object
	 *
	 * @param sql RecordSet $Result
	 * @return PlayerMessage
	 */
	protected  function load($Result)
	{
		return new Message($Result['i_Id'],$Result['s_Sender'],$Result['s_Resiver'],$Result['t_Text'],$Result['s_Header'],$Result['d_Date'],$Result['b_FromView'],$Result['b_FromDelete'],$Result['b_ToView'],$Result['b_ToDelete']);
	}	
	/**
	 * suchrt alle nachrichten nach dem empfänger
	 *
	 * @param string $Resiver
	 * @return PlayerMessageCollection
	 */
	public function findeByResiver($Resiver)
	{
		$Sql="SELECT s_Sender ,s_Resiver ,t_Text,i_Id ,d_Date,s_Header ,b_FromView,b_FromDelete ,b_ToView,	b_ToDelete FROM `tbl_message`
				WHERE `s_Resiver` LIKE '".$Resiver."' 
				ORDER BY d_Date DESC";
		//$Recordset=$this->load($Sql);
		return $this->doLoad($this->executeQuery($Sql));	
	}
	
	
	/**
	 * findet alle nachrichten die vom empfänger noch nicht gelesen wurden
	 *
	 * @param string $Resiver der name des Empfängers
	 * @return MessageCollection 
	 *
	 */
	public function findUnReadTo($Resiver,$Start=0,$Limit=30)
	{
		$Sql="SELECT s_Sender,s_Resiver,t_Text,i_Id ,d_Date ,s_Header ,b_FromView ,b_FromDelete ,b_ToView ,b_ToDelete FROM `tbl_message`
				WHERE `s_Resiver` LIKE '".$Resiver."' 
				and b_ToView = 0   
				and b_ToDelete=0
				ORDER BY d_Date DESC
				limit ".$Start.",".$Limit;
		//$Recordset=$this->load($Sql);
		return $this->doLoad($this->executeQuery($Sql));	
	}
	
	/**
		zählt die nachrichten die ein User bekommen hat
	*/
	public function countMessageByReciver($Reciver,$FromView,$ToView,$FromDelete,$ToDelete)
	{
		$Sql="SELECT count( * ) AS Count
		FROM `tbl_message` 
		WHERE s_Resiver='".$Reciver."'
		and b_FromView =".$FromView."
		AND b_FromDelete =".$FromDelete."
		AND b_ToView =".$ToView."
		AND b_ToDelete =".$ToDelete;
		$Temp=$this->executeQuery($Sql);
		return $Temp['0']['Count'];	
	}
	
	
	/**
	* findet alle nachrichten die vom empfänger gelesen wurden
	*
	* @param string $Resiver der name des Empfängers
	* @return MessageCollection 
	*
	*/
	public function findReadTo($Resiver,$Start=0,$Limit=30)
	{
		$Sql="SELECT s_Sender,s_Resiver,t_Text,i_Id ,d_Date ,s_Header ,b_FromView ,b_FromDelete ,b_ToView ,b_ToDelete FROM `tbl_message`
				WHERE `s_Resiver` LIKE '".$Resiver."' 
				and b_ToView = 1 
				and b_ToDelete=0
				ORDER BY d_Date DESC
				limit ".$Start.",".$Limit;
		//$Recordset=$this->load($Sql);
		return $this->doLoad($this->executeQuery($Sql));	
	}
	
	public function findFromAndNotDeletet($Sender,$Start=0,$Limit=30)
	{
		$Sql="SELECT s_Sender,s_Resiver,t_Text,i_Id ,d_Date ,s_Header ,b_FromView ,b_FromDelete ,b_ToView ,b_ToDelete FROM `tbl_message`
				WHERE `s_Sender` LIKE '".$Sender."' 
				and b_FromDelete = 0 
				ORDER BY d_Date DESC
				limit ".$Start.",".$Limit;
		//$Recordset=$this->load($Sql);
		return $this->doLoad($this->executeQuery($Sql));	
	}
	

	
	
	/**
	 * zählt  die nachricht des users
	 *
	 * @param string $Name
	 * @return int
	 */
	public function countMessage($Name)
	{
		$name=$_SESSION['name'];
		$sql="SELECT count(id) as gid
		FROM `tbl_message` 
		WHERE `s_Resiver` LIKE CONVERT( _utf8 '$name' USING latin1 ) COLLATE latin1_general_ci";
		$this->MySql->executeQuery($sql);
		$Result=$this->MySql->getResult();
		//var_dump($Result);
		return $anzahlneu=$Result[0]['gid'];	
	}  
	
	/**
	 * zählt  die nachricht des users zurück die noch nicht gelesen wurden
	 *
	 * @param string $Name
	 * @return int
	 */
	public function countMessageNoneListen($Name)
	{
		$Sql="SELECT count(i_Id) as gid
		FROM `tbl_message` 
		WHERE `s_Resiver` LIKE '".$Name."' and b_ToView =0 and b_ToDelete=0 ";
		$Result=$this->MySql->executeQuery($Sql);
		//var_dump($Result);
		return $Result[0]['gid'];
	}
	
}


?>