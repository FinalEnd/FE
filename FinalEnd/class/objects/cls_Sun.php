<?php
class Sun extends MapObject 
{

	protected $Size; // die größe in durchmesser der sonne
	protected $Wight;// das gewicht der sonne
	
	public function __construct($Id,$Name,$PictureString,$X,$Y,$Width) 
	{
		parent::__construct($Id,$Name,3,$PictureString,$X,$Y,$Width,$Width,0);
		$this->Size=0;
		$this->Wight=0;
	}
	
	public static function getEmptyInstance()
	{
		return new Sun(0,0,0,"",0,0);
	}

	
}
?>