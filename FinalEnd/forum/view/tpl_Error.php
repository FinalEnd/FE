
<?php

include "view/tpl_Header.php";

?>

<h2 class="ForumHeader">Fehler <?php echo $this->ErrorHeader; ?>   </h2>
<p class="ForumHeader">
<?php
echo $this->ErrorString;
?>
</p>
<br />
<br />
<br />

 <a class="ForumHeader" href="<?php echo $this->LastPage; ?>">zurück</a> 