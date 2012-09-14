<?php

function __autoload($Class)
{
	$BasicInclueConst =  BasicIncludeConst::getInstance();
	if (isset($BasicInclueConst->PathArray[$Class]) && file_exists($BasicInclueConst->PathArray[$Class]))
	{
		try {
			require_once($BasicInclueConst->PathArray[$Class]);	
			}
			catch (Exception $e)
			{
			echo "datei konnte nicht gefunden werden ". $Class."<br />\n";
			}	
	}else 
	{
		echo "ein include Datei wurde nicht gefunden ". $Class."<br />\n";
		
	}

}


 class  BasicIncludeConst
{
	
	
	public $PathArray=null;
    private static $Instance=null;
	
	
	
	private function __construct()
	{
		$this->createPathArray();
	}
	
	
	/**
	 * ld alle verf�gbaren php datein
	 *
	 * @return void 
	 *
	 */
	public function loadAll()
	{
		$this->createPathArray();
		
		foreach($this->PathArray as $Path)
		{
			try {
				echo $_SERVER['argv']['1']."/".$Path." geladen \n";
				require_once($_SERVER['argv']['1']."/".$Path);	
			}
			catch (Exception $e)
			{
				echo "datei konnte nicht gefunden werden ".$Class."<br />";
			}
		}
		
	}
	
	
	public static function getInstance()
	{
		{
			if(self::$Instance === NULL)
			{
				self::$Instance = new BasicIncludeConst();
			}

			return self::$Instance;
		}
	}
		
	private function createPathArray()
	{
		$this->PathArray['i_CollectionElement']='class/objects/i_CollectionElements.php';
		$this->PathArray['Request']='class/logic/cls_Request.php';
		$this->PathArray['Collection']='class/objects/cls_AbstractCollection.php';
	 	$this->PathArray['MySqlExeption']='class/db/cls_mysql_exeption.php';
		$this->PathArray['MySqldb']='class/db/cls_mysql.php';
		$this->PathArray['SystemFinder']='class/DatabaseObjects/cls_SystemFinder.php'; 
		$this->PathArray['SystemManager']='class/DatabaseObjects/cls_SystemManager.php';
		$this->PathArray['ParseAbleObject']='class/objects/cls_ParseAbleObject.php'; //parse object
		
		
		
		
		
		//$this->PathArray['Click']='class/objects/cls_Click.php';
		//$this->PathArray['ClickManager']='class/DatabaseObjects/cls_ClickManager.php';



		$this->PathArray['SunSystemNames']='cfg/cfg_SystemNames.php';

		#region User Objekte
		$this->PathArray['User']='class/objects/cls_User.php';

		$this->PathArray['UserCollection']='class/objects/cls_UserCollection.php';
		$this->PathArray['UserFinder']='class/DatabaseObjects/cls_UserFinder.php';
		$this->PathArray['UserManager']='class/DatabaseObjects/cls_UserManager.php';
		$this->PathArray['UserStats']='class/objects/cls_UserStats.php';
		#endregion
		
		
		$this->PathArray['Quote']='class/objects/cls_Quote.php';
		$this->PathArray['QuoteFinder']='class/DatabaseObjects/cls_QuoteFinder.php';
		
		
		#region Controler Objekte
		$this->PathArray['Controler_Admin']='class/logic/cls_Controler_Admin.php';
		$this->PathArray['Controler_Dock']='class/logic/cls_Controler_Dock.php';
		$this->PathArray['Controler_Building']='class/logic/cls_Controler_Building.php';
		$this->PathArray['Controler_Main']='class/logic/cls_Controler_Main.php';
		$this->PathArray['Controler_Login']='class/logic/cls_Controler_Login.php';
		$this->PathArray['Controler_Planet']='class/logic/cls_Controler_Planet.php';
		$this->PathArray['Controler_Resource']='class/logic/cls_Controler_Resource.php';
		$this->PathArray['Controler_Message']='class/logic/cls_Controler_Message.php';
		$this->PathArray['Controler_Map']='class/logic/cls_Controler_Map.php';	
		$this->PathArray['Controler_Ships']='class/logic/cls_Controler_Ships.php';	
		$this->PathArray['Controler_Allianz']='class/logic/cls_Controler_Allianz.php';		
		$this->PathArray['Controler_User']='class/logic/cls_Controler_User.php';
		$this->PathArray['Controler_Research']='class/logic/cls_Controler_Research.php';
		$this->PathArray['Controler_Ranking']='class/logic/cls_Controler_Ranking.php';
		$this->PathArray['Controler_Help']='class/logic/cls_Controler_Help.php';	
		$this->PathArray['Controler_Sale']='class/logic/cls_Controler_Sale.php';
		$this->PathArray['Controler_Skill']='class/logic/cls_Controler_Skill.php';
		$this->PathArray['Controler_Event']='class/logic/cls_Controler_Event.php';
		#endregion

		$this->PathArray['ShipManager']='class/DatabaseObjects/cls_ShipManager.php';
		$this->PathArray['ShipFinder']='class/DatabaseObjects/cls_ShipFinder.php';
		$this->PathArray['Ship']='class/objects/ships/cls_Ship.php'; 
		$this->PathArray['ShipCollection']='class/objects/ships/cls_ShipCollection.php';
		$this->PathArray['ShipBuild']='class/objects/ships/cls_ShipBuild.php';
		$this->PathArray['ShipBuildCollection']='class/objects/ships/cls_ShipBuildCollection.php';
		
		$this->PathArray['PlanetProtectionBuilding']='class/objects/buildings/cls_PlanetProtection.php';
		$this->PathArray['HeadQuarterBuilding']='class/objects/buildings/cls_HeadQuarter.php';
		
		
		$this->PathArray['SkillManager']='class/DatabaseObjects/cls_SkillManager.php';
		$this->PathArray['SkillFinder']='class/DatabaseObjects/cls_SkillFinder.php';
		 
		$this->PathArray['SkillCollection']='class/objects/cls_SkillCollection.php';
		$this->PathArray['Skill']='class/objects/cls_Skill.php';
		$this->PathArray['SkillRefuel']='class/objects/skills/cls_Skill_Refuel.php';
		$this->PathArray['SkillCreditsSteal']='class/objects/skills/cls_Skill_CreditsSteal.php';
		$this->PathArray['SkillRepair']='class/objects/skills/cls_Skill_Repair.php';
		$this->PathArray['SkillNewUnit']='class/objects/skills/cls_Skill_NewUnit.php';
		$this->PathArray['SkillJump']='class/objects/skills/cls_Skill_EmergencyJump.php';
		$this->PathArray['SkillPlanetEpidemic']='class/objects/skills/cls_Skill_PlanetEpidemic.php';
		$this->PathArray['SkillSabotage']='class/objects/skills/cls_Skill_Sabotage.php';
		$this->PathArray['SkillPlanetExtractRessources']='class/objects/skills/cls_Skill_PlanetExtractRessources.php';
			
		$this->PathArray['StatsManager']='class/DatabaseObjects/cls_StatsManager.php';
		$this->PathArray['StatsFinder']='class/DatabaseObjects/cls_StatsFinder.php';	
			
		$this->PathArray['EventCollection']='class/objects/events/cls_EventCollection.php';
		$this->PathArray['SystemEvent']='class/objects/events/cls_SystemEvent.php';		  
		$this->PathArray['MessageSendEvent']='class/objects/events/cls_MessageSendEvent.php';
		$this->PathArray['MessageReciveEvent']='class/objects/events/cls_MessageReciveEvent.php';
		$this->PathArray['UnitDestroyedEvent']='class/objects/events/cls_UnitDestroyedEvent.php';
		$this->PathArray['UnitLostEvent']='class/objects/events/cls_UnitLostEvent.php';
		$this->PathArray['PlanetRaidedEvent']='class/objects/events/cls_PlanetRaidedEvent.php';
		$this->PathArray['AllianzTopicCreateEvent']='class/objects/events/cls_AllianzTopicCreateEvent.php';
		$this->PathArray['AllianzTopicAnswerEvent']='class/objects/events/cls_AllianzTopicAnswerEvent.php';
		$this->PathArray['PlanetsGottenEvent']='class/objects/events/cls_PlanetsGottenEvent.php';
		$this->PathArray['PlanetsLostEvent']='class/objects/events/cls_PlanetsLostEvent.php';
		$this->PathArray['PlanetsScannedEvent']='class/objects/events/cls_PlanetsScannedEvent.php';

		
		//Events
		$this->PathArray['BuildingConstructed']='class/objects/events/cls_BuildingConstructed.php';
		$this->PathArray['EventConstants']='class/objects/events/cls_EventConstants.php';
		$this->PathArray['BuyEvent']='class/objects/events/cls_BuyEvent.php';
		$this->PathArray['SellEvent']='class/objects/events/cls_SellEvent.php';
		$this->PathArray['UnitCreatedEvent']='class/objects/events/cls_UnitCreatedEvent.php';
		$this->PathArray['SaleStatsChange']='class/objects/events/cls_SaleStatsChange.php';
			
		$this->PathArray['ReSearchManager']='class/DatabaseObjects/cls_ReSearchManager.php';
		$this->PathArray['ReSearchFinder']='class/DatabaseObjects/cls_ReSearchFinder.php';
		$this->PathArray['ReSearch']='class/objects/cls_ReSearch.php'; 
		$this->PathArray['ReSearchCollection']='class/objects/cls_ReSearchCollection.php';

		$this->PathArray['SaleManager']='class/DatabaseObjects/cls_SaleManager.php';
		$this->PathArray['SaleFinder']='class/DatabaseObjects/cls_SaleFinder.php';
		$this->PathArray['Sale']='class/objects/cls_Sale.php';
		$this->PathArray['UnitSale']='class/objects/cls_UnitSale.php';
		 
		$this->PathArray['SaleCollection']='class/objects/cls_SaleCollection.php';

		$this->PathArray['AllianzManager']='class/DatabaseObjects/cls_AllianzManager.php';
		$this->PathArray['AllianzFinder']='class/DatabaseObjects/cls_AllianzFinder.php';
		$this->PathArray['Allianz']='class/objects/cls_Allianz.php'; 
		$this->PathArray['AllianzCollection']='class/objects/cls_AllianzCollection.php';
		$this->PathArray['AllianzRank']='class/objects/cls_Allianz_Rank.php';
		$this->PathArray['AllianzRankCollection']='class/objects/cls_Allianz_RankCollection.php';
		$this->PathArray['AllianzTopic']='class/objects/cls_AllianzTopic.php'; 
		$this->PathArray['AllianzTopicCollection']='class/objects/cls_AllianzTopicCollection.php';
		$this->PathArray['AllianzComment']='class/objects/cls_AllianzComment.php'; 
		$this->PathArray['AllianzCommentCollection']='class/objects/cls_AllianzCommentCollection.php';
		$this->PathArray['AllianzTopicManager']='class/DatabaseObjects/cls_AllianzTopicManager.php';
		$this->PathArray['AllianzCommentManager']='class/DatabaseObjects/cls_AllianzCommentManager.php';
		$this->PathArray['AllianzCommentFinder']='class/DatabaseObjects/cls_AllianzCommentFinder.php';
		$this->PathArray['AllianzTopicFinder']='class/DatabaseObjects/cls_AllianzTopicFinder.php';
		
		$this->PathArray['MapObjectManager']='class/DatabaseObjects/cls_MapObjectManager.php';
		$this->PathArray['MapObjectFinder']='class/DatabaseObjects/cls_MapObjectFinder.php';
		$this->PathArray['MapObject']='class/objects/cls_MapObject.php'; 
		$this->PathArray['MapObjectCollection']='class/objects/cls_MapObjectCollection.php';
		$this->PathArray['Sun']='class/objects/cls_Sun.php'; 

		$this->PathArray['UnitManager']='class/DatabaseObjects/cls_UnitManager.php';
		$this->PathArray['UnitFinder']='class/DatabaseObjects/cls_UnitFinder.php';
		$this->PathArray['Unit']='class/objects/cls_Unit.php'; 
		$this->PathArray['UnitCollection']='class/objects/cls_UnitCollection.php';
		$this->PathArray['Task']='class/objects/cls_Task.php';
		$this->PathArray['TaskCollection']='class/objects/cls_TaskCollection.php';
		
		
		$this->PathArray['RouteManager']='class/DatabaseObjects/cls_RouteManager.php';
		$this->PathArray['RouteFinder']='class/DatabaseObjects/cls_RouteFinder.php';
		$this->PathArray['Route']='class/objects/cls_Route.php'; 
		$this->PathArray['RouteCollection']='class/objects/cls_RouteCollection.php';
		
		$this->PathArray['RoutePointManager']='class/DatabaseObjects/cls_RoutePointManager.php';
		$this->PathArray['RoutePointFinder']='class/DatabaseObjects/cls_RoutePointFinder.php';
		$this->PathArray['RoutePoint']='class/objects/cls_RoutePoint.php'; 
		$this->PathArray['RoutePointCollection']='class/objects/cls_RoutePointCollection.php';
		
		
		
		$this->PathArray['Battle']='class/objects/cls_Battle.php';
		$this->PathArray['BattleCollection']='class/objects/cls_BattleCollection.php';


		
		$this->PathArray['Template']='class/objects/cls_Template.php'; 
		$this->PathArray['Date']='class/objects/cls_Date.php';

		
		$this->PathArray['Message']="class/objects/cls_Message.php";
		$this->PathArray['MessageCollection']="class/objects/cls_MessageCollection.php";
		$this->PathArray['MessageFinder']="class/DatabaseObjects/cls_MessageFinder.php";
		$this->PathArray['MessageManager']="class/DatabaseObjects/cls_MessageManager.php";
		

		$this->PathArray['BuildingCollection']="class/objects/cls_BuildingCollection.php";
		$this->PathArray['Building']="class/objects/cls_Building.php";
		$this->PathArray['BuildingManager']="class/DatabaseObjects/cls_BuildingManager.php";
		$this->PathArray['BuildingFinder']="class/DatabaseObjects/cls_BuildingFinder.php";


		$this->PathArray['PlanetCollection']="class/objects/cls_PlanetCollection.php";
		$this->PathArray['Planet']="class/objects/cls_Planet.php";
		$this->PathArray['PlanetManager']="class/DatabaseObjects/cls_PlanetManager.php";
		$this->PathArray['PlanetFinder']="class/DatabaseObjects/cls_PlanetFinder.php";
		$this->PathArray['PlanetSystem']="class/objects/cls_PlanetSystem.php";

		$this->PathArray['InviteCollection']="class/objects/cls_InviteCollection.php";
		$this->PathArray['Invite']="class/objects/cls_Invite.php";
		$this->PathArray['InviteManager']="class/DatabaseObjects/cls_InviteManager.php";
		$this->PathArray['InviteFinder']="class/DatabaseObjects/cls_InviteFinder.php";
		$this->PathArray['IVENTCONSTANTS']="class/objects/cls_InviteConstants.php";


		$this->PathArray['State']="class/objects/state/cls_State.php";
		$this->PathArray['StateCollection']="class/objects/state/cls_StateCollection.php";
		$this->PathArray['StateManager']="class/DatabaseObjects/cls_StateManager.php";
		$this->PathArray['StateFinder']="class/DatabaseObjects/cls_StateFinder.php";
		$this->PathArray['StateMoral']="class/objects/state/cls_StateMoral.php";
		$this->PathArray['StateArmoured']="class/objects/state/cls_StateArmoured.php";
		$this->PathArray['StateSlowed']="class/objects/state/cls_StateSlowed.php";
		$this->PathArray['StateSpeedy']="class/objects/state/cls_StateSpeedy.php";
		$this->PathArray['StateFallout']="class/objects/state/cls_StateFallout.php";
		$this->PathArray['StateEMPed']="class/objects/state/cls_StateEMPed.php";
		$this->PathArray['StateLowDamage']="class/objects/state/cls_StateLowDamage.php";
		$this->PathArray['StateOverload']="class/objects/state/cls_StateOverload.php";
		$this->PathArray['StateHullDamage']="class/objects/state/cls_StateHullDamage.php";
		$this->PathArray['StateWeaponOffline']="class/objects/state/cls_StateWeaponOffline.php";
		$this->PathArray['StateArmoured']="class/objects/state/cls_StateArmoured.php";
		$this->PathArray['StateFrightened']="class/objects/state/cls_StateFrightened.php";	
		$this->PathArray['StateJumpOffline']="class/objects/state/cls_StateJumpOffline.php";
		$this->PathArray['StateBayOffline']="class/objects/state/cls_StateBayOffline.php";
		$this->PathArray['StateScannerOffline']="class/objects/state/cls_StateScannerOffline.php";
		$this->PathArray['StateEmpUsed']="class/objects/state/cls_StateEmpUsed.php";
		$this->PathArray['StateHullBreak']="class/objects/state/cls_StateHullBreak.php";
		$this->PathArray['StateShieldOffline']="class/objects/state/cls_StateShieldOffline.php";
		$this->PathArray['StateLaserOffline']="class/objects/state/cls_StateLaserOffline.php";
		$this->PathArray['StateParticleOffline']="class/objects/state/cls_StateParticleOffline.php";
		$this->PathArray['StateNoArmor']="class/objects/state/cls_StateNoArmor.php";
		$this->PathArray['StateShipForSale']="class/objects/state/cls_StateShipForSale.php";
		$this->PathArray['StateNoTorpedo']="class/objects/state/cls_StateNoTorpedo.php";
		
	}
	
	
	
}

















?>