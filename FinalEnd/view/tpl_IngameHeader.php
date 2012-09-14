<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Final End</title>
<meta name="keywords" content="" />
<meta name="Gestured" content="" />
<link href="./css/default.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body>
<div id="wrapper">
<div id="header">
	<div id="logo">
	<div id="monitor">
	<div class="ts"><div class="tc"><div class="tr">
		<div class="content">

			<table border="0" style="width:97%"><tr><td>
<select style="" onchange="window.location.href='index.php?Section=ChangeActivePlanet&amp;D=<?php echo $this->Section;?>&amp;cb_Planet='+this.value" name="cb_Planet" size="" >
<?php
foreach($this->MyPlanetCollection as $MyPlanet)
{
	echo " <option value='".$MyPlanet->getId()."'";
	if($this->Planet->getId()==$MyPlanet->getId())
	{
		echo "selected";
	}
	
	echo ">".$MyPlanet->getName()." (".$MyPlanet->getBuildingsInBuild()."/".$MyPlanet->getMaxBuildingsInBuild().")";
	echo $MyPlanet->getShipBuildCount();
	if($MyPlanet->isReSearchInBuild())
	{
		echo " f ";	
	}
	echo "</option>";
}
?>
</select> 

 <br />:T_HEADER_WELlCOME: <a href="index.php?Section=User&amp;Action=ShowStats"><?php echo $this->User->getName()." (".$this->User->getLevel().")";?></a>
 <?php
 if($this->MessageCount)
 {
 	echo '<a href="index.php?Section=Messages"><img height="15" width="25" src="./images/Msg.jpg" title=":T_HEADER_NEW_MSG:" /></a>';
 }
 ?>
 </td>
<td width="730">
<?php
if(!$this->User->getPremiumUser())
{
	echo '<script type="text/javascript"><!--
google_ad_client = "pub-9907469491233698";
/* 728x90, Erstellt 28.09.10 Final-End */
google_ad_slot = "2803726236";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
}
?>
</td>



<td valign="top" align="right">

<table>
<tr> <td>
  <div style="text-align:left;">
  <a style="color: #000000" class='VIPLink'  href="index.php?Section=Login&amp;Action=Logout">:T_HEADER_LOGOUT:</a>
   </div>
</td></tr>
<tr><td style="text-align:left;">:T_HEADER_TIME: <?php echo $this->Date; ?>
</td></tr>
</table>



</td>

</tr>

<tr><td colspan="3">
 <img src="./images/system/Credits.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_CREDITS:" title=":T_HEADER_CREDITS:" />:<?php echo $this->User->getCreditsFormated(true); ?>  
<img src="./images/metal.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_METAL:" title=":T_HEADER_METAL:" />:<?php echo $this->Planet->getMetalFormated(true); ?>
  <img src="./images/kristal.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_CRYSTAL:" title=":T_HEADER_CRYSTAL:" />:<?php echo $this->Planet->getCrystalFormated(true); ?>
  <img src="./images/Treibstoff.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_HYDROGEN:" title=":T_HEADER_HYDROGEN:" />:<?php echo $this->Planet->getHydrogenFormated(true); ?>
  <img src="./images/fleisch.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_BIOMAS:" title=":T_HEADER_BIOMAS:" />:<?php echo $this->Planet->getBiomassFormated(true); ?> 
   <img src="./images/system/People.png" width="20px" height="20px" class="Icons" alt=":T_HEADER_PEOPLE:" title=":T_HEADER_PEOPLE:" />:<?php echo $this->Planet->getPeopleCountAsString(true); ?>

</td></tr>

 <tr><td colspan="3" id="Ticker" >

</td></tr>

</table>
		</div>
		</div></div></div>
	</div>	
	</div>
</div>