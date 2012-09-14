<?php

/**
 * gegnerische flotte wurde zerstört
 *
 */
class AllianzTopicCreateEvent extends SystemEvent
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
		$UserStatsManager->addAlliTopicCreated($this->FromUser,1);
		return true;	
	}
}
?>
