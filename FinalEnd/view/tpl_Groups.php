<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/WarZone.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">


<script type="text/javascript">

  	function check(Name)
	{
		if(confirm("Sind Sie sicher das sie die Flotte "+Name+" Zerstören wollen? \nDer Rang der Flotte geht dabei verloren."))
		{
			return true;
		}
		return false;
	}

</script>



<div style="height:500px;" id="Main">
  <h2>:T_GROUP_OVERVIEW:</h2>

<?php
if($this->ErrorString)
{
	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
}
?>
<p>
<a href ="index.php?Section=Dock&amp;Action=ShowGroupsCreate" class="VIPLink"  >:T_GROUP_NEWONE:</a>
<?php
	if($this->IsPremium)
	{
		echo '<a href ="index.php?Section=Dock&amp;Action=ShowShipsPremium" class="VIPLink"  >:T_GROUP_ALLSHIPS:</a>';
	}
?>
</p>
<table class="DataTable" width="100%" >
<tr>
<td class='header' width="20px"> </td>
 <td class='header'>:T_GROUP_NAME: </td>
 <td class='header'><img src="./images/design/icons/damage.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_DMG:" /> </td>
 <td class='header'><img src="./images/design/icons/speed.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_SPEED:" /> </td>
 <td class='header'><img src="./images/design/icons/armour.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_ARMOR:" /> </td>
 <td class='header'><img src="./images/design/icons/hitpoints.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_HITP:" /> </td>
 <td class='header'><img src="./images/design/icons/health.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_HEALTH:" /> </td>
 <td class='header'><img src="./images/design/icons/capacity.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_CAPACITY:" /> </td>
<td class='header'><img src="./images/Treibstoff.png" width="20px" height="20px" class="Icons" alt="Treibstoff" title=":T_HEADER_HYDROGEN:" /> </td>
<td class='header'><img src="./images/metal.png" width="20px" height="20px" class="Icons" alt="Metall" title=":T_HEADER_METAL:" /> </td>
<td class='header'><img src="./images/kristal.png" width="20px" height="20px" class="Icons" alt="Kristall" title=":T_HEADER_CRYSTAL:" /> </td>
<td class='header'><img src="./images/fleisch.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_HEADER_BIOMAS:" /> </td>
<td class='header'>:T_GROUP_STATUS: </td>
 <td class='header' width="20px"></td>
<td class='header' width="20px"></td>
 <td class='header' align="center" width="20px"> </td>
</tr>
<?php

//var_dump($this->ShipCollection->getAll());
foreach($this->UnitCollection->getAll() as $Group)
{
	echo '
	<tr>
	
	<td><img src="./images/units/'.$Group->getPicture().'_F.png" width="20px" height="20px" class="Icons" alt="'.$Group->getName().'" title="'.$Group->getName().'" /> </td>
 <td>'.$Group->getName().' </td>
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

 <td>';
	echo $Group->getStateCollectionHTML();
	
	echo '</td>

 <td align="center">';
	if($Group->getState()<1 || $Group->getStatecollection()->getCount())
	{
		
		if($this->CanWorkOn)
		{
			echo '<a href="index.php?Section=Dock&Action=RepairUnit&amp;UId='.$Group->getId().'&amp;Start='.$this->ActivePage.'"><img src="images/system/Repaire.png" width="20px"  title=":T_GROUP_REPAIR: '.$Group->getMissingHealth().' :T_HEADER_METAL:" alt="Reparieren"/></a>';
		}else
		{
			echo '<a href="#"><img src="images/system/No.png" width="20px"  title=":T_GROUP_REPAIRNOTPOSS:" alt="Ihr Planet wird belagert. Reparieren nicht möglich"/></a>';
		}
	}  
	echo'</td>
 <td align="center"><a href="index.php?Section=Dock&amp;Action=ShowLoading&amp;UnitId='.$Group->getId().'"><img src="images/system/Store.png" width="20px"  title=":T_GROUP_LOAD:" alt="Beladen"/></a> </td>';

	if($this->CanWorkOn)
	{
		echo'<td align="center"><a onclick="return check(\''.$Group->getName().'\')" href="index.php?Section=Dock&amp;Action=DestroyUnit&amp;UnitId='.$Group->getId().'&amp;Start='.$this->ActivePage.'"><img src="images/system/close32.png" width="20px"  title=":T_GROUP_PENSION:" alt="Flotte Auflösen"/></a> </td>';
	}else
	{
		echo'<td align="center"><a href="#"><img src="images/system/No.png" width="20px"  title=":T_GROUP_PENSIONNOTPOSS:" alt="Ihr Planet wird belagert. Flotte Auflösen nicht möglich"/></a> </td>';
	}
	echo'</tr>
'; 
}
?>


<tr>
<td colspan="2" width="20px">
<?php 
if($this->Back)
{
	echo "<a href='./index.php?Section=Dock&amp;Start=".$this->BackStart."'>:T_GROUP_BACK:</a>";
}
?>
 </td>
 <td colspan="11" > </td>
 <td colspan="2" align="center" width="20px">
<?php 
if($this->Next)
{
	echo "<a href='./index.php?Section=Dock&amp;Start=".$this->Start."'>:T_GROUP_GOON:</a>";
}
?>

 </td>
</tr>	

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