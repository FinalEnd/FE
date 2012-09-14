<?php
class UserStats	implements i_CollectionElement
{
	protected $Id;
	protected $UserId;
	protected $PlanetsGotten;
	protected $PlanetsLost;
	protected $PlanetsScanned;
	protected $PlanetsRaided;
	protected $AlliWritten;
	protected $AlliAnswerd;
	protected $MessagesWritten;
	protected $MessagesReceived;
	protected $MetallBought;
	protected $MetallSold;
	protected $CrystalBought;
	protected $CrystalSold;
	protected $DeuteriumBought;
	protected $DeuteriumSold;
	protected $FoodBought;
	protected $FoodSold;
	protected $CreditsEarned;
	protected $CreditsGiven;
	protected $FleetLost;
	protected $FleetBuild;
	protected $FleetActive;
	protected $FleetRepaired;
	protected $FleetHitpointsLost;
	protected $FleetDamageGiven;
	protected $FleetGaineDrank;
	protected $FleetGuerillaRepair;
	protected $FleetInterventionFleet;
	protected $ActiveUpgrades;

	public function __construct($Id=0,$UserId=0,$PlanetsGotten=0,$PlanetsLost=0,$PlanetsScanned=0,$PlanetsRaided=0,$AlliWritten=0,$AlliAnswerd=0,$MessagesWritten=0,$MessagesReceived=0,$MetallBought=0,$MetallSold=0,$CrystalBought=0,$CrystalSold=0,$DeuteriumBought=0,$DeuteriumSold=0,$FoodBought=0,$FoodSold=0,$CreditsEarned=0,$CreditsGiven=0,$FleetLost=0,$FleetBuild=0,$FleetActive=0,$FleetRepaired=0,$FleetHitpointsLost=0,$FleetDamageGiven=0,$FleetGaineDrank=0,$FleetGuerillaRepair=0,$FleetInterventionFleet=0,$ActiveUpgrades=0)
	{
		$this->Id=$Id;
		$this->UserId=$UserId;
		$this->PlanetsGotten=$PlanetsGotten;
		$this->PlanetsLost=$PlanetsLost;
		$this->PlanetsScanned=$PlanetsScanned;
		$this->PlanetsRaided=$PlanetsRaided;
		$this->AlliWritten=$AlliWritten;
		$this->AlliAnswerd=$AlliAnswerd;
		$this->MessagesWritten=$MessagesWritten;
		$this->MessagesReceived=$MessagesReceived;
		$this->MetallBought=$MetallBought;
		$this->MetallSold=$MetallSold;
		$this->CrystalBought=$CrystalBought;
		$this->CrystalSold=$CrystalSold;
		$this->DeuteriumBought=$DeuteriumBought;
		$this->DeuteriumSold=$DeuteriumSold;
		$this->FoodBought=$FoodBought;
		$this->FoodSold=$FoodSold;
		$this->CreditsEarned=$CreditsEarned;
		$this->CreditsGiven=$CreditsGiven;
		$this->FleetLost=$FleetLost;
		$this->FleetBuild=$FleetBuild;
		$this->FleetActive=$FleetActive;
		$this->FleetRepaired=$FleetRepaired;
		$this->FleetHitpointsLost=$FleetHitpointsLost;
		$this->FleetDamageGiven=$FleetDamageGiven;
		$this->FleetGaineDrank=$FleetGaineDrank;
		$this->FleetGuerillaRepair=$FleetGuerillaRepair;
		$this->FleetInterventionFleet=$FleetInterventionFleet;
		$this->ActiveUpgrades=$ActiveUpgrades;
	}	
	
	public function getId()
	{
		return $this->Id;
	}
	public function setId($item)
	{
		$this->Id=$item;
	}
	
	public function getUserId()
	{
		return $this->UserId;
	}
	public function setUserId($item)
	{
		$this->UserId=$item;
	}
	
	public function getPlanetsGotten()
	{
		return $this->PlanetsGotten;
	}
	public function setPlanetsGotten($item)
	{
		$this->PlanetsGotten=$item;
	}
	
	public function getPlanetsLost()
	{
		return $this->PlanetsLost;
	}
	public function setPlanetsLost($item)
	{
		$this->PlanetsLost=$item;
	}
	
	public function getPlanetsScanned()
	{
		return $this->PlanetsScanned;
	}
	public function setPlanetsScanned($item)
	{
		$this->PlanetsScanned=$item;
	}

	public function getPlanetsRaided()
	{
		return $this->PlanetsRaided;
	}
	public function setPlanetsRaided($item)
	{
		$this->PlanetsRaided=$item;
	}
	
	public function getAlliWritten()
	{
		return $this->AlliWritten;
	}
	public function setAlliWritten($item)
	{
		$this->AlliWritten=$item;
	}
	
	public function getAlliAnswerd()
	{
		return $this->AlliAnswerd;
	}
	public function setAlliAnswerd($item)
	{
		$this->AlliAnswerd=$item;
	}
	
	public function getMessagesWritten()
	{
		return $this->MessagesWritten;
	}
	public function setMessagesWritten($item)
	{
		$this->MessagesWritten=$item;
	}

	public function getMessagesReceived()
	{
		return $this->MessagesReceived;
	}
	public function setMessagesReceived($item)
	{
		$this->MessagesReceived=$item;
	}
	
	public function getMetallBought()
	{
		return $this->MetallBought;
	}
	public function setMetallBought($item)
	{
		$this->MetallBought=$item;
	}

	public function getMetallSold()
	{
		return $this->MetallSold;
	}
	public function setMetallSold($item)
	{
		$this->MetallSold=$item;
	}
	
	public function getCrystalBought()
	{
		return $this->CrystalBought;
	}
	public function setCrystalBought($item)
	{
		$this->CrystalBought=$item;
	}
	
	public function getCrystalSold()
	{
		return $this->CrystalSold;
	}
	public function setCrystalSold($item)
	{
		$this->CrystalSold=$item;
	}
	
	public function getDeuteriumBought()
	{
		return $this->DeuteriumBought;
	}
	public function setDeuteriumBought($item)
	{
		$this->DeuteriumBought=$item;
	}
	
	public function getDeuteriumSold()
	{
		return $this->DeuteriumSold;
	}
	public function setDeuteriumSold($item)
	{
		$this->DeuteriumSold=$item;
	}
	
	public function getFoodBought()
	{
		return $this->FoodBought;
	}
	public function setFoodBought($item)
	{
		$this->FoodBought=$item;
	}
	
	public function getFoodSold()
	{
		return $this->FoodSold;
	}
	public function setFoodSold($item)
	{
		$this->FoodSold=$item;
	}

	public function getCreditsEarned()
	{
		return $this->CreditsEarned;
	}
	public function setCreditsEarned($item)
	{
		$this->CreditsEarned=$item;
	}
	
	public function getCreditsGiven()
	{
		return $this->CreditsGiven;
	}
	public function setCreditsGiven($item)
	{
		$this->CreditsGiven=$item;
	}
	
	public function getFleetLost()
	{
		return $this->FleetLost;
	}
	public function setFleetLost($item)
	{
		$this->FleetLost=$item;
	}
	
	public function getFleetBuild()
	{
		return $this->FleetBuild;
	}
	public function setFleetBuild($item)
	{
		$this->FleetBuild=$item;
	}
	
	public function getFleetActive()
	{
		return $this->FleetActive;
	}
	public function setFleetActive($item)
	{
		$this->FleetActive=$item;
	}
	
	public function getFleetRepaired()
	{
		return $this->FleetRepaired;
	}
	public function setFleetRepaired($item)
	{
		$this->FleetRepaired=$item;
	}
	
	public function getFleetHitpointsLost()
	{
		return $this->FleetHitpointsLost;
	}
	public function setFleetHitpointsLost($item)
	{
		$this->FleetHitpointsLost=$item;
	}
	
	public function getFleetDamageGiven()
	{
		return $this->FleetDamageGiven;
	}
	public function setFleetDamageGiven($item)
	{
		$this->FleetDamageGiven=$item;
	}
	
	public function getFleetGaineDrank()
	{
		return $this->FleetGaineDrank;
	}
	public function setFleetGaineDrank($item)
	{
		$this->FleetGaineDrank=$item;
	}
	
	public function getFleetGuerillaRepair()
	{
		return $this->FleetGuerillaRepair;
	}
	public function setFleetGuerillaRepair($item)
	{
		$this->FleetGuerillaRepair=$item;
	}
	
	public function getFleetInterventionFleet()
	{
		return $this->FleetInterventionFleet;
	}
	public function setFleetInterventionFleet($item)
	{
		$this->FleetInterventionFleet=$item;
	}
	
	public function getActiveUpgrades()
	{
		return $this->ActiveUpgrades;
	}
	public function setActiveUpgrades($item)
	{
		$this->ActiveUpgrades=$item;
	}
	
	public static function getEmptyInstance()
	{
		return new UserStats(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	}


}?>