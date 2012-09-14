<?php


class SkillPlanetExtractRessources extends Skill
{
	

	public function getHTML()
	{
		$HTML="<tr>
	 			<td width='80%' colspan='2'  class='header'>".$this->getName()."
			</td>
			</tr>";
		
		
		$HTML.= "<tr>
	 			<td width='80%'>".$this->getDescription()."<br />
				 <form action='index.php?Section=Skill&Action=DoSkill&SkillId=".$this->getId()."' id='PlanetRessources' method='post'>
					:T_PLAN_COORDIN:  X:<input id='PlanetRessourcesX' onkeyup='MySkill.split(\"PlanetRessources\",this.value)' type='Text' name='i_X' value='' size='7' maxlength=''> Y:<input id='PlanetRessourcesY' type='Text' name='i_Y' value='' size='7' maxlength=''> :T_GROUP_PLANET:
				</form>
				 </td>";		
		if($this->canDo())
		{
			$HTML.="<td rowspan='2' align='center' ><a onclick='document.getElementById(\"PlanetRessources\").submit()' style='text-decoration:underline;cursor:pointer' >:T_UNIT_ACTIVATE:</a></td>";
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
		$RessourceType=mt_rand(0,3);
		$Count=mt_rand(SKILL_EXTRACT_RESSOURCE_MIN,SKILL_EXTRACT_RESSOURCE_MAX);
		switch($RessourceType)
		{
			case"0":
			{
				$Count=$Planet->getMetal()-$Count;
				if($Count<0)			// Sollte die zufallszahl gr�er sein als was da ist, wird alles genommen
					$Count=0;
				$Planet->setResource("m",$Count);
				$Name=":T_HEADER_METAL:";
			}break;	
			case"1":
			{
				$Count=$Planet->getHydrogen()-$Count;
				if($Count<0)
					$Count=0;
				$Planet->setResource("t",$Count);
				$Name=":T_HEADER_HYDROGEN:";
			}break;
			case"2":
			{
				$Count=$Planet->getCrystal()-$Count;
				if($Count<0)
					$Count=0;
				$Planet->setResource("c",$Count);
				$Name=":T_HEADER_CRYSTAL:";
			}break;
			case"3":
			{
				$Count=$Planet->getBiomass()-$Count;
				if($Count<0)
					$Count=0;
				$Planet->setResource("b",$Count);
				$Name=":T_HEADER_BIOMAS:";
			}break;
		}
				
		$PlanetManager=new PlanetManager();
		$PlanetManager->updateResources($Planet);
		$DamagedPlayer=$Planet->getUser();
		
		$MessageControler->sendExtractRessources($DamagedPlayer,$User,$Planet,$Count,$Name);
	}
}


?>