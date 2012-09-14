<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/WarZone.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">

<div style="height:500px;" id="Main">
  <h2>:T_GROUP_OVERVIEW:</h2>

<?php
if($this->ErrorString)
{
	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
}
?>
<p>
<a href ="index.php?Section=Dock&amp;Action=ShowGroupsCreate" class="VIPLink"  >:T_SHIPBUIL_TITLE:</a>
</p>

<table class="DataTable" width="100%" >
<tr>
<td class='header' width="20px"> </td>
 <td class='header'>:T_GROUP_NAME: </td>
 <td class='header'><img src="./images/design/icons/damage.png" width="20px" height="20px" class="Icons" alt=":T_GROUP_DMG:" title=":T_GROUP_DMG:" /> </td>
 <td class='header'><img src="./images/design/icons/speed.png" width="20px" height="20px" class="Icons" alt=":T_GROUP_SPEED:" title=":T_GROUP_SPEED:" /> </td>
 <td class='header'><img src="./images/design/icons/armour.png" width="20px" height="20px" class="Icons" alt=":T_GROUP_ARMOR:" title=":T_GROUP_ARMOR:" /> </td>
 <td class='header'><img src="./images/design/icons/hitpoints.png" width="20px" height="20px" class="Icons" alt=":T_GROUP_HITP:" title=":T_GROUP_HITP:" /> </td>
 <td class='header'><img src="./images/design/icons/health.png" width="20px" height="20px" class="Icons" alt=:T_GROUP_HEALTH:" title=":T_GROUP_HEALTH:" /> </td>
 <td class='header'><img src="./images/design/icons/capacity.png" width="20px" height="20px" class="Icons" alt=":T_GROUP_CAPACITY:" title=":T_GROUP_CAPACITY:" /> </td>
<td class='header'><img src="./images/Treibstoff.png" width="20px" height="20px" class="Icons" alt="Treibstoff" title=":T_HEADER_HYDROGEN:" /> </td>
<td class='header'><img src="./images/metal.png" width="20px" height="20px" class="Icons" alt="Metall" title=":T_HEADER_METAL:" /> </td>
<td class='header'><img src="./images/kristal.png" width="20px" height="20px" class="Icons" alt="Kristall" title=":T_HEADER_CRYSTAL:" /> </td>
<td class='header'><img src="./images/fleisch.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_HEADER_BIOMAS:" /> </td>
<td class='header'></td>
<td class='header'>:T_GROUP_ROUTE: </td>
<td class='header'>:T_GROUP_STATUS: </td>
</tr>
<?php

//var_dump($this->ShipCollection->getAll());
foreach($this->UnitCollection->getAll() as $Group)
{
	echo '
	<tr onMouseOver = \'this.bgColor="#5F5F5F"\' 
onMouseOut = \' this.bgColor=""\'>
	
	<td><img src="./images/units/'.$Group->getPicture().'_F.png" width="20px" height="20px" class="Icons" alt="'.$Group->getName().'" title="'.$Group->getName().'" /> </td>
 <td class="left">'.$Group->getName().' </td>
<td>'.$Group->getDMG().' </td>
 <td>'.$Group->getSpeed().' </td>
 <td>'.$Group->getAmor().' </td>
 <td>'.$Group->getHealts().' </td>
 <td>'.$Group->getStateString().' </td>
 <td>'.$Group->getStorage().' </td>

 <td>'.$Group->getStoredElement("t",true).' </td>
 <td>'.$Group->getStoredElement("m").' </td>
 <td>'.$Group->getStoredElement("c").' </td>
 <td>'.$Group->getStoredElement("b",true).' </td>
 <td align=center>';
	
	
	
	
	$Planet = $this->PlanetCollection->getPLanetsInRange($Group->getX(),$Group->getY(),UNIT_REPAIR_RANGE)->getByIndex(0);
	if($Planet->getId())
	{
		echo '<a style="color:#FFFFFF;" href="index.php?Section=Map&amp;X='.$Group->getX().'&amp;Y='.$Group->getY().'"> 
		<img src="./images/planets/'.$Planet->getPicture().'" style="width:32px;height:32px;" class="Icons" alt="Route" title="'.$Planet->getName().'" /></a>';
	} else
	{
		if($Group->getTask()->getId())
		{
			echo '<a style="color:#FFFFFF;" title=":T_GROUP_TOFLEET:" 
		href="index.php?Section=Map&amp;X='.$Group->getX().'&amp;Y='.$Group->getY().'">
		<img src="./images/design/icons/tomapwithTask.png" alt=":T_NAVI_MAP:" title=":T_NAVI_MAP:" /></a>';
		}else{
			echo '<a style="color:#FFFFFF;" title=":T_GROUP_TOFLEET:" 
		href="index.php?Section=Map&amp;X='.$Group->getX().'&amp;Y='.$Group->getY().'">
		<img src="./images/design/icons/tomapwithoutTask.png" alt=":T_NAVI_MAP:" title=":T_NAVI_MAP:" /></a>';
		}
	}
	
echo '</td> <td>';

$Route=$this->RouteCollection->getByUnit($Group);
	if($Route->getId())
	{
		echo '<img src="./images/design/icons/Route.png" style="width:32px;height:32px;" class="Icons" alt="Route" title="'.$Route->getName().'" /> ';
	} 
 echo '</td>
 <td>';
	echo $Group->getStateCollectionHTML();
 
echo '</td>


</tr>';	
}

?>
</table>
</div>
</div>	

</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>