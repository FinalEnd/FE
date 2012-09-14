<?php

/**
 * gegnerische flotte wurde zerstört
 *
 */
class UnitCreatedEvent extends SystemEvent
{
	private $Unit;

	public function __construct(Unit $Unit)
	{
		parent::__construct();
		$this->Unit=$Unit;

	}
	
	
	/**
	 * handelt den event
	 *
	 * @return void 
	 *
	 */
	public function handle()
	{
		$Unitfinder = new UnitFinder();
		$ShipCount=$Unitfinder->countUnitsByUser($this->Unit->getUser());
		if($ShipCount>=2 ){return false;}
		$InviteFinder = new InviteFinder();
		$Invite=$InviteFinder->findByTypeAndUser(EventConstants::$NAVIGATION,$this->Unit->getUser());
		if(!$Invite->getId() && $Invite->getTemp()==0)
		{
			// nachricht verschicken und in db eintragen das die nachricht verschickt wurde	
			$MessageControler= new Controler_Message();
			$MessageControler->sendBattleTutToPlayer($this->Unit->getUser());
			$InviteManager=new InviteManager();
			$InviteManager->addInvite($this->Unit->getUser(),EventConstants::$NAVIGATION,1);
		}
		
		return true;	
	}
}
?><?php

