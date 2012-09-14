<?php
/**
 * Programm: zum upload von dateien
 * Type: upload
 * Description: mit diesem script ist es möglich dateien hoch zuladen
 * Copyrihgt:  24.05.2007
 * Firma: sCe-Ware
 * Autor: Matthias Herzog 
 * CVS: Zend Studion 5.2
 **/

class UploadExeption extends Exception
{
}
class UploadExeptionMessage
{
	const DIR_DONT_EXIST=1;
	const DIR_WORNG=2;
	const WORNG_PARAMETER=3;
	const FILE_NOT_UPLOADED=4;
	const FILE_NOT_EXIST=5;
	const FILE_NOT_RIGHT_FORMAT=6;
	const NO_FILE=7;
}
class upload
{

	private $dir=NULL;
	private $filehandle;
	private $dirname="";
	private static $instance=NULL;

	private function __construct()
	{
	}
	private function __clone()
	{
	}
	/**
	 * erzeugt eine instanz der klasse upload
	 *
	 * @return objekt upload
	 */
	public static function  getInstance()
	{
		if (self::$instance==NULL)
		{
			self::$instance=new upload();
		}
		return self::$instance;
	}
	/**
	 * liest das verzeichniss ein und gibt ein arry auf $this->dir zurück
	 *
	 * @param string $dir
	 */
	public function doScanDir($dir="./")
	{
		$this->dirname=$dir;
		$this->dir = scandir($dir);
	}
	/**
	 * macht eine html ausgabe des verzeichnisses 
	 *
	 */
	public function getDir()
	{
		$User = new User();
		$tempcnt=0;
		if(is_array($this->dir))
		{
			echo "<table>";
			foreach ($this->dir as $key => $value)
			{
				if($this->doFilterDir($value))
				{
					$tempcnt++;
					echo "<tr><td>".$value."</td><td><a href='".$this->dirname."$value' target='download'>Download</a></td><td>";
					if($User->check(1))
					{
						$ausgabe="<a href='index.php?section=stuff&pfad=".$this->dirname.$value."&action=entfernen' onClick='javascript:return(confirm("; $ausgabe .="artist wirklich löschen?";$ausgabe .="))' >Entfernen</a></td></tr>";
						echo $ausgabe;
					}
				}
			}
			echo "</table>";
			if($tempcnt>0)
			{
				echo " es befinden sich ".$tempcnt." objekte in diser Rubrik";
			}
			else
			{
				echo "es sind keine dateien zum download vorhanden";
			}
		}

	}
	/**
	 * filtert $value nach ordnern es werden keine über ordner mehr angezeit noch sonstige ordner
	 *
	 * @param string $value
	 * @return 1 für nicht gefunden 0 für ist enthalten
	 */
	private  function doFilterDir($value)
	{
		if(substr($value,0,1)=="."){return 0;}
		//if($value !="." && $value !=".."){return 0;}
		return 1;
	}
	private function validateDataUpload($UploadDir)
	{
		if ($UploadDir=="")
		{
			throw new UploadExeption("fehler",UploadExeptionMessage::WORNG_PARAMETER);
		}
		if (is_dir($UploadDir))
		{
			throw new UploadExeption("fehler",UploadExeptionMessage::DIR_DONT_EXIST);
		}
		if (empty($_FILES['Bild']['name']))
		{
			throw new UploadExeption("fehler",UploadExeptionMessage::NO_FILE);
		}
		if (!isset($_FILES['Bild']['tmp_name']))
		{
			throw new UploadExeption("fehler",UploadExeptionMessage::FILE_NOT_EXIST );
		}
		if (!isset($_FILES['Bild']['name']))
		{
			throw new UploadExeption("fehler",UploadExeptionMessage::FILE_NOT_EXIST );
		}
		if ($_FILES['Bild']['type']=="application/octet-stream")
		{
			throw new UploadExeption("fehler",UploadExeptionMessage::FILE_NOT_RIGHT_FORMAT );
		}
		return 1;
	}

	public function doDataUpload($UploadDir="")
	{
		if($this->validateDataUpload($UploadDir))
		{
			$UploadDir=".".$UploadDir;
			//echo $UploadDir;
			if(!move_uploaded_file($_FILES['Bild']['tmp_name'],$UploadDir)){throw new UploadExeption("fehler",UploadExeptionMessage::FILE_NOT_UPLOADED);}
		}
	}
	
	public function doDataDelet($data)
	{
		if(empty($data)){return 0;}
		if(preg_match("((/bilder/)|(/stuff/))")){return 0;}
		if(!unlink($data))
		{
			return 0;
		}
		return 1;
		
	}

	public function getHtmlOut()
	{
		echo '<body>
				<form action="index.php?section=stuff" enctype="multipart/form-data" method="post">
				<input name="Datei" type="file"><br>
				<select name="verzeichniss" >
				<option value="/bilder/stuff/">stuff</option>
				<option value="/bilder/dates/">bilder</option>
				</select>
				<input name="abschicken" type="submit" value="upload">
				</form>';
	}

}















?>