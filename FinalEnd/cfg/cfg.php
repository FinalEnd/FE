<?php


define("BAD_WORD","pisser,arschloch,wixxer,penner,remaker,hurensohn,homo,kümmeltürke,verpissen,schwuchteln,hitler,penis,neger,pissnelke,schweineprister,bitch,assface,nigga,nigger,negger,retardet,idiot,sau,rindvieh,mistvieh");// komma getrennt bitte alle wörter aufschreiben die aus allen nachrichten und sonst wo geparst werden sollen, groß und kleinschreibung ist egal
define("SYSTEM_VERSION","1.0.2.178");// die Version des Systems
define("EMAIL_FILTER","ikaswewrewd.co.tv,akifas-ukas.uni.cc,bobihal-xols.uni.cc");


// spiel einstellungen

define(STATE_BAY_OFFLINE,10800);// die zeit in sekunden wie lange der nicht geraidet werden kann
define(STATE_JUMP_OFFLINE,18000);// die zeit in sekunden wie lange der nicht gesprungen werden kann
define(STATE_SCANNER_OFFLINE,3600);// die zeit in sekunden wie lange der nicht gescannt werden kann
define(STATE_EMP_OFFLINE,3600);
define(STATE_EMPED,3600);
define(STATE_WEAPONDAMAGE,3600);
define(STATE_HULLDAMAGE,3600);
define(STATE_OVERLOAD,3600);
define(STATE_SPEEDY,3600);
define(STATE_ARMOR,3600);
define(STATE_ENGINGEDAMAGETIME,3600);
define(STATE_SHIPSELLABLE,30000);
define(STATE_SHIELD_OFFLINE,30000);
define(STATE_DEATHSTAR_BONUS,172800);// Planetenzerstörungsbonus
define(STATE_DEATHSTAR_MALUS,172800);// -||- Malus
define(STATE_BONUS,7200);// Planetenzerstörungsbonus
define(STATE_MALUS,7200);// -||- Malus
define(STATE_LASER,7200);
define(STATE_PARTI,7200);
define(STATE_TORPE,7200);


define(EMP_RANGE,300);
define("CREDITS_PER_LEVEL","100000"); // gibt an wieveile credits ein user pro level haben darf (lv. 1 =5000, lv. 2 = 10000, ....)
define("RESOURCE_PER_LEVEL","10000");// wenn kein lager gebaut wurden ist dann sind dies die maximalen resourcen die zur verfügung stehen sollen

define(TRADE_TAX,"0.10");// die gebühr die beim handel mit den Handelszentrum zum bezahlen ist jetzt 10%
		  
define(NEW_PLANETS_PER_PLAYER,3);
define(BASE_XP_PER_PLANET, 5000);
define(MAX_UNITS_PER_PLANET,3);// die maximale anzahl der flotten pro planet
define(MAX_UNITS_PER_CC,2);// die maximale anzahl der flotten pro level des Kommunications zentrums

define(PLANET_START_METALL,5000); // start metall für neue Planeten
define(PLANET_START_CRISTAL,5000); // start metall für neue Planeten
define(PLANET_START_HYDROGEN,5000);
define(PLANET_START_BIOMASS,5000);// lebensmittel
define(PLANET_START_PEOPLE,5000);
define(PLANET_NEW_USER_RANGE,5000);// gibt den abstand zu einem anderen Spieler bei der registrierung an 

  // einwohner formel für maximal bei lvl 20 ca. 10^8 einwohner
// 2253 *(1.733^X)	==> PEOPLE_MAX_STORE_PRE* (PEOPLE_MAX_STORE_SUF^X)
define(PEOPLE_MAX_STORE_PRE,2253);
define(PEOPLE_MAX_STORE_SUF,1.73);

// zur berechnung der Credits   CREDITS_PRE*StadtLevel^2-CREDITS_SUF*StadtLevel
define(CREDITS_PRE,17); 
define(CREDITS_SUF,20);	//


// maximal neue einwohner die stunde (PEOPLE_MAX_NEW_PEOPLE_PRE*(PEOPLE_MAX_NEW_PEOPLE_SUF^X)   100*(1.73^x)
define(PEOPLE_MAX_NEW_PEOPLE_PRE,100);
define(PEOPLE_MAX_NEW_PEOPLE_SUF,1.73);// maximal neue einwohner die stunde (PEOPLE_MAX_NEW_PEOPLE*X^2)

define(PEOPLE_CREDITS,25);// 10.000 Einwohner geben 25 Credits die stunde   // alt
define(PEOPLE_FOOD_PER_HOUR,0.000001);// der verbrauch eines einwohners die stunde	// alt

// zur berechnung des Lebensmittel verbrauches A*X-B
define(POEPLE_CONSUMTION_A,805); // 805*X+(-555)
define(POEPLE_CONSUMTION_B,-555);   // x ist das Level der stadt

define(PLANET_SIGHT_NORMAL,500);//die sichtweite einer einheit auf der karte 

define(UNIT_SIGHT_NORMAL,700);//die sichtweite einer einheit auf der karte 
define(UNIT_SIGHT_SCANNER,1200);//die sichtweite einer einheit auf der karte mit einem ausgerüstetem scanner
define(UNIT_MAX_SHIPS_IN_UNIT,50);//gibt die maximal anzahl der schiffe in einer flotte an
define(UNIT_PER_LEVEL_COMMUNICATIONCENTRAL,25);// wieviele schiffe können pro level Komzentrale in eine Flotte zusammengefast werden
define(UNIT_COMMUNICATIONCENTRAL_ID,21);// die Datenbank ID der Kommzentrale
define(UNIT_HEALTH_PER_LEVEL,0.05);//gibt die erhöhten treffer punkte der Flotte pro level an 0.05 = 5%
define(UNIT_SPEED_PER_LEVEL,0.05);//gibt die erhöhte Geschwindigkeit der Flotte pro level an 0.05 = 5%
define(UNIT_AMOR_PER_LEVEL,0.05);//gibt die erhöhte Panzerung der Flotte pro level um 0.05 = 5%
define(UNIT_DMG_PER_LEVEL,0.05);//gibt die erhöhte Panzerung der Flotte pro level um 0.05 = 5%
define(UNIT_MAX_LEVEL,10);//gibt das maximale level der Flotten an
define(UNIT_SIEGE_RANGE,60);//die range die feindliche flotten haben müssen damit auf dem planeten keine flotten mehr erstellt werden können
define(UNIT_REPAIR_RANGE,30);//die range die feindliche flotten haben müssen damit auf dem planeten keine flotten mehr erstellt werden können
define(UNIT_WAST_RESSOURCE_RECYCLE_MAX,20000); // gibt an wieviele ressourcen von schrott feldern recyclet werden können
define(UNIT_WAST_RESSOURCE_RECYCLE_MIN,5000);
define(UNIT_MAX_DEATHSTARS,1);// maximale anzahl der todessterne die pro spieler gebaut werden können

define(UNIT_KOLO_COOLDOWN,3628800);// die zeit für den noob schutz 

define(UNIT_KOLO_SPEED,0.5);// kolo minus speed in %


define(UNIT_DRIVE_DEVICE_SPEED,0.5);// wieviel % schneller sollen triebwerke fliegen können
define(UNIT_DRIVE_DEVICE_SPEEDLOW,0.25);
define(UNIT_MARTYR_SPEED,0.5);// % langsamer wenn märtyrer

define(ADMIN_NAME,"FEADMIN");
define(ADMIN_PASS,"xu546KEFBVAxu546KEFBVA");
define(MAP_REFRESH_KEY,"sdbjhdsyiwsjxu546KEFBVA");// der schlüsselder benötigt wird um die Karteupzudaten


define(UNIT_RAIDER_KEY,"bnjxsd5KtuzvAW513LPVhe");
define(UNIT_MAX_SPEED,390);
// pro woche ersden einmal neue Flotten gespawnt
define(UNIT_RAIDER_MIN_COUNT,25);// wieviele raider Flotten werden angelegt minimal
define(UNIT_RAIDER_MAX_COUNT,50);// wieviele raider Flotten werden angelegt maximal

define(UNIT_RAIDER_SHIP_MIN_COUNT,50);// wiviele schiffe sind in einer Flotte minimal 
define(UNIT_RAIDER_SHIP_MAX_COUNT,150);// wiviele schiffe sind in einer Flotte maximal 

// spawn postitions raum der Raider Flotten
define(UNIT_RAIDER_X_MIN,86000);
define(UNIT_RAIDER_X_MAX,120000);
define(UNIT_RAIDER_Y_MIN,86000); 
define(UNIT_RAIDER_Y_MAX,120000);

define(SKILL_MIN_LEVEL_TO_STEAL_FROM,5);//gibt das Level an ab dem User bestohlen werden können
define(SKILL_SABOTAGE_MAX_PERCENT,50);
define(SKILL_SABOTAGE_MIN_PERCENT,30);
define(SKILL_EXTRACT_RESSOURCE_MIN,20000);
define(SKILL_EXTRACT_RESSOURCE_MAX,50000);

define(BATTLE_NEW_BATTLE_RANGE,30);//der abstand von 2 gegnerischer einheiten die sich angreifen

define(USER_PREMIUM_LEVEL,0);// bis zu diesem level ist der Spieler Premium (unter lvl 3 ist der spieler Premium)
define(USER_FRIEND_UINVTE_CREDITS,100000);// die Credits die ein Spieler bekommt wenn er einen Freund wirbt
define(USER_MAX_LEVEL,500);

// Die anzahl der angezeigten posten im handelszentrum
define(SALE_PAGE_COUNT,16);

define(MAP_WAST_TIME,7776000000);// wielange soll müll im all bleiben bis es gelöscht wird
define(MAP_WAST_COUNT,3);// gibt an aus wievielen müll bildern angezeigt werden soll dieser wert gibt dabei den maximal wert an rand(1 , MAP_WAST_COUNT);
//************* Preise für die Premuim accounts
define(PREMIUM_1_MONTH_PRICE,"5,00");
define(PREMIUM_2_MONTH_PRICE,"7,00");
define(PREMIUM_3_MONTH_PRICE,"10,00");
define(PREMIUM_BUILD_PERCENT_FASTER,0.20);// wie viel schneller soll mit dem premium account gebaut werden können


define(SYSTEM_NAME,"System");

 // Länder Kürzel für die Sprachdateien
define(LANGUAGE_GER,"Ger"); 
define(LANGUAGE_ENG,"ENG"); 
define(LANGUAGE_FR,"FR"); 
define(LANGUAGE_SPA,"SPA"); 

// IDs für die schiffe
define(SHIP_ID_D,2);   // drohne
define(SHIP_ID_SH,3);  // kleiner Jäger
define(SHIP_ID_HH,4);  // großer Jäger
define(SHIP_ID_B,5);   // bomber
define(SHIP_ID_BS,6);  // kampfschiff
define(SHIP_ID_ST,7);  // kleiner Transporter
define(SHIP_ID_LT,8);  // Großer Transporter


define(SYSTEM_EMAIL_ADRESS,"system@final-end.de");
define(SYSTEM_EMAIL_PASS,"awfn897nif");
define(SYSTEM_EMAIL_HOST,"localhost");

define(DEATH_STAR_SPEED,10);
define(DEATH_STAR_DMG,100000);// das ist gleichzeitig das benötigte kristall
define(DEATH_STAR_LIFE,5000000);// das ist gleichzeitig das benötigte metall
define(DEATH_STAR_ARMOR,150);
define(DEATH_STAR_DESTROY_RANGE,50);
define(DEATH_STAR_DESTROY_CREATE_WAST,50);// wieviel müll soll erzeugt werden wenn ein Planet zerstört wird

define(SYSTEM_RES_X_MIN,1024);
define(SYSTEM_RES_Y_MIN,768);


define(USER_PICTURE_PATH,"./UserPctures/");

?>