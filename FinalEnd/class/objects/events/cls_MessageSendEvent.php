<?php

/**
 * sachen gekauft
 *
 */
class MessageSendEvent extends SystemEvent
{
	private $FromUser;
	/**
	 * der  nachrichten
	 *
	 * @var Benutzer 
	 *
	 */
	
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
		$UserStatsManager->addWritenMessages($this->FromUser);
		
		
		return true;	
	}
}
?><?php

