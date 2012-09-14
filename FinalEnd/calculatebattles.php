<?php    //error_reporting(E_ALL);

if(empty($_SERVER['argv'])){echo "kann nur in Komandozeilen modus ausgeführt werden \n";return false;}// wenn nicht konsole dann raus 
// db setzen

//$_SERVER['argv'][1]=".";
//$_SERVER['argv'][2]=1;
if(!isset($_SERVER['argv'][1]))	{echo "der ausführungs pfad wurde nicht angegeben (string) \n";return false;}//wenn nicht konsole dann raus
if(!isset($_SERVER['argv'][2]))	{echo "die datenbank wurde nicht angegeben  (int) \n";return false;}// wenn nicht konsole dann raus


include($_SERVER['argv'][1].'/class/logic/cls_Include.php');
echo "includes eingebunden\n";
//error_reporting(E_ALL | E_WARNING); 
BasicIncludeConst::getInstance()->loadAll();

echo "includes geladen\n"; 

$Controler_Main= Controler_Main::getInstance();

echo "Maincontroler instanziiert\n";

$Controler_Main->calculateBattles();
sleep(2);
echo "berechnung beendet\n";
sleep(5);
//include "inhalt.php";
?>