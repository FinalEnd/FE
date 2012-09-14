<?php
class PlanetSystem
{
	private $PlanetCollection;
	private $X;
	private $Y;
	private $User;	
	
	/**
	 * @var MapObjectCollection 
	 *
	 */
	private $SunCollection;

	public function __construct() 
	{
		$this->PlanetCollection= new PlanetCollection();
		$this->SunCollection= new MapObjectCollection();
	}
	
	
	
	/**
	 * erzeugt ein neues sonnen system
	 *
	 * @param int $X wo soll das zentrum des systems platziert werden
	 * @param int $Y wo soll das zentrum des systems platziert werden
	 * @param User $User wenn ein User angegeben wurde bekommt dieser einen Planeten system
	 * @return void 
	 *
	 */
	public function generateSystem($X,$Y,User $User=null)
	{// mehr stern systeme
		$this->X=$X;
		$this->Y=$Y;
		$this->User=$User;
		$this->addSuns();
		$this->addPlanets();
		
		// füge planeten hinzu
	}
	
	
	/**
	 * fügt zu dem sonnen system sonnen hinzu :)
	 *
	 * @return void 
	 *
	 */
	private function addSuns()
	{
		
		$SunSystemType=mt_rand(0,100);
		
		$SunSystemNames= new SunSystemNames();
		$SunNameArray= $SunSystemNames->getNameArray();
		$MaxSUnSystemNames=count($SunNameArray)-1;
		$SunName=$SunNameArray[mt_rand(0,$MaxSUnSystemNames)];
		if($SunSystemType<=80)// eine sonne
		{	
			$this->SunCollection->add(new Sun(0,$SunName,'sun'.mt_rand(1,3).'.png',$this->X,$this->Y,600));
		}
		if($SunSystemType>80 && $SunSystemType<99 )// zwei sonne
		{
			$Alpha = mt_rand(1,360);
			$Range=mt_rand(300,600);
			$X1=$Range*cos($Alpha);
			$Y1=$Range*sin($Alpha);
			$X2=$X1*-1;
			$Y2=$Y1*-1;
			
			$X1+=$this->X;
			$Y1+=$this->Y;
			$X2=$this->X+$X2;
			$Y2=$this->Y+$Y2;
			
			$this->SunCollection->add(new Sun(0,$SunName,'sun'.mt_rand(1,3).'.png',$X1,$Y1,600));
			$this->SunCollection->add(new Sun(0,$SunName,'sun'.mt_rand(1,3).'.png',$X2,$Y2,600));
		}
		if($SunSystemType>=99 )// zwei sonne
		{
			$Alpha = mt_rand(45,120);
			$Range=mt_rand(300,600);
			$X1=$Range*cos($Alpha);
			$Y1=$Range*sin($Alpha);
			$X2=$Range*cos($Alpha*120);
			$Y2=$Range*sin($Alpha*120);		
			$X3=$Range*cos($Alpha*240);
			$Y3=$Range*sin($Alpha*240);		
			$this->SunCollection->add(new Sun(0,$SunName,'sun'.mt_rand(1,3).'.png',$X1,$Y1,600));
			$this->SunCollection->add(new Sun(0,$SunName,'sun'.mt_rand(1,3).'.png',$X2,$Y2,600));
			$this->SunCollection->add(new Sun(0,$SunName,'sun'.mt_rand(1,3).'.png',$X3,$Y3,600));
		}
	}
	
	private function addPlanets()
	{
		$PlanetCount=mt_rand(10,30);
		$PlanetStartRange=mt_rand(1000,1270);
		$NewPlanetRange=170;
		$Alpha = mt_rand(1,359);
		if($this->User && $this->User->getId())
		{
			$UserIsSet=false;
		}else
		{
			$UserIsSet=true;
		}
		for ($i=1;$i<=$PlanetCount;$i++)
		{
			$Range=$PlanetStartRange+$NewPlanetRange*$i;
			$Alpha+= mt_rand(1,40);
			$X1=(int)$Range*cos($Alpha)+$this->X;
			$Y1=(int)$Range*sin($Alpha)+$this->Y;
			$SetUserNow=mt_rand(0,5);
			$Planet=new Planet(0,"Unbekannt",User::getEmptyInstance(),0,0,1,"Planet".mt_rand(1,78).".png",0,PLANET_START_METALL,PLANET_START_HYDROGEN,PLANET_START_BIOMASS,PLANET_START_CRISTAL,0,0,new BuildingCollection(),new ShipCollection(),new ReSearchCollection(),PLANET_START_PEOPLE,0,0);
			$Planet->setX($X1);
			$Planet->setY($Y1);
			if(!$UserIsSet && $SetUserNow==5 || !$UserIsSet && $i==$PlanetCount-1)
			{
				$Planet->setUser($this->User);
				$UserIsSet=true;
			}	
			$Size= mt_rand(200,9999);// durchmesser
			$Weight= mt_rand(200,9999)." *10 <sup>".mt_rand(2,50)."</sup>";
			$Planet->setSize($Size);
			$Planet->setWeight($Weight);
			$this->PlanetCollection->add($Planet);
		}
	}	
	
	
	public  function getSunCollection()
	{
		return $this->SunCollection;
	}
	
	public  function getPlanetCollection()
	{
		return $this->PlanetCollection;
	}
	
}


?>