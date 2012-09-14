<?php


class SkillCreditsSteal extends Skill
{
	

	public function getHTML()
	{
		$HTML="<tr>
	 			<td width='80%' colspan='2'  class='header'>".$this->getName()."</td>
			</tr>";

		$HTML.= "<tr>
	 			<td width='80%'>".$this->getDescription()." </td>  ";
		if($this->canDo())
		{
			$HTML.="<td rowspan='2' align='center' ><a href='index.php?Section=Skill&amp;Action=DoSkill&amp;SkillId=".$this->getId()."'>:T_UNIT_ACTIVATE:</a></td>";
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
		$UserFinder = new UserFinder();
		$UserManager= new UserManager();
		$MessageControler= new Controler_Message();	
		$AllianzId=0;
		if($User->getAllianzId()>0)	 // wenn der User keine alli hat dann gibt es hier einen fehler
		{
			$AllianzId=$User->getAllianzId();
		}
		$LostFromUser=	$UserFinder->findRandomUserOverLevel(SKILL_MIN_LEVEL_TO_STEAL_FROM,$AllianzId);
		$Counter=0;
		do
		{
			$LostCredits=mt_rand(1000,5000);// die gestohlenen credits
			$Counter++;	 // alternative abbruch bedinung
		}while($LostCredits>$LostFromUser->getCredits() && $Counter<50);
		if($Counter<50)	// wenn Credits gestohlen werden können es kann sein das der User keine Credits mehr -
		{
			$MessageControler->sendCreditStealToPlayer($LostFromUser->getName(),$LostCredits);
			$UserManager->setRefreshTimeAndCredits($LostFromUser->getId(),$LostFromUser->getCredits()-$LostCredits); // Credits abziehen
			$UserManager->setRefreshTimeAndCredits($User->getId(),$User->getCredits()+$LostCredits);	 // Credits hinzufügen
			$MessageControler->sendCreditGetToPlayer($User->getName(),$LostCredits); // nachicht schicken da td gelungen ist
		}else
		{
			$MessageControler->sendMessage("System",$User->getName(),":T_SKILL_STEAL_CREDITS_MSG2:",":T_SKILL_STEAL_CREDITS_MSG1:");
		}
		Controler_Main::getInstance()->refreshMessageIcon(); // den Header aktualisieren das man gleich sieht das man ne nachricht bekommen hat	
	}
}


?>