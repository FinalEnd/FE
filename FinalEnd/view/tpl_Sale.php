<?php
include("tpl_IngameHeaderNew.php");
?>


<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Trade.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">


<h2 style="margin-bottom:5px;">:T_SHOP_TITLE:</h2>
 <?php
 if($this->ErrorString)
 {
 	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
 }
 ?>

<h3>:T_SHOP_RESTITLE:</h3>
<div style="float:left;"><a class="VIPLink" href="index.php?Section=Trade&amp;Action=ShowCreateAuction">:T_SHOP_OWNSTUFF:</a></div>

<div style="width:100%;text-align:right;margin-bottom:8px;">
	<?php
	if($this->ShowShipAuction)
	{
		echo '<a class="VIPLink" href="index.php?Section=Trade&amp;Action=ShowUnits">:T_SHOP_FLEETS:</a>';
	}
	?>

</div>




Filtern:
	<select name="cb_FilterRessource" onchange="window.location.href='index.php?Section=Trade&amp;Action=showMarket&amp;cb_FilterRessource='+this.value">
	<option <?php if($this->FilterRessource=="All"){echo "selected";} ?> value="All">:T_SHOP_ALL: </option>
	<option <?php if($this->FilterRessource=="Metall"){echo "selected";} ?> value="Metall">:T_HEADER_METAL: </option>
	<option <?php if($this->FilterRessource=="Cristal"){echo "selected";} ?> value="Cristal">:T_HEADER_CRYSTAL: </option>
	<option <?php if($this->FilterRessource=="Hydrogen"){echo "selected";} ?> value="Hydrogen">:T_HEADER_HYDROGEN: </option>
	<option <?php if($this->FilterRessource=="Biomass"){echo "selected";} ?> value="Biomass">:T_HEADER_BIOMAS: </option>
	 </select>

	
	<br />
<table class="DataTable" width="100%">
<tr>
 <td class="header">:T_SHOP_RESSOURCE: </td>
 <td class="header">:T_SHOP_AMMOUNT: </td>
 <td class="header">:T_PLANET_FROM: </td>
 <td class="header">:T_HEADER_CREDITS: </td>
 <td class="header">:T_SHOP_PRICEPERUNIT:</td>
 <td class="header">



 </td>
</tr>
 <?php


 if($this->SaleCollection->getCount()!= 0)
 {
 	//var_dump($this->SaleCollection);
 	foreach($this->SaleCollection as $Sale)
 	{
 		echo '
	<tr onmouseover="this.style.backgroundColor=\'#5F5F5F\'" onmouseout="this.style.backgroundColor=\'\'"  >
	 <td>'.$Sale->getName().'</td>
	 <td>'.$Sale->getCount().' </td>
	 <td>'.$Sale->getCreator()->getName().' </td>
	 <td>'.$Sale->getPrice().' </td>
	 <td>'.$Sale->getAveragePriceFormatet().' </td>
	 <td><a href="index.php?Section=Trade&amp;Action=Buy&amp;i_Id='.$Sale->getId().'&amp;Start='.$this->Start.'&amp;cb_FilterRessource='.$this->FilterRessource.'" style="color: #FFFFFF;" >:T_SHOP_BUYIT:</a> </td>
	</tr>  ';
 	}

 }
 ?>
<tr>
 <td><?php
 if($this->LastPage)
 {
 	echo"<a id='VIPLink' href='index.php?Section=Trade&amp;Start=".$this->LastCount."&amp;cb_FilterRessource=".$this->FilterRessource."' >:T_GROUP_BACK:</a>";
 }
 ?></td>
 <td colspan="4" ></td>

 <td >
    

    
  <?php
  if($this->NextPage)
  {
  	echo"<a id='VIPLink' href='index.php?Section=Trade&amp;Start=".$this->NextCount."&amp;cb_FilterRessource=".$this->FilterRessource."' >:T_GROUP_GOON:</a>";
  }
  ?>


 </td>
</tr>

</table>
<br><br><br>
<table width ="100%">
<tr>
    <td class="header">:T_SALE_AVERAGE:</td>
	<td class="header">:T_HEADER_METAL:</td>
	<td class="header">:T_HEADER_CRYSTAL:</td>
	<td class="header">:T_HEADER_HYDROGEN:</td>
	<td class="header">:T_HEADER_BIOMAS:</td>
</tr>
<tr><td></td><?php
echo "<td>".round($this->Stats->getMetallSold()/$this->Stats->getMetallBought(),3)."</td>
	<td>".round($this->Stats->getCrystalSold()/$this->Stats->getCrystalBought(),3)."</td>
	<td>".round($this->Stats->getDeuteriumSold()/$this->Stats->getDeuteriumBought(),3)."</td>
	<td>".round($this->Stats->getFoodSold()/$this->Stats->getFoodBought(),3)."</td>
</tr>";?>
</table>

 </div>


</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>

