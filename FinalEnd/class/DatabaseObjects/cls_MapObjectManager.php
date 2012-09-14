<?php




class MapObjectManager extends SystemManager
{

	public  function insertMapObject(MapObject $MapObject)
	{
		$Sql="INSERT INTO `tbl_mapobjects` (
		`i_Id` ,
		`s_Name` ,
		`i_Type` ,
		`s_PictureString` ,
		`i_X` ,
		`i_Y` ,
		`i_Width` ,
		`i_Height` ,
		`i_DeleteTime` 
		)
		VALUES (
		NULL , '".$MapObject->getName()."', '".$MapObject->getType()."', '".$MapObject->getPictureString()."', '".$MapObject->getX()."', '".$MapObject->getY()."', '".$MapObject->getWidth()."', '".$MapObject->getHeight()."', '".$MapObject->getDeleteTime()."'
		)";	
		return $this->executeNonQuery($Sql);
	}
	
	


	/**
	 * löscht die unit aus tbl Union und aus der battle union verknüpfung
	 *
	 * @param int $Unit 
	 * @return die zeilen die gelöscht wurden 
	 *
	 */
	public  function deleteMapObject(MapObject $MapObject)
	{
		$Sql="DELETE FROM tbl_mapobjects WHERE `i_Id` =  ".$MapObject->getId();	
		return $this->executeNonQuery($Sql);
	}

}
?>