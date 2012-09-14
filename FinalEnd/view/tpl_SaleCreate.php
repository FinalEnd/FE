<?php
include("tpl_IngameHeaderNew.php");
?>

<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Trade.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">


<h2>:T_SHOP_TITLE:</h2>
 <?php
 if($this->ErrorString)
 {
 	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
 }
 ?>
<h3>:T_SHOP_CREATEAUC:</h3>

<table class="DataTable" width="100%">
<form action="index.php?Section=Trade&amp;Action=CreateAuction" method="post" >
 <tr>
 <td >

   <select name="cb_Ress" size="">
   <option value="Metall">:T_HEADER_METAL: </option>
   <option value="Cristal">:T_HEADER_CRYSTAL: </option>
   <option value="Hydrogen">:T_HEADER_HYDROGEN: </option>
   <option value="Biomass">:T_HEADER_BIOMAS: </option>
   </select>


  </td>
 <td >:T_SHOP_AMMOUNT::<input type="Text" name="i_Count" value="" size="" maxlength=""> </td>
 <td >:T_SHOP_PRICECRED:<input type="Text" name="i_Price" value="" size="" maxlength=""> </td>
 <td colspan="2" ><input type="Submit" name="" value=":T_SHOP_CREATE:"> </td>
</tr>
 </form>

<tr>
 <td class='header'>:T_SHOP_RESSOURCE: </td>
 <td class='header'>:T_SHOP_AMMOUNT: </td>
 <td class='header'>:T_PLANET_FROM: </td>
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
	          <td>'.$Sale->getName().'</td>
	          <td>'.$Sale->getCount().' </td>
	          <td>'.$Sale->getCreator()->getName().' </td>
	          <td>'.$Sale->getPrice().' </td>
	          <td><a href="index.php?Section=Trade&amp;Action=CancelAuction&amp;i_Id='.$Sale->getId().'" style="color:#FFFFFF;">:T_SHOP_REMOVE:</a> </td>
	         </tr>  ';
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