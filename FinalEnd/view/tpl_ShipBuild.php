<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/WarZone2.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">

<script type="text/javascript" src="javascript/Time.js"></script>
<script type="text/javascript" src="javascript/handling.js"></script>
<script type="text/javascript">
var MyTimer= new Timer();

function calculate(Id)
{
	if(!document.getElementById("tb_"+Id)){return false;}
	if(isNaN(document.getElementById("tb_"+Id).value)){return false;}
	document.getElementById("CREDITS"+Id).innerHTML=(document.getElementById("tb_"+Id).value*1)*(document.getElementById("CREDITSValue"+Id).innerHTML*1);
	document.getElementById("METAL"+Id).innerHTML=(document.getElementById("tb_"+Id).value*1)*(document.getElementById("METALValue"+Id).innerHTML*1);
	document.getElementById("CRYSTAL"+Id).innerHTML=(document.getElementById("tb_"+Id).value*1)*(document.getElementById("CRYSTALValue"+Id).innerHTML*1);
	document.getElementById("HYDROGEN"+Id).innerHTML=(document.getElementById("tb_"+Id).value*1)*(document.getElementById("HYDROGENValue"+Id).innerHTML*1);
	//document.getElementById("tb_"+Id).value;


}
</script>

<div id="Main">
  <h2>:T_SHIPBUIL_TITLE:</h2>

<div style="float:left;">
	:T_SHIPBUIL_QUEUE: <?php echo $this->ShipsInBuild;?> von <?php echo $this->MaxShips;?>
</div>

<div style="width:100%;text-align:right;margin-bottom:8px;">
<?php
if($this->IsPremium)
{
	echo '<a href ="index.php?Section=Ships&amp;Action=ShowShipBuildPremium" class="VIPLink"  >:T_ALL_DOCKS:</a>';
}
?>
</div>

<?php
if($this->ErrorString)
{
	echo"<h3 class='ErrorHeader' >".$this->ErrorString."</h3>";
}

?>

<table class="Table" width='90%' border='0'>

  <?php

  if($this->ShipBuildCollection->getCount()!=0)
  {
  	//var_dump($this->ShipBuildCollection);
  	echo  "
	<tr>
	<td colspan='3' ><h2>:T_SHIPBUIL_INPROGRESS:</h2> </td>

</tr>
<tr>
	<td class='header'>:T_SHOP_NUMBER: </td>
	<td class='header'>:T_SHIPBUIL_UNIT: </td>
	<td class='header'>:T_SHIPBUIL_TIMECOMPLETE:</td>
</tr>  ";




  	foreach($this->ShipBuildCollection as $ShipBuild)
  	{
  		//var_dump($ShipBuild->getShip());
  		echo "<tr>
				<td>".$ShipBuild->getCount()." </td>
				<td>".$ShipBuild->getShip()->getName()." </td>
				<td>".$ShipBuild->getCountDown()." </td>
			</tr>";	
  	}
  	echo "";
  }

  ?>



<?php

//var_dump($this->ShipCollection->getAll());
foreach($this->ShipCollection->getAll() as $Ship)
{
	//var_dump($Ship);
	echo "<tr>
	<td valign='top'>
		<table width='100%'>
			<tr>
	 			<td colspan='4' class='header'>".$Ship->getName()." (".$this->ShipUserCollection->getShipCountByShipId($Ship->getId()).")</td>
			 </tr>

			 <tr>
	 			<td width='80px'>		
					:T_HEADER_CREDITS::</td><td id='CREDITSValue".$Ship->getId()."'>".$Ship->getCredits()."</td>
					<td>|</td>
					<td style='width:100px;' id='CREDITS".$Ship->getId()."'></td>
			 
			</tr>
				<tr>
	 			<td>	
					:T_HEADER_METAL::</td><td id='METALValue".$Ship->getId()."'>".$Ship->getMetall()."</td><td>|</td><td id='METAL".$Ship->getId()."'></td>
			 </tr>
				<tr>
	 			<td>
					:T_HEADER_CRYSTAL::</td><td id='CRYSTALValue".$Ship->getId()."'>".$Ship->getCristal()."</td><td>|</td><td id='CRYSTAL".$Ship->getId()."'></td>
			 </tr>
				<tr>
	 			<td>
					:T_HEADER_HYDROGEN::</td><td id='HYDROGENValue".$Ship->getId()."'>".$Ship->getHydrogen()."</td> <td>|</td><td id='HYDROGEN".$Ship->getId()."'></td>
				</tr>
			</table>
			</td>
			<td>
			<table width='100%'>
				<tr>
	 				<td colspan='2' class='header'>
						:T_SHIPBUIL_PROPERTIES::
					</td> 
				</tr>
				<tr>
				 <td>		
					:T_GROUP_DMG::</td><td>".$Ship->getDmg()."
				</td> 
				</tr>
				<tr>
				 <td>		
					:T_GROUP_ARMOR::</td><td>".$Ship->getAmor()."
				</td>
			</tr>
			<tr>
				 <td>		
					:T_GROUP_HITP::</td><td>".$Ship->getHealth()."
				</td>
			</tr>
			<tr>
				 <td>		
					:T_GROUP_SPEED::</td><td>".$Ship->getSpeed()."
				</td>
			</tr>
			<tr>
				 <td>		
					:T_GROUP_CAPACITY::</td><td>".$Ship->getStorage()."
				</td>
				</tr>
			<tr>
				 <td>		
					:T_SHIPBUIL_TIMEAMMOUNT::</td><td>".$Ship->getBuildTimeFormated()."
				</td>
			</tr>
			
		</table>
	</td>";
	echo '<td >	
		<table >
<tr>
 <td><input type="button" value="1" onclick="load(\''.$Ship->getId().'\',1,'.$Ship->getBuildTime().');calculate('.$Ship->getId().')"> </td>
 <td><input type="button" value="5" onclick="load(\''.$Ship->getId().'\',5,'.$Ship->getBuildTime().');calculate('.$Ship->getId().')"> </td>
 <td><input type="button" value="10" onclick="load(\''.$Ship->getId().'\',10,'.$Ship->getBuildTime().');calculate('.$Ship->getId().')"> </td>
 <td><input type="button" value="20" onclick="load(\''.$Ship->getId().'\',20,'.$Ship->getBuildTime().');calculate('.$Ship->getId().')"> </td>
 <td><input type="button" value="50" onclick="load(\''.$Ship->getId().'\',50,'.$Ship->getBuildTime().');calculate('.$Ship->getId().')"> </td>
</tr>
<tr>
 <td colspan="5">
   <form action="index.php?Section=Ships&amp;Action=BuildShips&amp;ShipId='.$Ship->getId().'" method="post" >
			<input id="tb_'.$Ship->getId().'" onchange="calculate('.$Ship->getId().')" type="Text" name="i_Count" value="" size="4" maxlength="4" />
			<input type="Submit" name="" value=":T_SHIPBUIL_BULIT:" />
		</form>

  </td>
</tr>

<tr>
 <td colspan="4" id="l_'.$Ship->getId().'">

 </td>
</tr>

</table>
	</td> ';
echo "</tr>"; 
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