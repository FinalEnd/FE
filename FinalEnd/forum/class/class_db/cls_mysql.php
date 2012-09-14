<?php

//require_once('cls_mysql_exeption.php');




class MySqlDb
{

	private $Connection;
	private $Server=DB_SERVER;
	private $User=DB_USER;
	private $PassWord=DB_PASS;
	private $DataBase=DB_DATABASE;
	private static $Instance=null;
	private $ConnectionState;
	private $Result;
	
	private function __construct()
	{
		$this->Connection=mysql_connect($this->Server,$this->User,$this->PassWord);
		
		if ($this->Connection)
		{
			mysql_select_db($this->DataBase, $this->Connection);
			$result = mysql_query("SET NAMES 'utf8'",$this->Connection);
			$result = mysql_query("SET CHARACTER SET 'utf8'",$this->Connection); 
			$this->ConnectionState=true;
		}
	}
	
	
	
	/**
	 * gibt einen instance vom type mysql zurück
	 *
	 * @return MySqlDb 
	 *
	 */
	public static function getInstance()
	{
		if(self::$Instance===null)
		{
			self::$Instance= new MySqlDb();	
		}
		return self::$Instance;	
	}
	
	
	private function connect()
	{
		@$this->Vid = mysql_connect($this->Host,$this->User,$this->Pass);
		if(!is_resource($this->Vid))
		{
			echo"es konnte keine verindung zur datenbank aufgebaut werden!";
			die();
		}	
		mysql_query('set character set utf8;');
	}
	


	public function close()
	{
		mysql_close($this->Connection);
	}


	public function executeQuery($query)
	{
		$Result=array();
		if (!is_resource($this->Connection)) {return $Result;}
		//echo "im mysql drinnen :".$query;
		$this->Result = mysql_query($query,$this->Connection);
		//var_dump($this->Result);
		if(!$this->Result){return $Result;}
		$Result=array();
		try
		{
			while($row = mysql_fetch_assoc($this->Result))
			{
				$Result[] = $row;
			}
			$this->Result=$Result;
			return $Result;
			
		}catch(exeption $e)
		{
			$this->Result=$Result;
			return 	$Result;
		}
	}

	public function executeNoneQuery($SqlStatment)
	{
		if (!is_resource($this->Connection)){return false;}
		
		// hier nun statment absetzen
		$Result=mysql_query($SqlStatment,$this->Connection);
		if(!$Result)
		{
			echo mysql_error();
			return false;
		}
		else
		{
			return mysql_affected_rows();
		}
	}

	/**
	 * gibt die letzte eingefügte ID zurück
	 *
	 * @return int
	 */
	public function getLastId()
	{
		return mysql_insert_id($this->Connection);	
	}

	public function getResult()
	{
		$this->Result;
	}


}










?>