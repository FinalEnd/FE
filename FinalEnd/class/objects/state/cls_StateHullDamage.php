<?php

class StateHullDamage extends State implements i_CollectionElement 
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
		$Unit->setAmor($Unit->getAmor()-$Unit->getAmor()*0.20);
		$Unit->setHealts($Unit->getHealts()-$Unit->getHealts()*0.10);

	}
	
	
	
	
	
}



?>