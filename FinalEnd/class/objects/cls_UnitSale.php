<?php

class UnitSale extends Sale implements i_CollectionElement
{
	private $Unit;
	private $Creator;

	public function __construct($Id,User $Creator,$Price,$End,$InsertDate="",Unit $Unit)
	{
		parent::__construct($Id,$Creator,"SHIP_SALE",0,$Price,$End,0,$InsertDate);
		$this->Unit=$Unit;
	}

	public static function getEmptyInstance()
	{
		return new UnitSale(0,User::getEmptyInstance(),0,"","",Unit::getEmptyInstance());
	}
	
	public function getUnit()
	{
		return $this->Unit;
	} 
		
	public function getCreator()
	{
		return $this->Creator;
	} 

	
	
	
}

?>