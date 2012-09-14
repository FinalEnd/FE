<?php
class StateFinder extends SystemFinder
{
	private function doLoad($RecordSet)
	{
		$StateCollection = new StateCollection();
		
		foreach ($RecordSet as $Row)
		{
			$StateCollection->add($this->load($Row));
		}
		return $StateCollection;
	}

	protected function load($Result)
	{
		switch($Result['i_Id'])
		{
			case 1:
			{
				return new StateMoral($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 2:
			{
				return new StateArmoured($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 3:
			{
				return new StateSlowed($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 4:
			{
				return new StateSpeedy($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 5:
			{
				return new StateFallout($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 6:
			{
				return new StateEMPed($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 7:
			{
				return new StateLowDamage($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 8:
			{
				return new StateOverload($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 9:
			{
				return new StateHullDamage($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 10:
			{
				return new StateWeaponOffline($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 11:
			{
				return new StateFrightened($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 12:
			{
				return new StateScannerOffline($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 13:
			{
				return new StateBayOffline($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 14:
			{
				return new StateJumpOffline($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 15:
			{
				return new StateHullBreak($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 16:
			{
				return new StateShieldOffline($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 17:
			{
				return new StateLaserOffline($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 18:
			{
				return new StateParticleOffline($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			case 19:
			{
				return new StateNoArmor($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			
			case 20:
			{
				return new StateEmpUsed($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			
			case 21:
			{
				return new StateShipForSale($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
			}break;
			
			default:
				return new StateMoral($Result['i_Id'],$Result['s_Name'],$Result['i_Expired'],$Result['s_Picture'],$Result['t_Description']);	
		}
		
	}

	public function findbyUnitId($Id)
	{
		$Sql="SELECT S.i_Id, S.s_Name, S.t_Description, S.s_Picture, US.i_Expired
			FROM `tbl_unionstate` AS US, tbl_state AS S
			WHERE 
			US.i_StateId = S.I_Id and
			US.i_UnionId =".$Id;
		return $this->doLoad($this->executeQuery($Sql));
	}

	
}?>