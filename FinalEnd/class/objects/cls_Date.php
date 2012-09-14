<?php


class Date
{
		
	public static function dateFormat($Seconds)
	{
		$TempString="";
		
		$Minuts=$Seconds/60; // minuten ausrechnen
		$Hours=(int) ($Minuts/60);// stunden ausrechnen
		$RestMinuts=(int) ($Minuts-($Hours*60));
		$Seconds=$Seconds-(($RestMinuts*60)+($Hours*60*60));
		if(strlen($Hours)==1)
		{
			$Hours="0".$Hours;
		}
		if(strlen($RestMinuts)==1)
		{
			$RestMinuts="0".$RestMinuts;
		}
		if(strlen(((int)$Seconds))<=1)
		{
			$TempSeconds=(int) $Seconds;
			$Seconds="0".$TempSeconds;
		}else
		{
			$Seconds=(int) $Seconds;
		}
		return $Hours.":".$RestMinuts.":".$Seconds;
	}
	
}


?>