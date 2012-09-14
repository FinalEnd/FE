<?php



class ShipBuild
{
	private $Id;
	private $PlanetId;
	private $Ship;
	private $Count;
	private $StartTime;
	private $BuildTime;
	
	
	public function __construct($Id,$PlanetId,$Ship,$Count,$StartTime,$BuildTime)
	{
		$this->Id =$Id;
		 $this->PlanetId=$PlanetId;
		 $this->Ship=$Ship;
		 $this->Count=$Count;
		 $this->StartTime=$StartTime;
		 $this->BuildTime=$BuildTime;
	}
	
	
	public function getCountDown($BuildTime=false)
	{
		if($BuildTime)
		{
			return Date::dateFormat($this->getBuildTimeNextLevel()-microtime(true));
		}
		$TempDate= $this->getCountDownKomplete();
		$Split=explode(":",$TempDate);
		return '
		<div id="CountDownId'.$this->getId().'">'.$TempDate.'</div>
		<script type="text/javascript">
		var MyCountDown'.$this->getId().'= new CountDown('.$Split[0].','.$Split[1].','.$Split[2].',"CountDownId'.$this->getId().'","MyCountDown'.$this->getId().'");
		MyCountDown'.$this->getId().'.start();
		</script>';
	}
	
	
	
	public function getKomplettBuildTime()
	{
		return $this->BuildTime*$this->Count;		
	}
	
	public function getCountDownKomplete()
	{
		return Date::dateFormat(($this->StartTime+($this->BuildTime*$this->Count))-microtime(true));
	}
	
	public function getCountDownNextUnit()
	{
		return Date::dateFormat(($this->StartTime-microtime(true))%$this->BuildTime);
	}
	
	public function getBuildTime()
	{
		return $this->BuildTime;
	}
	
	public function getStartTime()
	{
		return $this->StartTime;
	}
	
	
	public function getCount()
	{
		return $this->Count;
	}
	
	public function getPlanetId()
	{
		return $this->PlanetId;
	}
	
	/**
	 * gibt das schiff zurück das gebaut werden soll
	 *
	 * @return Ship 
	 *
	 */
	public function getShip()
	{
		return $this->Ship;
	}
	
	public function getId()
	{
		return $this->Id;
	}	
}






?>