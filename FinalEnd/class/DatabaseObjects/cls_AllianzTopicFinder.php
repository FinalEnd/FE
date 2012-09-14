<?php
class AllianzTopicFinder extends SystemFinder 
{
	/**
	 * läd eine zeile aus der db in ein konkretess object
	 *
	 * @param sql RecordSet $Result
	 * @return PlayerMessage
	 */
	protected  function doLoad($Result)
	{
		$AllianzCollection= new AllianzTopicCollection();
		foreach($Result as $Row)
		{
			$AllianzCollection->add($this->load($Row));
		}
		return $AllianzCollection;
	}	
	
	
	protected function load($Row)
	{
		$UserCollection= new UserCollection();
		$UserFinder=new UserFinder();
		$User= $UserFinder->findById($Row['i_UserId']);
		$AllianzCommentFinder= new AllianzCommentFinder();
		$AllianzCommentCollection= $AllianzCommentFinder->findByTopicId($Row['i_Id']);
		
		return new AllianzTopic($Row['i_Id'],$Row['s_Name'],$User,$Row['d_CreateDate'],$AllianzCommentCollection,$Row['i_AllianzId']) ;
	}
	
	/**
	 * suchrt alle nachrichten nach dem empfänger
	 *
	 * @param string $Resiver
	 * @return PlayerMessageCollection
	 */
	public function findByAllianzId($AllianzId)
	{
		$Sql="SELECT i_Id,s_Name,i_UserId,d_CreateDate,i_AllianzId 
			FROM `tbl_allianztopic` 
			where i_AllianzId=".$AllianzId;	
		return  $this->doload($this->executeQuery($Sql));	
	}


	/**
	 * gibt den angegebene Allianztopic zurück
	 *
	 * @param int $Id 
	 * @return AllianzTopic 
	 *
	 */
	public function findById($Id)
	{
		$Sql="SELECT i_Id,s_Name,i_UserId,d_CreateDate,i_AllianzId 
			FROM `tbl_allianztopic` 
			where i_Id=".$Id;	
		return  $this->doload($this->executeQuery($Sql))->getByIndex(0);	
	}
	
}


?>