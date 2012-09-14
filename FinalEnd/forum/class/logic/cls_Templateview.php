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
	private $Vars = array();
	
	public function __construct($Template="")
	{
		$this->Content=$Template;
	}
	
	public function setHeader($HeaderTemplate)
	{
		$this->Header=$HeaderTemplate;
	}
	
	public function setFooter($FooterTemplate)
	{
		$this->Footer=$FooterTemplate;
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
	
	public function render()
	{
		header('content-type: text/html; charset=utf-8');
		ob_start();
	
		if ($this->Header)
			require_once("./view/".$this->Header);
		if ($this->Content)
			require_once("./view/".$this->Content); // hier die ausgaben
		if ($this->Footer)
			require_once("./view/".$this->Footer);
		
		$data=ob_get_clean(); // gibt ausgabe puffer zurück und löscht den puffer
		
		echo $data;
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