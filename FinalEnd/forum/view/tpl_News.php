<?php
include "view/tpl_Menu.php";
?>
<h1>Lanparty News</h1>

<table>

<?php


foreach($this->NewsCollection->getAll() as $NewsElement)
{
	echo "<tr>
 <td valign='top'>".$NewsElement->getCreateDate()." </td><td valign='top'>".$NewsElement->getContent()." </td></tr>";
}




?>
</table>