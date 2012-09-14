<?php
include("tpl_IngameHeaderNew.php");
?>



<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Settings.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">

 <h2>:T_SETUP_CHANGEPASS:</h2>
 <?php echo $this->Error;?>

<form action="index.php?Section=User&amp;Action=ChangePass" method="post" target="">
<table >
<tr>
 <td>:T_SETUP_OLDPASS: </td>
 <td><input type="Password" name="s_Old" value="" size="" maxlength="">   </td>
</tr>
 <tr>
 <td>:T_SETUP_NEWPASS: </td>
 <td><input type="Password" name="s_NewPass" value="" size="" maxlength="">   </td>
</tr>
 <tr>
 <td>:T_SETUP_NEWPASSAGAIN:</td>
 <td><input type="Password" name="s_NewPassConfirme" value="" size="" maxlength="">   </td>
</tr>
 <tr>
 <td><input type="Submit" name="" value=":T_SETUP_CHANGE:"> </td>
 <td> </td>
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