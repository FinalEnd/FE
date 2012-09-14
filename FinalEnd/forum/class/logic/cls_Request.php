<?php

class Request
{
	private $postRequest=null;
	private $getRequest=null;
	
	public function __construct()
	{
		$this->PostRequest=$_POST;
		$this->GetRequest=$_GET;
	}
	
	
	/**
	 * setzt einen wert in die reyouestklasse rein
	 *
	 * @param string $Key 
	 * @param string $Value der wert der gesett werden soll
	 * @return bool 
	 *
	 */
	public function setPost($Key,$Value)
	{
		$this->PostRequest[$Key]=$Value;
		$_POST[$Key]=$Value;
	}
	
	
	private function get($Request)
	{
		if(isset($this->PostRequest[$Request]))
		{
			return $this->PostRequest[$Request];
		}
		if(isset($this->GetRequest[$Request]))
		{
			return $this->GetRequest[$Request];
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
	private function parse($String)
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