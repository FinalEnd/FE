<?php
class InviteFinder extends SystemFinder 
{
	protected function load($Result)
	{
		$UserFinder= new UserFinder();
		$User=$UserFinder->findById($Result['i_UserId']);
		return new Invite($Result['i_Id'],$User,$Result['i_Temp'],$Result['s_Type']);	
	}
	private function doLoad($RecordSet)
	{
		$InviteCollection = new InviteCollection();
		
		foreach ($RecordSet as $Row)
		{
			$InviteCollection->add($this->load($Row));
		}
		return $InviteCollection;
	}




	
	
	/**
	 * lädt einen invite aus der datenbank
	 *
	 * @param string $Type This is a description
	 * @param User $User This is a description
	 * @param int $Temp This is a description
	 * @return Invite 
	 *
	 */
	public function findByTypeAndUserAndTemp($Type,User $User, $Temp)
	{
		$Sql="SELECT i_Id ,i_UserId ,i_Temp ,s_Type
			FROM `tbl_invite` 
			where s_Type='".$Type."' 
			AND i_Temp='".$Temp."' 
			AND i_UserId=".$User->getId();	
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	
	
	/**
	 * findet einen eintrag von heute mit den angegebene parametern
	 *
	 * @param mixed $Type This is a description
	 * @param User $User This is a description
	 * @param mixed $Temp This is a description
	 * @return mixed This is the return value description
	 *
	 */
	public function findByTypeAndUserAndTempAndToday($Type,User $User, $Temp)
	{
		$Sql="SELECT i_Id ,i_UserId ,i_Temp ,s_Type
			FROM `tbl_invite` 
			where s_Type='".$Type."' 
			AND i_Temp='".$Temp."' 
			AND d_Date=DATE_FORMAT(now(),'%Y-%m-%d')
			AND i_UserId=".$User->getId();	
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	
	public function countByUser(User $User)
	{
		$Sql="SELECT COUNT(`i_UserId`) as Count FROM `tbl_invite` WHERE `i_UserId` = ".$User->getId();	
		//var_dump($Temp['0']['Count']);
		return $Temp['0']['Count'];
	}
	
	public function findByTypeAndUser($Type,User $User)
	{
		$Sql="SELECT i_Id ,i_UserId ,i_Temp ,s_Type
			FROM `tbl_invite` 
			where s_Type='".$Type."' 
			AND i_UserId=".$User->getId();	
		return $this->doLoad($this->executeQuery($Sql))->getByIndex(0);
	}
	
}


?>
