<?php


class SkillNewUnit extends Skill
{
	

	public function getHTML()
	{
		$HTML="<tr>
	 			<td width='80%' colspan='2'  class='header'>".$this->getName()."
			</td>
			</tr>";
		
		
		$HTML.= "<tr>
	 			<td width='80%'>".$this->getDescription()."<br />
				 <form action='index.php?Section=Skill&Action=DoSkill&SkillId=".$this->getId()."' id='FormNewUnit' method='post'>
					:T_PLAN_COORDIN:  X:<input id='NewUnitX' onkeyup='MySkill.split(\"NewUnit\",this.value)' type='Text' name='i_X' value='' size='7' maxlength=''> Y:<input id='NewUnitY' type='Text' name='i_Y' value='' size='7' maxlength=''>
				</form>
				 </td>";		
		if($this->canDo())
		{
			$HTML.="<td rowspan='2' align='center' ><a onclick='document.getElementById(\"FormNewUnit\").submit()' style='text-decoration:underline;cursor:pointer' >:T_UNIT_ACTIVATE:</a></td>";
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
		$UnitManager= new UnitManager();
		$TempString="d:0;sh:50;hh:0;b:0;bs:0";
		$ShipFinder= new ShipFinder();
		$Ship=$ShipFinder->findById(3);	
		$TempDMG=$Ship->getDMG()*50;
		$Amor=$Ship->getAmor();
		$Speed=$Ship->getSpeed();
		$Storage=$Ship->getStorage()*50;
		$Healts=$Ship->getHealth()*50;
		$Stored="t:".$Storage.";m:0;b:0;c:0;";
		$NewUnit= new Unit(0,"Jäger",$TempString,$TempDMG,$Amor,$Speed,$Healts,$User,0,0,$Request->getAsInt("i_X"),$Request->getAsInt("i_Y"),1,$Storage,$Stored,0,0,new Task());
		$UnitManager->insertUnit($NewUnit);	
	}
	
	
	
}


?>