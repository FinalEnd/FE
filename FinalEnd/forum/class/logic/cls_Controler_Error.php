<?php


class Controler_Error
{
	private $Header;
	private $Message;
	private $BackLink;
	
	public function __construct($Header,$Message,$BackLink)
	{
		$this->Header=$Header;
		$this->Message=$Message;
		$this->BackLink=$BackLink;
	}
	
	public function render()
	{
		$Template= Template::getInstance("system/tpl_Error.php");
		$Template->Assign("ErrorHeader",$this->Header);
		$Template->Assign("ErrorString",$this->Message);
		$Template->Assign("LastPage",$this->BackLink);
		$Template->render();	
	}
	
	// knnte noch ne errorlog anlegen oder sowas
	
}




?>