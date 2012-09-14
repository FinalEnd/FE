<?php

class NewsFinder extends SystemFinder 
{
	
	/**
	 * mappt die ergebnissmengeauf eine NewsCollection 
	 *
	 * @param array $RecordSet
	 * @return NewsCollection
	 */
	private function doLoad($RecordSet)
	{
		$NewsCollection = new NewsCollection();
		
		foreach ($RecordSet as $Row)
		{
			$NewsCollection->add(new News($Row['Id'],$Row['Content'],$Row['Date'],$Row['CreatorId']));
		}
		return $NewsCollection;
	}
	
	
	/**
	 * läd alle news die in der db vorhanden sind
	 *
	 * @return NewsCollection
	 */
	public function findAll()
	{
		$Sql="SELECT Id, Content, Date, CreatorId 
				FROM `news` ORDER BY `Id` DESC";

		return $this->doLoad($this->executeQuery($Sql));
		//return $this->doLoad($this->MySql->getResult());
	}
	
	
	
	
	
}



?>