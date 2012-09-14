<?php
  class Quote
{
	private $Id;
	private $Content;
	private $Autor;
	
	
	
	public function __construct($Id,$Content,$Autor)
	{
		$this->Id=$Id;
		$this->Content=$Content;
		$this->Autor=$Autor;
	}
	
	
	
/**
*   getter Autor
*
* return string
*/
public function getAutor()
{
  return $this->Autor;
}
	
	
/**
*   getter Content
*
* return string
*/
public function getContent()
{
  return $this->Content;
}
	
/**
*   getter Id
*
* return string
*/
public function getId()
{
  return $this->Id;
}
	
	
	
}








?>