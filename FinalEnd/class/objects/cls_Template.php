<?php
/**
 * Programm: klasse für das dynamische zuweisen von templates über die bl
 * Type: Template
 * Description: mit diesem script ist es möglich temlates über die bl zu legen und so dynamischen im
 * design zu bleiben
 * Autor: Matthias Herzog 
 **/

class Template
{
	private $Header="tpl_Header.php";
	private $Content="tpl_Default.php";
	private $Footer="tpl_Footer.php";
	private $Templates = array();// templates die zu variabelen gemacht werden sollen
	private $Vars = array();	// die variabelen
	private static $Instance=null;
	private $Language;
	
	
	
	/**
	 * setzt den Pfad der sprechdateien
	 *
	 * @param string $Language nur der sufix der Sprachdatei  Lang_Ger.php ==> Ger
	 * @return void 
	 *
	 */
	public function setLanguage($Language)
	{
		$this->Language=$Language;
	}
	
	/**
	 * gibt eine instance vom typ Template zurück
	 *
	 * @param string $Template das template das geladen werden soll
	 * @return Template
	 *
	 */
	public static function getInstance($Template="")
	{
		if(self::$Instance===null)
		{
			self::$Instance = new Template($Template);	
		}
		self::$Instance->setTemplate($Template);
		return self::$Instance;	
	}
	
	public function __construct($Template="")
	{
		$this->Content=$Template;
	}
		
	public function setTemplate($Template)
	{
		$this->Content=$Template;
	}
	
	
	/**
	 * entfernt alle templates/ variabelen aus dem objekt 
	 *
	 * @return bool 
	 *
	 */
	public function clear()
	{
		$this->Content="";
		$this->Footer="";
		$this->Header="";
	}
	
	
	/**
	 * fügt eine neue ausgabe zum output hinzu
	 * es wird dann im template nach dem namen gesucht und dieser mit dem value ersetzt 
	 * achtung wenn array übergeben werden 
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function assign($Name,$Value)
	{
		$this->Vars[$Name]=$Value;
	}
	
	public function assignTemplate($Name,$Value)
	{
		$this->Templates[$Name]=$Value;
	}
	
	private function renderTemplates()
	{
		foreach($this->Templates as $Template)
		{
			ob_start();
			if ($Template)
			{
				require_once("./view/".$Template); // hier die ausgaben
			}	
			$this->assign(key($Template),ob_get_clean());
		}
	}
	
	
	public function render()
	{
		echo $this->renderWithoutSend();
	}
	
	/**
	 * rendert das TEMPLATE 
	 *
	 * @param bool $LanguageParsing gibt an ob die sprache geparst werden soll oder nicht
	 * @return string 
	 *
	 */
	public function renderWithoutSend($LanguageParsing=true)
	{
		header('content-type: text/html; charset=utf-8');
		ob_start();
		if($this->Content)
		{
			require_once("./view/".$this->Content); // hier die ausgaben
		}	
		$data=ob_get_clean(); // gibt ausgabe puffer zurück und löscht den puffer
		if($LanguageParsing)
		{
			$data=$this->rePlaceLanguage($data);
		}
		return $data;
	}
	
	
	public function rePlaceLanguage($Data)
	{
		// sprach datei laden 
		if(file_exists("./language/lang_".$this->Language.".php"))
		{
			$LangArray = $this->loadLanguageFile("./language/lang_".$this->Language.".php");
		}else
		{
			$LangArray = $this->loadLanguageFile("./language/lang_Ger.php");
		}
		// platzhalter im text ersetzen	
		$SearchArray=array_keys($LangArray);
		$ValueArray=array_values($LangArray);
		/*for($i=0;$i<count($SearchArray);$i++)
		{   */
			$Data= str_replace($SearchArray,$ValueArray,$Data);
		/*}	*/
		return $Data;
	}
	
	public function loadLanguageFile($File)
	{
		$TextArray="";
		$Text = file ($File);
		
		foreach ($Text as $Row) 
		{
			$Key="";
			$RowText="";
			$Temp=explode("=",$Row);
			$TextArray[trim($Temp[0])]=trim($Temp[1]);
			//$TextArray
			//echo $Row;
			
		}
		return $TextArray;
	}
	
	/**
	 * gibt die fehlerseite aus, mit den angegebenen parametern
	 *
	 * @param string $Header die überschrift des fehlers
	 * @param string $Error die fehler beschreibung
	 * @param string $BackLink der link zu vorhergehenden seite (index.php?section=NextLan)
	 * @return void macht eine ausgabe auf den bildschirm
	 *
	 */
	public  function renderError($Header,$Error,$BackLink)
	{
		$this->setTemplate("tpl_Error.php");
		$this->Assign("ErrorHeader",$Header);
		$this->Assign("ErrorString",$Error);
		$this->Assign("LastPage",$BackLink);
		$this->render();
	}
	
	
	
	
	/**
	 * wird zum suchen inerhalb des templates gebrauch wenn eine variabele gesucht wir die nicht deklariert ist dann suche in 
	 * dieser funktion im array ob vorhanden wenn ja wird ersettzt wenn nicht wird null übergeben
	 *
	 * @param string $property
	 * @return mixed
	 */
	public function __get($property)
	{
		if(isset($this->Vars[$property])){return $this->Vars[$property];}
		return null;
	}
	
	
	
	
}


?>