<?php
include("tpl_IngameHeaderNew.php");
?>

<style type="text/css">
img
{
	max-width:350px;
}

</style>

<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Allianz.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">

<script type="text/javascript" src="javascript/Word.js"></script>
 <h2>:T_ALLIANZWORKON_HEADER:</h2>
 <?php echo "<h3 class='ErrorHeader'>".$this->Error."</h3>";?>
<form action="index.php?Section=Allianz&amp;Action=AllianzWorkOn" method="post" target=""  enctype="multipart/form-data">
<table >
<tr>
 <td>Beschreibung: </td>
</tr>
<tr>
 <td><textarea id="rtb_Comment" name="tb_Description" cols="50" rows="10"><?php echo $this->Allianz->getDescription();?></textarea>  </td>
<td>

 <table >
<tr>
 <td><input type="button" style="cursor: pointer;border:none;width:150px;height:27px;padding-left: 2px;" onClick="http()" value=":BTN_ALLIANZWORKON_LINK:"> </td>
</tr>
<tr>
 <td>

<iframe src="http://pic-upload.eu/index.php?Section=Picture&Action=m&c=000000&amp;i=rtb_Comment" scrolling="no" frameborder="0" width="430" height="50" name=""></iframe>
</td>
</tr>
<tr>
 <td><input type="button" style="cursor: pointer;border:none;width:150px;height:27px;padding-left: 2px;" onClick="fat()" value=":BTN_ALLIANZWORKON_BOLD:"> </td>
</tr>
</table>


</td>
</tr>

<tr> 
 <td colspan="2"><input type="Submit" name="" value=":BTN_ALLIANZWORKON_WORKON:"> </td>
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