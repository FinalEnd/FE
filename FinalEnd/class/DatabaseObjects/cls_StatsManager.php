<?php


// Statistiken

class StatsManager extends SystemManager
{

	private  function insertNewUser(UserStats $Stats)
	{
		$Sql="INSERT INTO `tbl_userstats` (
`i_id` ,
`i_UserId` ,
`i_planetsgotten` ,
`i_planetslost` ,
`i_planetsscanned` ,
`i_planetsraided` ,
`i_alliwritten` ,
`i_allianswerd` ,
`i_messageswritten` ,
`i_messagesreceived` ,
`i_ metallbought` ,
`i_metallsold` ,
`i_crystalbought` ,
`i_crystalsold` ,
`i_deuteriumbought` ,
`i_deuteriumsold` ,
`i_foodbought` ,
`i_foodsold` ,
`i_creditsearned` ,
`i_creditsgiven` ,
`i_fleetlost` ,
`i_fleetbuild` ,
`i_fleetactive` ,
`i_fleetrepaired` ,
`i_fleethitpointslost` ,
`i_fleetdamagegiven` ,
`i_fleetgainedrank` ,
`i_fleetguerillarepair` ,
`i_fleetinterventionfleet` ,
`i_activeupgrades` 
)
VALUES (
'".$Stats->getId()."', 
'".$Stats->getUserId()."', 
'".$Stats->getPlanetsGotten()."', 
'".$Stats->getPlanetsLost()."', 
'".$Stats->getPlanetsScanned()."', 
'".$Stats->getPlanetsRaided()."', 
'".$Stats->getAlliWritten()."', 
'".$Stats->getAlliAnswerd()."', 
'".$Stats->getMessagesWritten()."', 
'".$Stats->getMessagesReceived()."', 
'".$Stats->getMetallBought()."', 
'".$Stats->getMetallSold()."', 
'".$Stats->getCrystalBought()."', 
'".$Stats->getCrystalSold()."', 
'".$Stats->getDeuteriumBought()."', 
'".$Stats->getDeuteriumSold()."', 
'".$Stats->getFoodBought()."', 
'".$Stats->getFoodSold()."', 
'".$Stats->getCreditsEarned()."', 
'".$Stats->getCreditsGiven()."', 
'".$Stats->getFleetLost()."', 
'".$Stats->getFleetBuild()."', 
'".$Stats->getFleetActive()."', 
'".$Stats->getFleetRepaired()."', 
'".$Stats->getFleetHitpointsLost()."', 
'".$Stats->getFleetDamageGiven()."', 
'".$Stats->getFleetGaineDrank()."', 
'".$Stats->getFleetGuerillaRepair()."',
'".$Stats->getFleetInterventionFleet()."', 
'".$Stats->getActiveUpgrades()."'
);";
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * wenn der spieler noch keine user stats hat werden hier welche angelegt
	 *
	 * @param User $User 
	 * @return bool 
	 *
	 */
	public  function createStats(User $User)
	{
		$Sql="INSERT INTO `tbl_userstats` (
		`i_id` ,
		`i_UserId`) 
		values(null,".$User->getId().")";
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * fügt dem spieler neue zerstörte flotte hinzu die der Spieler Zerstört hat
	 *
	 * @param User $User 
	 * @param int $Count 
	 * @return bool 
	 *
	 */
	public  function addDestroyedUnits(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` SET `i_messageswritten` = `i_messageswritten`+".$Count." 
		WHERE `tbl_userstats`.`i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * fügt dem user flotten hinzu die er verloren hat 
	 *
	 * @param User $User 
	 * @param int $Count 
	 * @return bool 
	 *
	 */
	public  function addLostUnits(User $User,$Count)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_UnitsLost` = `i_UnitsLost`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	

		return $this->executeNonQuery($Sql);
	}
	
	
	
	public  function addWritenMessages(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_messageswritten` = `i_messageswritten`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addRecivedMessages(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_messagesreceived` = `i_messagesreceived`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);

	}
	
	
	public  function addUnitDestroyed(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_UnitsDestroyed` = `i_UnitsDestroyed`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addAlliTopicCreated(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_alliwritten` = `i_alliwritten`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addAlliTopicAnswered(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_allianswerd` = `i_allianswerd`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addPlanetRaided(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_planetsraided` = `i_planetsraided`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addUnitLost(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_UnitsLost` = `i_UnitsLost`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addDeutBuy(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_deuteriumbought` = `i_deuteriumbought`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addCrysBuy(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_crystalbought` = `i_crystalbought`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addMetalBuy(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_ metallbought` = `i_ metallbought`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	} 	
	
	public  function addCreditsEarned(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_creditsearned` = `i_creditsearned`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addCreditsGiven(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_creditsgiven` = `i_creditsgiven`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addPlanetsLost(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_planetslost` = `i_planetslost`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addPlanetsScanned(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_planetsscanned` = `i_planetsscanned`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addPlanetsGotten(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_planetsgotten` = `i_planetsgotten`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addFoodBuy(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_foodbought` = `i_foodbought`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	public  function addFoodSell(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_foodsold` = `i_foodsold`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	public  function addCrysSell(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_crystalsold` = `i_crystalsold`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	public  function addMetalSell(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_metallsold` = `i_metallsold`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	public  function addDeutSell(User $User,$Count=1)
	{
		$Sql="UPDATE `tbl_userstats` 
		SET `i_deuteriumsold` = `i_deuteriumsold`+".$Count." 
		WHERE `i_UserId` =".$User->getId();	
		return $this->executeNonQuery($Sql);
		
	}
	
	// 	 	 	 	 	 	 	 	i_creditsearned 	i_creditsgiven 	i_fleetlost 	i_fleetbuild 	i_fleetactive 	i_fleetrepaired 	i_fleethitpointslost 	i_fleetdamagegiven 	i_fleetgainedrank 	i_fleetguerillarepair 	i_fleetinterventionfleet 	i_activeupgrades
}
?>