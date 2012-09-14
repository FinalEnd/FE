<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Allianz.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">


 <h2>:T_ALLIANZFOREIGEN_HEADER:</h2>

<table border="0" >
<tr>
 
 <td colspan="3"><h2><?php echo $this->Allianz->getName();?></h2></td>
</tr>
<?php

if($this->Allianz->hasPicture())
{
	echo '<tr>
 <td colspan="4"><img src="'.$this->Allianz->getPictureString().'" alt="Allianz Banner" width="480px" height="234px" /> </td>
</tr>';  
}
?>

<tr>
 <td colspan="4"><?php echo $this->Allianz->getDescription(true);?> </td>
</tr>

<tr>
 <td colspan="4" class='header' width="120px">:T_ALLIANZFOREIGEN_ADMINS: </td>
</tr>

<?php
$AllianFinder = new AllianzFinder();
foreach($this->Allianz->getUserCollection()->getAllianzAdmins() as $Element)
{
	$Name = $AllianFinder->findRankByUser($Element->getId());
	echo '<tr>
	 <td colspan="3"><a href="index.php?Section=Messages&PlayerName='.$Element->getName().'">
	<img src="./images/Msg.jpg" height="15px" width="25px"  title=":T_ALLIANZFOREIGEN_SEND_MSG:" /></a>'.$Element->getName().' 
	</td><td>'.$Name.'</td>
	<td>
	<a style="padding-left: 20px;" href="index.php?Section=User&amp;Action=ShowCompareStats&tb_Player='.$Element->getName().'">:T_COMPARE_HEADER:</a>
	</td>
	</tr>';
	
}
?>
<tr>
 <td class='header' width="120px">:T_ALLIANZFOREIGEN_MEMBERS: </td>
 <td colspan="3"><?php echo $this->Allianz->getUserCollection()->getCount();?></td>
</tr>
<?php

foreach($this->Allianz->getUserCollection()->getAllianzMembers() as $Element)
{
	$Name = $AllianFinder->findRankByUser($Element->getId());
	echo '<tr>
	 <td colspan="3"><a href="index.php?Section=Messages&PlayerName='.$Element->getName().'">
	<img src="./images/Msg.jpg" height="15px" width="25px"  title=":T_ALLIANZFOREIGEN_SEND_MSG:" /></a>'.$Element->getName().' </td><td>'.$Name.'</td>
	<td>
	<a style="padding-left: 20px;" href="index.php?Section=User&amp;Action=ShowCompareStats&tb_Player='.$Element->getName().'">:T_COMPARE_HEADER:</a>
	
	</td>
	</tr>';
}
														 
 

?>
</table>
</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>
