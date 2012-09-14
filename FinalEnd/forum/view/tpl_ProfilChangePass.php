<?php
	include "view/tpl_Menu.php";
	
echo $this->ErrorString;
	
?>



<form action="index.php?section=Profil&amp;action=ChangePass" method="post" >
<table >
<tr>
 <td>Altes Passwort: </td>
 <td><input type="Password" name="tb_OldPass" value="" size="" maxlength=""> </td>
</tr>
<tr>
 <td>Neues Passwort: </td>
 <td><input type="Password" name="tb_NewPassOne" value="" size="" maxlength=""> </td>
</tr>
<tr>
 <td>Passwort wiederholen: </td>
 <td><input type="Password" name="tb_NewPassTwo" value="" size="" maxlength=""> </td>
</tr>
<tr>
 <td><input type="Submit" name="" value="" style='cursor: pointer; background: url("./images/Bearbeiten.png") repeat scroll 0% 0% transparent; border: medium none; width: 115px; height: 25px;'> </td>
 <td> </td>
</tr>
</table>
<a  href='index.php?section=Profil'><img src='images/Back.png' alt='zurück' /></a>
</form>


