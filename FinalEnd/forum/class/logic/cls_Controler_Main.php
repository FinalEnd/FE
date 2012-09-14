<?php

class Controler_Main
{

	private $User;
	private static $Instance;
	/**
	* singelton
	*
	* @return Controler_Main 
	*
	*/
	public static  function getInstance()
	{
		if(self::$Instance===null)
		{
			self::$Instance = new Controler_Main();	
		}
		return self::$Instance;	
	}


	/**
	 * der Contructor
	 *
	 * @return void 
	 *
	 */
	public function __construct()
	{

		$this->loadConfig();	// config ins system laden
		$this->User=User::getEmptyInstance(); // user erzeugen
		$this->mappUser();
		$this->setLastLink();// lastlink setzen
		
		
	}	
	
	private function setLastLink()
	{
		$_SESSION['LASTPADGE']=$_SESSION['ACTIVEPADGE'];
		$_SESSION['ACTIVEPADGE']=$_SERVER["REQUEST_URI"];
		define("LAST_PAGE",$_SESSION['LASTPADGE']);
	}
	
	 public function getUser()
	{
		return $this->User;	
	}

	public function checkUserLevel($SecurityLevel)
	{				
		return true;			
	}

	/**
	 * lädt die einstellungen für das system aus der config datei
	 *
	 * @return  
	 *
	 */
	private static function loadConfig()
	{
		@include("cfg/cfg.php");
		@include("class/const/const.php");
	}


	/**
	* loggt den User ein
	*
	* @return bool 
	*
	*/

	
	/**
	 * loggt den User Über die Cookies ein
	 *
	 * @return bool This is the return value description
	 *
	 */
	private function userLogin()
	{
		$User = User::getInstance();
		$User->mapper();
		
		//var_dump($_COOKIE);
		if($User->getId()==0 && !empty($_COOKIE['UserName']) && !empty($_COOKIE['UserPass']) )
		{
			//$User->login($_COOKIE['UserName'],$_COOKIE['UserPass']);
			$this->mappUser();
		}
	}
	
	
		
	/**
	 *  holt den User Aus der Session / db un legt Ihn in den Controller macht auserdem noch den lastrefresh des Users in der DB
	 *
	 * @return void 
	 *
	 */
	private function mappUser()
	{
		$UserFinder= new UserFinder();
		//var_dump($_SESSION);
		if(!$_SESSION['DataBase'] || !$_SESSION['UserName']|| !$_SESSION['UserPass']){$Error=1;}
		if($Error)
		{
			$this->User=User::getEmptyInstance();	
			return false;
		}
		//echo $_SESSION['DataBase'];
		//var_dump($_SESSION);
		$TempUser=$UserFinder->findByNameAndPass($_SESSION['UserName'],$_SESSION['UserPass'],$_SESSION['DataBase']);
		//var_dump($TempUser);
		if($TempUser->getId())
		{	
			$this->User=$TempUser;	
			return true;
		}
		return false;
	}

	
	
	private function loggOut()
	{
		$User = User::getInstance();
		setcookie ("UserName", "",time()-60*60*24);
		setcookie ("UserPass", "",time()-60*60*24);
		$User->logout();
		
		//$Template= new Template ("tpl_News.php");
		$Template= new Template ("system/tpl_LogOut.php");
		$Template->render();
		return true;
	}
	
	
	// Diese Function startet das system
	public function start()
	{
		$Request= new Request();

		//echo $_SESSION['DataBase'];
		//echo $this->User->getGroup(10);

		switch($Request->getAsString('section'))
		{
			
			case "Login":
			{
				$this->login();
			}break;
			case "Forum": 
			{
				$Controler= new Controler_Forum();
				$Controler->start();
			}break;
			
			case "Impressum": 
			{
				$this->showImpressum();
			}break;
			
			case "logout": 
			{
				$this->loggOut();
			}break;
			
			case"login":
			{				
				$this->login();
			}break;
			
			default:
				$Controler= new Controler_Forum();
				$Controler->start();

				break;
			
		}
		
		
		
		
	}
	
	
	/**
	 * gibt eine messageCollection des userers zurück
	 *
	 * @param string $UserName 
	 * @return UserCollection 
	 *
	 */
	public static function getMessageByUserName($UserName)
	{
		$MessageFinder= new MessageFinder();
		return $MessageFinder->findUnReadByResiver($UserName);	
	}
	
	
	private function showImpressum()
	{
		$Template= Template::getInstance("tpl_Impressum.php");
		$Template->render();	
	}
	
	
	
	/**
	* gibt ein zufälliges passwort mit der angegeben länge zurück
	*
	* @param int $Length
	* @return string
	*/
	function getRandomPass($Length=6)
	{
		$Pool = "qwertzupasdfghkyxcvbnm";
		$Pool .= "23456789";
		$Pool .= "WERTZUPLKJHGFDSAYXCVBNM";
		srand ((double)microtime()*1000000);
		for($Index = 0; $Index < $Length; $Index++)
		{
			$PassWord .= substr($Pool,(rand()%(strlen ($Pool))), 1);
		}
		return $PassWord;
	}
	
	
	
}

?>