
<h1> DatenBank: <?php echo $_SESSION['DataBase'];?></h1>




<form action="indexAdmin.php?Section=Logout" method="post" >
<input type="submit" name="" value="Logout" /></form>

<?php
if($this->ErrorString)
{
	echo"<h3 class='ErrorHeader' >".$this->ErrorString."</h3>";
}

?>
<hr /><h2>Nachrichten</h2>
<form action="indexAdmin.php?Section=Messages" method="post" >
<input type="submit" name="" value="Messages" /> </form>

<hr /><h2>Planet erstellen:</h2>
<form action="indexAdmin.php?Section=SpawnNewPlanet" method="post" >
X<input id="i_KoorX" type="Text" name="i_X" value="" size="" maxlength="">
Y<input id="i_KoorY" type="Text" name="i_Y" value="" size="" maxlength="">
<input type="submit" name="" value="Neuen Planeten Spawnen" /> </form>
<br>
<hr /><h2>Sonnensystem erstellen:</h2>
<form action="indexAdmin.php?Section=SolarSystem" method="post" >
X<input id="i_KoorX" type="Text" name="i_X" value="" size="" maxlength="">
Y<input id="i_KoorY" type="Text" name="i_Y" value="" size="" maxlength="">
 <?php
 if($this->X)
 {
 	echo "Koordinaten X:Y -> ".$this->X." : ".$this->Y;
 }
 ?>
<input type="submit" name="" value="Neues Sonnensystem Spawnen" /> </form>


<hr /><h2>Npc's spawnen</h2>

<input onclick="window.location.href='indexAdmin.php?Section=SetEnemyToMap&amp;Type=SMALL'" type="button" value="Jäger" />
<input onclick="window.location.href='indexAdmin.php?Section=SetEnemyToMap&amp;Type=MEDIUM'" type="button" value="Bomber" />
<input onclick="window.location.href='indexAdmin.php?Section=SetEnemyToMap&amp;Type=TALL'" type="button" value="Kamfschiffe" />



<hr /><h2>Key einfügen:</h2>
<form action="indexAdmin.php?Section=InsertKey" method="post" >

Gltigkeitsdauer(def.: 30 tage)<input id="i_KoorX" type="Text" name="i_X" value="" size="" maxlength="">
Key(optional)<input id="i_KoorY" type="Text" name="i_Y" value="" size="" maxlength="">
<input type="submit" name="" value="einfügen" /> </form>

<br>
<form action="indexAdmin.php?Section=DeleteOldKeys" method="post" >
<input type="submit" name="" value="Täglicher Key Check" /> </form>
<?php
if($this->PremUsers)
{
	echo "Neue Nicht-Premium User: ".$this->PremUsers." /Gelöschte Keys: ".$this->DelKeys;
}
?>
<?php

}else
{
	echo 'You are not logged in.';
}
?>