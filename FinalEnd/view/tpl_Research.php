<?php
include("tpl_IngameHeaderNew.php");
?>
<script type="text/javascript" src="javascript/Time.js"></script>
<script type="text/javascript">
var MyTimer= new Timer();
</script>


<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Lab.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">




<div id="Main">
  <h2>:T_RESEAR_TITLE:</h2>
<?php
if($this->ErrorString)
{
	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
}
?>

<table class="Table" width='80%' >

<?php
for($i=0;$i<$this->ReSearchCollection->getCount();$i++)
{
	$ReSearch=$this->ReSearchCollection->getByIndex($i);
	echo "<tr>
	<td style='padding-bottom:20px'>
		<table width='100%'>
			
			<tr>
	 			<td width='100%' colspan='2' class='header'>".$ReSearch->getName();
	
	if($ReSearch->getLevel()!=0)
	{
		echo "(".$ReSearch->getLevel().")";
	}
	echo "</td>
			 </tr>
			 <tr>
	 			<td width='100%'>".$ReSearch->getDescription()." </td>";
				
	if($ReSearch->getInbuild())
	{
		echo "<td rowspan='4' >".$ReSearch->getCountDown()."<a href='index.php?Section=ReSearch&amp;Action=CancelUpdateReSearch&amp;ReSearchId=".$ReSearch->getId()."'>:T_RESEAR_ABORT:</a></td>";
	}else
	{
		echo "<td rowspan='4' ><a href='index.php?Section=ReSearch&amp;Action=UpdateReSearchs&amp;SId=".$ReSearch->getReSearchId()."'>:T_RESEAR_DOWORK:</a></td>";
	}
				
				
				
			echo " </tr>";

	echo ' <tr>
	 			<td>		
					<img src="./images/credits.png" width="20px" height="20px" class="Icons" alt="Credits" title=":T_HEADER_CREDITS:" />:'.$ReSearch->getBuildCreditsNextLevel().'
					<img src="./images/metal.png" width="20px" height="20px" class="Icons" alt="Metall" title=":T_HEADER_METAL:" />:'.$ReSearch->getBuildMetallNextLevel().'
					<img src="./images/kristal.png" width="20px" height="20px" class="Icons" alt="Kristall" title=":T_HEADER_CRYSTAL:" />:'.$ReSearch->getBuildCrystalNextLevel().'
					<img src="./images/Treibstoff.png" width="20px" height="20px" class="Icons" alt="Deuterium" title=":T_HEADER_HYDROGEN:" />:'.$ReSearch->getBuildHydrogenNextLevel().'
					<img src="./images/fleisch.png" width="20px" height="20px" class="Icons" alt="Lebensmittel" title=":T_HEADER_BIOMAS:" />:'.$ReSearch->getBuildBioMassNextLevel().'
					 </td>
					</tr>
					<tr> 
					<td>
					
					:T_RESEAR_TIMENEED:: '.$ReSearch->getCountDown(true).'
				</td> 
			</tr>
		</table>
	</td>';


	echo "</tr>"; 
}


?>

</table>
</div>

</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>