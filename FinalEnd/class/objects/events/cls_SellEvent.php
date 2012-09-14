<?php

/**
 * gegnerische flotte wurde zerstört
 *
 */
class SellEvent extends SystemEvent
{
	private $FromUser;

	private $Sale;
	public function __construct(User $FromUser,Sale $Sale)
	{
		parent::__construct();
		$this->FromUser=$FromUser;
		$this->Sale=$Sale;
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
		switch($this->Sale->getRessource())
		{
			case "Biomass":
			{
				$UserStatsManager->addFoodSell($this->FromUser,$this->Sale->getCount());
			}break;

			case "Metall":
			{
				$UserStatsManager->addMetalSell($this->FromUser,$this->Sale->getCount());
			}break;
			case "Cristal":
			{
				$UserStatsManager->addCrysSell($this->FromUser,$this->Sale->getCount());
			}break;
			case "Hydrogen":
			{
				$UserStatsManager->addDeutSell($this->FromUser,$this->Sale->getCount());
			}break;
			
		}
		$UserStatsManager->addCreditsEarned($this->FromUser,$this->Sale->getPrice());
		
		return true;	
	}
}
?><?php

