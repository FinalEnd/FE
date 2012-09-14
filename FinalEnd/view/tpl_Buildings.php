<?php
include("tpl_IngameHeaderNew.php");
?>

<script type="text/javascript" src="javascript/Time.js"></script>
<script type="text/javascript">
	var MyTimer= new Timer();
	function deleteBuilding()
	{
		 if(confirm(":T_BUILDING_JS:"))
		 {
			return true;
		 }
	 return false;
	}

 function destroyPlanetBuilding(Text)
	{
		 if(confirm(Text))
		 {
			return true;
		 }
	 return false;
	}




</script>

<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Planet.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">
  <h2>:T_BUILDING_HEADER:</h2>


<div style="float:left;">
:T_BUILDING_TEXT1: <?php echo $this->BuildedCount;?> :T_BUILDING_TEXT2: <?php echo $this->MaxBuildedBuildings;?>
</div>
<div style="width:100%;text-align:right;margin-bottom:8px;">
<?php
if($this->User->IsPremium())
{
	echo '<a href ="index.php?Section=Building&amp;Action=ShowBuildingsPremium" class="VIPLink"  >:T_BUILDINGS_ALLALLBUILDINGS:</a>';
}
?>
</div>

<?php
if($this->ErrorString)
{
	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
}
?>


<table class="Table" style ="width:100%" border="0" >

<?php
$TempCollection= $this->BuildingCollection;
for($i=0;$i<$TempCollection->getCount();$i++)   // war vorher foreeach hat aber den 4 punkt übersprungen warum auch immer eval
 {
	$Building=$TempCollection->getByIndex($i);
	echo $Building->getHTML();
 }


?>

</table>
</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
	
</div>

<?php

include("tpl_Footer.php");
?>