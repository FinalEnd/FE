<?php

/**
 * class cls_ForumThread
 *
 * Description for class cls_ForumThread
 *
 * @author:
*/
class ForumThread implements i_CollectionElement
{

	private $Id;
	private $Name;
	private $ThreadId;
	private $Description;
	private $CreateDate;
	/**
	 * der user der den thread erstellt hat
	 *
	 * @var User 
	 *
	 */
	private $Creator;
	private $Modus;
	private $Views;
	private $ForumContentCollection;
	private $ForumThreadCollection;
	private $SubThreadCount;
	private $SubContentCount;
	private $LastContent;
	private $AllowShow= false;
	
	
	/**
	 * gibt an ob es eine struktur ist oder ob beiträge am thred hängen können
	 *
	 * @var mixed 
	 *
	 */
	private $IsStruct;
	private $Sort;


	function __construct($Id,$Name,$ThreadId,$Description,$CreateDate,User $Creator,$Modus,$Views,$ForumContentCollection,$IsStruct,$SubThreadCount,$SubContentCount,$LastContent,$Sort=0) 
	{
		$this->Id=$Id;
		$this->Name=$Name;
		$this->ThreadId=$ThreadId;
		$this->Description=$Description;
		$this->CreateDate=$CreateDate;
		$this->Creator=$Creator;
		$this->Modus=$Modus;
		$this->Views=$Views;
		$this->ForumContentCollection=$ForumContentCollection;
		$this->IsStruct=$IsStruct;
		$this->ForumThreadCollection=$ForumThreadCollection;
		$this->SubThreadCount=$SubThreadCount;
		$this->SubContentCount=$SubContentCount;
		$this->LastContent=$LastContent;
		$this->Sort=$Sort;
	}
	
	
	public static function getEmptyInstance()
	{
		return new ForumThread(0,"",0,"","",User::getEmptyInstance(),0,	0,new ForumThreadCollection(),0,0,0,"",0);
	}
	
	
	public function getSort()
	{
		return $this->Sort;
	}
	
	
	/**
	 * gibt den letzten Kommentar der thread und unter threds zurück
	 *
	 * @return ForumContent 
	 *
	 */
	public function getLastContent()
	{
		return $this->LastContent;
	}
	
	public function getSubThreadCount()
	{
		return $this->SubThreadCount;	
	}

	public function getSubContentCount()
	{
		return (int) $this->SubContentCount;	
	}
	
	/**
	 * gibt zurück 
	 *
	 * @return mixed This is the return value description
	 *
	 */
	public function IsStruct()
	{
		return $this->IsStruct;	
	}
	
	public function getForumContentCollection()
	{
		return $this->ForumContentCollection;	
	}
	
	public function getViews()
	{
		return $this->Views;	
	}
	
	public function getModus()
	{
		return (int) $this->Modus;	
	}
	
	public function setModus($Modus)
	{
		$this->Modus=$Modus;	
	}
	
	
	/**
	 * gibt den ersteller des Threrds  zurück
	 *
	 * @return User der ersteller des Threads
	 *
	 */
	public function getUser()
	{
		return $this->Creator;	
	}
	
	
	public function getCreateDate()
	{
		return $this->CreateDate;	
	}
	
	public function getDescription()
	{
		return $this->Description;	
	}
	
	
	public function setDescription($Description)
	{
		$this->Description=$Description;	
	}
	
	public function getThreadId()
	{
		return $this->ThreadId;	
	}
	
	
	public function getName()
	{
		return $this->Name;	
	}
	
	public function setName($Name)
	{
		$this->Name=$Name;	
	}
	
	
	public function getId()
	{
		return $this->Id;	
	}
	
	
	public function parse()
	{
		$this->ForumContentCollection->parse();	
	}
	
	
	
	public function isAllowShow()
	{
		return $this->AllowShow;
	}
	
	
	/**
	 * setzt den wert ob der user den thread sehen darf oder nicht
	 *
	 * @param bool $Allowed true er darf ihn sehen false er darf ihn nicht sehen
	 * @return void 
	 *
	 */
	public function setAllowShow($Allowed)
	{
		$this->AllowShow=$Allowed;
	}
	
}


?>