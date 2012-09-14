<?php

class Skill extends ParseAbleObject implements i_CollectionElement 
{
	private $i_Id;
	private $s_Name; 
	private $t_Description;
	private $i_CoolDown; 
	private $i_CoolDownAction; 
	private $i_NeededLevel; 
	private $i_Type;
	private $UserLevel;

	
	
	
	public function __construct($Id,$Name,$Description,$CoolDown,$CoolDownAction,$NeededLevel,$Type)
	{
		$this->i_Id=$Id;
		$this->s_Name=$Name;
		$this->t_Description=$Description;
		$this->i_CoolDown=$CoolDown;
		$this->i_CoolDownAction=$CoolDownAction;
		$this->i_NeededLevel=$NeededLevel;
		$this->i_Type=$Type;
		$this->UserLevel=0;
		
	}

	public function setUserLevel($UserLevel)
	{
		$this->UserLevel=$UserLevel;	
	}
	
	
	/**
	 * prüft ob der Skill gemacht werden darf
	 *
	 * @return bool wenn es zeittechnisch gemacht werden darf dann kommt ein true
	 *
	 */
	public function canDo()
	{
		if($this->i_CoolDownAction<=time() && $this->UserLevel>=$this->i_NeededLevel)
		{
			return true;	
		}
		return false;
	}
	
	public function getHTML()
	{
		$HTML="<tr>
	 			<td width='80%' colspan='2'  class='header'>".$this->getName()."</td>
			</tr>";

		$HTML.= "<tr>
	 			<td width='80%'>".$this->getDescription()." </td>  ";
		if($this->canDo())
		{
			$HTML.="<td rowspan='2' align='center' ><a href='index.php?Section=Skill&amp;Action=DoSkill&amp;SkillId=".$this->getId()."'>Aktivieren</a></td>";
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
	
	
	/**
	 * gibt die zeit zuück bis der CD abgelaufen ist
	 *
	 * @return int 
	 *
	 */
	public function getNextCoolDownTime()
	{
		return time()+$this->i_CoolDown;
	}
					   
	/**
	 * gibt den Cooldown des Aktivierten skills zurück
	 *
	 * @return int 
	 *
	 */
	public function getCoolDownAction()
	{
		return $this->i_CoolDownAction ;
	}
	
	public function setCoolDownAction($CoolDownAction)
	{
		$this->i_CoolDownAction= $CoolDownAction;
	}
	
	
	public function getCoolDown()
	{
		return $this->i_CoolDown;
	}

	/**
	 * gibt die Type Id zurück
	 *
	 * @return int 
	 *
	 */
	public function getType()
	{
		return $this->i_Type ;
	}	
	
	public function setType($Type)
	{
		$this->i_Type= $Type;
	}
	
	
	public function getNeededLevel()
	{
		return $this->i_NeededLevel;
	}
	
	public static function getEmptyInstance()
	{
		return new Skill(0,"","","","",0,0);
	}
	
	public function getCountDown($BuildTime=false)
	{
		
		if($this->UserLevel<$this->i_NeededLevel)
		{
			return ":T_SKILL_AVAIL1: ".$this->i_NeededLevel." :T_SKILL_AVAIL2:";	
		}
		if($BuildTime)
		{
			return Date::dateFormat($this->i_CoolDown);
		}
		$TempDate= Date::dateFormat($this->i_CoolDownAction-time());
		$Split=explode(":",$TempDate);
		return '
		<div id="CountDownId'.$this->getId().'">'.$TempDate.'</div>
		<script type="text/javascript">
		var MyCountDown'.$this->getId().'= new CountDown('.$Split[0].','.$Split[1].','.$Split[2].',"CountDownId'.$this->getId().'","MyCountDown'.$this->getId().'");
		MyCountDown'.$this->getId().'.start();
		</script>';
	}

	public function getDescription()
	{
		return $this->parseAll($this->t_Description);
	}
	

	public function getId()
	{
		return $this->i_Id ;
	}
	public function getName()
	{
		return $this->s_Name;
	}
	
	
	/**
	 * führt die Fähigkeit aus
	 *
	 * @return void 
	 *
	 */
	public function doSkill()
	{
		return true;	
	}
	
	
	
	
	
	
}



?>