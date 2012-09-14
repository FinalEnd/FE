<?php

/**
 * sachen gekauft
 *
 */
class BuyEvent extends SystemEvent
{
	private $FromUser;
	
	/**
	 * der kauf
	 *
	 * @var Sale 
	 *
	 */
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
				$UserStatsManager->addFoodBuy($this->FromUser,$this->Sale->getCount());
			}break;

			case "Metall":
			{
				$UserStatsManager->addMetalBuy($this->FromUser,$this->Sale->getCount());
			}break;
			case "Cristal":
			{
				$UserStatsManager->addCrysBuy($this->FromUser,$this->Sale->getCount());
			}break;
			case "Hydrogen":
			{
				$UserStatsManager->addDeutBuy($this->FromUser,$this->Sale->getCount());
			}break;
			
		}
		$UserStatsManager->addCreditsGiven($this->FromUser,$this->Sale->getPrice());
		
		return true;	
	}
}
?><?php

