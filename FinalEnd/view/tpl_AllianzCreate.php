<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Allianz.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">

 <h2>Allianz Erstellen</h2>
 <?php echo "<h3 class='ErrorHeader'>".$this->Error."</h3>";?>
<form action="index.php?Section=Allianz&amp;Action=CreateAllianz" method="post" target="">
<table >
<tr>
 <td>:T_ALLIANZCREATE_NAME: </td>
 <td><input type="Text" name="tb_Name" value="" size="" maxlength="">  </td>
</tr>
<tr>
 <td>:T_ALLIANZCREATE_DESCRIPTION: </td>
 <td><textarea name="tb_Description" cols="20" rows="5"></textarea>  </td>
</tr>
<tr>
 <td> </td>
 <td><input type="Submit" name="" value=":BTN_ALLIANZCREATE_CREATE:"> </td>
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