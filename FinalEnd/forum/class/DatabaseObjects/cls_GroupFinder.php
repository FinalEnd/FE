<?php

class GroupFinder extends SystemFinder 
{
	
	/**
	 * Enter description here...
	 *
	 * @param array $RecordSet
	 * @return UserCollection
	 */
	private function doLoad($RecordSet)
	{
		$GroupCollection = new GroupCollection();
		//var_dump($RecordSet);
		foreach ($RecordSet as $Row)
		{
			$GroupCollection->add($this->load($Row));
		}
		return $GroupCollection;
	}
	
	protected function load($Row)
	{
		$UserFinder= new UserFinder();
		//$UserCollection= $UserFinder->findGroupById($Row['i_Id']);
		$UserCollection= new UserCollection();
		return new Group($Row['i_Id'],$Row['s_Name'],$Row['s_OnlineColor'],$Row['i_MinPosts'],$Row['i_SecurityLevel'],$UserCollection);
	}
	
	
	
	public function findAll()
	{
		$Sql="SELECT i_Id,s_Name,s_OnlineColor,i_MinPosts,i_SecurityLevel 
		FROM `tbl_forumgroups`";
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
	}
	
	
	/**
	 * findet den angegebene user
	 *
	 * @param int $Id die id des zu suchenden users
	 * @return User This is the return value description
	 *
	 */
	public function findById($Id)
	{
		$Sql="SELECT i_Id,s_Name,s_OnlineColor,i_MinPosts,i_SecurityLevel 
FROM `tbl_forumgroups` where 
 	i_Id=".$Id;
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
	}
	

	
	/**
	 * findet den angegeben user anhand seines namen
	 *
	 * @param string $Name der name des users
	 * @return User This is the return value description
	 *
	 */
	public function findByName($Name)
	{
		$Sql="SELECT i_Id,s_Name,s_OnlineColor,i_MinPosts,i_SecurityLevel 
FROM `tbl_forumgroups` where 
 	s_Name=".$Name;
		return $this->doLoad($this->MySql->executeQuery($Sql))->getByIndex(0);
	}
	

	
	
	
	
}


?>