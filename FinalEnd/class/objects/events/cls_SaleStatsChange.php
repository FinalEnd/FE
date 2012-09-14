<?php

/**
 * sachen gekauft
 *
 */
class SaleStatsChange extends SystemEvent
{
	public $Ammount;
	
	/**
	 * der kauf
	 *
	 * @var Sale 
	 *
	 */
	public $Type;
	public $Price;
	public function __construct($Type,$Ammount,$Price)
	{
		parent::__construct();
		$this->Type=$Type;
		$this->Ammount=$Ammount;
		$this->Price=$Price;
	}
	
	
	/**
	 * statistik allgemein für sale
	 * 
	 * buy durch sell is so ne art börsenwert
	 * rest der db felder wird nicht benutzt
	 * 
	 * createstats hab ich aus performance mal net gemacht
	 * 
	 *
	 * @return void 
	 *
	 */
	public function handle()
	{
		/*$Statsmanger = new StatsManager();
		$Statsmanger->createStats($User);*/
		$UserStatsManager=new StatsManager();
		$User= new User(0,"NULL","VOID","EMPTY",0,1,0,0);	
		switch($this->Type)
		{
			case "Biomass":
			{
				$UserStatsManager->addFoodBuy($User,$this->Ammount);
				$UserStatsManager->addFoodSell($User,$this->Price);
			}break;

			case "Metall":
			{
				$UserStatsManager->addMetalBuy($User,$this->Ammount);
				$UserStatsManager->addMetalSell($User,$this->Price);
			}break;
			case "Cristal":
			{
				$UserStatsManager->addCrysBuy($User,$this->Ammount);
				$UserStatsManager->addCrysSell($User,$this->Price);
			}break;
			case "Hydrogen":
			{
				$UserStatsManager->addDeutBuy($User,$this->Ammount);
				$UserStatsManager->addDeutSell($User,$this->Price);
			}break;
		}
		
		return true;	
	}
}
?><?php

