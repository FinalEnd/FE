<div id="Panel" style="position:relative;bottum:0px;margin:auto;padding:0px;width:100%;height:100px;background-image:url(./images/design/Panel.png);background-repeat:no-repeat">

<div style="position:relative;top:30px;left:55px">
<a href="index.php?Section=User&amp;Action=ShowStats"><?php echo $this->User->getName()." (".$this->User->getLevel().")";?></a>

 <?php
 if($this->MessageCount)
 {
 	echo '<a href="index.php?Section=Messages"><img height="15" width="25" src="./images/Msg.jpg" title=":T_HEADER_NEW_MSG:" /></a>';
 }
 ?>
 </div>


<div style="position:relative;top:42px;left:50px;width:250px;">

<select style="" onchange="window.location.href='index.php?Section=ChangeActivePlanet&amp;D=<?php echo $this->Section;?>&amp;cb_Planet='+this.value" name="cb_Planet" size="" >
<?php
foreach($this->PlanetArray as $MyPlanet)
{
	echo " <option value='".$MyPlanet['i_Id']."'";
	if($this->Planet->getId()==$MyPlanet['i_Id'])
	{
		echo "selected";
	}
	
	echo ">".$MyPlanet['s_Name']." (".$MyPlanet['BuildingCount'].")";
	echo $MyPlanet['ShipBuildCount'] ;
	if($MyPlanet['ResearchCount'])
	{
		echo " f ";	
	}
	echo "</option>";
}
?>
</select> 
 </div>

<table border="0" style="position:relative;top:-33px;left:325px">
<tr>
<td style="width:100px;">

	<?php echo $this->User->getCreditsFormated(true); ?>  	
 </td>

	<td style="width:100px;">
		<?php echo $this->Planet->getMetalFormated(true); ?>
	 </td>
	
	<td style="width:100px;">
		<?php echo $this->Planet->getCrystalFormated(true); ?>
	  </td>
	<td style="width:100px;">
		<?php echo $this->Planet->getHydrogenFormated(true); ?>
	</div>	
	<td style="width:100px;">
		<?php echo $this->Planet->getBiomassFormated(true); ?> 
	 </td>	
	
	<td>
	<?php echo $this->Planet->getPeopleCountAsString(true); ?>
	 </td>
</tr>	
</table>



<table border="0"  style="position:relative;top:-28px;left:325px;">
<tr>
	<td style="width:120px;">
		<a style="display: inline;" class="MenuEntry" href="index.php?Section=Planet&amp;Action=ShowPlanet">:T_NAVI_GENERALVIEW:</a></li>
	<td style="width:120px;height:25px;">
						<a class="MenuEntry" href="index.php?Section=Building">:T_NAVI_BUILDINGS:</a></li>
						</td>
						<td style="width:120px;">
						<a class="MenuEntry" href="index.php?Section=ReSearch">:T_NAVI_RESEARCH:</a></li>
						</td>
						
						<td style="width:120px;">
						<a class="MenuEntry" href="index.php?Section=Ships&amp;Action=ShowDock">:T_NAVI_SHIPYARD:</a></li>
						</td>
						
						<td style="width:110px;">
						<a class="MenuEntry" href="index.php?Section=Dock">:T_NAVI_DOCK:</a></li>
						</td>
						
						<td style="width:120px;">
						<a class="MenuEntry" href="index.php?Section=Trade">:T_NAVI_TRADE:</a></li>
						</td>
					</tr>	
					
					<tr>
						<td>
						<a class="MenuEntry" href="index.php?Section=Map">:T_NAVI_MAP:</a></li>
						</td>
						
						<td>
						<a class="MenuEntry" href="index.php?Section=Messages">:T_NAVI_MSG:</a></li>
						</td>
						
						<td>
						<a class="MenuEntry" href="index.php?Section=Allianz">:T_NAVI_ALLIANZ:</a></li>
						</td>
						
						<td>
						<a class="MenuEntry" href="index.php?Section=Skill&amp;Action=ShowUserSkills">:T_NAVI_SKILL:</a>
						</td>
						
						<td>
						<a class="MenuEntry" href="index.php?Section=User&amp;Action=ShowSettings">:T_NAVI_SETTINGS:</a>
				</td>
			<td style="width:100px;">
		<a class="MenuEntry" href="index.php?Section=Planet&amp;Action=ShowPlanetReName">:T_PLAN_RENAME:</a>
	</td>
</tr>	
</table>

<div style="position:relative;top:-84px;left:1148px; width:200px;">
<div style="width:100px;text-align:center;margin-bottom:3px;">
<?php echo date("d.m.Y"); ?>
</div>
<div style="width:100px;text-align:center;">
<?php echo date("H:i"); ?>
</div>
</div>

</div>