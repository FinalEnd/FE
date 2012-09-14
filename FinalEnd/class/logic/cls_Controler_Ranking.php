<?php

/**
 * class cls_Controler_Click
 *
 * Description for class cls_Controler_Click
 *
 * @author:
*/
class Controler_Ranking  
{

	/**
	 * cls_Controler_Click constructor
	 *
	 * @param 
	 */
	function __construct() {

	}
	
	
	public function start()
	{
		$Request= new Request();
		switch($Request->getAsString('Action'))
		{
			case "ShowRanking":
			{
				$this->showUserRanking();
			}break;
			case "ShowAllianzRanking":
			{
				$this->showAllianzRanking();
			}break;
			default:
				$this->showUserRanking();
		}	
	}
	
	public function showAllianzRanking()
	{
		$Request= new Request();
		$AllianzFinder= new AllianzFinder();
		$Count=10;
		$AllianzCollection= $AllianzFinder->findAllAllianzOrderByPlayerCount($Request->getAsInt("Start"),$Count);
		$PlayerCount=  $AllianzFinder->countAllAllianz();
		$TempLate=Template::getInstance("tpl_RankingAllianz.php"); 
		$TempLate->assign("AllianzCollection",$AllianzCollection);
		$TempLate->assign("PlayerCount",$PlayerCount);
		
		if($Request->getAsInt("Start")==0)
		{
			$TempLate->assign("CantBackWard",true);
		}
		
		if(($Request->getAsInt("Start")+$Count)>$PlayerCount)
		{
			$TempLate->assign("CantForWard",true);
		}
		
		$TempLate->assign("Start",$Request->getAsInt("Start"));
		$TempLate->assign("Count",$Count);
		$TempLate->render();
	}	
	
	
		
	public function showUserRanking()
	{
		
		$Request= new Request();
		$UserFinder= new UserFinder();
		$Count=50;
		$UserCollection= $UserFinder->findAllUserOrderByEXP($Request->getAsInt("Start"),$Count);
		$PlayerCount=  $UserFinder->findUserCount();
		$TempLate=Template::getInstance("tpl_Ranking.php"); 
		$TempLate->assign("UserCollection",$UserCollection);
		$TempLate->assign("PlayerCount",$PlayerCount);
		
		if($Request->getAsInt("Start")==0)
		{
			$TempLate->assign("CantBackWard",true);
		}
		
		if(($Request->getAsInt("Start")+$Count)>$PlayerCount)
		{
			$TempLate->assign("CantForWard",true);
		}
		
		$TempLate->assign("Start",$Request->getAsInt("Start"));
		$TempLate->assign("Count",$Count);
		$TempLate->render();
	}	
		


}

?>