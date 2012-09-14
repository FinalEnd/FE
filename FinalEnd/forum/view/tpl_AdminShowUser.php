
<?php

include "view/tpl_Menu.php";

if($this->ErrorString)
{
	echo $this->ErrorString;
}
?>

<table border="2">
<tr>
 <td>Id</td>
 <td>Name </td>
 <td>Passwort </td>
<td></td>

<?php

//var_dump($this->UserCollection);
//if (empty($this->UserCollection))
//{
	//echo " in der Foreach";
	foreach($this->UserCollection as $User)
	{
		
		echo"<tr>
				<td>".$User->getId()."</td>
			<td>".$User->getName()."</td>
			<td>  <form action=\"index.php?section=admin&action=ChanceUserPass&amp;UserId=".$User->getId()."\" method=\"post\" target=\"\">
			<input type=\"Password\" name=\"s_Pass\" value=\"".$User->getPass()."\" size=\"\" maxlength=\"\"></td>";	
			echo "<td>   <input type=\"Submit\" name=\"\" value=\"Bearbeiten\"></form> </td>";
	}	
	
	
	
	
//}



?>
</tr>
</table>

