<?php
class AllianzCommentFinder extends SystemFinder 
{

	protected  function doLoad($Result)
	{
		$AllianzCollection= new AllianzCommentCollection();
		foreach($Result as $Row)
		{
			$AllianzCollection->add($this->load($Row));
		}
		return $AllianzCollection;
	}	
	
	
	protected function load($Row)
	{
		$UserFinder=new UserFinder();
		$User= $UserFinder->findById($Row['i_UserId']);
		return new AllianzComment($Row['i_Id'],$Row['t_Comment'],$User,$Row['d_CreateDate']) ;
	}
	
	/**
	 * suchrt alle nachrichten nach dem empfänger
	 *
	 * @param string $Resiver
	 * @return PlayerMessageCollection
	 */
	public function findByTopicId($TopicId)
	{
		$Sql="SELECT i_Id,t_Comment,i_UserId,d_CreateDate,i_TopicId 
			FROM `tbl_allianzcomment` 
			where i_TopicId=".$TopicId."
			ORDER BY `d_CreateDate` ASC";	
		return  $this->doload($this->executeQuery($Sql));	
	}


	
}


?>