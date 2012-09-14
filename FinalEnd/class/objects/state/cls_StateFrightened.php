<?php

class StateFrightened extends State implements i_CollectionElement 
{
	protected $Id;
	protected $s_Name; 
	protected $t_Description;
	protected $s_Picture; 
	protected $EndTime;

	public function __construct($Id,$Name,$EndTime,$Picture,$Description)
	{
		$this->i_Id=$Id;
		$this->s_Name=$Name;
		$this->t_Description=$Description;
		$this->s_Picture=$Picture;
		$this->EndTime=$EndTime;
	}

	public function calculate(Unit &$Unit)
	{
		// setzt alle eigenschaften +5%
		$Unit->setAmor($Unit->getAmor()-$Unit->getAmor()*0.05);
		$Unit->setSpeed($Unit->getSpeed()-$Unit->getSpeed()*0.05);
		$Unit->setHealts($Unit->getHealts()-$Unit->getHealts()*0.05);
		$Unit->setDMG($Unit->getDMG()-$Unit->getDMG()*0.05);
	}
	
	
	
	
	
}



?>