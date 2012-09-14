<?php

class StateBayOffline extends State implements i_CollectionElement 
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
		$Unit->setExtentionOne(0);
	}
	
	
	
	
	
}



?>