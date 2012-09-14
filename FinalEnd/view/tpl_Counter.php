
<?php

include "view/tpl_Menu.php";

?>

<h2>Statistik</h2>
<h1>Wochen ansicht</h1>
<table style="background-color:#000000;width:100%">
<tr style="color: rgb(255, 255, 255); font-weight: bold; background-image: url(images/site_background2.gif);font-size:18px;">
<td > </td>
 <td><?php echo $this->YesterDay5;?> </td>
 <td><?php echo $this->YesterDay4;?> </td>
 <td><?php echo $this->YesterDay3;?> </td>
 <td><?php echo $this->YesterDay2;?> </td>
 <td><?php echo $this->YesterDay1;?> </td>
 <td><?php echo $this->YesterDay;?> </td>
 <td>Heute </td>
</tr>
<tr style='background-color: rgb(255, 255, 224);'>
<td>Besucher </td>
 <td><?php echo $this->YesterDayHit6;?> </td>
 <td><?php echo $this->YesterDayHit5;?> </td>
 <td><?php echo $this->YesterDayHit4;?> </td>
 <td><?php echo $this->YesterDayHit3;?> </td>
 <td><?php echo $this->YesterDayHit2;?> </td>
 <td><?php echo $this->YesterDayHit1;?> </td>
 <td><?php echo $this->ToDayHit;?> </td>

</tr>
<tr style='background-color: rgb(255, 255, 224);'>
<td >Seiten aufrufe </td>
 <td><?php echo $this->YesterDayClick6;?> </td>
 <td><?php echo $this->YesterDayClick5;?> </td>
 <td><?php echo $this->YesterDayClick4;?> </td>
 <td><?php echo $this->YesterDayClick3;?> </td>
 <td><?php echo $this->YesterDayClick2;?> </td>
 <td><?php echo $this->YesterDayClick1;?> </td>
 <td><?php echo $this->ToDayClick;?> </td>
</tr>
</table>


