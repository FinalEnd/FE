<?php
class MapObjectFinder extends SystemFinder
{
	private function doLoad($RecordSet)
	{
		$MapObjectCollection = new MapObjectCollection();
		
		foreach ($RecordSet as $Row)
		{
			$MapObjectCollection->add($this->load($Row));
		}
		return $MapObjectCollection;
	}
	
	protected function load($Result)
	{
		switch($Result['i_Type'])
		{
		case 3:
			{
				return new Sun($Result['i_Id'],$Result['s_Name'],$Result['s_PictureString'],$Result['i_X'],$Result['i_Y'],$Result['i_Width']);
			}break;
			default:
				return new MapObject($Result['i_Id'],$Result['s_Name'],$Result['i_Type'],$Result['s_PictureString'],$Result['i_X'],$Result['i_Y'],$Result['i_Width'],$Result['i_Height'],$Result['i_DeleteTime']);	
		}
		
	}

	public function findAll()
	{
		$Sql="SELECT i_Id,s_Name,i_Type,s_PictureString,i_X,i_Y,i_Width,i_Height,i_DeleteTime FROM tbl_mapobjects";
		return $this->doLoad($this->executeQuery($Sql));
	}


	public function findFallesAway()
	{
		$Sql="SELECT i_X,i_Y, 
			(i_X/(
			SQRT(POW(i_X,2)+POW(i_Y,2))
			))as Alpha
			,SQRT( pow( 100000-i_X , 2 ) + pow( 100000-i_Y , 2 ) )  as MaxRange
			FROM `tbl_mapobjects`
			where SQRT( pow( 100000-i_X , 2 ) + pow( 100000-i_Y , 2 ) ) =(select max(SQRT( pow( 100000-i_X , 2 ) + pow( 100000-i_Y , 2 ) ) ) from tbl_mapobjects)";
		$Temp= $this->executeQuery($Sql);
		return $Temp[0];
		//return $this->doLoad($this->MySql->getResult());
	}


	public function findAllSuns()
	{
		$Sql="SELECT i_Id,s_Name,i_Type,s_PictureString,i_X,i_Y,i_Width,i_Height,i_DeleteTime FROM tbl_mapobjects where i_Type=3";
		$TempCollection=$this->doLoad($this->executeQuery($Sql));
		return $TempCollection;
	}



	/**
	 * sucht aus der db die einheit mit der angegebenen Id
	 *
	 * @param int $UnitId 
	 * @return Unit 
	 *
	 */
	public function findById($UnitId)
	{
		$Sql="SELECT i_Id,s_Name,i_Type,s_PictureString,i_X,i_Y,i_Width,i_Height,i_DeleteTime FROM tbl_mapobjects where i_Id=".$UnitId;
		$TempCollection=$this->doLoad($this->executeQuery($Sql));
		return $TempCollection->getByIndex(0);
	}
	
	public function findByKoordinates($X,$Y)
	{
		$Sql="SELECT i_Id,s_Name,i_Type,s_PictureString,i_X,i_Y,i_Width,i_Height,i_DeleteTime FROM tbl_mapobjects
		 where i_X=".$X." and i_Y=".$Y;
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	public function findBetweenKoordinates($X,$X2,$Y,$Y2)
	{
		$Sql="SELECT i_Id,s_Name,i_Type,s_PictureString,i_X,i_Y,i_Width,i_Height,i_DeleteTime FROM tbl_mapobjects
		 where 
		i_X
			BETWEEN ".$X." 
			AND ".$X2." 	
		and 
		i_Y BETWEEN ".$Y." 
			AND ".$Y2;
		return $this->doLoad($this->executeQuery($Sql));
	}


	/**
	 * findet alle mapobjecte deren type kleiner $Type 1 müll 2 asteroiden 3 sonnen
	 *
	 * @param mixed $X This is a description
	 * @param mixed $X2 This is a description
	 * @param mixed $Y This is a description
	 * @param mixed $Y2 This is a description
	 * @param mixed $Type This is a description
	 * @return mixed This is the return value description
	 *
	 */
	public function findBetweenKoordinatesAndTypeSmaller($X,$X2,$Y,$Y2,$Type)
	{
		$Sql="SELECT i_Id,s_Name,i_Type,s_PictureString,i_X,i_Y,i_Width,i_Height,i_DeleteTime FROM tbl_mapobjects
		 where 
		i_X
			BETWEEN ".$X." 
			AND ".$X2." 	
		and 
		i_Y BETWEEN ".$Y." 
			AND ".$Y2."
		and	i_Type<=".$Type;
		return $this->doLoad($this->executeQuery($Sql));
	}

	public function findBetweenKoordinatesAndTypeHigher($X,$X2,$Y,$Y2,$Type)
	{
		$Sql="SELECT i_Id,s_Name,i_Type,s_PictureString,i_X,i_Y,i_Width,i_Height,i_DeleteTime FROM tbl_mapobjects
		 where 
		i_X
			BETWEEN ".$X." 
			AND ".$X2." 	
		and 
		i_Y BETWEEN ".$Y." 
			AND ".$Y2."
		and	i_Type>=".$Type;
		return $this->doLoad($this->executeQuery($Sql));
	}

	/**
	* findet um den angegeben koords den planeten wenn es einen gibt
		 *
	* @param int $X This is a description
	* @param int $Y This is a description
	* @param int $Range in welchem umkreis soll gesucht werden
	* @return Planet kann Null Objekt sein		
	*
	*/
	public function findAllByKoordinates($X,$Y,$Range)
	{
		$Sql="SELECT i_Id,s_Name,i_Type,s_PictureString,i_X,i_Y,i_Width,i_Height,i_DeleteTime FROM tbl_mapobjects 
			WHERE SQRT( pow( i_X - ".$X.", 2 ) + pow( i_Y - ".$Y.", 2 )  ) <".$Range;
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
}?>