<?php
include("tpl_IngameHeaderNew.php");
?>

<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Background.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">


<div id="Main" algin="center">
<div algin="center">
	<h2>:T_RANK_TITLE:</h2>
	<p><a href="index.php?Section=Ranking&amp;Action=ShowAllianzRanking">:T_RANK_ALLI:</a></p>
	<div><?php echo $this->Start+1;?> - <?php echo $this->Start+50;?> :T_RANK_FROM: <?php echo $this->PlayerCount;?> :T_RANK_PLAYERS:</div>
	<table style="width:80%;" border="0">
	<tr>
	 <td class='header'>:T_RANK_LVL: </td>
	 <td style="width:250px;" class='header'>:T_RANK_NAME: </td>
	 <td class='header'>:T_RANK_LEVEL: </td>
	<td class='header'>:T_RANK_ALLIANCE: </td>
	</tr>
	<?php
	$I=$this->Start+1;
	foreach($this->UserCollection as $User)
	{
		echo"<tr>
	 <td>".$I." </td> <td><a href='index.php?Section=Allianz&Action=ShowForeignAllianz&s_Name=".$User->getName()."'><a ";
		
		if($User->getName()==$this->User->getName())
		{
			echo 'style="font-weight:bold;color:white"';	
		}
		
		
		echo "href='index.php?Section=Messages&PlayerName=".$User->getName()."'><img height='15' width='25' src='./images/Msg.jpg' title=':T_RANK_SENDMESS:' />&nbsp;".$User->getName()."</a></td>
	 <td>".$User->getLevel()."</td>
	<td><a href='index.php?Section=Allianz&Action=ShowForeignAllianz&s_Name=".$User->getAllianzName()."'>".$User->getAllianzName()."</a></td>
	</tr>";
		$I++;
	}
	 ?>
	
	<tr>
	
	 <td>
	<?php
	
	if(!$this->CantBackWard)
	{
		echo '<a href="index.php?Section=Ranking&Start='.($this->Start-$this->Count).'">:BTN_QUOTE_NEXT:</a>';
	}
	
	?>
	 </td>
	 <td> </td>
	<td> </td>
	 <td>
	  	<?php
	  	if(!$this->CantForWard)
	  	{
	  		echo '<a href="index.php?Section=Ranking&Start='.($this->Start+$this->Count).'">:T_GROUP_BACK:</a>';
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