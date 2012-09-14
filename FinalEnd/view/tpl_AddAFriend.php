<?php
include("tpl_IngameHeaderNew.php");
?>

<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Settings.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">

<h2>:T_ADDFRIEND_HEADER:</h2>


<p>:T_ADDFRIEND_TEXT_PART1: <?php echo USER_FRIEND_UINVTE_CREDITS; ?> :T_ADDFRIEND_TEXT_PART2:</p>

<p><input type="text" size="40" onclick="this.focus();this.select();" value="http://www.final-end.de/index.php?S=<?php echo Controler_Main::getInstance()->getDataBaseId(); ?>&Ref=<?php echo $this->MyUser->getId(); ?>"/>	</p>
<p>:T_ADDFRIEND_TEXT2:</p>


<p><h2>:T_ADDFRIEND_BANNER_TEXT:</h2></p>


<p><img src="./images/Banner/Banner.png" /></p>
<p><textarea onclick="this.focus();this.select();" name="" cols="65" rows="2"><a href="http://www.final-end.de/index.php?S=<?php echo Controler_Main::getInstance()->getDataBaseId(); ?>&Ref=<?php echo $this->MyUser->getId(); ?>"><img src="http://www.final-end.de/images/Banner/Banner.png" /></a></textarea>
</p>

<p><img src="./images/Banner/Banner2.png" /></p>
<p><textarea onclick="this.focus();this.select();" name="" cols="65" rows="2"><a href="http://www.final-end.de/index.php?S=<?php echo Controler_Main::getInstance()->getDataBaseId(); ?>&Ref=<?php echo $this->MyUser->getId(); ?>"><img src="http://www.final-end.de/images/Banner/Banner2.png" /></a></textarea>
</p>

<p><img src="./images/Banner/Banner3.png" /></p>
<p><textarea onclick="this.focus();this.select();" name="" cols="65" rows="2"><a href="http://www.final-end.de/index.php?S=<?php echo Controler_Main::getInstance()->getDataBaseId(); ?>&Ref=<?php echo $this->MyUser->getId(); ?>"><img src="http://www.final-end.de/images/Banner/Banner3.png" /></a></textarea>
</p>

<p><img src="./images/Banner/Banner4.png" /></p>
<p><textarea onclick="this.focus();this.select();" name="" cols="65" rows="2"><a href="http://www.final-end.de/index.php?S=<?php echo Controler_Main::getInstance()->getDataBaseId(); ?>&Ref=<?php echo $this->MyUser->getId(); ?>"><img src="http://www.final-end.de/images/Banner/Banner4.png" /></a></textarea>
</p>
</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
	


<?php

include("tpl_Footer.php");
?>