
<?php

include "view/tpl_Menu.php";

?>

<h2>Fehler <?php echo $this->ErrorHeader; ?>   </h2>

<?php
echo $this->ErrorString;
?>

<br />
<br />
<br />

 <a href="<?php echo $this->LastPage; ?>"><img src='images/Back.png' title='zurück' /></a>