<?php

/**
 * class cls_KlickManager
 *
 * Description for class cls_KlickManager
 *
 * @author:
*/
class ClickManager extends SystemManager 
 {

	public 	function __construct() 
	{
		parent::__construct();
	}
	
	public function insertClick(Click $Click)
	{
		$Sql="INSERT INTO `tbl_click` (
				`i_Id` ,
				`s_Ip` ,
				`d_Date` ,
				`t_ParamString` ,
				`i_UserId` ,
				`s_Reffer`
				)
				VALUES (
				NULL , '".$Click->getIp()."',now(), '".$Click->getParamString()."', '".$Click->getUser()->getId()."', '".$Click->getReffer()."'
				)";
		return 	$this->MySql->executeNoneQuery($Sql) ;
	}
}

?>