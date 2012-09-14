<?php


class diagramm
{
	const underTen=2;
	const overTen=10;
	const overFiften=50;
	
	
	public function createDiagramm($head,$foot,$Input)
	{	
		if(!isset($head)|| empty($head))
		{
			$head="default";
		}
		if(!isset($foot)|| empty($foot))
		{
			$foot="default";
		}
		if(!isset($Input)|| empty($Input))
		{
			$Input="default";
		}
		
		// maximal wert bekommen
		$TempMaxWert=0;
		$TempCount=count($Input);
		foreach ($Input as $Value)
		{
			$TempInsgesamt+=$Value[Hit];
			if($TempMaxWert<$Value[Hit])
			{
			$TempMaxWert=$Value[Hit];
			}
			
		}
		$tempAnzeigenBerechner=0;
		if($TempMaxWert<10)
		{
			$tempAnzeigenBerechner=diagramm::underTen;
		}
		if($TempMaxWert>10)
		{
			$tempAnzeigenBerechner=diagramm::overTen ;
		}
		if($TempMaxWert>50)
		{
			$tempAnzeigenBerechner=diagramm::overFiften;
		}
		
		while($TempMaxWert%$tempAnzeigenBerechner!==0)
		{
			$TempMaxWert++;	
		}
		
		
		
		Header("Content-Type: image/png");
		# Hier wird der Header gesendet, der später die Bilder "rendert" ausser png kann auch jpeg dastehen

		##################################################
		$width = 900; // Später die Breite des Rechtecks
		$height =300; // Später die Höhe des Rechtecks
		$img = ImageCreate($width, $height); # Hier wird das Bild einer Variable zu gewiesen
		$DiagrammBreite=500;
		##################################################


		##################################################
		$background = ImageColorAllocate($img, 66, 204, 255); # Hier wird der Variable $background also dem hintergund eine frabe zugewisen
		$white = ImageColorAllocate($img, 255, 255, 255); # Hier wird der Variable $white die Farbe weiß zugewiesen
		$line = ImageColorAllocate($img, 0, 0, 0); # Hier wird der Variable $line also dlinien farbe zugewiessen
		$Balken = ImageColorAllocate($img, 255, 0, 0); # Hier wird der Variable $line also dlinien farbe zugewiessen
		# Die drei nullen bestehen aus den RGB-Parametern. 255, 0, 0 wäre z.B. rot. ($img muss am Anfang stehen)
		##################################################


		##################################################
		ImageFill($img, 0, 0, $background); # Hier wird mit ImageFill() das Bild gefüllt an den Koordinaten 0 und 0 mit der Variable $background, also dem zuvor definierten
		ImageString($img, 2, 10, 10, $head, $white);
		ImageString($img, 2, 780, 280, $foot, $white);
		ImageString($img, 2, 10, 25, "Hit's", $white); // anzeige hits auf dem bild
		ImageString($img, 2, 20, 35, $TempMaxWert, $white); // anzeige maxilam wert imma links oben
		ImageLine($img, 45, 42.5, 550, 42.5, $white); // maxilam linie
		//*************** die 10
		ImageString($img, 2, 20, 57.5, $TempMaxWert-($TempMaxWert/10), $white); // anzeige maxilam wert imma links an der gleichen stelle
		ImageLine($img, 45, 63.25, 550, 63.25, $white); // maxilam linie
		//***********
		
		//*************** die 9
		ImageString($img, 2, 20, 77, $TempMaxWert-($TempMaxWert/10)*2, $white); // anzeige maximal wert imma links an der gleichen stelle
		ImageLine($img, 45, 84, 550, 84, $white); // maxilam linie
		//***********
		
		//*************** die 8
		ImageString($img, 2, 20, 97.5, $TempMaxWert-($TempMaxWert/10)*3, $white); // anzeige maximal wert imma links an der gleichen stelle
		ImageLine($img, 45, 104.75, 550, 104.75, $white); // maxilam linie
		//***********
		
		//*************** die 7
		ImageString($img, 2, 20, 118, $TempMaxWert-($TempMaxWert/10)*4, $white); // anzeige maximal wert imma links an der gleichen stelle
		ImageLine($img, 45, 125.5, 550, 125.5, $white); // maxilam linie
		//***********
		
		
		//*************** die 6
		ImageString($img, 2, 20, 139.5, $TempMaxWert-($TempMaxWert/10)*5, $white); // anzeige maximal wert imma links an der gleichen stelle
		ImageLine($img, 45, 146.25, 550, 146.25, $white); // maxilam linie
		//***********
		
		//*************** die 5
		ImageString($img, 2, 20, 160, $TempMaxWert-($TempMaxWert/10)*6, $white); // anzeige maximal wert imma links an der gleichen stelle
		ImageLine($img, 45, 167, 550, 167, $white); // maxilam linie
		//***********
		
		//*************** die 4
		ImageString($img, 2, 20, 180, $TempMaxWert-($TempMaxWert/10)*7, $white); // anzeige maximal wert imma links an der gleichen stelle
		ImageLine($img, 45, 187.75, 550, 187.75, $white); // maxilam linie
		//***********
		
		//*************** die 3
		ImageString($img, 2, 20, 201, $TempMaxWert-($TempMaxWert/10)*8, $white); // anzeige maximal wert imma links an der gleichen stelle
		ImageLine($img, 45, 208.5, 550, 208.5, $white); // maxilam linie
		//***********
		//*************** die 2
		ImageString($img, 2, 20, 222, $TempMaxWert-($TempMaxWert/10)*9, $white); // anzeige maximal wert imma links an der gleichen stelle
		ImageLine($img, 45, 229.25, 550, 229.25, $white); // maxilam linie
		//***********
		
		//*************** die 1
		ImageString($img, 2, 35, 242.5, "0", $white); // anzeige 0 wert imma links unten
		ImageLine($img, 45, 250, 550, 250, $white); // maxilam linie
		//***********
		
		// nun die antworten einfügen start *********************************************************
		$abstand=500/$TempCount; // der platz zwischen den antworten
		$aliasAntwortPlatzierungStartlinks=70;// von links nach rechts
		$aliasAntwortPlatzierungStartoben=258;// von links nach rechts
		$AntwortPlatzierungStartlink=600;// von links nach rechts
		$AntwortPlatzierungStartoben=35;// von links nach rechts
		$BalkenPlatzierunglinks=70;		// start positzionierung des balken
		
		$TempCnt=1;
		foreach ($Input as $Value) // balken länge berechnen
		{
			
			$tempHit=$Value[Hit];
			$tempName=$Value[Name];
			if($tempHit!=0)
			{
				$aktuellPorzentAnzeige=($tempHit*100)/$TempInsgesamt; // die prozente ausrechnen
				$aktuelleprozent=($tempHit*100)/$TempMaxWert;			// die prozentualle länge des balkens ausrechnen
				$aktuellepixel=$aktuelleprozent*2.075;					// mit den pixeln verrechnen
			}
			else 
			{
				
				$aktuellPorzentAnzeige=0;
				$aktuelleprozent=0;
				$aktuellepixel=1;
			}
			
		
			ImageString($img, 2, $AntwortPlatzierungStartlink, $AntwortPlatzierungStartoben, $TempCnt.". ".$tempHit." ".$tempName." ".number_format($aktuellPorzentAnzeige, 2)."% ", $white); // anzeige der antwort am rechten rand
			ImageString($img, 2, $aliasAntwortPlatzierungStartlinks, $aliasAntwortPlatzierungStartoben, $TempCnt.".", $white); // anzeige 0 wert imma links unten
			ImageFilledRectangle($img, $BalkenPlatzierunglinks, 250-$aktuellepixel, $BalkenPlatzierunglinks+20, 250, $Balken);  // recht eck zeichnen das angibt wie viele hit die antwort bekommen hat
			// Die 1. 0 ist die Entfernung in px von Links.
			// Die 2. 0 ist die Entfernung in px von Oben.
			// Die 300 ist die Breite der Farbe.
			// Die 100 ist die Höhe der Farbe. 
			$TempCnt++;
			$AntwortPlatzierungStartoben+=20;
			$aliasAntwortPlatzierungStartlinks+=$abstand;
			$BalkenPlatzierunglinks+=$abstand;
		}
		
		
		
		
		# Die 2 steht für die GD-Lib interne Schriftart (es gibt insgesamt 5, also probierts aus).
		# Die 10 steht für die Position von Links, also 26px von Links entfernt.
		# Die 10 steht für die Postion von Oben, also 20px von oben entfernt.
		# Der Text, ist der, der später im Bild erscheinen soll.
		# $white steht für die Farbe die der Text haben soll.
		###################################################
		ImageLine($img, 50, 250, 550, 250, $line); # Linie unten
		ImageLine($img, 50, 25, 50, 250, $line); # Linie vertikal da wo die werte drann stehen 
		#
		# Die 1 steht für den Abstand in px von links
		# Die 1. 125 steht für den Abstand in px von Oben vom linken Punkt der Strecke
		# Die 250 steht für den Abstand in px von rechts
		# Die 2. 125 steht für den Abstand in px von Oben vom rechten Punkt der Strecke
		#
		# !!! WICHTIG: Für geschtrichelte Lininen einfach den Befehl 'ImageDashedLine()' benutzen
		# Die Parameter sind gleich wie bei 'ImageLine' !!!
		#
		#
		################################################## 
		
		ImagePNG($img); # Hier wird das Bild PNG zugewiesen
		ImageDestroy($img); # Hier wird der Speicherplatz für andere Sachen geereinigt
		return true;
	}
}


?>