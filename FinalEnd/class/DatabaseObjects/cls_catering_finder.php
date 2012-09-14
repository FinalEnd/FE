<?php

class CateringFinder extends SystemFinder 
{
	
	/**
	 * This is method findAllFoodGroups
	 *
	 * @return mixed This is the return value description
	 *
	 */
	public function  findAllFoodGroups($WithEllements= false)
	{
		$Sql="SELECT Id,Name,Description FROM `cateringgroup`";
		$Result=$this->load($Sql);
		$TempFooGroups = null;
		if ($WithEllements==true)
		{
			// alle ellemente laden
			foreach($Result as $Group)
			{
				$MyTempGroup= new CateringCollection($Group['Id'],$Group['Name'],$Group['Description']);
				$MyTempGroup->addMany($this->findByGroupId($Group['Id']));
				$TempFooGroups[]=$MyTempGroup;
			}
		}else
		{
			// nur die Collection zurck geben
			if ($result)
			{
				foreach($result as $Group)
				{
					$TempFooGroups[]=new CateringCollection($Group['Id'],$Group['Name'],$Group['Description']);
				}
			}
		}
		return $TempFooGroups;
	}
	
	
	protected  function doLoad($Result)
	{
		return new Catering($Result['Name'],$Result['Preis'],$Result['Description'],$Result['Erweiterbar'],$Result['materials'],$Result['Id']);
	}
	
	
	/**
	 * sucht alle alle Catering objecte mit dieser Group id
	 *
	 * @param mixed $ID This is a description
	 * @return array vom Typ Catering
	 *
	 */
	public function findByGroupId($ID=0)
	{
		$command= "SELECT id as Id,Name as Name,Preis as Preis,Description ,Inhaltsstoffe as materials, Erweiterbar
				FROM `catering` 
				WHERE `cateringGroupId` =".$ID;
		$result=$this->load($command);
		//var_dump($command);
		if ($result)
		{
			foreach($result as $CateringObject)
			{
				$TempArray[]=$this->doLoad($CateringObject);
			}
		}
		return $TempArray;
		
	}
	
	
	/**
	 * läd alle objecte mit dieser ID
	 *
	 * @param int[] $IDArray 
	 * @return CateringCollection 
	 *
	 */
	public function findByIds($IDArray)
	{
		if(!is_array($IDArray)){return new CateringCollection();}	
		$TempIdString="";
		$MyCateringCollection= new CateringCollection();
		foreach($IDArray as $ID)
		{
			$TempIdString.=" or id =".$ID;
		}
		$command= "SELECT id as Id,Name as Name,Preis as Preis,Description ,Inhaltsstoffe as materials, Erweiterbar
				FROM catering 
				WHERE  id =0 ".$TempIdString;
		$result=$this->load($command);
		if ($result)
		{
			foreach($result as $FoodObject)
			{
				$MyCateringCollection->add($this->doLoad($FoodObject));
			}
		}
		return $MyCateringCollection;
	}
	
	
	
	
	
	
	/**
	 * läd ein element anhand der angegebenen ID 
	 *
	 * @param mixed $Id This is a description
	 * @return mixed This is the return value description
	 *
	 */
	public function findById($Id)
	{
		$command= "SELECT id as Id,Name as Name,Preis as Preis,Description ,Inhaltsstoffe as materials, Erweiterbar
				FROM catering 
				WHERE  id = ".$Id;
		$tempResult=$this->load($command);
		return $this->doload($tempResult[0]);
	}
	
	
	/**
	*	sucht alle angelegten gruppen aus der datenbank
	*
	*
	*	@return array mit dem namen aller gruppen
	*/ 
	public function findAllGroups()
	{
		$command= "SELECT Name FROM `cateringgroup`";
		return $this->load($command);
	}
	
	
	
	
	
	
}

?>