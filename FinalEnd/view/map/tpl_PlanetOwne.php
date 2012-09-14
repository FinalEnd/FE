<table class="Table" border="0" width="100%">
<tr>
<td>
<table class="Table" border="0" width="100%">
	<tr>
		<td colspan='4' align="left" ><input type='button' colspan='2' name='' onclick='getMap().showMapOnKoordianteXY(<?php echo $this->Planet->getX();?>,<?php echo $this->Planet->getY(); ?>)' value=':T_PLAN_CENTER:'> 
			<a href='index.php?Section=ChangeActivePlanet&amp;D=Map&amp;cb_Planet=<?php echo $this->Planet->getId(); ?>'>:T_PLAN_CHOOSEPLAN:</a> | 
			<a style="display: inline;" class="MenuEntry" href="index.php?Section=ChangeActivePlanet&D=Planet&cb_Planet=<?php echo $this->Planet->getId();?>t&amp;Action=ShowPlanet">:T_NAVI_GENERALVIEW:</a> | 
			<a class="MenuEntry" href="index.php?Section=ChangeActivePlanet&D=Building&cb_Planet=<?php echo $this->Planet->getId();?>">:T_NAVI_BUILDINGS:</a> | 
			<a class="MenuEntry" href="index.php?Section=ChangeActivePlanet&D=ReSearch&cb_Planet=<?php echo $this->Planet->getId();?>">:T_NAVI_RESEARCH:</a> | 
			<a class="MenuEntry" href="index.php?Section=ChangeActivePlanet&D=Ships&amp;cb_Planet=<?php echo $this->Planet->getId();?>&amp;Action=ShowDock">:T_NAVI_SHIPYARD:</a> | 
			<a class="MenuEntry" href="index.php?Section=ChangeActivePlanet&D=Dock&cb_Planet=<?php echo $this->Planet->getId();?>">:T_NAVI_DOCK:</a> | 
			<a class="MenuEntry" href="index.php?Section=ChangeActivePlanet&D=Trade&cb_Planet=<?php echo $this->Planet->getId();?>">:T_NAVI_TRADE:</a> | 
		</td>
	</tr>
   
  <tr>
 <td colspan ="3"> 
<img src="./images/metal.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_METAL:" title=":T_HEADER_METAL:" />:<?php echo $this->Planet->getMetalFormated(true); ?>
  <img src="./images/kristal.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_CRYSTAL:" title=":T_HEADER_CRYSTAL:" />:<?php echo $this->Planet->getCrystalFormated(true); ?>
  <img src="./images/Treibstoff.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_HYDROGEN:" title=":T_HEADER_HYDROGEN:" />:<?php echo $this->Planet->getHydrogenFormated(true); ?>
  <img src="./images/fleisch.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_BIOMAS:" title=":T_HEADER_BIOMAS:" />:<?php echo $this->Planet->getBiomassFormated(true); ?> 
   <img src="./images/system/People.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_PEOPLE:" title=":T_HEADER_PEOPLE:" />:<?php echo $this->Planet->getPeopleCountAsString(true); ?>
</td>
 
</tr>

<tr>
 <td class='header' style="width:20%;">:T_PLAN_NAME::</td>
 <td><?php echo $this->Planet->getName(); ?></td>
 <td rowspan="5" width="120px"><a href="index.php?Section=Map&amp;X=<?php echo $this->Planet->getX();?>&amp;Y=<?php echo $this->Planet->getY();?>"><img width="120px" height="120px" src="images/planets/<?php echo $this->Planet->getPicture(); ?>"></a> </td>
</tr>
<tr>
 <td class='header'>:T_PLAN_OWNER:: </td>
 <td><?php echo $this->Planet->getUser()->getName(); ?><a href='index.php?Section=Messages&PlayerName=<?php echo $this->Planet->getUser()->getName(); ?>'></td>
</tr>

<tr>
	<td class='header'>:T_ALLIANZNOALLIANZ_HEADER::</td>
	<td><a href='index.php?Section=Allianz&Action=ShowForeignAllianz&s_Name=<?php echo $this->Planet->getUser()->getAllianzName(); ?>'><?php echo $this->Planet->getUser()->getAllianzName(); ?></td>
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
