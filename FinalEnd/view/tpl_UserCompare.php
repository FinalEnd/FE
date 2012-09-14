<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Planet.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">


 <h2>:T_COMPARE_HEADER:</h2>
<br>
<br>
<a href="index.php?Section=User&Action=ShowStats">:BTN_STATS_HEADER:</a> <!--<a href="index.php?Section=User&Action=ShowProfil">:BTN_STATS_HEADER:</a>--> <a style="padding-left: 20px;" href="index.php?Section=Skill&Action=ShowUserSkills">:BTN_STATS_SKILLS:</a>

<br>
<form action="index.php?Section=User&amp;Action=ShowCompareStats" method='post' target=''>	
<table border="0">
<tr>
	<td >
		:T_COMPARE_PLAYER:
	</td> 
	<td align="left">
		<input name="tb_Player" id="tb_Player" maxlength="50" size="30" autocomplete="off" value='<?php echo $this->UserCompareName;?>'/>
	</td>
</tr>
<tr>
	<td align="left" colspan="7">
		<input class='button' type='Submit' name='abschicken' value=':T_COMPARE_REQUEST:'>
	</td>
</tr>
</table>
</form>	

<table border="0"><tr><td >

<table border="0">
		<tr>
		 <td>:T_STATS_TITEL: </td>
		 <td align="right" style="width:100px"><?php echo $this->User->getName();?> </td>
		</tr>
		<tr>
		 <td>:T_STATS_LEVEL: </td>
		 <td align="right"><?php echo $this->User->getLevel();?> </td>
		</tr>
		<tr>
		 <td>:T_STATS_EXP: </td>
		 <td align="right"> <?php echo number_format($this->User->getExperience(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td>:T_STATS_PLANET_COUNT: </td>
		 <td align="right"><?php echo number_format($this->UserPlanets,0,",",".");?> </td>
		</tr>

		<tr>
		 <td>:T_COMPARE_PLANETSGOTTEN: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getPlanetsGotten(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td>:T_COMPARE_PLANETSLOST: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getPlanetsLost(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td>:T_COMPARE_PLANETSSCANNED: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getPlanetsScanned(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td>:T_COMPARE_PLANETSRAIDED: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getPlanetsRaided(),0,",",".");?> </td>
		</tr>

		<tr>
		 <td>:T_COMPARE_FLEETLOST: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getFleetLost(),0,",",".");?> </td>
		</tr>
		
		
		<tr>
		 <td colspan="2"><h2 style="margin-top:10px;margin-bottom:0px;">:T_COMPARE_TRADE:</h2></td>
		</tr>
		
		<tr>
		<td>:T_COMPARE_CEARNED: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getCreditsEarned(),0,",",".");?> </td>
		</tr>
		
		<tr>
		<td>:T_COMPARE_CGIVEN: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getCreditsGiven(),0,",",".");?> </td>
		</tr>
		
		<tr>
		
		 <td>:T_COMPARE_MSOLD: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getMetallSold(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td>:T_COMPARE_MBOUGHT: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getMetallBought(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td>:T_COMPARE_CSOLD: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getCrystalSold(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td>:T_COMPARE_CBOUGHT: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getCrystalBought(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td>:T_COMPARE_DSOLD: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getDeuteriumSold(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td>:T_COMPARE_DBOUGHT: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getDeuteriumBought(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td>:T_COMPARE_FSOLD: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getFoodSold(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td>:T_COMPARE_FBOUGHT: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getFoodBought(),0,",",".");?> </td>
		</tr>

		<tr>
			<td colspan="2"><h2 style="margin-top:10px;margin-bottom:0px;">:T_COMPARE_MESSAGE:</h2></td>
		</tr>

		<tr>
		 <td>:T_COMPARE_MESSAGESSEND: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getMessagesWritten(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td>:T_COMPARE_MESSAGESRECEIV: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getMessagesReceived(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td>:T_COMPARE_ALLITOPIC: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getAlliWritten(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td>:T_COMPARE_ALLIMESSAGE: </td>
		 <td align="right"><?php echo number_format($this->UserStats->getAlliAnswerd(),0,",",".");?> </td>
		</tr>
	</table></td>
	 <?php 
	if($this->CompareUserState)
	 {
		?>
	 	<td valign="top">
			
			<table >
		<tr>
		 <td align="right" style="width:100px"><?php echo $this->CompareUser->getName();?> </td>
		</tr>
		<tr>
		 <td align="right"><?php echo $this->CompareUser->getLevel();?> </td>
		</tr>
		<tr>
		 <td align="right"> <?php echo number_format($this->CompareUser->getExperience(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td align="right"><?php echo number_format($this->CompareUserPlanets,0,",",".");?> </td>
		</tr>

		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getPlanetsGotten(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getPlanetsLost(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getPlanetsScanned(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getPlanetsRaided(),0,",",".");?> </td>
		</tr>

		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getFleetLost(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td colspan="2"><h2 style="margin-top:10px;margin-bottom:0px;">&nbsp;</h2></td>
		</tr>

		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getCreditsEarned(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getCreditsGiven(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getMetallSold(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getMetallBought(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getCrystalSold(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getCrystalBought(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getDeuteriumSold(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getDeuteriumBought(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getFoodSold(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getFoodBought(),0,",",".");?> </td>
		</tr>
		
		<tr>
		 <td colspan="2"><h2 style="margin-top:10px;margin-bottom:0px;">&nbsp;</h2></td>
		</tr>
		
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getMessagesWritten(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getMessagesReceived(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getAlliWritten(),0,",",".");?> </td>
		</tr>
		<tr>
		 <td align="right"><?php echo number_format($this->CompareStats->getAlliAnswerd(),0,",",".");?> </td>
		</tr>
	</table>
	</td>
	 <?php }?>
</tr>
</table>


</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
</div>
<?php
include("tpl_Footer.php");
?>
