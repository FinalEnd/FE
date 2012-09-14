
<?php

include "view/tpl_Menu.php";

?>

Bitte die Werte mit einem komma getrennt und ohne leertaste eingeben<br />
<form action="index.php?section=admin&action=updateBadWords" method="post" >
<textarea name="badWords" cols="80" rows="6"><?php echo $this->badWords;
?></textarea><br />
<input type="Submit" name="Button" value="Bearbeiten" />
</form>