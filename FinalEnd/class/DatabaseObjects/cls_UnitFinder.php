<?php
class UnitFinder extends SystemFinder
{
	private static $UserCollection=null;
	
	
	/**
	 * initialisiert die user Collection
	 * 
	 * 
	 */
	private static function init()
	{
		if(!self::$UserCollection)
		{
			self::$UserCollection=new UserCollection();	
		}
	}
	
	public static function reset()
	{
		if(!self::$UserCollection)
		{
			self::$UserCollection=null;	
			unset(self::$UserCollection);
		}
	}
	
	
	private function doLoad($RecordSet)
	{
		$UnitCollection = new UnitCollection();
		
		foreach ($RecordSet as $Row)
		{
			$UnitCollection->add($this->load($Row));
		}
		return $UnitCollection;
	}
	
	private function doLoadTask($RecordSet)
	{
		$TaskCollection = new TaskCollection();
		
		foreach ($RecordSet as $Row)
		{
			$TaskCollection->add($this->loadTask($Row));
		}
		return $TaskCollection;
	}
	
	protected function loadTask($Result)
	{
		return new Task($Result['i_Id'],$Result['i_X'],$Result['i_Y'],$Result['i_Refresh'],$Result['i_UnitId'],$Result['t_Action'],$Result['b_Message']);
	}
	
	protected function load($Result)
	{
		$Task= $this->findTaskByUnitId($Result['i_Id']);
		$UserFinder= new UserFinder();
		$StateFinder= new StateFinder();
		self::init();
		if(self::$UserCollection->getById($Result['i_UserId'])->getId()==0 && $Result['i_UserId']!=0)
		{
			self::$UserCollection->add($UserFinder->findById($Result['i_UserId'])); // user aus der db suchen
		}
		$User=self::$UserCollection->getById($Result['i_UserId']);// user aus der Collection holen
		$StateCollection= $StateFinder->findbyUnitId($Result['i_Id']);
		return new Unit($Result['i_Id'],$Result['s_Name'],$Result['t_Units'],$Result['i_DMG'],$Result['i_Amor'],$Result['i_Speed'],$Result['i_Healts'],$User,$Result['i_ExtentionOne'],$Result['i_ExtentionTwo'],$Result['i_X'],$Result['i_Y'],$Result['f_State'],$Result['i_Storage'],$Result['t_Stored'],$Result['i_Experience'],$Result['i_Level'],$Task,$StateCollection);
	}
	

	private function doLoadBattle($RecordSet)
	{
		$BattleCollection = new BattleCollection();
		
		foreach ($RecordSet as $Row)
		{
			$BattleCollection->add($this->loadBattle($Row));
		}
		return $BattleCollection;
	}
	
	protected function loadBattle($Result)
	{
		$UnitCollection=$this->findByBattleId($Result['i_Id']);
		return new Battle($Result['i_Id'],$Result['i_Refresh'],$UnitCollection,$Result['i_X'],$Result['i_Y']);
	}


	/**
	 * findet den Kamp zwischen den koordinaten
	 *
	 * @param int $X This is a description
	 * @param int $X2 This is a description
	 * @param int $Y This is a description
	 * @param int $Y2 This is a description
	 * @return Battle 
	 *
	 */
	public function findBattleBetweenKoordinates($X,$X2,$Y,$Y2)
	{
		$Sql="SELECT i_Id,i_Refresh,i_X,i_Y 
		FROM `tbl_battle` 
		WHERE 
		i_X
			BETWEEN ".$X." 
			AND ".$X2." 	
		and 
		i_Y BETWEEN ".$Y." 
			AND ".$Y2;
		return $this->doLoadBattle($this->executeQuery($Sql))->getByIndex(0);
	}


	/**
	 * findet kämpfe bei x und y mit der angegebenen Range
	 *
	 * @param int $X 
	 * @param int $X2 
	 * @param int $Range der abstand der Koordinaten
	 * @return Battle kann ein Null object sein
	 *
	 */
	public function findBattleByKoordinatesAndRange($X,$X2,$Range)
	{
		$Sql="SELECT i_Id,i_Refresh,i_X,i_Y 
		FROM `tbl_battle` 
		WHERE SQRT( pow( i_X - ".$X.", 2 ) + pow( i_Y - ".$Y.", 2 )  ) <".$Range2;
		return $this->doLoadBattle($this->executeQuery($Sql))->getByIndex(0);
	}
	/**
	 * findet alle Flotten die der angegebenen route folgen
	 *
	 * @param int $RouteId die Routen Id
	 * @return UnitCollection kann leer sein
	 *
	 */
	public function findAllByRoutId($RouteId)
	{
		$Sql="SELECT u.i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level FROM `tbl_union` as u ,tbl_routeunit as r
		WHERE 
		u.i_Id=r.i_UnitId 
		and 
		r.i_RouteId=".$RouteId;
		return $this->doLoad($this->executeQuery($Sql));
	}


	 
	public function countBattles()
	{
		$Sql="SELECT count( i_Id ) as Count 
		FROM tbl_battle";
		$Temp=$this->MySql->executeQuery($Sql);

		return $Temp[0]['Count'];	
	}
	
	public function countUnits()
	{
		$Sql="SELECT count( i_Id ) as Count 
		FROM tbl_union";
		$Temp=$this->MySql->executeQuery($Sql);

		return $Temp[0]['Count'];	
	}
	
	public function countUnitsByUser(User $User)
	{
		$Sql="SELECT count( i_Id ) as Count 
		FROM tbl_union
		where i_UserId=".$User->getId();
		$Temp=$this->MySql->executeQuery($Sql);

		return $Temp[0]['Count'];	
	}
	
	public function countAllUnits()
	{
		$Sql="SELECT count( i_Id ) as Count 
FROM tbl_union";
		$Temp=$this->MySql->executeQuery($Sql);

		return $Temp[0]['Count'];
		
	}
	
	
	
	
		public function countDeathStarByUser(User $User)
	{
		$Sql="SELECT count( i_Id ) as Count 
		FROM tbl_union
		where 
		i_UserId=".$User->getId()."
		and 
		(`t_Units` LIKE '%ds%' || `t_Units` LIKE '%bds%')";
		$Temp=$this->MySql->executeQuery($Sql);

		return $Temp[0]['Count'];
		
	}
	
	
	
	 
	public function findallBattles()
	{
		$Sql="SELECT i_Id,i_Refresh,i_X,i_Y 
		FROM `tbl_battle`"; 
		return $this->doLoadBattle($this->executeQuery($Sql));
	}


	
	/**
	 * gibt das battle anhand seienr Id zurück
	 *
	 * @param int $Id die Id des Battels
	 * @return Battle 
	 *
	 */
	public function findBattleById($Id)
	{
		$Sql="SELECT i_Id,i_Refresh,i_X,i_Y 
		FROM `tbl_battle`
		where i_Id=".$Id; 
		return $this->doLoadBattle($this->executeQuery($Sql))->getByIndex(0);
	}

	/**
	 * gibt als array die Ids der vorhandenen battle zurück
	 *
	 * @return array array[0][i_Id]
	 *
	 */
	public function findallBattlesAsIdArray()
	{
		$Sql="SELECT i_Id 
		FROM `tbl_battle`"; 
		return $this->executeQuery($Sql);
	}



	public  function findByBattleId($BattleId)
	{
		$Sql="SELECT tbl_union.i_Id, s_Name, t_Units, i_DMG, i_Amor, i_Speed, i_Healts, i_UserId, i_ExtentionOne, i_ExtentionTwo, i_X, i_Y, f_State, i_Storage, t_Stored, i_Experience, i_Level
		FROM `tbl_union` , tbl_battleunit
		WHERE tbl_battleunit.i_UnitId = tbl_union.i_Id
		AND tbl_battleunit.i_BattleId =".$BattleId;
		return $this->doLoad($this->executeQuery($Sql));	
	}
	
	public  function findByUserId($UserId)
	{
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level FROM `tbl_union` where i_UserId=".$UserId."
		ORDER BY s_Name";
		return $this->doLoad($this->executeQuery($Sql));	
	}
	
	
	/**
	 * findet alle Usereinheiten die sich in den angegebenen Koordinaten befunden
	 *
	 * @param int $UserId 
	 * @return UnitCollection 
	 *
	 */
	public  function findByUserIdAndBetweenKoordinates($UserId,$X,$X2,$Y,$Y2)
	{
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level 
		FROM `tbl_union` 
		where i_UserId=".$UserId." and
		
		i_X
			BETWEEN ".$X." 
			AND ".$X2." 	
		and 
		i_Y BETWEEN ".$Y." 
			AND ".$Y2;
		return $this->doLoad($this->executeQuery($Sql));		
	}
	
	public  function findByKoordinatesInRange($X,$Y,$Range)
	{
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level 
		FROM `tbl_union` 
		WHERE SQRT( pow( i_X - ".$X.", 2 ) + pow( i_Y - ".$Y.", 2 )  ) <".$Range;
		
		return $this->doLoad($this->executeQuery($Sql));

	}
	
	
	public  function findByUserIdAndKoordinatesInRange($UserId,$X,$Y,$Range)
	{
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level 
		FROM `tbl_union` 
		WHERE `i_UserId` = ".$UserId." AND SQRT( pow( i_X - ".$X.", 2 ) + pow( i_Y - ".$Y.", 2 )  ) <".$Range;
		
		return $this->doLoad($this->executeQuery($Sql));

	}
	
	
	
	
	/**
	 * findet den task mit der angegebenen Id
	 *
	 * @param int $UnitId zugehrige UnitId
	 * @return Task 
	 *
	 */
	public  function findTaskByUnitId($UnitId)
	{
		$Sql="SELECT i_Id,i_X,i_Y,i_Refresh,i_UnitId,t_Action,b_Message FROM tbl_unittask where i_UnitId=".$UnitId;
		$TaskCollection=$this->doLoadTask($this->executeQuery($Sql));
		return $TaskCollection->getByIndex(0);
	}
	
	public  function findAllTask()
	{
		$Sql="SELECT i_Id,i_X,i_Y,i_Refresh,i_UnitId,t_Action,b_Message FROM tbl_unittask ";
		return $this->doLoadTask($this->executeQuery($Sql));
	}
	
	public  function findTaskByUnitsCollection(UnitCollection $UnitCollection)
	{
		$Sql="SELECT i_Id,i_X,i_Y,i_Refresh,i_UnitId,t_Action,b_Message FROM tbl_unittask ";
		
		if($UnitCollection->getCount()>0)
		{
			$Sql.="where ";	
		}
		for($i=0;$UnitCollection->getCount()>$i;$i++)
		{
			$Unit=$UnitCollection->getByIndex($i);
			$Sql.="i_UnitId = ".$Unit->getId();
			if($UnitCollection->getByIndex($i+1)->getId()!=0)
			{
				$Sql.=" or ";
			}
		}
		
		return $this->doLoadTask($this->executeQuery($Sql));
	}
	
	public  function findAllTaskByUnit(Unit $Unit)
	{
		$Sql="SELECT i_Id,i_X,i_Y,i_Refresh,i_UnitId,t_Action,b_Message FROM tbl_unittask where i_UnitId=".$Unit->getId();
		return $this->doLoadTask($this->executeQuery($Sql));
	}
	
	public function findAllWithTask()
	{
		$Sql="SELECT tbl_union.i_Id AS i_Id, s_Name, t_Units, i_DMG, i_Amor, i_Speed, i_Healts, i_UserId, i_ExtentionOne, i_ExtentionTwo, tbl_union.i_X, tbl_union.i_Y, f_State, i_Storage, t_Stored, i_Experience, i_Level
			FROM `tbl_union` 
			JOIN tbl_unittask ON tbl_union.i_Id = tbl_unittask.i_UnitId";
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	/**
	 * findet die einheiten die eine aufgabe haben und ein kolo trupp sind
	 *
	 * @return UntiCollection 
	 *
	 */
	public function findAllWithTaskAndKolo()
	{
		$Sql="SELECT tbl_union.i_Id AS i_Id, s_Name, t_Units, i_DMG, i_Amor, i_Speed, i_Healts, i_UserId, i_ExtentionOne, i_ExtentionTwo, tbl_union.i_X, tbl_union.i_Y, f_State, i_Storage, t_Stored, i_Experience, i_Level
			FROM `tbl_union` 
			JOIN tbl_unittask ON tbl_union.i_Id = tbl_unittask.i_UnitId
			WHERE i_ExtentionTwo = 17";
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	/**
	 * gibt alle flotte mit dem märtyrer zurück die einen auftrag haben
	 *
	 * @return UnitCollection kann keine element enthalten
	 *
	 */
	public function findAllWithTaskAndMartyr()
	{
		$Sql="SELECT tbl_union.i_Id AS i_Id, s_Name, t_Units, i_DMG, i_Amor, i_Speed, i_Healts, i_UserId, i_ExtentionOne, i_ExtentionTwo, tbl_union.i_X, tbl_union.i_Y, f_State, i_Storage, t_Stored, i_Experience, i_Level
			FROM `tbl_union` 
			JOIN tbl_unittask ON tbl_union.i_Id = tbl_unittask.i_UnitId
			WHERE i_ExtentionOne = 23";
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	public function findAll()
	{
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level FROM `tbl_union`";
		return $this->doLoad($this->executeQuery($Sql));
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
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level FROM `tbl_union` where i_Id=".$UnitId;
		$TempCollection=$this->doLoad($this->executeQuery($Sql));
		return $TempCollection->getByIndex(0);
	}
	
	public function findByKoordinates($X,$Y)
	{
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level FROM `tbl_union`
		 where i_X=".$X." and i_Y=".$Y;
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	public function findBetweenKoordinates($X,$X2,$Y,$Y2)
	{
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level FROM `tbl_union`
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
	 * gibt an ob die Flotte im Kampf ist
	 *
	 * @param int $Id die Id der Flotte
	 * @return bool 
	 *
	 */
	public function isUnitInBattle($Id)
	{
		$Sql="SELECT count( * ) AS UnitCount
			FROM `tbl_battleunit` 
			WHERE `i_UnitId` =".$Id;
		$Temp=$this->executeQuery($Sql);	
		return $Temp[0]['UnitCount'];
	}
	
	
	public function areUnitsInbattle(UnitCollection $UnitCollection)
	{
		$State=0;
		$Counter=0;
		foreach($UnitCollection as $Unit)
		{
			if($this->isUnitInBattle($Unit->getId()))
			{
				$Counter++;
				$State=1;
			}
		}
		if($UnitCollection->getCount()==$Counter)// wenn alle in einem Kampf sind
		{
			$State=2;
		} 
		
		return $State;
	}
	
	
	public  function findDestroyedUnit()
	{
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level FROM `tbl_union` where f_State<=0";
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
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level
			FROM `tbl_union` 
			WHERE SQRT( pow( i_X - ".$X.", 2 ) + pow( i_Y - ".$Y.", 2 )  ) <".$Range;
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	public function findAllByPlanetKoordinates($X,$Y,$Range,$Start=0,$Limit=15)
	{
		$Sql="SELECT i_Id,s_Name,t_Units,i_DMG,i_Amor,i_Speed,i_Healts,i_UserId,i_ExtentionOne,i_ExtentionTwo,i_X,i_Y,f_State,i_Storage,t_Stored,i_Experience,i_Level
			FROM `tbl_union` 
			WHERE SQRT( pow( i_X - ".$X.", 2 ) + pow( i_Y - ".$Y.", 2 )  ) <".$Range." 
			limit ".$Start.",".$Limit;
		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	/**
	 *	Zählt die Flotten um die angegeben Koordinaten 
	 * 
	 **/
	public function countAllByPlanetKoordinates($X,$Y,$Range)
	{
		$Sql="SELECT count(i_Id) as Count
			FROM `tbl_union` 
			WHERE SQRT( pow( i_X - ".$X.", 2 ) + pow( i_Y - ".$Y.", 2 )  ) <".$Range;
		$Temp=$this->executeQuery($Sql);
		return $Temp[0]['Count'];
		
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	/**
	 * findet den DMG aller Flotten des angegebenen Users
	 *
	 * @param User $User der User dessen DMG gefunden werden soll
	 * @return int 
	 *
	 */
	public function findDMGByUser(User $User)
	{
		$Sql="SELECT Sum( i_DMG + i_DMG * ( i_Level * 0.1 ) ) AS DMG
				FROM `tbl_union` 
				WHERE i_UserId =".$User->getId();
		$Temp=$this->executeQuery($Sql);
		return $Temp[0]['DMG'];
		//return $this->doLoad($this->MySql->getResult());
	}
	
}?>