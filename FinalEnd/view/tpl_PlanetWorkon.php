<?php
include("tpl_IngameHeaderNew.php");
?>

<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Planet.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">


 <h2>:T_PLAN_RENAMETITLE:</h2>

<form action="index.php?Section=Planet&amp;Action=ReNamePlanet" method="post" >
	<table >
	<tr>
	 <td>:T_NAVI_NAME:: </td>
	 <td><input type="text" name="tb_Name" /> </td>
	</tr>
	<tr>
	 <td> </td>
	 <td><input type="submit" value=":BT_PLAN_RENAME:"  /> </td>
	</tr>
	</table>

</form>

</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>
