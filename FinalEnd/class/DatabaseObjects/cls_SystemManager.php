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
		$Controler_Main= Controler_Main::getInstance();
		$this->MySql= MySqldb::getInstance();
		$this->MySql->setConnection($Controler_Main->getDataBaseId());
		//$this->MySql->connect();
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
		 * daf�r da das ein daten satz eingef�gt wird
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

		

			
		
		/**
		* schick sql anfragen ab die db die keinen r�ckgabe wert haben 
		*
		* @param string $SqlCommand
		* @return bool
		*/
		protected function baseNoneGuery($SqlCommand="")
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
		
		protected function query($SqlStatment)
		{
			return $this->MySql->executeQuery($SqlStatment);	
		}
		
	/**
	* gibt die letzte eingetragene id zurück
	*
	* @return mixed This is the return value description
	*
	*/	
	public function getLastInsertId()
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
}
		
		
		
		
		

?>