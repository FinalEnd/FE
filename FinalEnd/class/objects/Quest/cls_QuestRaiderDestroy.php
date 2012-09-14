<?php

abstract class QuestRaiderDestroy implements i_CollectionElement 
{
	protected $Id;
	protected $Name; 
	protected $Description;
	protected $Picture; 
	protected $SkillLevel;

	public function __construct($Id,$Name,$Picture,$Description,$SkillLevel)
	{
		$this->Id=$Id;
		$this->Name=$Name;
		$this->Description=$Description;
		$this->Picture=$Picture;
		$this->SkillLevel=$SkillLevel;
	}
	
	
	public function getSkillLevel()
	{
		echo $this->SkillLevel;
	}
	
	public abstract static function getEmptyInstance();
	{
		return new QuestRaiderDestroy("",0,0,"","");
	}
	
	public function getDescription()
	{
		echo $this->t_Description;
	}
	
	public function getPicture()
	{
		echo $this->picture;
	}

	public function getId()
	{
		return $this->i_Id ;
	}
	public function getName()
	{
		return $this->s_Name ;
	}
	
	/**
	 * berechnet und setzt die Flotte neu die Flotte wird per pointer übergeben
	 *
	 * @param Unit $Unit This is a description
	 * @return void 
	 */
	public abstract function startQuest(User &$User);


	public abstract function endQuest(User &$User);
	
	
	/**
	 * wen der quest abgebrochen wird
	 *
	 * @param User $User This is a description
	 * @return bool 
	 *
	 */
	public abstract function abortQuest(User &$User);
	
}



?>