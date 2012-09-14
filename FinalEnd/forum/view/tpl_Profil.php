<?php

include "view/tpl_Menu.php";

?>

<h1>Übersicht zu deinem Profil</h1>

<table >
<tr>
 <td><a href="index.php?section=Profil&amp;action=ShowChangePass" style="padding-right: 10px;"><img src='images/passwortwechseln.png' alt='zurück' /></a><!--<a><img style="height:27px;" src="./images/Profil.png"><img style="width:115px;height:27px;" src="./images/Bearbeiten.png"></a>-->
<a href="index.php?section=Profil&amp;action=ShowUserProfil" style="padding-right: 10px;"><img src='images/meinedaten.png' alt='zurück' /></a><!--<a><img style="height:27px;" src="./images/Profil.png"><img style="width:115px;height:27px;" src="./images/Bearbeiten.png"></a>-->
<a href="index.php?section=Profil&amp;action=ShowChangeProfil" style="padding-right: 10px;"><img src='images/datenbearbeiten.png' alt='zurück' /></a><!--<a><img style="height:27px;" src="./images/Profil.png"><img style="width:115px;height:27px;" src="./images/Bearbeiten.png"></a>-->
</td>
</tr>
<tr>


ShowUserProfil


<tr>
 <td><h3>Essens bestellung</h3> </td>
</tr>
<?php

if(!count($this->FoodOrderArray))
{
	echo "<tr>
 <td>Sie haben keine Bestellungen </td>
</tr>";
}else
{
	foreach($this->FoodOrderArray as $FoodOrder)
	{
		foreach($FoodOrder->getFoodElements() as $FoodElement)
		{
			echo "<tr>
			<td><div style='width:150px;float: left;'>".$FoodElement->getName()."</div><div style='width:80px;float: left;'>".$FoodElement->getSize()."</div><div style='float: left;'>".$FoodElement->getPrice()." €</div> </td>
			</tr>";
		}
		echo "<tr style=';font-weight:bold;'>
			<td><div style='width:150px;float: left'>Status: ".$FoodOrder->isPaidAsString()."</div><div style='width:150px;float: left;'>Gesammtpreis: ".$FoodOrder->getPrice()."€</div></td>
			</tr>";
	}
	
	
}




?>
<tr>
 <td> </td>
</tr>
<tr>
 <td><h3>Nachrichten</h3> </td>
</tr>
<tr>
 <td>
<?php
if($this->MessageCollection->getCount())
{
	echo "<a href='index.php?section=messages'>Sie haben neue Nachrichten (".$this->MessageCollection->getCount().")</a>";
}else
{
	echo "Sie haben keine neuen Nachrichten";
}



?>
 </td>
</tr>



</table>