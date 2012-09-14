<?php

/**
 * class cls_Controler_Click
 *
 * Description for class cls_Controler_Click
 *
 * @author:
*/
class Controler_Help  
{

	/**
	 * cls_Controler_Click constructor
	 *
	 * @param 
	 */
	function __construct() {

	}
	
	
	public function start()
	{
		$Request= new Request();
		switch($Request->getAsString('Action'))
		{



			default:
				$this->showHelp();
		}
		
		
		
		
		
	}
	
	
	
	public function showHelp()
	{
		
		$Request= new Request();
		$TempLate=Template::getInstance("tpl_Help.php"); 
		$TempLate->render();
		
	}	
	


}

?>