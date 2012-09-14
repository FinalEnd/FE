<?php

/**
 * gegnerische flotte wurde zerstört
 *
 */
class UnitDestroyedEvent extends SystemEvent
{
	private $FromUser;

	public function __construct(User $FromUser)
	{
		parent::__construct();
		$this->FromUser=$FromUser;
	}
	
	
	/**
	 * handelt den event
	 *
	 * @return void 
	 *
	 */
	public function handle()
	{
		$UserStatsManager= New StatsManager();
		$UserStatsManager->addUnitDestroyed($this->FromUser,1);
		return true;	
	}
}
?>