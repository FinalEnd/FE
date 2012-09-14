<?php


abstract class SystemManager
{
	/**
	 * die Mysql schnittstelle
	 *
	 * @var MySqldb
	 */
	public  $MySql=null;
	private $Result= Array();
	
	public function __construct()
	{
		
		$this->MySql = MySqldb::getInstance();
	}
	
	/**
		 * funktion zur ausführung von lösch und update befehlen
		 *
		 * @param string $UpdateStatement
		 * @return true oder im fehler fall false
		 */
		protected function Update($UpdateStatement)
		{
				//echo "im update drin";
				if(!is_string($UpdateStatement)){return false;}
			if(!$this->MySql->executeNoneQuery($UpdateStatement)){return false;}
				return true;
		}
		/**
		 * dafür da das ein daten satz eingefügt wird
		 *
		 * @param string $InsertStatement
		 * @return true oder im fehler fall false
		 */
		protected function Insert($InsertStatement)
		{
				if(!is_string($InsertStatement)){return false;}
		if(!$this->MySql->executeNoneQuery($InsertStatement)){return false;}
				return true;
			
		}

		

			

			
	protected function baseNoneQuery($SqlCommand="")
	{
		if($this->MySql->executeNoneQuery($SqlCommand))
		{
			return true;
		}
		else
		{
			return false;
		}
		
	}
		
		protected function query($sqlCommand="")
		{
			$this->MySql->Abfrage($sqlCommand);
			return $this->MySql->getResult();	
		}
		
	/**
	* gibt die letzte eingetragene id zurück
	*
	* @return mixed This is the return value description
	*
	*/	
	protected function getLastInsertId()
	{
		return 	$this->MySql->getLastId();
	}
		
	/**
	* schicckt einen sql befehl zur datenbank
	*
	* @param string $SqlStatment This is a description
	* @return bool wenn etwas gelöscht hinzugefügt oder verändert wird true zurück gegeben.
	*
	*/
	protected function executeNonQuery($SqlStatment)
	{
		return $this->MySql->executeNoneQuery($SqlStatment);
	}
	
	
	/**
	 * gibt die zuletzt eingefügte ID wider zurück
	 *
	 * @return int 
	 *
	 */
	public function getLasId()
	{
		return $this->MySql->getLastId();
	}	
		
		
}
		
		
		
		
		

?>