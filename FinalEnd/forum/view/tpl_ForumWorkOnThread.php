<?php

/* TODO: Code hinzufgen */



	include("view/tpl_Header.php");

?>

<h2>Thread Bearbeiten</h2>

<form action="index.php?section=Forum&Action=WorkOnThread&amp;ThreadId=<?php echo $this->Thread->getId();?>" method="post" target="">
<table >
<tr>
 <td>Name: </td>
 <td><input type="Text" name="tb_Name" value="<?php echo $this->Thread->getName()?>" size="30" maxlength=""> </td>
</tr>
<tr>
 <td>Beschreibung: </td>
 <td><input type="Text" name="tb_Description" value="<?php echo $this->Thread->getDescription()?>" size="30" maxlength=""> </td>
</tr>
<tr>
 <td colspan="2"><table >
<tr>
 <td>Modus: </td>
			<td colspan="4">
    <select name="cb_Modus" size="">
     <option <?php if($this->Thread->getModus()===0){echo"selected";}?> value="0">für alle sichtbar                     | User/Moderator/Admin darf schreiben</option>
     <option <?php if($this->Thread->getModus()===1){echo"selected";}?> value="1">für alle sichtbar                     | Moderator/Admin darf schreiben</option>
     <option <?php if($this->Thread->getModus()===2){echo"selected";}?> value="2">für alle sichtbar                     | Admin darf schreiben</option>
     <option <?php if($this->Thread->getModus()===3){echo"selected";}?> value="3">Nur Für User oder höher sichtbar      | User/Moderator/Admin darf schreiben</option>
     <option <?php if($this->Thread->getModus()===4){echo"selected";}?> value="4">Nur Für User oder höher sichtbar      | Moderator/Admin darf schreiben     </option>
     <option <?php if($this->Thread->getModus()===5){echo"selected";}?> value="5">Nur Für User oder höher sichtbar      | Admin darf schreiben     </option>
     <option <?php if($this->Thread->getModus()===6){echo"selected";}?> value="6">Nur Für Moderator oder höher sichtbar | Moderator/Admin darf schreiben     </option>
     <option <?php if($this->Thread->getModus()===7){echo"selected";}?> value="7">Nur Für Admin sichtbar                | Admin darf schreiben     </option>
    </select>
  </td>
</tr>
</table>
 <input type="Submit" style='cursor: pointer;width:115px;height:25px;' name="" value="Bearbeiten">
</form>

