<?php
abstract class SystemEvent implements i_CollectionElement
{
	private $Id;
	private $CreatTime;

	public function __construct()
	{
		$Time=time();
		$this->Id=$Time;
		$this->CreatTime=$Time;
	}
	
	public function getId()
	{
		return $this->Id;	
	}
	
	/**
	 * handelt den event
	 *
	 * @return void 
	 *
	 */
	abstract public function handle();
	
	static public  function getEmptyInstance()
	{
		return new SystemEvent();
	}
	
}
?>