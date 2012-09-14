<?php

/**
 * gegnerische flotte wurde zerstört
 *
 */
class BuildingConstructed extends SystemEvent
{
	private $Planet;
	private $Building;
	public function __construct(Planet $Planet,Building $Building)
	{
		parent::__construct();
		$this->Planet=$Planet;
		$this->Building=$Building;
	}
	
	
	/**
	 * handelt den event
	 *
	 * @return void 
	 *
	 */
	public function handle()
	{
		switch ($this->Building->getId())
		{
			case '7':
			{
				if($this->Building->getLevel()==1)
				{
					// versende tut	
					$Controler_Message= new Controler_Message();
					$Controler_Message->sendGetNewPlanetsToPlayer($this->Planet->getUser()->getName());
					
				}
			}break;
			default:
			{
				
			}	
			
			
		}
		return true;	
	}
}
?>