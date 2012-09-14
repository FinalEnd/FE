<?php

class Request
{
	private $postResponse=null;
	private $getResponse=null;
	
	public function __construct()
	{
		$this->PostResponse=$_POST;
		$this->GetResponse=$_GET;
	}
	
	
	/**
	 * setzt einen wert in die requestklasse rein
	 *
	 * @param string $Key 
	 * @param string $Value der wert der gesetzt werden soll
	 * @return bool 
	 *
	 */
	public function setPost($Key,$Value)
	{
		$this->PostResponse[$Key]=$Value;
		$_POST[$Key]=$Value;
	}
	
	
	private function get($Response)
	{
		if(isset($this->PostResponse[$Response]))
		{
			return $this->PostResponse[$Response];
		}
		if(isset($this->GetResponse[$Response]))
		{
			return $this->GetResponse[$Response];
		}
		return false;	
	}
	
	
	/**
	 * parst schädliche zeichen aus der eingebe der benutzer
	 *
	 * @param string $String die benutzer eingabe
	 * @return string die geparste benutzer eingabe
	 *
	 */
	public function parse($String)
	{
		$TempString=str_replace("%","",$String);	
		$TempString=str_replace("#","",$TempString);
		$TempString=str_replace("'","",$TempString);
		//$TempString=str_replace("?","",$TempString);
		//$TempString=str_replace("/","",$TempString);
		$TempString=str_replace("<","&lt;",$TempString);
		$TempString=str_replace(">","&gt;",$TempString);
		$TempString=str_replace('"',"&quot;",$TempString);
		$TempString=str_replace('\\',"",$TempString);
		return $TempString;
	}
	
	
	
	public function getAsInt($Reguest)
	{
		$Reguest=$this->get($Reguest);
		settype($Reguest, "integer"); 
		return $Reguest;
		
	}
	
	
	public function getAsString($Reguest)
	{
		$Reguest=$this->get($Reguest);
		settype($Reguest, "string");
		return $this->parse($Reguest); 
	}
	
	public function getAsBool($Reguest)
	{
		$Reguest=$this->get($Reguest);
		settype($Reguest, "boolean");
		return $Reguest;
	}
	
	public function getAsFloat($Reguest)
	{
		$Reguest=$this->get($Reguest);
		settype($Reguest, "float");
		return $Reguest;
	}
	
	public function getAsArray($Reguest)
	{
		return $this->get($Reguest);
	}
	
	public function getNoneParsed($Reguest)
	{
		return $this->get($Reguest);
	}
	
	
	
}




?>