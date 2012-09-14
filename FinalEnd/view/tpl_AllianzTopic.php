<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Allianz.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">


 <script type="text/javascript">
function check()
{
	 if(confirm(":T_ALLIANZTOPIC_CONFIRME_TEXT:"))
	 {
		return true;
	 }
 return false;
}
</script> 

<div id="Main">

 <h2><?php
 echo $this->Topic->getName();

?></h2>



<?php
if($this->IsAdmin)
{
	echo "<a onclick='return check();' href='index.php?Section=Allianz&amp;Action=DeleteTopic&amp;TId=".$this->Topic->getId()."' class='VIPLink'>:T_ALLIANZTOPIC_DELETE_THREAD:</a>";	
}

?>


 <form action="index.php?Section=Allianz&amp;Action=AddComment&amp;TId=<?php echo $this->Topic->getId();?>" method="post" >
<table >

 <?php


 foreach($this->Topic->getAllianzCommecntCollection() as $Comment)
 {
 	echo "<tr>
 <td class='header'>".$Comment->getUser()->getName()."</td>
 <td class='header'>".$Comment->getCreateDate()."</td>
 
</tr>
<tr>
 <td colspan='2'>".$Comment->getContent()."</td>
</tr>";
 }

?>





<tr>
 <td colspan="2"><textarea name="tb_Content" cols="45" rows="6" onclick="if(this.value=='Kommetar'){this.value=''}"></textarea> </td>
</tr>
<tr>
 <td> </td>
 <td align="right" ><input  type="Submit" name="" value=":BTN_ALLIANZTOPIC_WRITE:"> </td>
</tr>
</table></form>

</div>
</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>