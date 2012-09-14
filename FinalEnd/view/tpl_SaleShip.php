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

<h3>:T_SHOP_SHIPTITLE:</h3>	

<div style="float:left"><a class="VIPLink" href="index.php?Section=Trade&amp;Action=ShowCreateShipAuction">:T_SHOP_OWNSTUFF:</a></div>

<div style="width:100%;text-align:right;margin-bottom:8px;"><a class="VIPLink" href="index.php?Section=Trade">:T_SHOP_GOODS:</a></div>

<table class="DataTable" width="100%">
<tr>
 <td class='header'>:T_GROUP_NAME: </td>
 <td class='header'><img src="./images/design/icons/damage.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_DMG:" /> </td>
 <td class='header'><img src="./images/design/icons/speed.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_SPEED:" /> </td>
 <td class='header'><img src="./images/design/icons/armour.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_ARMOR:" /> </td>
 <td class='header'><img src="./images/design/icons/hitpoints.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_HITP:" /> </td>
 <td class='header'><img src="./images/design/icons/health.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_HEALTH:" /> </td>
 <td class='header'><img src="./images/design/icons/capacity.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_GROUP_CAPACITY:" /> </td>


 <td class='header'> <img src='./images/units/BattleShip_F.png' alt='' width="20px" height="20px" title=':T_SHIP_NAMEBATTLE:'  class='Icons'> </td>
 <td class='header'> <img src='./images/units/Bomber_F.png' alt='' width="20px" height="20px" title=':T_SHIP_NAMEBOMB:'  class='Icons'> </td>
 <td class='header'> <img src='./images/units/HunterBig_F.png' alt='' width="20px" height="20px" title=':T_SHIP_NAMEHHUNTER:' border='0' class='Icons'> </td>
 <td class='header'> <img src='./images/units/Hunter_F.png' alt='' width="20px" height="20px" title=':T_SHIP_NAMEHUNTER:' border='0' class='Icons'> </td>
 <td class='header'> <img src='./images/units/Transporter_F.png' width="20px" height="20px" alt='' title=':T_SHIP_NAMEHTRANS:' border='0' class='Icons'> </td>
 <td class='header'> <img src='./images/units/TransporterSmall_F.png' alt='' width="20px" height="20px" title=':T_SHIP_NAMETRANS:' border='0' class='Icons'> </td>
 <td class='header'> <img src='./images/units/Drone_F.png' alt='' width="20px" height="20px" title=':T_SHIP_NAMEDRONE:' border='0' class='Icons'> </td>
 <td class='header'>:T_GROUP_LEVEL: </td>
 <td class='header'>:T_PLANET_FROM: </td>
 <td class='header'>:T_HEADER_CREDITS: </td>
 <td class='header'>



 </td>
</tr>
 <?php


 if($this->UnitSale->getCount()!= 0)
 {
 	//var_dump($this->SaleCollection);
 	foreach($this->UnitSale as $Sale)
 	{
 		echo '
	<tr onmouseover="this.style.backgroundColor=\'#5F5F5F\'" onmouseout="this.style.backgroundColor=\'\'"  >
	 <td>'.$Sale->getUnit()->getName().'</td>
	 <td>'.round($Sale->getUnit()->getDMG()).' </td>
	 <td>'.round($Sale->getUnit()->getSpeed()).' </td>
     <td>'.round($Sale->getUnit()->getAmor()).' </td>
     <td>'.round($Sale->getUnit()->getHealts()).' </td>
     <td>'.$Sale->getUnit()->getStateString().' </td>
     <td>'.$Sale->getUnit()->getStorage().' </td>
	 
	 <td>'.$Sale->getUnit()->getShipCountByType("bs").' </td>
	 <td>'.$Sale->getUnit()->getShipCountByType("b").' </td>
	 <td>'.$Sale->getUnit()->getShipCountByType("hh").' </td>
	 <td>'.$Sale->getUnit()->getShipCountByType("sh").' </td>
	 <td>'.$Sale->getUnit()->getShipCountByType("lt").' </td>
	 <td>'.$Sale->getUnit()->getShipCountByType("st").' </td>
	 <td>'.$Sale->getUnit()->getShipCountByType("d").' </td>
	 <td> <img style="width:20px" src ="./images/units/Level/'.$Sale->getUnit()->getLevel().'.png" title =":T_GROUP_LEVEL: '.$Sale->getUnit()->getLevel().'" /></td>
     <td>'.$Sale->getUser()->getName().' </td>
	 <td>'.$Sale->getPrice().' </td>';?>
	
	<?php
	
	if($this->CanWorkOn)
		{
			echo '<td><a href="index.php?Section=Trade&amp;Action=BuyShip&amp;i_Id='.$Sale->getId().'&amp;Start='.$this->Start.'" style="color: #FFFFFF;" >:T_SHOP_BUYIT:</a> </td>';
		}else
		{
			echo '<td><a href="#"><img src="images/system/No.png" width="20px"  title="Ihr Planet wird belagert." alt=""/></a>';
		}
	
	 ?>
	</tr><?php
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

 </div>


</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>

