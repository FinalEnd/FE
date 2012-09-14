<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Planet.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">


 <h2>:T_STATS_HEADER:</h2>
<br>
<br> <!--<a href="index.php?Section=User&Action=ShowProfil">:BTN_STATS_HEADER:</a>--> <a href="index.php?Section=Skill&Action=ShowUserSkills">:BTN_STATS_SKILLS:</a> <a style="padding-left: 20px;" href="index.php?Section=User&amp;Action=ShowCompareStats">:T_COMPARE_HEADER:</a>

<table >
<tr>
 <td>:T_STATS_TITEL: </td>
 <td align="right"><?php echo $this->User->getName();?> </td>
</tr>
<tr>
 <td>:T_STATS_LEVEL: </td>
 <td align="right"><?php echo $this->User->getLevel();?> </td>
</tr>
<tr>
 <td>:T_STATS_EXP: </td>
 <td align="right"> <?php echo $this->EXP;?> </td>
</tr>
<tr>
 <td>:T_STATS_NEXT_LEVEL:  </td>
 <td align="right"><?php echo $this->EXPNextLevel;?> </td>
</tr>
  <tr>
 <td>:T_STATS_PEOPLE: </td>
 <td align="right"><?php echo $this->People;?> </td>
</tr> 


<tr>
 <td >:T_STATS_MAX_CREDITS: </td>
 <td align="right"><?php echo $this->MaxCredits;?> </td>
</tr>
<tr>
 <td style="Height:35px;vertical-align:bottom;">:T_STATS_UNIT_COUNT: </td>
 <td align="right" style="Height:35px;vertical-align:bottom;"><?php echo $this->Units;?> </td>
</tr>

<tr>
 <td>:T_STATS_PLANET_COUNT: </td>
 <td align="right"><?php echo $this->UserPlanets;?> </td>
</tr>

<tr>
 <td>:T_STATS_MAX_UNITS: </td>
 <td align="right"><?php echo $this->MaxUnits;?> </td>
</tr>

<tr>
 <td>:T_COMPARE_FLEETLOST: </td>
 <td align="right"><?php echo $this->FleetLost;?> </td>
</tr>

<br>

 <tr>
 <td colspan="2"> <h2 style="margin-top:10px;margin-bottom:0px;">:T_STATS_BILANZ:</h2> </td>
 
</tr>

 <tr>
 <td>:T_STATS_INCOME_TAX: </td>
 <td align="right"><?php echo $this->CreditsPerHour;?> </td>
</tr>

<tr>
 <td>:T_STATS_PAY: </td>
 <td align="right" style="color:red"><?php echo $this->PayPerHour;?> </td>
</tr>
 <tr>
 <td>:T_STATS_INCOME: </td>
 <td align="right"><?php echo $this->CreditsPerHour-$this->PayPerHour;?> </td>
</tr>

<tr>
 <td style="Height:35px;vertical-align:bottom;">:T_COMPARE_MSOLD: </td>
 <td align="right" style="Height:35px;vertical-align:bottom;"><?php echo $this->MetallSold;?> </td>
</tr>
<tr>
 <td>:T_COMPARE_MBOUGHT: </td>
 <td align="right"><?php echo $this->MetallBought;?> </td>
</tr>
<tr>
 <td>:T_COMPARE_CSOLD: </td>
 <td align="right"><?php echo $this->CrystalSold;?> </td>
</tr>
<tr>
 <td>:T_COMPARE_CBOUGHT: </td>
 <td align="right"><?php echo $this->CrystalBought;?> </td>
</tr>
<tr>
 <td>:T_COMPARE_DSOLD: </td>
 <td align="right"><?php echo $this->DeuteriumSold;?> </td>
</tr>
<tr>
 <td>:T_COMPARE_DBOUGHT: </td>
 <td align="right"><?php echo $this->DeuteriumBought;?> </td>
</tr>
<tr>
 <td>:T_COMPARE_FSOLD: </td>
 <td align="right"><?php echo $this->FoodSold;?> </td>
</tr>
<tr>
 <td>:T_COMPARE_FBOUGHT: </td>
 <td align="right"><?php echo $this->FoodBought;?> </td>
</tr>

<tr>
 <td colspan="2"> <h2 style="margin-top:10px;margin-bottom:0px;">:T_COMPARE_MESSAGES:</h2> </td>
 
</tr>

<br>

<tr>
 <td>:T_COMPARE_MESSAGESSEND: </td>
 <td align="right"><?php echo $this->MessagesWritten;?> </td>
</tr>
<tr>
 <td>:T_COMPARE_MESSAGESRECEIV: </td>
 <td align="right"><?php echo $this->MessagesReceived;?> </td>
</tr>
<tr>
 <td>:T_COMPARE_ALLITOPIC: </td>
 <td align="right"><?php echo $this->AlliWritten;?> </td>
</tr>
<tr>
 <td>:T_COMPARE_ALLIMESSAGE: </td>
 <td align="right"><?php echo $this->AlliAnswerd;?> </td>
</tr>
	 <?php if($this->CompareUserState)
	 {
	 	// der user ist geladen
	 }?>
</table>



<p>:T_ADDFRIEND_TEXT_PART1: <?php echo USER_FRIEND_UINVTE_CREDITS; ?> :T_ADDFRIEND_TEXT_PART2:</p>

<p><input type="text" size="40" onclick="this.focus();this.select();" value="http://www.final-end.de/index.php?S=<?php echo Controler_Main::getInstance()->getDataBaseId(); ?>&Ref=<?php echo $this->User->getId(); ?>"/>	</p>
<p>:T_ADDFRIEND_TEXT2:</p>

</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
</div>
<?php
include("tpl_Footer.php");
?>
