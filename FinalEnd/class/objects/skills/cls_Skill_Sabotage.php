<?php


class SkillSabotage extends Skill
{
	

	public function getHTML()
	{
		$HTML="<tr>
	 			<td width='80%' colspan='2'  class='header'>".$this->getName()."
			</td>
			</tr>";
		
		
		$HTML.= "<tr>
	 			<td width='80%'>".$this->getDescription()."<br />
				 <form action='index.php?Section=Skill&Action=DoSkill&SkillId=".$this->getId()."' id='Sabotage' method='post'>
					:T_PLAN_COORDIN:  X:<input id='SabotageX' onkeyup='MySkill.split(\"Sabotage\",this.value)' type='Text' name='i_X' value='' size='7' maxlength=''> Y:<input id='SabotageY' type='Text' name='i_Y' value='' size='7' maxlength=''> :T_GROUP_PLANET:
				</form>
				 </td>";		
		if($this->canDo())
		{
			$HTML.="<td rowspan='2' align='center' ><a onclick='document.getElementById(\"Sabotage\").submit()' style='text-decoration:underline;cursor:pointer' >:T_UNIT_ACTIVATE:</a></td>";
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
		$User= Controler_Main::getInstance()->getUser();
		$Request= new Request();
		$PlanetFinder= new PlanetFinder();
		$MessageControler= new Controler_Message();	
		if(!$Request->getAsInt("i_X")||!$Request->getAsInt("i_Y")){return ":T_SKILL_NO_PLANET_FOUND:";}
		$Planet=$PlanetFinder->findAllByKoordinates($Request->getAsInt("i_X"),$Request->getAsInt("i_Y"),200)->getByIndex(0);
		if($Planet->getId()==0){return ":T_SKILL_NO_PLANET_FOUND:";}

		$ShipManager= new ShipManager();	
		$ShipCollection=$Planet->getShipCollection();


		$AbortNoFound=0;
		do 
		{
			$RandomType=mt_rand(0,8); // Welcher Einheitentyp soll zerstört werden
			$RandomCount=mt_rand(SKILL_SABOTAGE_MIN_PERCENT,SKILL_SABOTAGE_MAX_PERCENT); // Wieviel % sollen zerstört werden
			if($ShipCollection->getShipCountByShipId($RandomType)>0)
			{
				$RandomCount=intval($ShipCollection->getShipCountByShipId($RandomType)*$RandomCount/100);
				$ShipManager->subductShips($RandomType,$Planet->getId(),$RandomCount);
				
				$MessageControler->sendSabotageWin($Planet->getUser(),$User,$Planet,$RandomCount);
				break;
			}
			$AbortNoFound += 1;	
		} while ($AbortNoFound < 10);
		if($AbortNoFound==10){			 
			$MessageControler->sendSabotageFail($Planet->getUser(),$User,$Planet);
		}
	}
	
}


?>