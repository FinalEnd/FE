<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Allianz.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">

 <h2>:T_ALLIANZADDTOPIC_HEADER:</h2>


  <form action="index.php?Section=Allianz&amp;Action=CreateTopic" method="post" >
<table  >
<tr>
 <td>:T_ALLIANZADDTOPIC_NAME: </td>
 <td><input style="width:300px;" type="Text" name="tb_Name" value=""  maxlength=""> </td>
</tr>
<tr>
 <td>:T_ALLIANZADDTOPIC_COMMENT: </td>
 <td><textarea style="width:300px;" name="tb_Content"  rows="6"></textarea> </td>
</tr>
<tr>
 <td> </td>
 <td><input type="Submit" name="" value=":BTN_ALLIANZADDTOPIC_CREATE:"> </td>
</tr>
</table></form>

</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>
