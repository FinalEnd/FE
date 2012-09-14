<?php
include("tpl_IngameHeaderNew.php");
?>



<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Settings.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">

<h2>Account aufladen</h2>


<table width="30%">
<tr>
 <td class="header" colspan="3"><?php echo $this->Packet;?> €</td>

</tr>
<tr>
 <td>Bezahlen mit PayPal</td>

</tr>

<!-- <tr>
 <td>Bezahlen mit Amazon</td>
</tr>

<tr>
 <td>Bezahlen mit Pay Safe Card</td>
</tr>-->

</table>


<table width="30%" id="Results">

</table>


</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
	


<?php

include("tpl_Footer.php");
?>