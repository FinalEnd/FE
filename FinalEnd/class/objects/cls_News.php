<?php
/**
 * zur bearbeitung der news die auf der start seite angezeigt wird
 *
 */
class News extends ParseAbleObject 
{
	private $Id;
	private $Content;
	Private $CreateDate;
	private $CreatorId;
	
	
	
	public function __construct($Id,$Content,$CreateDate,$CreatorId)
	{
		$this->Id=$Id;
		$this->Content=$Content;
		$this->CreateDate=$CreateDate;
		$this->CreatorId=$CreatorId;
	}
	
	
	public function getId() 
	{
		return $this->Id;
	}
	
	
	public function getContent()
	{
		return $this->parseAll($this->Content);
	}
	
	public function getContentNoneParse()
	{
		return $this->Content;
	}
	
	public function getCreateDate()
	{
		return $this->CreateDate;
	}
	
	public function getCreatorId()
	{
		return $this->CreatorId;
	}
	
	
	
	
	
}

?>