<?php

class Controler_Units
{
	
	public function start()
	{
		$Respons= new Request();
		switch($Respons->getAsString("Action"))
		{
			case "WorkOnMessage":
			{
				//$this->showAll();
			}break;


			default:
				$this->showAll();
		}
		
		
	}
	public function showAll()
	{
		$Request= new Request();
		$TempLate=Template::getInstance("tpl_Planet.php"); 
		$TempLate->render();
	}
	
}
?>