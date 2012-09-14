
<?php

include "view/tpl_Menu.php";

?>

<fieldset><legend>Fehler</legend>
<table >
<tr>
 <td rowspan="2"><img src="images/error.jpg" /> </td>
 <td><?php echo $this->Message;?> </td>
</tr>
<tr>
 <td><?php echo $this->From; ?> </td>
</tr>
</table>
</fieldset>