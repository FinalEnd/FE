<?php    //error_reporting(E_ALL);
session_start();
include('class/logic/cls_Include.php');
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE|E_WARNING));

error_reporting(0);
$Controler_Main= Controler_Main::getInstance();

$Controler_Main->start();

//include "inhalt.php";
?>