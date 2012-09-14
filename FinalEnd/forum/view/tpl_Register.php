
<?php

include "view/tpl_Menu.php";


if ($this->Error)
{
	echo "<h1>Fehler ".$this->Error."</h1>";
}


?>



<form action='index.php?section=Register&amp;Action=RegisterUser' name='form' method='POST' target=''>
name eingeben unter dem sie sich registrieren wollen:<br>
<input type='Text' name='name' value='' size='' maxlength='25'><br>
password :
<br><input type='password' name='pass' value='' size='' maxlength='25'><br>
password wiederholen:
<br><input type='password' name='pass2' value='' size='' maxlength='25'><br>
<input type='Submit' class='button' name='reggen' value='' style='cursor: pointer; background: url("./images/registry.png") repeat scroll 0% 0% transparent; border: medium none; width: 135px; height: 25px;'>
</form>