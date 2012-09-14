<?php

 abstract class State implements i_CollectionElement 
{
	protected $Id;
	protected $s_Name; 
	protected $t_Description;
	protected $s_Picture; 
	protected $EndTime;

	public function __construct($Id,$Name,$EndTime,$Picture,$Description)
	{
		$this->Id=$Id;
		$this->s_Name=$Name;
		$this->t_Description=$Description;
		$this->s_Picture=$Picture;
		$this->EndTime=$EndTime;
	}
	
	
	public static function getEmptyInstance()
	{
		return new State("",0,0,"","");
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
	 * der timestamp wann der status abläuft
	 *
	 * @return int 
	 *
	 */
	public function getEndTime()
	{
		return $this->EndTime;
	}
	
	
	/**
	 * berechnet und setzt die Flotte neu die Flotte wird per pointer übergeben
	 *
	 * @param Unit $Unit This is a description
	 * @return void 
	 */
	public abstract function calculate(Unit &$Unit);

/**
 * gibt das bild des statuses als html zurück
 * 
 * */
	public function getHTMLPicture()
	{
		$Title=$this->getName()." \n ".$this->t_Description." \n".Date::dateFormat($this->EndTime-time());
		if(!$this->EndTime)
		{
			$Title=$this->getName()." \n ".$this->t_Description;
		}
		
		return "<img class='StateImage' title='".$Title."' src='./images/state/".$this->s_Picture.".png'/>" ;
	}
	
	
	
	
}



?>