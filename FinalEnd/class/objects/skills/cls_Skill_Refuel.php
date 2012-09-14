<?php


class SkillRefuel extends Skill
{
	

	public function getHTML()
	{
		$HTML="<tr>
	 			<td width='80%' colspan='2'  class='header'>".$this->getName()."
			</td>
			</tr>";
		
		
		$HTML.= "<tr>
	 			<td width='80%'>".$this->getDescription()."<br />
				 <form action='index.php?Section=Skill&Action=DoSkill&SkillId=".$this->getId()."' id='FormRefuel' method='post'>
					:T_PLAN_COORDIN:  X:<input id='FuelX' onkeyup='MySkill.split(\"Fuel\",this.value)' type='Text' name='i_X' value='' size='7' maxlength=''> Y:<input id='FuelY' type='Text' name='i_Y' value='' size='7' maxlength=''> :T_SHOP_FLEET:
				</form>
				 </td>";		
		if($this->canDo())
		{
			$HTML.="<td rowspan='2' align='center' ><a onclick='document.getElementById(\"FormRefuel\").submit()' style='text-decoration:underline;cursor:pointer' >:T_UNIT_ACTIVATE:</a></td>";
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
		$User= Controler_Main::getInstance()->getUser();
		$UnitFinder= new UnitFinder();
		if(!$Request->getAsInt("i_X")||!$Request->getAsInt("i_Y")){return ":T_SKILL_COORDERR:";}
		$UnitCollection = new UnitCollection();
		//$Unit=$UnitFinder->findByUserIdAndBetweenKoordinates($User->getId(),$Request->getAsInt("i_X"),$Request->getAsInt("i_X")+5,$Request->getAsInt("i_Y"),$Request->getAsInt("i_Y"),$Request->getAsInt("i_Y")+5)->getByIndex(0);// findet die einheit die sich an den angegeben Koordinaten befindet
		$UnitCollection=$UnitFinder->findAllByKoordinates($Request->getAsInt("i_X"),$Request->getAsInt("i_Y"),5);// anhand der range finden
		if($UnitCollection->getCount()==0){return ":T_SKILL_FLEETNOTFOUND:";}
		foreach($UnitCollection as $Unit)
		{
			if($Unit->getUser()->getId() == $User->getId())
			{
				$UnitManager=new UnitManager();
				
				$Storage = $Unit->getFreeStoredSpace();
				if($Storage > 10000)
				{
					$DeuteriumLoaded = $Unit->getStoredElement("t",true) + 10000;
				} else
				{
					$DeuteriumLoaded = $Unit->getStoredElement("t",true) + $Storage;
				}
				$Unit->setStoredElement("t",$DeuteriumLoaded);
				$UnitManager->updateUnit($Unit);
				$MessageControler= new Controler_Message();
				$MessageControler->sendMessage("System",$User->getName(),":T_SKILL_JUMP_MSG2: ".$Unit->getName()." :T_SKILL_FUEL1: ",":T_SKILL_FUEL1_TITLE:");
				Controler_Main::getInstance()->addPermanentOutPut();
				return;
			}
		}
		return ":T_SKILL_FLEETNOTFOUND:";
		
	}
	
	
}


?>