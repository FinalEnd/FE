<?php

  include("view/tpl_Header.php");

?>


<script type="text/javascript">
function check()
{
	if(confirm("Sind Sie sicher das sie diesen Thread entfernen wollen"))
	{
		return true;
	}
	return false;
}

function checkUp()
{
	if(confirm("Sind Sie sicher das sie diesen Thread eine Position nach oben setzen wollen"))
	{
		return true;
	}
	return false;
	
}


</script>

<h1 class="ForumHeader"> <?php echo FORUM_NAME;?></h1>


 <?php
 if($this->ErrorString)
 {
 	echo"<h2 class='ErrorHeader'>".$this->ErrorString."</h2>";
 }
 ?>

<h3 class="ForumHeader"><?php echo $this->Path;?></h3>



<?php
  // den Login Oder die anzewige des Namens im Div mit 300px 



?>
   <form method="post" target="">

</form>

<a class="ForumHeader" href='index.php?section=Forum&Action=ShowSearch'><img alt="Suchen" height="25px"  src="images/system/search.png"></a>
<?php

if($this->CanCreate)
{
	echo "<a class='ForumHeader' href='index.php?section=Forum&Action=ShowCreateThread&amp;ThreadId=".$this->ThreadId."'>Neuen Beitrag erstellen</a>";	
}

?>
	  

<table class="MainTable">
	<tr ><td class='header' style="width:35%"> Name</td><td class='header' style="width:35%">Letzter Beitrag</td><td class='header' style="width:15%">Themen/Hits</td><td class='header' style="width:35%">Beiträge</td></tr>
<?php
foreach($this->ThreadCollection as $ForumThread)
{
	// checken thread angezeigt werden darf
	if(!$ForumThread->isAllowShow())
	{
		continue ;
	}
	
	echo "<tr >";
	if($ForumThread->IsStruct())
	{//
		echo"<td> <a style='text-decoration:none;' href='index.php?section=Forum&amp;ThreadId=".$ForumThread->getId()."'><div style='font-size:1.4em'><img src='./images/system/Folder.png' />".$ForumThread->getName()."</div><div style='font-size:0.8em'>".$ForumThread->getDescription()."</div></a>";
		
		if($this->CanDelete)
		{
			echo "<a onclick='return check();' style='text-decoration:none;' href='index.php?section=Forum&amp;Action=DeleteThread&amp;ThreadId=".$ForumThread->getId()."'><img width='15px' alt='Entfernt den Thread.' src='./images/system/close.gif' /></a>";
		}
		if($this->CanWorkOn)
		{
			echo "<a style='text-decoration:none;' href='index.php?section=Forum&amp;Action=ShowWorkOnThread&amp;ThreadId=".$ForumThread->getId()."'><img width='15px' alt='Thread bearbeiten' src='./images/system/im_reply_all.gif' /></a>";
		}
		if($this->CanWorkOn)
		{
			echo "<a onclick='return checkUp();' style='text-decoration:none;' href='index.php?section=Forum&amp;Action=upThread&amp;ThreadId=".$ForumThread->getId()."'><img width='15px' alt='Setzt den Thread eine Ebene höher.' src='./images/system/arrow-up.png' /></a>";
		}
		if($this->CanWorkOn)
		{
			echo "<a onclick='return checkUp();' style='text-decoration:none;' href='index.php?section=Forum&amp;Action=downThread&amp;ThreadId=".$ForumThread->getId()."'><img width='15px' alt='Setzt den Thread eine Ebene runter.' src='./images/system/arrow-down.png' /></a>";
		}
		
		echo"</td>";
	}else
	{
		echo"<td> <a  style='text-decoration:none;' href='index.php?section=Forum&amp;Action=ShowThreadContent&amp;ThreadId=".$ForumThread->getId()."'><div style='font-size:1.4em'><img src='./images/system/Txt.png' />".$ForumThread->getName()."</div><div style='font-size:0.8em'>".$ForumThread->getDescription()."</div></a>";
		
		if($this->CanDelete)
		{
			echo "<a onclick='return check();' style='text-decoration:none;' href='index.php?section=Forum&amp;Action=DeleteThread&amp;ThreadId=".$ForumThread->getId()."'><img width='15px' alt='Entfernt den Thread.' src='./images/system/close.gif' /></a>";
		}
		if($this->CanWorkOn)
		{
			echo "<a style='text-decoration:none;' href='index.php?section=Forum&amp;Action=ShowWorkOnThread&amp;ThreadId=".$ForumThread->getId()."'><img width='15px' alt='Thread bearbeiten' src='./images/system/im_reply_all.gif' /></a>";
		}
		if($this->CanWorkOn)
		{
			echo "<a onclick='return checkUp();' style='text-decoration:none;' href='index.php?section=Forum&amp;Action=upThread&amp;ThreadId=".$ForumThread->getId()."'><img width='15px' alt='Setzt den Thread eine Ebene höher.' src='./images/system/arrow-up.png' /></a>";
		}
		
		if($this->CanWorkOn)
		{
			echo "<a onclick='return checkUp();' style='text-decoration:none;' href='index.php?section=Forum&amp;Action=downThread&amp;ThreadId=".$ForumThread->getId()."'><img width='15px' alt='Setzt den Thread eine Ebene runter.' src='./images/system/arrow-down.png' /></a>";
		}
		
		echo"</td>";
		
		echo"</td>";
	}
	echo"<td><div style='font-size:1.2em'><a style='text-decoration:none;' href='index.php?section=Forum&amp;Action=ShowThreadContent&amp;ThreadId=".$ForumThread->getLastContent()->getThreadId()."'>von ".$ForumThread->getLastContent()->getUser()->getName()."</a></div><div style='font-size:0.8em'>".$ForumThread->getLastContent()->getCreateDate()."</div></a> </td>";
	echo"<td align='center'> ".$ForumThread->getSubThreadCount()." / ".$ForumThread->getViews()." </td>";
	echo"<td align='center'> ".$ForumThread->getSubContentCount()."</td>";
	echo "</tr>";
}
?>
</table>



 <?php
   if($this->ThreadCollectionLastCommentedShow)
   {
 	echo "<h2 class='ForumHeader' >Letzte Beiträge </h2>";
 	echo '<table class="MainTable"><tr ><td class="header" style="width:35%" > Name</td><td class="header" style="width:35%">Letzter Beitrag</td><td class="header" style="width:15%">Hits</td><td class="header" style="width:15%">Beiträge</td></tr>';
 	foreach($this->ThreadCollectionLastCommented as $ForumThread)
 		{
 			echo "<tr >";
 			echo"<td> <a style='text-decoration:none;' href='index.php?section=Forum&amp;Action=ShowThreadContent&amp;ThreadId=".$ForumThread->getId()."'><div style='font-size:1.4em'><img src='./images/system/Txt.png' />".$ForumThread->getName()."</div><div style='font-size:0.8em'>".$ForumThread->getDescription()."</div></a></td>";
 			echo"<td><div style='font-size:1.2em'><a style='text-decoration:none;' href='index.php?section=Forum&amp;Action=ShowThreadContent&amp;ThreadId=".$ForumThread->getLastContent()->getThreadId()."'>von ".$ForumThread->getLastContent()->getUser()->getName()."</a></div><div style='font-size:0.8em'>".$ForumThread->getLastContent()->getCreateDate()."</div></a> </td>";
 			echo"<td align='center'>  ".$ForumThread->getViews()." </td>";
 			echo"<td align='center'> ".$ForumThread->getSubContentCount()."</td>";
 			echo "</tr>";
 		}
 	echo "</table>";
	}
 ?>

<?php

include("view/tpl_Footer.php");

?>