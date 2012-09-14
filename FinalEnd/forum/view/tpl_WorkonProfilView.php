<?php
include "view/tpl_Menu.php";

?>
<form action="index.php?section=Profil&amp;action=ChangeProfil" method="post" target="" enctype="multipart/form-data">

<table class="table">
<tr>
 <td  rowspan="33" valign="top"><img src="<?php echo $this->Player->getPicString();?>" width="130px" height="130"> </td>
</tr>

<tr>
 <td colspan="2" class="header"> <?php echo $this->Player->getName();?> </td>
</tr>
 <tr>
 <td>Profilbild:</td>
 <td>
<input name="s_Picture" type="file" size="50" maxlength="100000" accept="image">
 </td>
</tr>
 <tr>
 <td>Name:</td>
 <td><input type="Text" name="s_RealName" value="<?php echo $this->Player->getRealName();?>" size="62" maxlength="">   </td>
</tr>

 <tr>
 <td>Geb.:</td>
 <td><input type="Text" name="s_BirthDate" value="<?php echo $this->Player->getBirthDate();?>" size="62" maxlength="">   </td>
</tr>

 <tr>
 <td>Plz/Ort:</td>
 <td><input type="Text" name="s_Zip" value="<?php echo $this->Player->getPLZ();?>" size="32" maxlength="">   <input type="Text" name="s_Town" value="<?php echo $this->Player->getTown();?>" size="39" maxlength="">   </td>
</tr>

 <tr>
 <td>Straße:</td>
 <td><input type="Text" name="s_Street" value="<?php echo $this->Player->getStreet();?>" size="62" maxlength="">   </td>
</tr>

 <tr>
 <td>Games:</td>
 <td><input type="Text" name="s_Games" value="<?php echo $this->Player->getGames();?>" size="62" maxlength="">   </td>
</tr>

 <tr>
 <td colspan="2" class="contentBold">Rechner</td>
 </tr>

<tr>
 <td>CPU: </td>
 <td><input type="Text" name="s_CPU" value="<?php echo $this->Player->getCPU();?>" size="62" maxlength="">   </td>
</tr>
<tr>

 <td>RAM: </td>
 <td><input type="Text" name="s_RAM" value="<?php echo $this->Player->getRAM();?>" size="62" maxlength="">   </td>
</tr>
<tr>

 <td>MainBord: </td>
 <td><input type="Text" name="s_MainBord" value="<?php echo $this->Player->getMainBord();?>" size="62" maxlength="">  </td>
</tr>
<tr>

 <td>Grafikkarte: </td>
 <td><input type="Text" name="s_GraphigKart" value="<?php echo $this->Player->getGraphigKart();?>" size="62" maxlength="">   </td>
</tr>
<tr>
 <td>Festplatte: </td>
 <td><input type="Text" name="s_HDD" value="<?php echo $this->Player->getHDD();?>" size="62" maxlength="">   </td>
</tr>

<tr>
 <td>Netzteil: </td>
 <td><input type="Text" name="s_Energy" value="<?php echo $this->Player->getEnergy();?>" size="62" maxlength="">   </td>
</tr>
<tr>
 <td>SoundKarte: </td>
 <td><input type="Text" name="s_Sound" value="<?php echo $this->Player->getSound();?>" size="62" maxlength="">   </td>
</tr>
<tr>
 <td>Soundsystem: </td>
 <td><input type="Text" name="s_HeadSet" value="<?php echo $this->Player->getHeadset();?>" size="62" maxlength="">   </td>
</tr>

<tr>
 <td>Gehäuse: </td>
 <td><input type="Text" name="s_Case" value="<?php echo $this->Player->getCase();?>" size="62" maxlength="">   </td>
</tr>
 <td>Maus: </td>
 <td><input type="Text" name="s_Mouse" value="<?php echo $this->Player->getMous();?>" size="62" maxlength="">   </td>
</tr>
<tr>
 <td>Tastatur: </td>
 <td><input type="Text" name="s_KeyBord" value="<?php echo $this->Player->getKeyBord();?>" size="62" maxlength="">   </td>
</tr>
<tr>
 <td>Tele: </td>
 <td><input type="Text" name="s_Handy" value="<?php echo $this->Player->getHandy();?>" size="62" maxlength="">   </td>
</tr>

 <tr>
 <td colspan="2" class="contentBold">Kontakt</td>
 </tr>

<tr>
 <td>ICQ: </td>
 <td><input type="Text" name="s_ICQ" value="<?php echo $this->Player->getICQ();?>" size="62" maxlength="">   </td>
</tr>
<tr>
 <td>Xfire: </td>
 <td><input type="Text" name="s_XFire" value="<?php echo $this->Player->getXFire();?>" size="62" maxlength="">   </td>
</tr>
<tr>
 <td>Skype: </td>
 <td><input type="Text" name="s_Skype" value="<?php echo $this->Player->getSkype();?>" size="62" maxlength="">   </td>
</tr>
<tr>
 <td>MSN: </td>
 <td><input type="Text" name="s_MSN" value="<?php echo $this->Player->getMSN();?>" size="62" maxlength="">   </td>
</tr>
<tr>
 <td>TS 3: </td>
 <td><input type="Text" name="s_TSIP" value="<?php echo $this->Player->getTSIP();?>" size="62" maxlength="">  </td>
</tr>
<tr>
 <td>Mail: </td>
 <td><input type="Text" name="s_Mail" value="<?php echo $this->Player->getMail();?>" size="62" maxlength="">   </td>
</tr>
<tr>
 <td>HomePage: </td>
 <td><input type="Text" name="s_HomePage" value="<?php echo $this->Player->getHomePage();?>" size="62" maxlength="">   </td>
</tr>
 <tr>
   <td class="contentBold" colspan="2">
      Übersich selbst
   </td>
</tr>
 <tr>
   <td colspan="2">
      <textarea name="s_Other" cols="75" rows="3"><?php echo $this->Player->getOther();?></textarea> 
   </td>
</tr>

 <tr>
   <td class="contentBold" colspan="2">
      Signatur
   </td>
</tr>
 <tr>
   <td colspan="2">
      <textarea name="s_Signature" cols="75" rows="3"><?php echo $this->Player->getSignature();?></textarea> 
   </td>
</tr>

</table>
<input  type="Submit" name="" value="" style='cursor: pointer; background: url("./images/Bearbeiten.png") repeat scroll 0% 0% transparent; border: medium none; width: 115px; height: 25px;'>

<br />
<br />
<a  href='index.php?section=Profil'>  <img src='images/Back.png' title='zurück' /></a>

</form>