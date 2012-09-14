<?php


class Controler_Download
{

public function start()
	{
		$User = User::getInstance();
		$Request = new Request(); // eingaben abfangen
		
		switch($Request->getAsString("Action"))
		{
			case "UploadFile":
			{
				$this->upLoadFile();
			}break;
			default:
				$this->showDir();	
			
			
		}
		
		

	}
	
	private function upLoadFile()
	{
		ini_set ( "file_uploads" , "on" );
		ini_set ("upload_max_filesize" , "200" );
		ini_set ("max_execution_time" , "600" );
		ini_set ("max_input_time " , "600" );
		$User = User::getInstance();
		if(!$User->check(10)){$this->showDir();}
		$Path=$this->getPatch();
		//var_dump($_FILES);
		$UpLoadFile = $Path.basename($_FILES['tb_File']['name']);	
		//var_dump($_FILES['tb_File']['name']);
		//var_dump($UpLoadFile);
		//copy($_FILES['tb_File']['tmp_name'], $UpLoadFile);
		move_uploaded_file($_FILES['tb_File']['tmp_name'], $UpLoadFile);
		
		$this->showDir();	
	}
	
	private function getPatch()
	{
		$Request = new Request();
		if(!$Request->getNoneParsed("Dir"))
		{
			return "./download/incoming/";// erst initialiesirung
		}
		else 
		{
			return $Request->getNoneParsed("Dir");
		}
	}
	
	
	private function showDir()
	{
		$User = User::getInstance();
		$Request = new Request(); // eingaben abfangen
		$Path=$this->getPatch();
		$View = Template::getInstance("tpl_Download.php");
		$MyFolder= new Download($Path);
		if($User->check(10)){$View->assign("IsAdmin",true);}
		$View->assign("MyFolder",$MyFolder);
		$View->render();
	}
	
	
	private function parse($String)
	{
		$TempString=str_replace("ö","",$String);	
		$TempString=str_replace("ä","",$TempString);
		$TempString=str_replace("ü","",$TempString);
		$TempString=str_replace("Ö","",$String);	
		$TempString=str_replace("Ä","",$TempString);
		$TempString=str_replace("Ü","",$TempString);
		$TempString=str_replace("<","&lt;",$TempString);
		$TempString=str_replace(">","&gt;",$TempString);
		$TempString=str_replace('"',"&quot;",$TempString);
		$TempString=str_replace('\\',"",$TempString);
		$TempString=str_replace("?","",$String);	
		$TempString=str_replace("ß","",$TempString);
		$TempString=str_replace(")","",$TempString);
		$TempString=str_replace("(","",$String);	
		$TempString=str_replace("/","",$TempString);
		$TempString=str_replace("&","",$TempString);
		$TempString=str_replace("&","",$String);	
		$TempString=str_replace("%","",$TempString);
		$TempString=str_replace("$","",$TempString);
		$TempString=str_replace("§","",$String);	
		$TempString=str_replace("!","",$TempString);
		$TempString=str_replace("?","",$String);	
		$TempString=str_replace("^","",$TempString);
		$TempString=str_replace("°","",$TempString);
		$TempString=str_replace("#","",$TempString);
		$TempString=str_replace("'","",$String);	
		$TempString=str_replace("+","",$TempString);
		$TempString=str_replace("*","",$TempString);
		$TempString=str_replace("~","",$TempString);
		return $TempString;
	}
	
	
}






?>