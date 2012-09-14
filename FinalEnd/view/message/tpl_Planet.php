<table class="Table" border="0" width="100%">
<tr>
<td>
<table class="Table" border="0" width="100%">

   
  <tr>
 <td colspan ="3">
<img src="./images/metal.png" width="20px" height="20px" class="Icons" alt="Metall" title=":T_HEADER_METAL:" />:<?php echo $this->Planet->getMetal(true); ?> 
<img src="./images/kristal.png" width="20px" height="20px" class="Icons" alt="Kristall" title=":T_HEADER_CRYSTAL:" />:<?php echo $this->Planet->getCrystal(true); ?>
<img src="./images/Treibstoff.png" width="20px" height="20px" class="Icons" alt="Deuterium" title=":T_HEADER_HYDROGEN:" />:<?php echo $this->Planet->getHydrogen(true); ?>
<img src="./images/fleisch.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_HEADER_BIOMAS:" />:<?php echo $this->Planet->getBiomass(true); ?>
</td>
 
</tr>

<tr>
 <td class='header' style="width:20%;">:T_PLAN_NAME::</td>
 <td><?php echo $this->Planet->getName(); ?></td>
 <td rowspan="5" width="120px"><a href="index.php?Section=Map&amp;X=<?php echo $this->Planet->getX();?>&amp;Y=<?php echo $this->Planet->getY();?>"><img width="120px" height="120px" src="images/planets/<?php echo $this->Planet->getPicture(); ?>"></a> </td>
</tr>
<tr>
 <td class='header'>:T_PLAN_OWNER:: </td>
 <td><?php echo $this->Planet->getUser()->getName(); ?><a href='index.php?Section=Messages&PlayerName=<?php echo $this->Planet->getUser()->getName(); ?>'><img height='15' width='25' src='./images/Msg.jpg' title=':T_MESSAGE_WRITEONE:' /></a> </td>
</tr>
<tr>
 <td class='header'>:T_PLAN_SIZE:: </td>
 <td><?php echo $this->Planet->getSize(); ?> Km Ø </td>
</tr>
<tr>
 <td class='header'>:T_PLAN_MASS:: </td>
 <td><?php echo $this->Planet->getweight(); ?> Kg </td>
</tr>
<tr>
 <td class='header'>:T_PLAN_COORDIN:: </td>
 <td><?php echo $this->Planet->getX().":".$this->Planet->getY(); ?> </td>
</tr>
</table> 
 </td>
</tr>

<tr>
<td>
<table class="Table" width="100%">
<tr>
 <td class='header' >:T_PLAN_BUILDINGS:: </td><td class='header' >:T_PLAN_RESEARCH:: </td>
</tr>
<tr>
 <td width ="50%" valign="top"><?php
 foreach($this->Planet->getBuildingCollection() as $Building)
 {
 	echo "<div style='width:240px;' >";
 	echo $Building->getName(); 
 	if($Building->getLevel()==0)
 	{
 		echo " :T_PLAN_INCONSTR:";
 	}else
 	{
 		echo " (".$Building->getLevel().")";
 	}
 	
 	if($Building->getInbuild() && $Building->getLevel())
 	{
 		echo " :T_PLAN_INCONSTR:";
 	}
 	echo "</div>";
 }
 ?></td>
  <td valign="top"><?php
  foreach($this->Planet->getReSearchCollection() as $ReSearch)
  {
  	echo "<div style='width:230px;' >".$ReSearch->getName();	
  	if($ReSearch->getLevel()==0)
  	{
  		echo " :T_PLAN_INRESEAR:";
  	}else
  	{
  		echo " (".$ReSearch->getLevel().")";
  	}
  	
  	if($ReSearch->getInbuild() && $ReSearch->getLevel())
  	{
  		echo " :T_PLAN_INRESEAR:";
  	}
  	echo "</div>";
  }
  ?></td>
 </tr>
 <tr>
  <td colspan="2" class='header' >:T_PLAN_UNITS::</td>
   </tr>
<tr>
 <td colspan="2">
 <?php
 foreach($this->Planet->getShipCollection() as $Ships)
 {
 	echo $Ships->getName()." (".$this->Planet->getShipCollection()->getShipCountByShipId($Ships->getId()).")<br />";
 }
 ?>
</td>
</tr>
</table>
</tr>
</table>
