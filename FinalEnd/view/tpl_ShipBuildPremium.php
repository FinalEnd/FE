<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/WarZone2.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">

<script type="text/javascript" src="javascript/Time.js"></script>
<script type="text/javascript" src="javascript/handling.js"></script>
<script type="text/javascript">
var MyTimer= new Timer();
</script>
<div id="Main">
  <h2 >:T_SHIPBUIL_TITLE:</h2>

<?php
echo "<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";

?>

  <table class="DataTable" width="100%"  >
<tr>
<td class='header' width="20px"></td>
<td class='header' >:T_GROUP_NAME:</td>
 <td class='header' >:T_BUILDING_TEXT5:</td>
 <td class='header' ><img src="./images/units/Drone_F.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_SHIP_NAMEDRONE:" /> </td>
 <td class='header' ><img src="./images/units/TransporterSmall_F.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_SHIP_NAMETRANS:" /> </td>
 <td class='header' ><img src="./images/units/Transporter_F.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_SHIP_NAMEHTRANS:" /> </td>
 <td class='header' ><img src="./images/units/Hunter_F.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_SHIP_NAMEHUNTER:" /> </td>
 <td class='header' ><img src="./images/units/HunterBig_F.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_SHIP_NAMEHHUNTER:" /> </td>

 <td class='header' ><img src="./images/units/Bomber_F.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_SHIP_NAMEBOMB:" /> </td>
 <td class='header' ><img src="./images/units/BattleShip_F.png" width="20px" height="20px" class="Icons" alt="Treibstoff" title=":T_SHIP_NAMEBATTLE:" /> </td>

<td class='header'></td>
</tr>
<?php
  if($this->IsPremium)
{
	
	

	//var_dump($this->ShipCollection->getAll());
	$ShipFinder = new ShipFinder();
	foreach($this->PlanetCollection as $Planet)
	{
		echo '<tr><td rowspan="2" >
		<a href="index.php?Section=ChangeActivePlanet&D=Ships&cb_Planet='.$Planet->getId().'&Action=ShowDock">
		<img src="./images/planets/'.$Planet->getPicture().'" width="20px" height="20px" class="Icons" alt="Route" title="'.$Planet->getName().'" /> 
		</a>
		</td>';
		echo '<td class="left" rowspan="2"><a href="index.php?Section=ChangeActivePlanet&D=Ships&cb_Planet='.$Planet->getId().'&Action=ShowDock">'.$Planet->getName().'</a></td>';
		echo '<td >'.$ShipFinder->countShipsInBuild($Planet->getId()).' / ';
		$DockLevel = $Planet->getBuildingCollection()->getByTypeId(7)->getLevel();
		if ($DockLevel < 5)
		{
			if ($DockLevel == 0)
				echo '0';
			else
				echo '2';
		} else
		{
			echo '5';
		}
		echo '</td>';		
		$ShipCollection=$Planet->getShipCollection();    

		echo '<form action="index.php?Section=Ships&amp;Action=BuildShipsPremium&amp;PlanetId='.$Planet->getId().'" method="post" >';
	
		if($DockLevel>0)
		{
			echo '<td style="text-align:center"><input id="tb_drone" type="Text" name="tb_drone" value="" size="3" maxlength="4" /></td>';
		} else
			echo '<td >X</td>';
		
		if($DockLevel>1)
		{
			echo '<td style="text-align:center"><input id="tb_tsmall" type="Text" name="tb_tsmall" value="" size="3" maxlength="4" /></td>';
		}else
			echo '<td >X</td>';
		if($DockLevel>7)
		{
			echo '<td style="text-align:center"><input id="tb_tbig" type="Text" name="tb_tbig" value="" size="3" maxlength="4" /></td>';
		}else
			echo '<td >X</td>';
		
		
		if($DockLevel>0)
		{
			echo '<td style="text-align:center"><input id="tb_hunter" type="Text" name="tb_hunter" value="" size="3" maxlength="4" /></td>';
		}else
			echo '<td >X</td>';
		if($DockLevel>2)
		{
			echo '<td style="text-align:center"><input id="tb_hhunter" type="Text" name="tb_hhunter" value="" size="3" maxlength="4" /></td>';
		}else
			echo '<td >X</td>';

		if($DockLevel>=5)
		{
			echo '<td style="text-align:center"><input id="tb_bomber" type="Text" name="tb_bomber" value="" size="3" maxlength="4" /></td>';
		}else
			echo '<td >X</td>';
		if($DockLevel>9)
		{
			echo '<td style="text-align:center"><input id="tb_battleship" type="Text" name="tb_battleship" value="" size="3" maxlength="4" /></td>';
		}else
			echo '<td >X</td>';
		
	
		echo '<td  rowspan="2"><input type="Submit" name="" value=":T_SHIPBUIL_BULIT:" />
			
			</td>';
	echo '</tr>';
	
		echo '<tr style=""><td>';

		echo '<td style="text-align:center">'.$ShipCollection->getShipCountByShipId(2).'</td>';


		echo '<td >'.$ShipCollection->getShipCountByShipId(7).'</td>';

		echo '<td >'.$ShipCollection->getShipCountByShipId(8).'</td>';

		echo '<td >'.$ShipCollection->getShipCountByShipId(3).'</td>';

		echo '<td >'.$ShipCollection->getShipCountByShipId(4).'</td>';

		
		echo '<td >'.$ShipCollection->getShipCountByShipId(5).'</td>';
		
		echo '<td >'.$ShipCollection->getShipCountByShipId(6).'</td>';
		

		echo '<td>
			</form>
			</td>';
	echo '</tr>';
	
		echo '<tr><td colspan="11"><hr /></td> </tr>';
	
	

	
	
	}
}
?>


</table>
</div>

</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>

