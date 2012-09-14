<?php

class QuoteFinder extends SystemFinder 
{


	
	protected function load($Result)
	{
		$Result=$Result[0];
		return new Quote($Result['i_Id'],$Result['t_Quote'],$Result['s_Autor']);
	}	
	
	/**
	 * gibt die bauauftrüge des planeten zurück
	 *
	 * @param array $RecordSet mit den daten aus der sb
	 * @return ShipBuildCollection 
	 *
	 */

	

	public function findOne()
	{
		$Sql="SELECT i_Id,t_Quote,s_Autor 
FROM tbl_quote
ORDER BY RAND( ) 
LIMIT 1";
		return $this->load($this->executeQuery($Sql));
	}
	


	


	
}



?>