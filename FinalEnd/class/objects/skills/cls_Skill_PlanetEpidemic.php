<?php


class SkillPlanetEpidemic extends Skill
{
	

	public function getHTML()
	{
		$HTML="<tr>
	 			<td width='80%' colspan='2'  class='header'>".$this->getName()."
			</td>
			</tr>";
		
		
		$HTML.= "<tr>
	 			<td width='80%'>".$this->getDescription()."<br />
				 <form action='index.php?Section=Skill&Action=DoSkill&SkillId=".$this->getId()."' id='PlanetEpidemic' method='post'>
					:T_PLAN_COORDIN:  X:<input id='PlanetEpidemicX' onkeyup='MySkill.split(\"PlanetEpidemic\",this.value)' type='Text' name='i_X' value='' size='7' maxlength=''> Y:<input id='PlanetEpidemicY' type='Text' name='i_Y' value='' size='7' maxlength=''> :T_GROUP_PLANET:
				</form>
				 </td>";		
		if($this->canDo())
		{
			$HTML.="<td rowspan='2' align='center' ><a onclick='document.getElementById(\"PlanetEpidemic\").submit()' style='text-decoration:underline;cursor:pointer' >:T_UNIT_ACTIVATE:</a></td>";
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
		$Planet->setPeopleCount(0);
		$PlanetManager=new PlanetManager();
		$PlanetManager->updatePeopleCount($Planet);
		$DamagedPlayer=$Planet->getUser();
		$MessageControler->sendPlanetEpidemicToPlayer($DamagedPlayer,$User,$Planet);
		$UnitFinder = new UnitFinder();
		$Units = $UnitFinder->findByUserIdAndKoordinatesInRange($User, $Request->getAsInt("i_X"),$Request->getAsInt("i_Y"), 700);
		foreach ($Units as $Unit);
		{
			$State = new StateMoral(1,"usastyle",time()+ STATE_BONUS,"","");
			$StateManager = new StateManager();
			$StateManager->insertStateToUnit($State, $Unit);
		}
		$EnemysUnits = $UnitFinder->findByUserIdAndKoordinatesInRange($DamagedPlayer, $Request->getAsInt("i_X"),$Request->getAsInt("i_Y"), 700);
		foreach ($EnemysUnits as $Unit);
		{
			$State = new StateFrightened(11,"fear",time()+ STATE_MALUS,"","");
			$StateManager = new StateManager();
			$StateManager->insertStateToUnit($State, $Unit);
		}
	}
}


?>