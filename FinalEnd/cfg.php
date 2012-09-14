<?php
define("BAD_WORD","pisser,arschloch,wixxer,penner,idiot,remaker,hurensohn,homo");// komma getrennt bitte alle wörter aufschreiben die aus allen nachrichten gbook forum news geparst werden sollen, groß und kleinschreibung ist egal
define("SYSTEM_VERSION","1.0.1.21");// die Version des Systems
define("EMAIL_FILTER","ikaswewrewd.co.tv,akifas-ukas.uni.cc,bobihal-xols.uni.cc");

// Datenbank Connection 

define("DB_SERVER","127.0.0.1");	// die adresse des Mysql server
define("DB_DATABASE","FINALEND");		// die datenbank die ausgewählt werden soll	
define("DB_USER","FINEND");			// der User Mit dem sich das system einloggen soll
define("DB_PASS","5sdf651bs616sd51fvd");				// Das Passwort für den server


// spiel einstellungen



define("CREDITS_PER_LEVEL","10000"); // gibt an wieveile credits ein user pro level haben darf (lv. 1 =5000, lv. 2 = 10000, ....)
define("RESOURCE_PER_LEVEL","3000");// wenn kein lager gebaut wurden ist dann sind dies die maximalen resourcen die zur verfügung stehen sollen


define(TRADE_TAX,"0.05");// die gebühr die beim handel mit den Handelszentrum zun bezahlen ist   jetzt 5%


define(MAX_UNITS_PER_PLANET,3);// die maximale anzahl der flotten pro planet
define(MAX_UNITS_PER_CC,2);// die maximale anzahl der flotten pro level des Kommunications zentrums
?>