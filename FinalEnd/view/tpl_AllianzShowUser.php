<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Allianz.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">

 <h2>:T_ALLIANZSHOWUSER_HEADER:</h2>

<table>
<tr>
 <td class='header' colspan="2">:T_ALLIANZSHOWUSER_NAME: </td>

 <td class='header'>:T_ALLIANZSHOWUSER_STATE: </td> 
 <td class='header'>:T_ALLIANZSHOWUSER_LEVEL:</td>
 <td class='header'>:T_GROUP_RANK:</td>
 <td class='header'>:T_HEADER_CREDITS:</td>
 <td class='header'>:T_COMPARE_HEADER:</td>
 
</tr>
	 <?php
	 $AllianFinder = new AllianzFinder();
	 foreach($this->UserCollection as $User)
	 {
	 	$Name = $AllianFinder->findRankByUser($User->getId());
	 	echo "  
		<tr>
			<td>".$User->getName()." </td>
			<td><a href=\"index.php?Section=Messages&PlayerName='".$User->getName()."'\"><img src=\"./images/Msg.jpg\" height=\"15px\" width=\"25px\"  title=\":T_ALLIANZFOREIGEN_SEND_MSG:\" /></a></td>
			<td>"; if($User->getAllianzMemberState()=="admin") {echo " :T_ALLIANZSHOWUSER_ADMIN: ";}
	 	if($User->getAllianzMemberState()=="member") {echo " :T_ALLIANZSHOWUSER_MEMBER: ";}
	 	echo "</td>
	<td>".$User->getLevel()."</td><td>".$Name."</td>
	<td style='text-align:right;'>".$User->getCreditsFormated()."</td>
	<td><a style=\"padding-left: 20px;\" href=\"index.php?Section=User&amp;Action=ShowCompareStats&tb_Player='".$User->getName()."'\">:T_COMPARE_HEADER:</a></td>
</tr>";
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
