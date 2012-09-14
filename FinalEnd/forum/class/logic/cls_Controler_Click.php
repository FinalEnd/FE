<?php

/**
 * class cls_Controler_Click
 *
 * Description for class cls_Controler_Click
 *
 * @author:
*/
class Controler_Click  
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
		
		$TempLate= Template::getInstance("tpl_Counter.php");
		$ClickFinder= new ClickFinder();
		
		
		
		
		// tage Adden
		$TempLate->assign("Today",date("D"));
		$TempDate = mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"));
		$TempLate->assign("YesterDay",$this->getGermanDay(date("D",$TempDate)));
		$TempDate = mktime(0, 0, 0, date("m")  , date("d")-2, date("Y"));
		$TempLate->assign("YesterDay1",$this->getGermanDay(date("D",$TempDate)));
		$TempDate = mktime(0, 0, 0, date("m")  , date("d")-3, date("Y"));
		$TempLate->assign("YesterDay2",$this->getGermanDay(date("D",$TempDate)));
		$TempDate = mktime(0, 0, 0, date("m")  , date("d")-4, date("Y"));
		$TempLate->assign("YesterDay3",$this->getGermanDay(date("D",$TempDate)));
		$TempDate = mktime(0, 0, 0, date("m")  , date("d")-5, date("Y"));
		$TempLate->assign("YesterDay4",$this->getGermanDay(date("D",$TempDate)));
		$TempDate = mktime(0, 0, 0, date("m")  , date("d")-6, date("Y"));
		$TempLate->assign("YesterDay5",$this->getGermanDay(date("D",$TempDate)));
		$TempDate = mktime(0, 0, 0, date("m")  , date("d")-7, date("Y"));
		
		$TempLate->assign("YesterDay6",$this->getGermanDay(date("D",$TempDate)));	
		
		$TempLate->assign("ToDayHit",$ClickFinder->findByHitsDay(0)->getCount());
		$TempLate->assign("YesterDayHit1",$ClickFinder->findByHitsDay(1)->getCount());
		$TempLate->assign("YesterDayHit2",$ClickFinder->findByHitsDay(2)->getCount());
		$TempLate->assign("YesterDayHit3",$ClickFinder->findByHitsDay(3)->getCount());
		$TempLate->assign("YesterDayHit4",$ClickFinder->findByHitsDay(4)->getCount());
		$TempLate->assign("YesterDayHit5",$ClickFinder->findByHitsDay(5)->getCount());
		$TempLate->assign("YesterDayHit6",$ClickFinder->findByHitsDay(6)->getCount());
	
		//var_dump($ClickFinder->findClicksByDay(0));
		
		$TempLate->assign("ToDayClick",$ClickFinder->findClicksByDay(0));
		$TempLate->assign("YesterDayClick1",$ClickFinder->findClicksByDay(1));
		$TempLate->assign("YesterDayClick2",$ClickFinder->findClicksByDay(2));
		$TempLate->assign("YesterDayClick3",$ClickFinder->findClicksByDay(3));
		$TempLate->assign("YesterDayClick4",$ClickFinder->findClicksByDay(4));
		$TempLate->assign("YesterDayClick5",$ClickFinder->findClicksByDay(5));
		$TempLate->assign("YesterDayClick6",$ClickFinder->findClicksByDay(6));
		
		
		
		
		$TempLate->render();
			
		
		
		
		
	}
	
	
	public function getGermanDay($Day)
	{
		switch($Day)
		{
			case "Mon":
			{
				return "Mo";
			}break;
			
			case "Tue":
			{
				return "Di";
			}break;
			
			case "Wed":
			{
				return "Mi";
			}break;
			
			case "Thu":
			{
				return "Do";
			}break;
			
			case "Fri":
			{
				return "Fr";
			}break;
			
			case "Sat":
			{
				return "Sa";
			}break;
			
			case "Sun":
			{
				return "So";
			}break;
			
			default:
				return $Day;
		}	
		
		
		
	}
	
	
	
}

?>