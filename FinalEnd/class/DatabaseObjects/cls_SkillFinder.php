<?php
class SkillFinder extends SystemFinder 
{
	/**
	 * läd eine zeile aus der db in ein konkretess object
	 *
	 * @param sql RecordSet $Result
	 * @return PlayerMessage
	 */
	protected  function doLoad($Result)
	{
		$SkillCollection= new SkillCollection();
		foreach($Result as $Row)
		{
			$SkillCollection->add($this->load($Row));
		}
		return $SkillCollection;
	}	
	
	protected function load($Row)
	{
		switch($Row['i_Id'])
		{
			case 1:
			{
				return new SkillCreditsSteal($Row['i_Id'],$Row['s_Name'],$Row['t_Description'],$Row['i_CoolDown'],$Row['i_Time'],$Row['i_NeededLevel'],$Row['i_SkillId']);   
			}break;
			
		case 2:
			{
				return new SkillRepair($Row['i_Id'],$Row['s_Name'],$Row['t_Description'],$Row['i_CoolDown'],$Row['i_Time'],$Row['i_NeededLevel'],$Row['i_SkillId']);   
			}break;
			
		case 3:
			{
				return new SkillNewUnit($Row['i_Id'],$Row['s_Name'],$Row['t_Description'],$Row['i_CoolDown'],$Row['i_Time'],$Row['i_NeededLevel'],$Row['i_SkillId']);   
			}break;	
				
		case 4:
			{
				return new SkillJump($Row['i_Id'],$Row['s_Name'],$Row['t_Description'],$Row['i_CoolDown'],$Row['i_Time'],$Row['i_NeededLevel'],$Row['i_SkillId']);   
			}break;	
			
		case 5:
			{
				return new SkillPlanetEpidemic($Row['i_Id'],$Row['s_Name'],$Row['t_Description'],$Row['i_CoolDown'],$Row['i_Time'],$Row['i_NeededLevel'],$Row['i_SkillId']);   
			}break;
			
		case 6:
			{
				return new SkillSabotage($Row['i_Id'],$Row['s_Name'],$Row['t_Description'],$Row['i_CoolDown'],$Row['i_Time'],$Row['i_NeededLevel'],$Row['i_SkillId']);   
			}break;
		case 8:
		{
			return new SkillRefuel($Row['i_Id'],$Row['s_Name'],$Row['t_Description'],$Row['i_CoolDown'],$Row['i_Time'],$Row['i_NeededLevel'],$Row['i_SkillId']);   
		}break;
		case 7:
			{
				return new SkillPlanetExtractRessources($Row['i_Id'],$Row['s_Name'],$Row['t_Description'],$Row['i_CoolDown'],$Row['i_Time'],$Row['i_NeededLevel'],$Row['i_SkillId']);   
			}break;		
			default:
				return new Skill($Row['i_Id'],$Row['s_Name'],$Row['t_Description'],$Row['i_CoolDown'],$Row['i_Time'],$Row['i_NeededLevel'],$Row['i_SkillId']);
		}
		
		
		
	}
	
	public function findByUserId(User $User)
	{
		$Sql="SELECT S.i_Id,s_Name ,S.t_Description ,S.i_CoolDown ,S.i_NeededLevel, US.i_Time  ,US.i_SkillId
			FROM `tbl_skills` as S, tbl_userskills	as US
		WHERE US.i_UserId = ".$User->getId()." 
		and
		 S.i_Id=US.i_SkillId  ORDER BY `i_NeededLevel` ASC";	
		
		return  $this->doload($this->executeQuery($Sql));	
	}
	
	
	public function findByUserAndType(Skill $Skill,User $User)
	{
		$Sql="SELECT S.i_Id,s_Name ,S.t_Description ,S.i_CoolDown ,S.i_NeededLevel, US.i_Time  ,US.i_SkillId
			FROM `tbl_skills` as S, tbl_userskills	as US
		WHERE US.i_UserId = ".$User->getId()." 
		and
		 S.i_Id=US.i_SkillId
		and 
		US.i_SkillId=".$Skill->getType()." ORDER BY `i_NeededLevel` ASC";	
		
		return  $this->doload($this->executeQuery($Sql))->getByIndex(0);	
	}
	
	/**
	 * findet das element aus de db mit der angegebenen id
	 *
	 * @param int $Id 
	 * @return Sale kann ein Null element sein
	 *
	 */
	public function findById($Id)
	{
		$Sql="SELECT S.i_Id,s_Name ,S.t_Description ,S.i_CoolDown ,S.i_NeededLevel 
			FROM `tbl_skills` as S
		WHERE i_Id = ".$Id." ORDER BY `i_NeededLevel` ASC";	
		return  $this->doload($this->executeQuery($Sql))->getByIndex(0);	
	}

	public function findAll()
	{
		$Sql="SELECT S.i_Id,S.s_Name,S.t_Description,S.i_CoolDown,S.i_NeededLevel 
			FROM `tbl_skills` as S  ORDER BY `i_NeededLevel` ASC";	
		return  $this->doload($this->executeQuery($Sql));	
	}
	
}


?>