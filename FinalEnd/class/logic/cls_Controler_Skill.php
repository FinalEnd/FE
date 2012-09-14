<?php

/**
 * class cls_Controler_Skill
 *
 * Description for class cls_Controler_Skill
 *
 * @author:
*/
class Controler_Skill  
{

	/**
	 * cls_Controler_Skill constructor
	 *
	 * @param 
	 */
	function __construct() 
	{





	}
	
	
	public function start()
	{
		$Request= new Request();
		switch($Request->getAsString('Action'))
		{ 
			
			case "ShowUserSkills":
			{
				$this->showUserSkills();
			}break;
			
			case "DoSkill":
			{
				$this->doSkill();
			}break;
			
			default:
				$this->showUserSkills();
		}
	}
	
	public function doSkill()
	{
		$SkillFinder= new SkillFinder();
		$ReQuest= new Request();
		$Skill=$SkillFinder->findById($ReQuest->getAsInt("SkillId"));
		if($Skill->getId()==0)// wenn es den Skill nicht gibt
		{
			$this->showUserSkills(":T_ERROR_SKILL1:!");
			return false;
		}
		//$Skill=Skill::getEmptyInstance();
		$Skill->setType($ReQuest->getAsInt("SkillId"));
		$User= Controler_Main::getInstance()->getUser();
		$SkillTemp=$SkillFinder->findByUserAndType($Skill,$User);
		if($SkillTemp->getId()!=0)//wenn der skiill noch auf Cooldonw ist soll er ihn nicht nochmal nehmen können
		{
			$this->showUserSkills(":T_SKILL_CANTDO1:");
			return false;
		}
		// alle eingaben prüfen
		//darf der User das oder nicht
		$ReQuest= new Request();	

		$ErrorString=$Skill->doSkill(); // switch wurde entfernt
		if(!$ErrorString){$this->insertSkill($Skill);} // wenn alles klar ging dann den Skill eintragen	
		$this->showUserSkills($ErrorString);
		
	}

	public function insertSkill($Skill=false)
	{
		$SkillFinder= new SkillFinder();
		$ReQuest= new Request();
		if(!$Skill)
		{
			$Skill=$SkillFinder->findById($ReQuest->getAsInt("SkillId"));	// findet hier nur den nicht verknüpften skill 
		}
		$Skill->setType($Skill->getId());
		$SkillManager= new SkillManager();
		$User= Controler_Main::getInstance()->getUser();
		$SkillManager->insertSkillCoolDown($Skill,$User);	
	}
	
	
	
	public function showUserSkills($ErrorString="")
	{
		$User= Controler_Main::getInstance()->getUser();
		$SkillManager= new SkillManager();
		
		$SkillManager->deleteOldSkills();// setzt den CD für skills	 
		$SkillFinder=new SkillFinder();
		$TempLate=Template::getInstance("tpl_Skill.php");
		$SkillCollection=  $SkillFinder->findAll();
		$SkillCollection2=   $SkillFinder->findByUserId($User);
		$SkillCollection->merge($SkillCollection2);
		$SkillCollection->setUserLevel($User->getLevel());
		$TempLate->assign("ErrorString",$ErrorString);
		$TempLate->assign("SkillCollection",$SkillCollection);
		$TempLate->render();
	}
	
	
		
}
	
	
	


?>