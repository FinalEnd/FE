<?php

include "view/tpl_Menu.php";

?>
<script type="text/javascript" src="javascript/autocomplette.js"></script>



<script type="text/javascript">

<?php
echo $this->AutoComplete;
?>

WordCache= new WordCache();
WordCache.add("Player",CompleteArray);
AutoComplete= new AutoComplete(WordCache,"#0080FF");
</script>
<?php
echo "<h1>Nachrichten für: ".$this->UserName."</h1>";
?>

<h2><a href="index.php?section=messages&amp;Show=UnRead">ungelesen</a>|<a href="index.php?section=messages&amp;Show=All">Alle</a></h2>

<form action="index.php?section=messages" method="post" target="">
<table width='95%'>
    	 <tr id='titel'><td valign='top' ><font size="+1"><b><u>Von</u></b></font></td>
     		<td valign='top' ><font size="+1"><b><u>Nachricht</u></b></font></td>
      		<td valign='top' ><font size="+1"><b><u>Datum</u></b></font></td>
			<td valign='top' align='center' >
				<select name="Action" size="">
						  <option value="0">ungelesen</option>
						  <option value="1">gelesen</option>
						  <option value="2">Löschen</option>
				</select>
			</td>
			<td colspan= valign='top' ><input type="Submit" name="btn_WorkOn" value=","  style='cursor: pointer; background: url("./images/Bearbeiten.png") repeat scroll 0% 0% transparent; border: medium none; width: 115px; height: 25px;'/> </td>
		</tr>
<?php 

if($this->MessageCollection->getCount()!=0)
{
	foreach ($this->MessageCollection->getAll() as $Message)
	{
		echo "<tr> 
			<td valign='top' background='../Bilder/hellgr.gif'>".$Message->getFrom()."</td>
			<td valign='top' >".$Message->getContent()."</td>
				<td valign='top' >".$Message->getDate()."</td>
				<td  valign='top' align='center' background='../Bilder/hellgr.gif'>
				<input type='checkbox' name='Id[]' value='".$Message->getId()."' />
				<td  ></td>
			</td>
			</tr>";

	}
	
}else
{
	echo "<tr><td colspan='5'>Es sind keine Nachrichten vorhanden</td></tr>";
}		
?>
			 
			 
	</table>
</form>		
		<br><b>Nachricht schreiben</b><br>
		<form action='index.php?section=messages' method='post' target=''>
		Empfänger: <input onclick="AutoComplete.checkForOptions(this.id)" onkeyup="AutoComplete.complete(this.id)"  name="Kategorie" id="Player" value="<?php echo $this->PlayerName; ?>" maxlength="50" size="30" autocomplete="off" /><br />
		<br><textarea name='text' cols='60' rows='7'></textarea><br>
		<input class='button' type='Submit' name='abschicken' value='.' style='cursor: pointer; background: url("./images/senden.png") repeat scroll 0% 0% transparent; border: medium none; width: 80px; height: 25px;'>
		</form>