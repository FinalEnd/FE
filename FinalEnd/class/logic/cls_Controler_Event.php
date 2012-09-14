<?php
class Controler_Event
{
	private static $Instance;
	private $EventCollection;
	
	/**
	 * singelton
	 *
	 * @return Controler_Event 
	 *
	 */
	public static function getInstance()
	{
		if(self::$Instance===null)
		{
			self::$Instance = new Controler_Event();	
		}
		return self::$Instance;	
	}
	
	public function __construct()
	{
		$this->EventCollection= new EventCollection();
	}
	public function start()
	{

	}


	
	/**
	 * fürgt einen Event zum StatsControler hinzu
	 *
	 * @param SystemEvent $Event 
	 * @return bool 
	 *
	 */
	public function addEvent(SystemEvent $Event)
	{
		$this->EventCollection->add($Event);
		return true;
	}
	
	
	/**
	 * verarbeitet die integrierten Events 
	 *
	 * @return void 
	 *
	 */
	public function handleEvents()
	{
		foreach($this->EventCollection as $Event)
		{
			$Event->handle();
		}
	}
	
	
	
	
	
	
}



?>