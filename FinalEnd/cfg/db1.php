<?php

/*** der erste server des spiels **/

$MySql= MySqldb::getInstance();
$MySql->setIP("localhost");
$MySql->setDataBase("FINALEND");
$MySql->setPassWord("toor");
$MySql->setUser("root"); 
//$MySql->connect();

?>