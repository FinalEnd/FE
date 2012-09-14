<?php
include("tpl_IngameHeaderNew.php");
?>

<script type="text/javascript" src="javascript/Time.js"></script>

<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Planet.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">
  <h2>:T_BUILDING_HEADER:</h2>
<?php
	if($this->ErrorString)
	{
		echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
	}
?>

<?php
if($this->IsPremium)
{
	echo '<a href ="index.php?Section=Building&amp;Action=ShowBuildingsPremium" class="VIPLink"  >:T_BUILDINGS_ALLALLBUILDINGS:</a>';
}
?>

<table class="DataTable" style ="width:100%" border="0" >
<tr>
	<td class="header"></td>
	<td class="header">:T_GROUP_PLANET:</td>
	<td class="header">:T_BUILDING_TEXT1:</td>
	<td class="header"><img src="./images/design/buildings/HQ.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_HQ:" /></td>
	<td class="header"><img src="./images/design/buildings/Town.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_TOWN:" /></td>
	<td class="header"><img src="./images/design/buildings/Warhouse.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_STORAGE:" /></td>
	<td class="header"><img src="./images/design/buildings/fleisch.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_PLANT:" /></td>
	<td class="header"><img src="./images/design/buildings/metal.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_METALL:" /></td>
	<td class="header"><img src="./images/design/buildings/kristal.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_CRYSTAL:" /></td>
	<td class="header"><img src="./images/design/buildings/Treibstoff.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_HYDROGEN:" /></td>
	<td class="header"><img src="./images/design/buildings/Dock.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_DOCK:" /></td>
	<td class="header"><img src="./images/design/buildings/Lab.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_LAB:" /></td>
	<td class="header"><img src="./images/design/buildings/Trade.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_TRADECENTER:" /></td>
	<td class="header"><img src="./images/design/buildings/Communication.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_COMMUNICATIONCENTER:" /></td>
	<td class="header"><img src="./images/design/buildings/Defense.png" width="35px" height="35px" class="Icons" alt="" title=":T_BUILDING_HALO:" /></td>
</tr>
<?php
$TempCollection= $this->PlanetCollection;
for($i=0;$i<$TempCollection->getCount();$i++) 
 {
	$Planet=$TempCollection->getByIndex($i);
	echo "<tr onMouseOver = 'this.bgColor=\"#5F5F5F\"' 
onMouseOut = ' this.bgColor=\"\"' >";
	
	echo "	
	<td><a href='index.php?Section=ChangeActivePlanet&D=Building&cb_Planet=".$Planet->getId()."&Action=ShowDock'><img src=\"./images/planets/".$Planet->getPicture()."\" width=\"20px\" height=\"20px\" class=\"Icons\" alt=\"Route\" title=\"".$Planet->getName()."\" />
	</a></td>
	<td class='left'>
	<a href='index.php?Section=ChangeActivePlanet&D=Building&cb_Planet=".$Planet->getId()."&Action=ShowDock'>".$Planet->getName()."</a></td>
	<td>".$Planet->getBuildingCollection()->countInbuild()." / ".$Planet->getMaxBuildingsInBuild()."</td>";
	echo "<td>";
	if($Planet->getBuildingByType(1)->getInbuild())
	{
		echo $Planet->getBuildingByType(1)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(1)->getType()."' title=':T_BUILDING_HQ: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(1)->getLevel(true)."</a>";
	}
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(22)->getInbuild())
	{
		echo $Planet->getBuildingByType(22)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(22)->getType()."' title=':T_BUILDING_TOWN: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(22)->getLevel(true)."</a>";
	}
	
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(18)->getInbuild())
	{
		echo $Planet->getBuildingByType(18)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(18)->getType()."' title=':T_BUILDING_STORAGE: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(18)->getLevel(true)."</a>";
	}
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(4)->getInbuild())
	{
		echo $Planet->getBuildingByType(4)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(4)->getType()."' title=':T_BUILDING_PLANT: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(4)->getLevel(true)."</a>";
	}
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(2)->getInbuild())
	{
		echo $Planet->getBuildingByType(2)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(2)->getType()."' title=':T_BUILDING_METALL: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(2)->getLevel(true)."</a>";
	}
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(5)->getInbuild())
	{
		echo $Planet->getBuildingByType(5)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(5)->getType()."' title=':T_BUILDING_CRYSTAL: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(5)->getLevel(true)."</a>";
	}
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(8)->getInbuild())
	{
		echo $Planet->getBuildingByType(8)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(8)->getType()."' title=':T_BUILDING_HYDROGEN: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(8)->getLevel(true)."</a>";
	}
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(7)->getInbuild())
	{
		echo $Planet->getBuildingByType(7)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(7)->getType()."' title=':T_BUILDING_DOCK::T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(7)->getLevel(true)."</a>";
	}
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(19)->getInbuild())
	{
		echo $Planet->getBuildingByType(19)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(19)->getType()."' title=':T_BUILDING_LAB: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(19)->getLevel(true)."</a>";
	}
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(20)->getInbuild())
	{
		echo $Planet->getBuildingByType(20)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(20)->getType()."' title=':T_BUILDING_TRADECENTER: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(20)->getLevel(true)."</a>";
	}
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(21)->getInbuild())
	{
		echo $Planet->getBuildingByType(21)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(21)->getType()."' title=':T_BUILDING_COMMUNICATIONCENTER: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(21)->getLevel(true)."</a>";
	}
	echo "</td>";
	echo "<td>";
	if($Planet->getBuildingByType(23)->getInbuild())
	{
		echo $Planet->getBuildingByType(23)->getLevel()."^";
	}else
	{
		echo "<a style='color:#FFFFFF;' href='index.php?Section=Building&amp;PlanetId=".$Planet->getId()."&amp;Action=UpdateBuildings&amp;PremiumView=true&amp;BuildingId=".$Planet->getBuildingByType(23)->getType()."' title=':T_BUILDING_HALO: :T_BUILDING_BUILD_TITLE:'>".$Planet->getBuildingByType(23)->getLevel(true)."</a>";
	}
	echo "</td>";		
	echo "</tr>";
 }


?>

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