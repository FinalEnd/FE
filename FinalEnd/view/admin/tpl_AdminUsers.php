<?php
if($this->IsLoggedIn)
{
	echo '<form action="indexAdmin.php?Section=Logout" method="post" >
		  <input type="submit" name="" value="Logout" /></form>
	';
?>
	<?php
	if($this->ErrorString)
	{
		echo"<h3 class='ErrorHeader' >".$this->ErrorString."</h3>";
	}
	echo "<table><tr><td>Name</td><td>Level</td></tr>";
	foreach ($this->Users as $User)
	{
		echo "<tr><td>".$User->getName()."</td><td>".$User->getLevel()."</td></tr>";	



	}
	echo "</table>";
	?>



<?php	
}else
{
	echo 'You are not logged in.';
}
?>