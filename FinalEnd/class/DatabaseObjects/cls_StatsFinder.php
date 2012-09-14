<?php

class StatsFinder extends SystemFinder 
{
	
	private function doLoad($RecordSet)
	{
		
		$Stats = new UserStats($RecordSet[0]['i_Id'],$RecordSet[0]['i_UserId'],$RecordSet[0]['i_planetsgotten'],
			$RecordSet[0]['i_planetslost'],$RecordSet[0]['i_planetsscanned'],$RecordSet[0]['i_planetsraided'],
			$RecordSet[0]['i_alliwritten'],$RecordSet[0]['i_allianswerd'],$RecordSet[0]['i_messageswritten'],
			$RecordSet[0]['i_messagesreceived'],$RecordSet[0]['i_ metallbought'],$RecordSet[0]['i_metallsold'],
			$RecordSet[0]['i_crystalbought'],$RecordSet[0]['i_crystalsold'],$RecordSet[0]['i_deuteriumbought'],
			$RecordSet[0]['i_deuteriumsold'],$RecordSet[0]['i_foodbought'],$RecordSet[0]['i_foodsold'],
			$RecordSet[0]['i_creditsearned'],$RecordSet[0]['i_creditsgiven'],$RecordSet[0]['i_fleetlost'],
			$RecordSet[0]['i_fleetbuild'],$RecordSet[0]['i_fleetactive'],$RecordSet[0]['i_fleetrepaired'],
			$RecordSet[0]['i_fleethitpointslost'],$RecordSet[0]['i_fleetdamagegiven'],$RecordSet[0]['i_fleetgainedrank'],
			$RecordSet[0]['i_fleetguerillarepair'],$RecordSet[0]['i_fleetinterventionfleet'],$RecordSet[0]['i_activeupgrades']);
		return $Stats;
	}
				   

	public function findStatsById($Id) 
	{
		$Sql="SELECT * 
FROM `tbl_userstats` 
WHERE `i_UserId` = ".$Id."";
		return $this->doLoad($this->MySql->executeQuery($Sql));
	}
	
}


?>