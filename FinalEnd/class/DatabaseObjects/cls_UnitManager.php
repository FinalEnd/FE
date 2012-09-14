<?php




class UnitManager extends SystemManager
{

	public  function insertUnit(Unit $Unit)
	{
		$Sql="INSERT INTO `tbl_union` (
			`i_Id` ,
			`s_Name` ,
			`t_Units` ,
			`i_DMG` ,
			`i_Amor` ,
			`i_Speed` ,
			`i_Healts` ,
			`i_UserId` ,
			`i_ExtentionOne` ,
			`i_ExtentionTwo` ,
			`i_X` ,
			`i_Y` ,
			`f_State` ,
			i_Storage  ,
			t_Stored,
			i_Experience,
			i_Level
			)
			VALUES (
			NULL , '".$Unit->getName()."', '".$Unit->getUnits()."', '".$Unit->getDMG()."', '".$Unit->getAmor(true)."', '".$Unit->getSpeed(true)."', '".$Unit->getHealts(true)."', '".$Unit->getUserId()."', '".$Unit->getExtentionOne()."', '".$Unit->getExtentionTow()."', '".$Unit->getX()."', '".$Unit->getY()."', '".$Unit->getState()."', ".$Unit->getStorage(true)." , '".$Unit->getStored()."', ".$Unit->getExperience().", ".$Unit->getLevel()."
			)";	
		return $this->executeNonQuery($Sql);
	}
	
	public  function updateUnitDMG(Unit $Unit,$DMG)
	{
		$Sql="UPDATE `finalend`.`tbl_union` SET `i_DMG` = ".$DMG."
		WHERE `tbl_union`.`i_Id` =".$Unit->getId();
		return $this->executeNonQuery($Sql);
	}
	
	
	public  function updateUnitHealth(Unit $Unit,$Health)
	{
		$Sql="UPDATE `finalend`.`tbl_union` SET `i_Healts` = ".$Health."
		WHERE `tbl_union`.`i_Id` =".$Unit->getId();
		return $this->executeNonQuery($Sql);
	}
	
	public  function updateUnitSpeed(Unit $Unit,$Speed)
	{
		$Sql="UPDATE `finalend`.`tbl_union` SET `i_Speed` = ".$Speed."
		WHERE `tbl_union`.`i_Id` =".$Unit->getId();
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * setzt die koordinaten hart in die datenbank i_X=
	 *
	 * @param Unit $Unit die Flotte die aktualisiert werden soll
	 * @param int $X die neue X koordinate
	 * @param int $Y die neue Y koordinate
	 * @return bool ob es klar ging oder nicht
	 *
	 */
	public  function updateUnitKoordinates(Unit $Unit,$X,$Y)
	{
		$Sql="UPDATE `finalend`.`tbl_union` SET `i_X` = ".$X.",
		`i_Y` = ".$Y." WHERE `tbl_union`.`i_Id` =".$Unit->getId();
		return $this->executeNonQuery($Sql);
	}
	
	/**
	* setzt die koordinaten in die Datenbank i_X=
	*
	* @param Unit $Unit die Flotte die aktualisiert werden soll
	* @param int $X die neue X koordinate
	* @param int $Y die neue Y koordinate
	* @return bool ob es klar ging oder nicht
	*
	*/
	public  function updateUnitKoordinatesCalculation(Unit $Unit,$X,$Y)
	{
		$TempX=$X-$Unit->getX();
		$TempY=$Y-$Unit->getY();
		$Sql="UPDATE `finalend`.`tbl_union` SET `i_X` = i_X+".$TempX.",
		`i_Y` = i_Y+".$TempY." 
		WHERE `tbl_union`.`i_Id` =".$Unit->getId();
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * updatet den laderaum einer einheit
	 *
	 * @param Unit $Unit This 
	 * @return mixed This is the return value description
	 *
	 */
	public  function updateUnitStored(Unit $Unit)
	{
		$Sql="UPDATE `finalend`.`tbl_union` SET `t_Stored` ='".$Unit->getStored()."' 
		WHERE `tbl_union`.`i_Id` =".$Unit->getId();
		return $this->executeNonQuery($Sql);
	}
	
	
	public  function updateUnit(Unit $Unit)
	{
		$Sql="UPDATE `tbl_union` SET
		 `s_Name` = '".$Unit->getName()."',
		`t_Units` = '".$Unit->getUnits()."',
		`i_DMG` = '".$Unit->getDMG(true)."',
		`i_Amor` = '".$Unit->getAmor(true)."',
		`i_Speed` = '".$Unit->getSpeed(true)."',
		`i_Healts` = '".$Unit->getHealts(true)."',
		`i_UserId` = '".$Unit->getUserId()."',
		`i_ExtentionOne` = '".$Unit->getExtentionOne(true)."',
		`i_ExtentionTwo` = '".$Unit->getExtentionTow(true)."',
		`i_X` = '".$Unit->getX()."',
		`i_Y` = '".$Unit->getY()."',
		`f_State` = '".$Unit->getState()."',
		`i_Storage` = '".$Unit->getStorage(true)."',
		`t_Stored` = '".$Unit->getStored()."',
		`i_Experience` = '".$Unit->getExperience()."',
		`i_Level` = '".$Unit->getLevel()."' 
		WHERE `tbl_union`.`i_Id` =".$Unit->getId();	
		return $this->executeNonQuery($Sql);
	}
	
	public  function updateUnitNoneOriginal(Unit $Unit)
	{
		$Sql="UPDATE `tbl_union` SET
		 `s_Name` = '".$Unit->getName()."',
		`t_Units` = '".$Unit->getUnits()."',
		`i_DMG` = '".$Unit->getDMG()."',
		`i_Amor` = '".$Unit->getAmor()."',
		`i_Speed` = '".$Unit->getSpeed()."',
		`i_Healts` = '".$Unit->getHealts()."',
		`i_UserId` = '".$Unit->getUserId()."',
		`i_ExtentionOne` = '".$Unit->getExtentionOne()."',
		`i_ExtentionTwo` = '".$Unit->getExtentionTow()."',
		`i_X` = '".$Unit->getX()."',
		`i_Y` = '".$Unit->getY()."',
		`f_State` = '".$Unit->getState()."',
		`i_Storage` = '".$Unit->getStorage()."',
		`t_Stored` = '".$Unit->getStored()."',
		`i_Experience` = '".$Unit->getExperience()."',
		`i_Level` = '".$Unit->getLevel()."' 
		WHERE `tbl_union`.`i_Id` =".$Unit->getId();	
		return $this->executeNonQuery($Sql);
	}
	
	
	public  function updateRessource(Unit $Unit)
	{
		$Sql="UPDATE `tbl_union` SET
		`t_Stored` = '".$Unit->getStored()."'
		WHERE `tbl_union`.`i_Id` =".$Unit->getId();	
		return $this->executeNonQuery($Sql);
	}
	
	
	
	public function updateUnitLevel()
	{
		$Sql="UPDATE `tbl_union` SET `i_Level` = i_Level+1 
			WHERE i_Experience > 2375 * ( i_Level +1 ) * ( i_Level +1 ) -1875  * ( i_Level +1 ) and i_Level<".UNIT_MAX_LEVEL;
		return  $this->MySql->executeNoneQuery($Sql);
	}
	
	
	
	public  function insertTask(Task $Task)
	{
		$Sql="INSERT INTO `tbl_unittask` (
		`i_Id` ,
		`i_X` ,
		`i_Y` ,
		`i_Refresh` ,
		`i_UnitId` ,
		`t_Action`,
		`b_Message` 
		)
		VALUES (
		'', ".$Task->getX().", ".$Task->getY().", '".microtime(true)."', '".$Task->getUnitId()."', '".$Task->getAction()."','".$Task->getMessage()."'
		)";	
		return $this->executeNonQuery($Sql);
	}
	
	public  function updateTask(Task $Task)
	{
		$Sql="UPDATE `tbl_unittask` SET 
		`i_X` = '".$Task->getX()."',
		`i_Y` = '".$Task->getY()."',
		`i_Refresh` = '".$Task->getRefresh()."',
		`i_UnitId` = '".$Task->getUnitId()."',
		`t_Action` = '".$Task->getAction()."',
		`b_Message` = '".$Task->getMessage()."'
		 WHERE `i_Id` =".$Task->getId();	
		return $this->executeNonQuery($Sql);
		
		
	}

	public  function updateTaskRefresh(Task $Task)
	{
		$Sql="UPDATE `tbl_unittask` SET `i_Refresh` = '".microtime(true)."' WHERE `i_Id` =".$Task->getId();	
		return $this->executeNonQuery($Sql);
	}


	
	public  function deleteTaskByUnit(Unit $Unit)
	{
		$Sql="DELETE FROM `tbl_unittask` WHERE `i_UnitId` = ".$Unit->getId();	
		return $this->executeNonQuery($Sql);
	}
	public  function deleteTask(Task $Task)
	{
		$Sql="DELETE FROM `tbl_unittask` WHERE `i_Id` = ".$Task->getId();	
		return $this->executeNonQuery($Sql);
	}
   	public  function deleteBattle(Battle $Battle)
	{
		$Sql="DELETE FROM `tbl_battle` WHERE `tbl_battle`.`i_Id` = ".$Battle->getId();	
		 $this->executeNonQuery($Sql);
		$Sql="DELETE FROM `tbl_battleunit` WHERE `tbl_battleunit`.`i_BattleId` =".$Battle->getId();	
		return $this->executeNonQuery($Sql);
	}

	public function deleteUnitByBattle(Unit $Unit)
	{
		$Sql="DELETE FROM `tbl_battleunit` WHERE `tbl_battleunit`.`i_UnitId` = ".$Unit->getId();	
		$this->executeNonQuery($Sql);
		
	}
	 
	
	public  function deleteUnitCollection(UnitCollection $UnitCollection)
	{
		foreach($UnitCollection as $Unit)
		{
			$this->deleteUnit($Unit);
		}
	}

	/**
	 * löscht die unit aus tbl Union und aus der battle union verknüpfung
	 *
	 * @param int $Unit 
	 * @return die zeilen die gelöscht wurden 
	 *
	 */
	public  function deleteUnit(Unit $Unit)
	{
		$Sql="DELETE FROM `tbl_union` WHERE `tbl_union`.`i_Id` =  ".$Unit->getId();	
		$this->executeNonQuery($Sql);
		
		$Sql="DELETE FROM `tbl_routeunit` WHERE `tbl_routeunit`.`i_UnitId` = ".$Unit->getId();	// routen link löschen
		$this->executeNonQuery($Sql);
		
		$Sql="DELETE FROM `tbl_battleunit` WHERE `tbl_battleunit`.`i_UnitId` =".$Unit->getId();	
		return $this->executeNonQuery($Sql);
		
		// alle stati löschen 
		$StateManager= new StateManager();
		$StateManager->deleteStatesByUnit($Unit);
	}

	 
	public  function deleteTaskByBattle(Battle $Battle)
	{
		foreach ($Battle->getUnitCollection() as $Unit)
		{
			$this->deleteTask($Unit->getTask());
		}
	}


	public function insertBattle(Battle $Battle)
	{
		$Sql="INSERT INTO `tbl_battle` (
		`i_Id` ,
		`i_Refresh` ,
		`i_X` ,
		`i_Y` 
		)
		VALUES (
		NULL , '".microtime(true)."', '".$Battle->getX()."', '".$Battle->getY()."'
		)";
		$this->executeNonQuery($Sql); 
		$InserdId=$this->getLastInsertId();
		foreach ($Battle->getUnitCollection() as $Unit)
		{
			$this-> insertUnitToBattle($InserdId,$Unit);
		}
	}
	
	public function insertUnitToBattle($BattleId,Unit $Unit)
	{
		$Sql="INSERT INTO `tbl_battleunit` (
		`i_Id` ,
		`i_BattleId` ,
		`i_UnitId` ,
		`s_JoinTime` 
		)
		VALUES (
		NULL , '$BattleId', '".$Unit->getId()."', '".microtime(true)."'
		)";
		$this->executeNonQuery($Sql);
	}
	
	public function addUnitsToBattle($BattleId,UnitCollection $UnitCollection)
	{
		foreach($UnitCollection as $Unit)
		{
			$this->insertUnitToBattle($BattleId,$Unit);
			
		}
	}
	


	public function updateBattle(Battle $Battle)
	{
		$Sql="UPDATE `tbl_battle` 
		SET `i_Refresh` = '".microtime(true)."',
		`i_X` = '".$Battle->getX()."',
		`i_Y` = '".$Battle->getY()."' 
		WHERE `tbl_battle`.`i_Id` =".$Battle->getId();
		$this->executeNonQuery($Sql);
		foreach ($Battle->getUnitCollection() as $Unit)
		{
			$this->updateUnit($Unit);
		}
	}


}
?>