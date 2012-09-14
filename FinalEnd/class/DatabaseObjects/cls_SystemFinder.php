<?php


abstract class SystemFinder 
{
	/**
	 * die mysql schnittstelle
	 *
	 * @var MySqldb
	 */
	protected $MySql = null;
	
	public function __construct()
	{
		$Controler_Main= Controler_Main::getInstance();
		$this->MySql= MySqldb::getInstance();
		$this->MySql->setConnection($Controler_Main->getDataBaseId());
		//$this->MySql->connect();
	}
	
	protected function load($SqlStatment="")
	{
		return $this->MySql->executeQuery($SqlStatment);		
	}
	
	
	/**
	 * schickt das statment zur datenbank und gibt die ergebnissmenge zurück
	 *
	 * @param string $SqlStatment 
	 * @return array die ergebnissmenge der abfrage
	 *
	 */
	protected function executeQuery($SqlStatment)
	{
		return $this->MySql->executeQuery($SqlStatment);
	}
	
	
}


?>