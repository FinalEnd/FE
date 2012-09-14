<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/WarZone.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">

<script type="text/javascript" src="javascript/Time.js"></script>
<script type="text/javascript" src="javascript/System.js"></script>
<script type="text/javascript" src="javascript/handling.js"></script>
<script type="text/javascript">
var MyTimer= new Timer();
</script>
<div id="Main">
  <h2 >:T_GROUP_OVERVIEW2:</h2>

<?php
echo "<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";

?>

<?php
echo "<p><div style='float:left;'>:T_GROUP_MAXSHIPS:: ".$this->MaxUnitsCount."</div><div style='padding-left:10px;float:left;'>:T_GROUP_NEEDED_PEOPLE:: </div>
<div id='PeopleCount'> 0</div></p>";

?>

<table class="Table" border="0" width="80%" >
  <form action="index.php?Section=Dock&amp;Action=AddGroup" method="post" >
<?php
$i=0;
//var_dump($this->ShipCollection->getAll());
foreach($this->ShipCollection->getAll() as $Ship)
{
	//var_dump($Ship);
	echo "<tr>
	<td width='50%'>
		<table width='100%' >
			<tr>
	 			<td Colspan='3' class='header' >".$Ship->getName()." (".$this->ShipCollection->getShipCountByShipId($Ship->getId()).")</td>
			 </tr>
				<tr>
				 <td width='150px'>		
					:T_GROUP_DMG::</td><td>".$Ship->getDmg()."
				</td> 
				</tr>
				<tr>
				 <td width='150px'>		
					:T_GROUP_ARMOR::</td><td>".$Ship->getAmor()."
				</td>
			</tr>
			<tr>
				 <td width='150px'>		
					:T_GROUP_HITP::</td><td>".$Ship->getHealth()."
				</td>
			</tr>
			<tr>
				 <td width='150px'>		
					:T_GROUP_SPEED::</td><td>".$Ship->getSpeed()."
				</td>
			</tr>
			<tr>
				 <td width='150px'>		
					:T_GROUP_CAPACITY::</td><td>".$Ship->getStorage()."
				</td>
				</tr>
				
				<tr>
				 <td width='150px'>		
					:T_GROUP_PEOPLE_CAPACITY::</td><td>".$Ship->getCrew()."
				</td>
				</tr>
		</table>
	</td>";
	echo '<td width="50%" >	
	
	
	<table >
<tr>
 <td><input type="button" value=" 5" onclick="load(\'Unit_'.$Ship->getId().'\',5);calculatePeople(this);"> </td>
 <td><input type="button" value="10" onclick="load(\'Unit_'.$Ship->getId().'\',10);calculatePeople(this);"> </td>
 <td><input type="button" value="20" onclick="load(\'Unit_'.$Ship->getId().'\',20);calculatePeople(this);"> </td>
 <td><input type="button" value="50" onclick="load(\'Unit_'.$Ship->getId().'\',50);calculatePeople(this);"> </td>
</tr>
<tr>
 <td colspan="4">
   <input class="ShipCount" type="Text" id="tb_Unit_'.$Ship->getId().'" name="i_Unit_'.$Ship->getId().'" value="" onchange="calculatePeople(this);" size="4" maxlength="4" />
	<input class="ShipCrew" type="hidden" id="i_Unit_Crew_'.$i.'" name="i_Unit_Crew_'.$i.'" value="'.$Ship->getCrew().'" size="4" maxlength="4" />
  </td>
</tr>
</table>
	
	</td> ';
	echo "</tr>"; 
	$i++;
}
?>
	<tr>
				 <td class='header' colspan="2">		
					:T_GROUP_EXTENS:
				</td>
			</tr>
	 <tr>
		<td>		
			 <select name="i_ExtentionOne" size="">
			   <option value="0" onclick="document.getElementById(tb_ExtOne).innerHTML='Kein Upgrade ausgewählt'">-------------</option>
			   <?php
					echo $this->OneString;
			   ?>
			   </select>
		</td>
	<td>		
			<select name="i_ExtentionTwo" size="">
			   <option value="0" onclick="document.getElementById('tb_ExtTwo').innerHTML='Kein Upgrade ausgewählt'">-------------</option>
				<?php
					echo $this->TowString;
				?>
			 </select>
		</td>
	</tr>
	
	<tr>
		<td id="tb_ExtOne" style="padding-right:30px">		
			:T_GROUP_UPGADENOTINST: 
		</td>
		<td id="tb_ExtTwo" style="padding-right:30px">		
			:T_GROUP_UPGADENOTINST: 
		</td>
	</tr>  
	

	<tr>
		<td colspan="2" class='header'>
		:T_GROUP_NAMEOFNEW::
	  </td>
	</tr>
		   

	  <tr>

<tr>
	<td colspan="2">
	 <input type="text" name="t_Name" value="" size="30" maxlength="90" />
	 </td>
	</tr>
		   


	  <tr>
	<td>
	 <input type="Submit" name="" value=":BT_GROUP_CREATE:" />
	 </td>
	</tr>
</table>
</div>
 </form>

</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>