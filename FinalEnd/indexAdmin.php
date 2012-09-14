<?php   
//error_reporting(E_ERROR);
session_start();
include('class/logic/cls_Include.php');
//error_reporting(E_ALL); 

$Controler_Main= Controler_Admin::getInstance();

$Controler_Main->start();

//include "inhalt.php";
?><?php

