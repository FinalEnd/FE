<?php

/**
 * class cls_ClickFinder
 *
 * die angabe der  Variable $Day wird angegeben in tagen d.h es wird immer der aktuelle datum des server genommen und din anzahl an tage/ Monate abgezogen
 *
 * @author: Matthias Herzog
*/
class ClickFinder extends SystemFinder 
{
	
	function __construct() 
	{
		parent::__construct();
	}
	
	
	protected function doLoad($RecordSet)
	{
		$ClickCollection = new ClickCollection();
		foreach ($RecordSet as $Row)
		{
			$ClickCollection->add($this->load($Row));
		}
		return $ClickCollection;
	}
	
	protected function load($Result)
	{
		$UserFinder= new UserFinder();
		$TempUser=$UserFinder->findById($Result['i_UserId']);
		return new Click($Result['i_Id'],$Result['s_Ip'],$Result['d_Date'],$Result['t_ParamString'],$TempUser);
	}
	
	
	/**
	 * gibt den count der besucher zurück
	 *
	 * @return int 
	 *
	 */
	public function findAllHitsCount()
	{// count im sql geht nicht bringt komische ergebnisse zurück :(
		$Sql="SELECT i_Id
				FROM `tbl_click` 
				GROUP BY s_Ip";	
		return count($this->executeQuery($Sql));
	}
	
	/**
	 * findet alle ips die sich von heute - Day  gemacht wurden
	 * hits sind die personen die auf die seite zugegriffen haben und Clicks sind die einzelnen seiten aufrufe
	 *
	 * @param int $Day gibt den tag an der gefunden werden soll 0= heute, 1 = gestern, 2= vorgestern, usw.
	 * @return ClickCollection 
	 *
	 */
	public function findByHitsDay($Day=0)
	{
		$Sql="SELECT * 
				FROM `tbl_click` 
				WHERE DATE_FORMAT( d_Date, '%X-%m-%d' ) = DATE_FORMAT( now( ) - INTERVAL ".$Day." 
				DAY , '%X-%m-%d' ) 
				GROUP BY s_Ip";	
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	/**
	 * gibt nur den COunt zurück
	 *
	 * @param int $Day die tage - now()
	 * @return int 
	 *
	 */
	public function findByHitsDayCount($Day=0)
	{
		$Sql="SELECT count( * )  as Count 
				FROM `tbl_click` 
				WHERE DATE_FORMAT( d_Date, '%X-%m-%d' ) = DATE_FORMAT( now( ) - INTERVAL ".$Day." 
				DAY , '%X-%m-%d' ) 
				GROUP BY s_Ip";	
		$TempResult=$this->executeQuery($Sql);
		return 	$TempResult[0]['Count'];
	}
	
	
	/**
	* findet alle ips die sich von heute - Day gemacht wurden
	* hits sind die personen die auf die seite zugegriffen haben und Clicks sind die einzelnen seiten aufrufe
	*
	* @param int $Day gibt den tag an der gefunden werden soll 0= heute, 1 = gestern, 2= vorgestern, usw.
	* @return ClickCollection 
	*
	*/
	public function findByHitsMonth($Month=0)
	{
		$Sql="SELECT * 
				FROM `tbl_click` 
				WHERE DATE_FORMAT( d_Date, '%X-%m' ) = DATE_FORMAT( now( ) - INTERVAL ".$Month." 
				MONTH , '%X-%m' ) 
				GROUP BY s_Ip";	
		return $this->doLoad($this->executeQuery($Sql));
	}
	
	
	
	public function findClicksByDay($Day=0)
	{
		$Sql="SELECT count(*) as Count
				FROM `tbl_click` 
				WHERE DATE_FORMAT( d_Date, '%X-%m-%d' ) = DATE_FORMAT( now( ) - INTERVAL ".$Day."  
				DAY , '%X-%m-%d' ) ";
		$TempResult=$this->executeQuery($Sql);
		return 	$TempResult[0]['Count'];
	}
	
	/**
	* findet alle seiten aufrufe die im system gemacht worden sind 
	*
	* @return int 
	*
	*/
	public function findClicksByMonth($Month=0)
	{
		$Sql="SELECT count(*) as Count
				FROM `tbl_click` 
				WHERE DATE_FORMAT( d_Date, '%X-%m' ) = DATE_FORMAT( now( ) - INTERVAL ".$Month."  MONTH , '%X-%m' ) ";
		$TempResult=$this->executeQuery($Sql);
		return 	$TempResult[0]['Count'];
	}
	
	/**
	 * findet alle klicks die im system gemacht worden sind
	 *
	 * @return int 
	 *
	 */
	public function findAllClicks()
	{
		$Sql="SELECT count( * )  as Count
				FROM `tbl_click`";
		$TempResult=$this->executeQuery($Sql);
		return 	$TempResult[0]['Count'];
	}
	
}

?>