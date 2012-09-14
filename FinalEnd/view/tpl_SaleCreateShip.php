<?php
include("tpl_IngameHeaderNew.php");
?>


<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Trade.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">


<h2 style="margin-bottom:5px;">:T_SHOP_SHIPTITLE:</h2>

 <?php
 if($this->ErrorString)
 {
 	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
 }
 ?>
 <h3>:T_SHOP_CREATEAUC:</h3></td>

<div style="width:100%;text-align:right;margin-bottom:8px;">
	<a class="VIPLink" href="index.php?Section=Trade&amp;Action=ShowUnits">:T_SHOP_FLEETS:</a>
</div>



<table class="DataTable" width="100%">
<tr>
 <td class='header'>:T_GROUP_NAME: </td>
 <td class='header'><img src="./images/design/icons/damage.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_DMG:" /> </td>
 <td class='header'><img src="./images/design/icons/speed.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_SPEED:" /> </td>
 <td class='header'><img src="./images/design/icons/armour.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_ARMOR:" /> </td>
 <td class='header'><img src="./images/design/icons/hitpoints.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_HITP:" /> </td>
 <td class='header'><img src="./images/design/icons/health.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_HEALTH:" /> </td>
 <td class='header'><img src="./images/design/icons/capacity.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_CAPACITY:" /> </td>
 <td class='header'>:T_GROUP_LEVEL: </td>
 <td class='header'>:T_HEADER_CREDITS: </td>
 <td class='header'> </td>
</tr>
 <?php


 if($this->SaleCollection->getCount()!= 0)
 {
 	//var_dump($this->SaleCollection);
 	foreach($this->SaleCollection as $Sale)
 	{
 		echo '
       	  <tr onmouseover="this.style.backgroundColor=\'#5F5F5F\'" onmouseout="this.style.backgroundColor=\'\'">
	          <td>'.$Sale->getUnit()->getName().'</td>
			 <td>'.$Sale->getUnit()->getDMG().' </td>
			 <td>'.$Sale->getUnit()->getSpeed().' </td>
			 <td>'.$Sale->getUnit()->getAmor().' </td>
			 <td>'.$Sale->getUnit()->getHealts().' </td>
			 <td>'.$Sale->getUnit()->getStateString().' </td>
			 <td>'.$Sale->getUnit()->getStorage().' </td>
			<td> <img style="width:20px" src ="./images/units/Level/'.$Sale->getUnit()->getLevel().'.png" title =":T_GROUP_LEVEL: '.$Sale->getUnit()->getLevel().'" /></td>
			<td>'.$Sale->getPrice().' </td>
	          <td><a href="index.php?Section=Trade&amp;Action=CancelShipAuction&amp;i_Id='.$Sale->getId().'" style="color:#FFFFFF;">:T_SHOP_REMOVE:</a> </td>
	         </tr>  ';
 	}
	

 }
 if($this->UnitCollection->getCount()!= 0)
 {
 	foreach($this->UnitCollection as $Sale)
 	{
 		echo '<form action="index.php?Section=Trade&amp;Action=CreateShipAuction&amp;i_Id='.$Sale->getId().'" method="post" >
       	  <tr onmouseover="this.style.backgroundColor=\'#5F5F5F\'" onmouseout="this.style.backgroundColor=\'\'">
	          <td>'.$Sale->getName().'</td>
			 <td>'.$Sale->getDMG().' </td>
			 <td>'.$Sale->getSpeed().' </td>
			 <td>'.$Sale->getAmor().' </td>
			 <td>'.$Sale->getHealts().' </td>
			 <td>'.$Sale->getStateString().' </td>
			 <td>'.$Sale->getStorage().' </td>
			<td> <img style="width:20px" src ="./images/units/Level/'.$Sale->getLevel().'.png" title =":T_GROUP_LEVEL: '.$Sale->getLevel().'" /></td>
			<td ><input type="Text" name="i_Price" value="" size="" maxlength=""> </td>
	          <td><input type="Submit" name="" value=":T_SHOP_CREATE:"> </td>
	         </tr>   </form>';
 	}
 }
 ?>
</table>
</div>


</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>
