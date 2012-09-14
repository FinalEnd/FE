<?php
include "view/tpl_Menu.php";

?>


<table   width="100%" class="table" >
<tr>
 <td  rowspan="45" valign="top"><img src="<?php echo $this->Player->getPicString();?>" width="130px"  height="130"> </td>
</tr>

<tr  >
 <td  colspan="2" class="header"> <?php echo $this->Player->getName();?> </td>
</tr>
 <tr >
 <td width="20%" >Name:</td>
 <td width="79%" ><?php echo $this->Player->getRealName();?>  </td>
</tr>

 <tr class="row">
 <td >Geb.:</td>
 <td ><?php echo $this->Player->getBirthDate();?>  </td>
</tr>

 <tr>
 <td>Plz/Ort:</td>
 <td><?php echo $this->Player->getPLZ();?> <?php echo $this->Player->getTown();?>  </td>
</tr>

 <tr>
 <td>Straße:</td>
 <td><?php echo $this->Player->getStreet();?>  </td>
</tr>

 <tr>
 <td>Games:</td>
 <td><?php echo $this->Player->getGames();?>  </td>
</tr>

 <tr>
 <td colspan="2" class="contentBold">Rechner</td>
 </tr>

<tr>
 <td>CPU: </td>
 <td><?php echo $this->Player->getCPU();?>  </td>
</tr>
<tr>

 <td>RAM: </td>
 <td><?php echo $this->Player->getRAM();?>  </td>
</tr>
<tr>

 <td>MainBord: </td>
 <td><?php echo $this->Player->getMainBord();?> </td>
</tr>
<tr>

 <td>Grafikkarte: </td>
 <td><?php echo $this->Player->getGraphigKart();?>  </td>
</tr>
<tr>
 <td>Festplatte: </td>
 <td><?php echo $this->Player->getHDD();?>  </td>
</tr>
<tr>
 <td>Netzteil: </td>
 <td><?php echo $this->Player->getEnergy();?>  </td>
</tr>
<tr>
 <td>SoundKarte: </td>
 <td><?php echo $this->Player->getSound();?>  </td>
</tr>
<tr>
 <td>Gehäuse: </td>
 <td><?php echo $this->Player->getCase();?>  </td>
</tr>
<tr>
 <td>Soundsystem: </td>
 <td><?php echo $this->Player->getHeadset();?>  </td>
</tr>
<tr>
 <td>Maus: </td>
 <td><?php echo $this->Player->getMous();?>  </td>
</tr>
<tr>
 <td>Tastatur: </td>
 <td><?php echo $this->Player->getKeyBord();?>  </td>
</tr>

 <tr>
 <td colspan="2" class="contentBold">Kontakt</td>
 </tr>

<tr>
 <td>ICQ: </td>
 <td><?php echo $this->Player->getICQ();?>  </td>
</tr>
<tr>
 <td>Xfire: </td>
 <td><?php echo $this->Player->getXFire();?>  </td>
</tr>
<tr>
 <td>Skype: </td>
 <td><?php echo $this->Player->getSkype();?>  </td>
</tr>
<tr>
 <td>MSN: </td>
 <td><?php echo $this->Player->getMSN();?>  </td>
</tr>
<tr>
 <td>TS2 / 3: </td>
 <td><?php echo $this->Player->getTSIP();?> </td>
</tr>
<tr>
 <td>Mail: </td>
 <td><?php echo $this->Player->getMail();?>  </td>
</tr>
<tr>
 <td>HomePage: </td>
 <td><?php echo $this->Player->getHomePage();?>  </td>
</tr>

 <tr>
   <td colspan="2" class="contentBold">
      Übersich selbst
   </td>
</tr>
 <tr>
   <td colspan="2">
      <?php echo $this->Player->getOther();?>
   </td>
</tr>
 <tr>
   <td colspan="2" class="contentBold">
      Signatur
   </td>
</tr>
 <tr>
   <td colspan="2">
      <?php echo $this->Player->getSignature();?>
   </td>
</tr>

</table>
<a  href='<?php echo $this->LastPage;?>'><img src='images/Back.png' title='zurück' /></a>