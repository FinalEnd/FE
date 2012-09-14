
<?php

include "view/tpl_Menu.php";

?>

<h1>News Bearbeiten</h1>



<?php


foreach($this->NewsCollection->getAll() as $NewsElement)
{
	
	
	echo "<form action='index.php?section=admin&amp;action=NewsWorkOn&amp;Id=".$NewsElement->getId()."' method='post' >";
	echo "<div class='newsDate' >".$NewsElement->getCreateDate()."</div><div class='newsContent' ><textarea name='NewsContent' rows='6' cols='60'>".$NewsElement->getContentNoneParse()."</textarea> </div>";
	echo "
			<input type='submit' name='WorkOn' value='' style='cursor: pointer;background: transparent url(./images/Bearbeiten.png);border:none;width:115px;height:27px;padding-left: 2px;' />

			<a href='index.php?section=admin&amp;action=NewsWorkOn&amp;Id=".$NewsElement->getId()."&amp;Delete=True'><img src='images/Entfernen.png' title='Löschen' /></a>
	</form>
	";


}




?>















