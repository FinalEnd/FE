<?php

class PlanetManager extends SystemManager 
{

	public function insertPlanet(Planet $Planet)
	{
		$Sql="INSERT INTO `tbl_planet` (
		`i_Id` ,
		`s_Name` ,
		`i_UserId` ,
		`i_Size` ,
		`s_Weight` ,
		`i_Type` ,
		`s_Picture` ,
		`i_RefreshTime` ,
		`i_Metal` ,
		`i_Hydrogen` ,
		`i_Biomass` ,
		`i_Crystal` ,
		`i_X`,
		`i_Y`,i_PeopleCount,f_Satisfaction,f_Tax
		)
		VALUES (
		NULL , '".$Planet->getName()."',
		 '".$Planet->getUser()->getId()."',
		 '".$Planet->getSize()."',
		 '".$Planet->getWeight()."',
		 '".$Planet->getType()."',
		 '".$Planet->getPicture()."',
		 '".microtime(true)."',
		 '".$Planet->getMetal()."',
		 '".$Planet->getHydrogen()."',
		 '".$Planet->getBiomass()."',
		 '".$Planet->getCrystal()."',
		 '".$Planet->getX()."',
		 '".$Planet->getY()."',
		500,1,0.5
		)";
		return $this->MySql->executeNoneQuery($Sql);
	}


	public function setUserToPlanet(Planet $Planet,User $User)
	{
		$Sql="UPDATE `tbl_planet` SET `i_UserId` = ".$User->getId()." WHERE `tbl_planet`.`i_Id` =".$Planet->getId();
		return $this->baseNoneGuery($Sql);
	}



	/**
		 * addes neue People das auch negadit sein darf zum planeten hinzu
		 *
		 * @param Planet $Planet 
		 * @param float $NewMetal das metall das addiert werden soll
		 * @return bool 
		 *
		 */
	public function updatePeople(Planet $Planet,$NewPeople)
	{
		$Sql="UPDATE `tbl_planet` SET 
		`i_PeopleCount` = `i_PeopleCount`+".$NewPeople."
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ;";
		$this->executeNonQuery($Sql);
		$Sql="update tbl_planet set 
			i_PeopleCount =IF(`i_PeopleCount`<0,0,`i_PeopleCount`)
			where i_Id=".$Planet->getId()." LIMIT 1 ";
		return $this->baseNoneGuery($Sql);
	}



	public function inserPlanetSystem(PlanetSystem $PlanetSystem)
	{
		// planeten eintragen
		foreach($PlanetSystem->getPlanetCollection() as $Planet)
		{
			$this->insertPlanet($Planet);
		}
		$MapobjectManager= new MapObjectManager();
		foreach($PlanetSystem->getSunCollection() as $Sun)
		{
			$MapobjectManager->insertMapObject($Sun);
		}
		
	}


	/**
	 * addes neues metal das auch negadit sein darf zum planeten hinzu
	 *
	 * @param Planet $Planet 
	 * @param float $NewMetal das metall das addiert werden soll
	 * @return bool 
	 *
	 */
	public function updateMetal(Planet $Planet,$NewMetal)
	{
		$Sql="UPDATE `tbl_planet` SET 
		`i_Metal` = `i_Metal`+".$NewMetal."
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ";
		return $this->baseNoneGuery($Sql);
	}


	/**
	 * addes neues metal das auch negativ sein darf zum planeten hinzu
	 *
	 * @param Planet $Planet This is a description
	 * @param mixed $NewBioMass  das Biomass das addiert werden soll
	 * @return bool 
	 *
	 */
	public function updateBioMass(Planet $Planet,$NewBioMass)
	{
		$Sql="UPDATE `tbl_planet` SET 
		`i_Biomass` = `i_Biomass`+".$NewBioMass."
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ";
		$this->baseNoneGuery($Sql);// nahrungs mittel updaten
		$Sql="update tbl_planet set 
			i_Biomass =IF(`i_Biomass`<0,0,`i_Biomass`)
			where i_Id=".$Planet->getId()." LIMIT 1 ";
		$this->baseNoneGuery($Sql);
	}


	/**
	 * addes neues metal das auch negativ sein darf zum planeten hinzu
	 *
	 * @param Planet $Planet This is a description
	 * @param mixed $NewCrystal das Crystal das addiert werden soll
	 * @return bool 	 
	 * 
	 */
	public function updateCrystal(Planet $Planet,$NewCrystal)
	{
		$Sql="UPDATE `tbl_planet` SET 
		`i_Crystal` = `i_Crystal`+".$NewCrystal."
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ";
		return $this->baseNoneGuery($Sql);
	}

	/**
	 * addes neues Hydrogen das auch negativ sein darf zum planeten hinzu
	 *
	 * @param Planet $Planet This is a description
	 * @param mixed $$NewHydrogen das Hydrogen das addiert werden soll
	 * @return bool 	 
	 * 
	 */
	public function updateHydrogen(Planet $Planet,$NewHydrogen)
	{
		$Sql="UPDATE `tbl_planet` SET 
		`i_Hydrogen` = `i_Hydrogen`+".$NewHydrogen."
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ";
		return $this->baseNoneGuery($Sql);
	}


	/**
	 * diese fkt !!! NICHT !!! benutzen das eventuelle veränderungen wärend der skriptlaufzeit verworfen werden
	 *
	 * @param Planet $Planet 
	 * @return bool 
	 *
	 */
	public function updateResources(Planet $Planet)
	{
		$Sql="UPDATE `tbl_planet` SET `i_Metal` = '".$Planet->getMetal()."',
		`i_Hydrogen` = '".$Planet->getHydrogen()."',
		`i_Biomass` = '".$Planet->getBiomass()."',
		`i_Crystal` = '".$Planet->getCrystal()."',
		`i_RefreshTime` = '".$Planet->getRefreshTime()."'
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ";
		//var_dump($Sql);
		return $this->baseNoneGuery($Sql);
	}
	
	/**
	 * setzt die aktuelle berechnungs zeit des Planeten	
	 * 
	*/
	public function updateRefeshTime(Planet $Planet)
	{
		$Sql="UPDATE `tbl_planet` SET 
		`i_RefreshTime` = '".microtime(true)."'
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ;";
		return $this->baseNoneGuery($Sql);
		
	}
	
	public function setMaxRessourceMetal($StorePerStoreLevel)
	{
		$Sql="update tbl_planet
				set 
				i_Metal=(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel.",
				i_RefreshTime=now()
				where
				i_Metal>(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel;
		return $this->baseNoneGuery($Sql);
	}
	
	public function setMaxRessourceHydrogen($StorePerStoreLevel)
	{
		$Sql="update tbl_planet
				set 
				i_Hydrogen=(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel.",
				i_RefreshTime=now()
				where
				i_Hydrogen>(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel;
		return $this->baseNoneGuery($Sql);
	}
	
	public function setMaxRessourceCrystal($StorePerStoreLevel)
	{
		$Sql="update tbl_planet
				set 
				i_Crystal=(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel.",
				i_RefreshTime=now()
				where
				i_Crystal>(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel;
		return $this->baseNoneGuery($Sql);
	}	
	
	public function setMaxRessourceBiomass($StorePerStoreLevel)
	{
		$Sql="update tbl_planet
				set 
				i_Biomass=(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel.",
				i_RefreshTime=now()
				where
				i_Biomass>(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel;
		return $this->baseNoneGuery($Sql);
	}
	
	public function setMaxPeopleByUser(User $User)
	{
		$Sql="update tbl_planet 
		set i_PeopleCount=0
		where i_PeopleCount<0";
		$this->baseNoneGuery($Sql);
		
		$Sql="update tbl_planet 
		set i_PeopleCount=".PEOPLE_MAX_STORE_PRE." * pow(".PEOPLE_MAX_STORE_SUF.",(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =22
				))
		where i_PeopleCount>".PEOPLE_MAX_STORE_PRE." * pow(".PEOPLE_MAX_STORE_SUF.",(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =22
				))
				and i_UserId=".$User->getId();
		return $this->baseNoneGuery($Sql);
		
		
	}
	
	
	public function setMaxRessouces($StorePerStoreLevel)
	{
		$this->setMaxRessourceBiomass($StorePerStoreLevel);
		$this->setMaxRessourceCrystal($StorePerStoreLevel);
		$this->setMaxRessourceHydrogen($StorePerStoreLevel);
		$this->setMaxRessourceMetal($StorePerStoreLevel);
	}
	
	/**
	 * berechnet die maximalen lagerbestände und entfernt überschüssige rohstoffe
	 *
	 * @param int $StorePerStoreLevel wieviel pro lager limit darf gespeichert werden
	 * @return int die aktualisierten planeten
	 *
	 */
	public function setMaxRessoucesByUser($StorePerStoreLevel,$User)
	{
		$this->setMaxRessourceBiomassByUser($StorePerStoreLevel,$User);
		$this->setMaxRessourceCrystalByUser($StorePerStoreLevel,$User);
		$this->setMaxRessourceHydrogenByUser($StorePerStoreLevel,$User);
		$this->setMaxRessourceMetalByUser($StorePerStoreLevel,$User);
		$this->setMaxPeopleByUser($User);
	}
	
	public function setMaxRessourceMetalByUser($StorePerStoreLevel,$User)
	{
		$Sql="update tbl_planet
				set 
				i_Metal=(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel.",
				i_RefreshTime=now()
				where
				i_Metal>(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel."
				and i_UserId=".$User->getId();
		return $this->baseNoneGuery($Sql);
	}
	
	
	public function setMaxRessourceHydrogenByUser($StorePerStoreLevel,$User)
	{
		$Sql="update tbl_planet
				set 
				i_Hydrogen=(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel.",
				i_RefreshTime=now()
				where
				i_Hydrogen>(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel."
				and i_UserId=".$User->getId();
		return $this->baseNoneGuery($Sql);
	}
	

	
	
	public function setMaxRessourceCrystalByUser($StorePerStoreLevel,$User)
	{
		$Sql="update tbl_planet
				set 
				i_Crystal=(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel.",
				i_RefreshTime=now()
				where
				i_Crystal>(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel."
				and i_UserId=".$User->getId();
		return $this->baseNoneGuery($Sql);
	}
	
	
	public function setMaxRessourceBiomassByUser($StorePerStoreLevel,$User)
	{
		$Sql="update tbl_planet
				set 
				i_Biomass=(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel.",
				i_RefreshTime=now()
				where
				i_Biomass>(SELECT i_Level
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =18
				) *".$StorePerStoreLevel."
				and i_UserId=".$User->getId();
		$this->baseNoneGuery($Sql);
		
		$Sql="update tbl_planet
				set 
				i_Biomass= 0
				where
				i_Biomass< 0
				and i_UserId=".$User->getId();
		return $this->baseNoneGuery($Sql);
		
		
	}
		
	public function calculateBiomass()
	{
		$Sql="update tbl_planet
				set 
				i_Biomass=i_Biomass+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=4) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =4
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60,
				i_RefreshTime=now()";	
		return $this->baseNoneGuery($Sql);
	}
	
	
	public function calculateMetal()
	{
		$Sql="update tbl_planet
				set 
								i_Metal=i_Metal+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=2) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =2
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60,
				i_RefreshTime=now()";	
		return $this->baseNoneGuery($Sql);
	}
	
	
	public function calculateCristal()
	{
		$Sql="update tbl_planet
				set 
				i_Crystal=i_Crystal+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=5) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =5
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60,
				i_RefreshTime=now()";	
		return $this->baseNoneGuery($Sql);
	}
	
	public function calculateResourceAllPlanets()
	{
		$Sql="update tbl_planet
set 
i_Hydrogen=i_Hydrogen+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=8) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =8
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60,
				i_Crystal=i_Crystal+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=5) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =5
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60,
				i_Metal=i_Metal+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=2) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =2
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60,
				
		i_Biomass=(i_Biomass+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=4) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =4
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60)- (( now( ) - tbl_planet.i_RefreshTime ) /60 /60) * (805 * log(if(tbl_planet.i_PeopleCount<=5000,5000,tbl_planet.i_PeopleCount)/2253)/log(1.73)-555)
		,
		i_PeopleCount = If (tbl_planet.i_Biomass > 0 , 
		 i_PeopleCount + 100 * pow(1.73,(select i_Level from tbl_planetbuildings where i_BiuldId=22 and tbl_planetbuildings.i_PlanetId=tbl_planet.i_Id))
		*( now( ) - tbl_planet.i_RefreshTime ) /60 /60  
		,
		 i_PeopleCount - 100 * pow(1.73,(select i_Level from tbl_planetbuildings where i_BiuldId=22 and tbl_planetbuildings.i_PlanetId=tbl_planet.i_Id))
		*( now( ) - tbl_planet.i_RefreshTime ) /60 /60 *2  
		),
		i_RefreshTime=now()
		where i_RefreshTime!=now()";	
		 $this->baseNoneGuery($Sql);
		return $this->setMaxRessouces(RESOURCE_PER_LEVEL);
	}

	/**
	 * berechnet die ressourcen aller Planeten
	 *
	 * @return void 
	 *
	 */
	public function calculateResource()
	{
		$this->calculateResourceAllPlanets();
		$this->setMaxRessouces(RESOURCE_PER_LEVEL);
	}	

	
	public function calculateResourceByUser(User $User)
	{
		$Sql="update tbl_planet
set 
i_Hydrogen=i_Hydrogen+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=8) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =8
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60,
				i_Crystal=i_Crystal+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=5) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =5
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60,
				i_Metal=i_Metal+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=2) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =2
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60,
i_Biomass=(i_Biomass+(SELECT i_Level*
				(select f_Multiplicator from tbl_buildings where i_Id=4) 
				FROM tbl_planetbuildings
				WHERE i_PlanetId = tbl_planet.i_Id
				AND i_BiuldId =4
				) * ( now( ) - tbl_planet.i_RefreshTime ) /60 /60)- (( now( ) - tbl_planet.i_RefreshTime ) /60 /60) * (805 * log(if(tbl_planet.i_PeopleCount<=5000,5000,tbl_planet.i_PeopleCount)/2253)/log(1.73)-555)
,
i_PeopleCount = If (tbl_planet.i_Biomass > 0 , 
 i_PeopleCount + 100 * pow(1.73,(select i_Level from tbl_planetbuildings where i_BiuldId=22 and tbl_planetbuildings.i_PlanetId=tbl_planet.i_Id))
*( now( ) - tbl_planet.i_RefreshTime ) /60 /60  
,
 i_PeopleCount - 100 * pow(1.73,(select i_Level from tbl_planetbuildings where i_BiuldId=22 and tbl_planetbuildings.i_PlanetId=tbl_planet.i_Id))
*( now( ) - tbl_planet.i_RefreshTime ) /60 /60 *2*-1  
),
i_RefreshTime=now()
where i_RefreshTime!=now()
and i_UserId=".$User->getId();				
		$this->baseNoneGuery($Sql);
		$this->setMaxRessoucesByUser(RESOURCE_PER_LEVEL,$User);
	}	
	
	
	
	
	
	
	
	
	
	/**
	 * updatet die Planeten ressourcen 
	 *
	 * @param Planet $Planet 
	 * @param itn $Count die menge die Upgedatet werdensoll
	 * @param string $RessourceType m= metall; t=deuterium, b= Lebbensmittel; c= Kristall
	 * @return bool This is the return value description
	 *
	 */
	public function addRessource(Planet $Planet,$Count,$RessourceType)
	{
		switch($RessourceType)
		{
			case"m":
			{
				return $this->addMetal($Planet,$Count);
			}break;	
			case"t":
			{
				return $this->addHydrogen($Planet,$Count);
			}break;
			case"c":
			{
				return $this->addCristal($Planet,$Count);
			}break;
			case"b":
			{
				return $this->addBioMass($Planet,$Count);
			}break;
		}
		
		
	}
	
	
	public function addHydrogen(Planet $Planet,$Count)
	{
		$Planet->setHydrogen($Planet->getHydrogen()+$Count);
		$this->updateResources($Planet);
	}
	
	public function addCristal(Planet $Planet,$Count)
	{
		$Planet->setCrystal($Planet->getCrystal()+$Count);
		$this->updateResources($Planet);
	}
	
	
	public function addBioMass(Planet $Planet,$Count)
	{
		$Planet->setBiomass($Planet->getBiomass()+$Count);
		$this->updateResources($Planet);
	}
	
	
	
	/**
	 * fügt die angegebene anzahl dem planeten hinzu
	 *
	 * @param Planet $Planet This is a description
	 * @param itn $count das metall das dem Planeten gutgeschrieben werden soll
	 * @return bool 
	 *
	 */
	public function addMetal(Planet $Planet,$Count)
	{
		$Planet->setMetal($Planet->getMetal()+$Count);
		$this->updateResources($Planet);
	}
	
	
	
	public function updateName(Planet $Planet)
	{
		$Sql="UPDATE `tbl_planet` SET 
		`s_Name` = '".$Planet->getName()."'
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ;";
		//var_dump($Sql);
		return $this->baseNoneGuery($Sql);
		
	}
	
	/**
	 * setzten den besitzer den Planeten neu
	 *
	 * @param Planet $Planet 
	 * @param User $NewUser 
	 * @return bool 
	 *
	 */
	public function updateOwner(Planet $Planet,User $NewUser)
	{
		$Sql="UPDATE `tbl_planet` SET `i_UserId` = '".$NewUser->getId()."' WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1";
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * setzt die zufriedenhait des planeten neu
	 *
	 * @param Planet $Planet 
	 * @return bool 
	 *
	 */
	public function updateSatisfaction(Planet $Planet)
	{
		$Sql="UPDATE `tbl_planet` SET 
		`f_Satisfaction` = '".$Planet->getSatisfaction()."'
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ;";
		return $this->executeNonQuery($Sql);
	}
	
	
	/**
	 * setzt die anzahl der einwohner des planeten neu
	 *
	 * @param Planet $Planet This is a description
	 * @return bool  
	 *
	 */
	public function updatePeopleCount(Planet $Planet)
	{
		$Sql="UPDATE `tbl_planet` SET 
		`i_PeopleCount` = '".$Planet->getPeopleCount()."'
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ;";
		return $this->executeNonQuery($Sql);
	}
	
	
	public function updateTax(Planet $Planet)
	{
		$Sql="UPDATE `tbl_planet` SET 
		`f_Tax` = '".$Planet->getTax()."'
		 WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1 ;";
		return $this->executeNonQuery($Sql);
	}
	
	public function delete(Planet $Planet)
	{
		$Sql="DELETE FROM `tbl_planet` WHERE `tbl_planet`.`i_Id` =".$Planet->getId()." LIMIT 1;";
		return $this->executeNonQuery($Sql);
	}
	
}



?>