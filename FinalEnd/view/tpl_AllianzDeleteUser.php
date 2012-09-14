<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Allianz.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">


 <h2>:T_ALLIANZDELETUSER_HEADER:</h2>
 <?php echo $this->Error;?>
	  
<form action="index.php?Section=Allianz&amp;Action=DeleteUser" method="post" target="">
<table >

 <tr>
 <td colspan ="2 ">:T_ALLIANZDELETUSER_TEXT:
 </td>
</tr>

<tr>
 <td><input type="Text" name="s_Delete" value="" size="" maxlength=""> </td>
<td><input type="Submit" name="" value=":BTN_ALLIANZDELETUSER_EXIT:"> </td>
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