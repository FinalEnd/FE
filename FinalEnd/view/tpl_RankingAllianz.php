<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Background.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">


<div id="Main" algin="center">
<div algin="center">
	<h2>:T_RANK_ALLI:</h2>
	
	<p><a href="index.php?Section=Ranking">:T_RANK_TITLE:</a></p>
	<div><?php echo $this->Start+1;?> - <?php echo $this->Start+10;?> :T_RANK_FROM: <?php echo $this->PlayerCount;?> :T_RANK_ALLIANCES:</div>
	<table style="width:80%;" border="0">
	<tr>
	 <td class='header'>:T_RANK_LVL: </td>
	 <td style="width:250px;" class='header'>:T_RANK_NAME: </td>
	<td class='header'>:T_RANK_PLAYERS: </td>
	</tr>
	<?php
	$I=$this->Start+1;
	foreach($this->AllianzCollection as $Allianz)
	{
		echo"<tr>
	 <td>".$I." </td>
	 <td><a href='index.php?Section=Allianz&Action=ShowForeignAllianz&s_Name=".$Allianz->getName()."'>".$Allianz->getName()."</a></td>
	<td>".$Allianz->getUserCount()."</td>
	</tr>";
		$I++;
	}
	?>
	
	<tr>
	
	 <td>
	<?php
	
	if(!$this->CantBackWard)
	{
		echo '<a href="index.php?Section=Ranking&amp;Action=ShowAllianzRanking&Start='.($this->Start-$this->Count).'">vor</a>';
	}
	
	?>
	 </td>
	 <td> </td>
	
	 <td>
	  	<?php
	  	if(!$this->CantForWard)
	  	{
	  		echo '<a href="index.php?Section=Ranking&amp;Action=ShowAllianzRanking&Start='.($this->Start+$this->Count).'">weiter</a>';
	  	}
	  	?>
	 </td>
	</tr>
	
	</table>
	</div>
</div>
</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>