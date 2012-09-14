<?php


class SkillRepair extends Skill
{
	

	public function getHTML()
	{
		$HTML="<tr>
	 			<td width='80%' colspan='2'  class='header'>".$this->getName()."
			</td>
			</tr>";
		
		
		$HTML.= "<tr>
	 			<td width='80%'>".$this->getDescription()."<br />
				 <form action='index.php?Section=Skill&Action=DoSkill&SkillId=".$this->getId()."' id='FormRepair' method='post'>
					:T_PLAN_COORDIN:  X:<input id='RepairX' onkeyup='MySkill.split(\"Repair\",this.value)' type='Text' name='i_X' value='' size='7' maxlength=''> Y:<input id='RepairY' type='Text' name='i_Y' value='' size='7' maxlength=''> :T_SHOP_FLEET:
				</form>
				 </td>";		
		if($this->canDo())
		{
			$HTML.="<td rowspan='2' align='center' ><a onclick='document.getElementById(\"FormRepair\").submit()' style='text-decoration:underline;cursor:pointer' >:T_UNIT_ACTIVATE:</a></td>";
		}else
		{
			$HTML.= "<td rowspan='2' align='center' >".$this->getCountDown()." </td>";
		}
		
		$HTML.= " </tr>";
		
		$HTML.= "<tr> 
			<td>
			Cooldown: ".$this->getCountDown(true)."
			</td>
		</tr>";	
		return $HTML; 
	}
	
	public function doSkill()
	{
		$Request= new Request();
		$MessageControler= new Controler_Message();
		
		$User= Controler_Main::getInstance()->getUser();
		$UnitFinder= new UnitFinder();		
		if(!$Request->getAsInt("i_X")||!$Request->getAsInt("i_Y")){return ":T_SKILL_COORDERR:";}
		$UnitCollection=$UnitFinder->findAllByKoordinates($Request->getAsInt("i_X"),$Request->getAsInt("i_Y"),5);// findet die einheit die sich an den angegeben Koordinaten befindet
		if($UnitCollection->getCount()==0){return ":T_SKILL_FLEETNOTFOUND:";}
		$StateManager= new StateManager();
		
		foreach($UnitCollection as $Unit)
		{
			if($Unit->getUser()->getId() == $User->getId())
			{	
				
				$UnitManager= new UnitManager();
				if($Unit->getHighesUnit()=="bds" || $Unit->getHighesUnit()=="ds" )
				{// todessterne können nicht repariert werden 
					$MessageControler->cantRepairDeathStar($User);
					return false;
				}
				$Unit->setState(1);
				$UnitManager->updateUnit($Unit);
				$StateManager->deleteStatesByUnit($Unit);
				
				$MessageControler->sendMessage("System",$User->getName(),":T_SKILL_JUMP_MSG2: ".$Unit->getName()." :T_SKILL_REPAIR_MSG2:",":T_SKILL_REPAIR_MSG1:");
			}
		}
	}
}


?>