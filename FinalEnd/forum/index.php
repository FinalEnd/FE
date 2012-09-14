<?php    //error_reporting(E_ALL);
session_start();
include('class/logic/cls_Include.php');


$Controler_Main=  Controler_Main::getInstance();

$Controler_Main->start();

//include "inhalt.php";



?>