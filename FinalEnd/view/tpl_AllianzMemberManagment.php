<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Allianz.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">


 <h2>:T_ALLIANZMEMBER_HEADER:</h2>
 <?php if($this->Message) {echo $this->Message;}?>
<form action='index.php?Section=Allianz&amp;Action=SendAllianzInvite' method='post' target=''>
 <table><tr>

<tr>
 <td colspan="2">:T_ALLIANZMEMBER_TEXT:</td> 

</tr>

 <td><input type="Text" name="tb_UserName" value="" size="" maxlength=""> </td> 
  <td><input type="Submit" name="" value=":T_ALLI_INVITEP:"> </td>
</tr>
</table>
</form>
<br>
<br>

:T_ALLIANZSHOWUSER_RANK:
<form action='index.php?Section=Allianz&amp;Action=AddRank' method='post' target=''>
  <input type="Text" name="tb_NewRank" value="" size="" maxlength="">
  <input type="Submit" name="" value=":T_PREM_ADD:">
	</form>
	<form action='index.php?Section=Allianz&amp;Action=DeleteRank' method='post' target=''>
	<select name='cb_Ranks' size=''>
	<?php
	foreach($this->Ranks as $Rank)
	{	 	
		echo "<option ";
		echo "value='".$Rank->getName()."'>".$Rank->getName()." </option>";
	}
	echo"</select>"; ?>
  <input type="Submit" name="" value=":T_SETUP_DELETE:">
	</form>
<br>
<br>
<table>
<tr>
 <td class="header">:T_ALLIANZMEMBER_NAME: </td>
 <td class="header">:T_ALLIANZMEMBER_STATE: </td>
 <td class="header">:T_GROUP_RANK: </td>
<td></td>
<td></td>
</tr>
	 <?php
	 $AllianFinder = new AllianzFinder();
	 foreach($this->UserCollection as $User)
	 {
	 	echo "   <form action='index.php?Section=Allianz&amp;Action=AllianzMemberWorkOn&amp;UserId=".$User->getId()."' method='post' target=''>
		<tr>
			<td>".$User->getName()." </td>
			<td><select name='cb_MemberstateState' size=''>
			
    	<option"; if($User->getAllianzMemberState()=="admin") {echo " selected ";}
	 	echo " value='admin'>:T_ALLIANZMEMBER_ADMIN:</option>
	 	 <option value='member'";
	 	if($User->getAllianzMemberState()=="member") {echo " selected ";}
	 	echo ">:T_ALLIANZMEMBER_MEMBER:</option>
    </select> <td>
	<select name='cb_Rank' size=''>";
	 $Name = $AllianFinder->findRankByUser($User->getId());
	if($Name != '')
 	{
	 		echo "<option selected value='".$Name."'>".$Name."</option>";
 	} else
 	{
	 		echo "<option selected value='none'> - - - </option>";
 	}
	foreach($this->Ranks as $Rank)
    {	 	
	 		echo "<option ";
	 		if($Rank->getName() == $Name)	
				continue;
	 		echo "value='".$Rank->getName()."'>".$Rank->getName()." </option>";
	}
    echo"</select> </td>
	
	</td> 
			<td><a href='index.php?Section=Allianz&amp;Action=AllianzKickMember&amp;UserId=".$User->getId()."'>:BTN_ALLIANZMEMBER_KICK:</a></td>
			<td><input type='Submit' name='btn_Submit' value=':BTN_ALLIANZMEMBER_WORKON:' /> </td>
		</tr>
		 </form> 
		";
	 }

	 ?>
	</table>
	
</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>
