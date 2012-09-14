<?php
include("tpl_IngameHeaderNew.php");
?>



<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Settings.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">





 <h2>:T_SETUP_TITLE:</h2>


<h3>Profil Bild</h3>

<img class="ImageBorder" style="width:100px;height:100px;" src="<?php echo $this->MyUser->getPictureString();?>" />
<form enctype="multipart/form-data" action="index.php?Section=User&amp;Action=UploadAvatar" method="post" >
	<p>
:T_SET_AVATAR::<br />
 <input id="File" name="File" type="file"  />
<input  type="submit" value=":T_SETUP_UPLOAD_AVATAR:" />
</form>
<?php
if($this->IsNotPremium)
{
	echo ':T_SET_PREMKEY::<br />
<form action="index.php?Section=User&amp;Action=UsePremium" method="post" target="">
		 <input type="Text" name="s_Old" value="" size="" maxlength=""> 
		 <input type="Submit" name="" value=":T_MESSAGE_SEND:">
</form>';
}
?>

<table width="80%">
<tr>
 <td width="30%" class='header'><h3>:T_SETUP_PAYFREESERV:</h3></td>
 <td width="30%" class='header'><h3>:T_SETUP_PAYSERVICE:</h3> </td>
</tr>

<tr>
 <td><a href="index.php?Section=User&amp;Action=AddAFriend">:T_SETUP_FRIEND:</a></td>
 <td><a href="index.php?Section=User&amp;Action=ShowChargePremiumAccount">:T_SETUP_SPONSORSHIP:</a> </td>
</tr>
<tr>
 <td><a href="index.php?Section=User&amp;Action=ShowChangePass">:T_SETUP_CHANGEPASS:</a> </td>
 <td>

<?php
if($this->IsNotPremium == false)
{
	echo ':T_SETUP_PREMDAYSVADLID:: '.$this->DaysValid.' :T_SETUP_PREMDAY:';
}
?>

</td>
</tr>
 <tr>
 <td><a href="index.php?Section=User&amp;Action=ShowDeleteUser">:T_SETUP_WHMPARROUND:</a></td>
 <td><!-- <a href="index.php?Section=User&amp;Action=AddAFriend">:T_SETUP_SMSSERVICE:</a> --> </td>
</tr>



</table>
 <p>:T_SETUP_VERSION:: <?php echo SYSTEM_VERSION; ?> </p>


<p>
	<a href="index.php?Section=User&Action=ShowSettings&amp;Lang=Ger"> <img src ="./images/flags/flag-de.png" title ="Deutsche Sprache wählen" alt ="Deutsche Sprache wählen" /></a>
	<a href="index.php?Section=User&Action=ShowSettings&amp;Lang=Eng"> <img src ="./images/flags/flag-gb.png" title ="Select English language" alt ="Select English language" /></a> 
</p>	                        


</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
	


<?php

include("tpl_Footer.php");
?>
