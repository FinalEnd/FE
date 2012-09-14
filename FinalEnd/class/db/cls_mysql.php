<?php

//require_once('cls_mysql_exeption.php');




class MySqldb
{

	private $Connection;
	private $Server=DB_SERVER;
	private $User=DB_USER;
	private $PassWord=DB_PASS;
	private $DataBase=DB_DATABASE;
	private static $Instance=null;
	private $ConnectionState;
	private $Result;
	private $ServerId;
	
	private function __construct()
	{
		$this->ServerId=false;
		$this->ConnectionState=false;
		$this->Connection=null;
		/*$this->Connection=mysql_connect($this->Server,$this->User,$this->PassWord);
		
		if ($this->Connection)
		{
			mysql_select_db($this->DataBase, $this->Connection);
			$result = mysql_query("SET NAMES 'utf8'",$this->Connection);
			$result = mysql_query("SET CHARACTER SET 'utf8'",$this->Connection); 
			$this->ConnectionState=true;
		}*/
	}
	
	
	public function setServerId($ServerId)
	{
		$this->ServerId=$ServerId;
	} 
	 
/**
	*   setter DataBase
*
* return string
*/
	public function setDataBase($DataBase)
	{
		$this->DataBase=$DataBase;
	}
/**
	*   setter PassWord
*
* return string
*/
	public function setPassWord($PassWord)
{
		$this->PassWord=$PassWord;
}
	
/**
	*   setter User
*
* return string
*/
	public function setUser($User)
{
		$this->User=$User;
}
	
	
	public function setIP($Ip)
	{
		$this->Server=$Ip;
		
	}
	
	
	
	public function setConnection($ConnectionIndex)
	{
		if($this->ServerId===$ConnectionIndex && $this->ConnectionState && is_resource($this->Connection))
		{
			return true;
		}
		$this->close();
		@include("cfg/db".$ConnectionIndex.".php");
		$this->connect();
		$this->ServerId=$ConnectionIndex;
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
	
	
	public function connect()
	{
		if( $this->ConnectionState && is_resource($this->Connection))
		{
			return true;
		}	
		$this->Connection=mysql_connect($this->Server,$this->User,$this->PassWord,true);
		//var_dump($this);
		if ($this->Connection)
		{
			mysql_select_db($this->DataBase, $this->Connection);
			$result = mysql_query("SET NAMES 'utf8'",$this->Connection);
			$result = mysql_query("SET CHARACTER SET 'utf8'",$this->Connection); 
			$this->ConnectionState=true;
			return true;
		}
		return false;
	}
	


	public function close()
	{
		if(!$this->ConnectionState)	{return false;}
		mysql_close($this->Connection);
		$this->ConnectionState=false;
		$this->ServerId=false;
	}


	public function executeQuery($query)
	{
		$Result=array();
		if (!is_resource($this->Connection)) {return $Result;}
		//echo "im mysql drinnen :".$query;
		if(!$this->ConnectionState)	  {return false;}
		$this->Result = mysql_query($query,$this->Connection);
		//var_dump($this->Result);
		echo mysql_error();
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
			//echo mysql_error();
			$this->Result=$Result;
			return $Result;
		}
	}

	public function executeNoneQuery($SqlStatment)
	{
		if (!is_resource($this->Connection)){return false;}
		//var_dump($this);
		// var_dump($this->Connection);
		// hier nun statment absetzen
		if(!$this->ConnectionState){return false;}
		$Result=mysql_query($SqlStatment,$this->Connection);
		if(!$Result)
		{
			//echo mysql_error();
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