<?php
include("tpl_IngameHeaderNew.php");
?>

<script type="text/javascript">
function check()
{
	if(confirm(":T_ALLIANZ_CONFIRME:"))
	{
		return true;
	}
	return false;
}
</script>


<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Allianz.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">



 <h2>:T_ALIANCE:</h2>
    	<table >
<tr>
 <?php 

if($this->IsAdmin)
{

 	echo"<td ><a href='index.php?Section=Allianz&amp;Action=ShowAllianzWorkOn' class='VIPLink'>:BTN_ALLIANZ_ALLIANZ_MANAGE:</a> </td>
 <td><a href='index.php?Section=Allianz&amp;Action=ShowAllianzMemberWorkOn' class='VIPLink'>:BTN_ALLIANZ_MEMBER_MANAGE:</a></td>";


}?>
  <td><a href='index.php?Section=Allianz&amp;Action=ShowDeleteUser' class="VIPLink">:BTN_ALLIANZ_EXIT:</a></td>

 </tr>
  </table>

<table  class="DataTable" style="margin-top:10px;" width="100%" >
<tr>
 
 <td colspan="3"><a onclick='return check();'  href='index.php?Section=Allianz&amp;Action=DeleteTopic'></a><h2><?php echo $this->Allianz->getName();?></h2></td>
</tr>
<tr>
 <td colspan="3"><p><?php echo $this->Allianz->getDescription(true);?></p> </td>
</tr>
<tr>
 <td class='header' width="120px">:T_ALLIANZ_MEMBER: </td>
 <td colspan="2" style="text-align:left"><a href='index.php?Section=Allianz&amp;Action=ShowMember' style="margin-left:10px;"><?php echo $this->Allianz->getUserCollection()->getCount();?></a> </td>
</tr>
<tr>
 <td colspan="3" style="text-align:left"> 
	<a style="color:white;margin-left:10px;" href="index.php?Section=Allianz&amp;Action=ShowCreateTopic" >:T_ALLIANZ_NEW_TOPIC:</a>
</td>
 
</tr>

 <tr>
 <td></td>
 <td></td>
 <td></td>
</tr>

<tr>
 <td class='header'>:T_ALLIANZ_TOPIC: </td>
 <td class='header'>:T_ALLIANZ_LAST_COMMENT: </td>
 <td class='header'>:T_ALLIANZ_FROM: </td>
<td class='header'>:T_ALLIANZ_COMMENTS: </td>
</tr>

<?php
foreach($this->Allianz->getAllianzTopicColletion() as $Topic)
{
	echo"<tr>
	<td align='left'><a href='index.php?Section=Allianz&amp;Action=ShowTopic&amp;TId=".$Topic->getId()."'>".$Topic->getName()."</a> </td>
	<td align='center'><a href='index.php?Section=Allianz&amp;Action=ShowTopic&amp;TId=".$Topic->getId()."'>".$Topic->getLastCommentDate()."</a> </td>
	<td align='center'><a href='index.php?Section=Allianz&amp;Action=ShowTopic&amp;TId=".$Topic->getId()."'>".$Topic->getLastCommentUserName()."</a> </td>
	<td align='center'><a href='index.php?Section=Allianz&amp;Action=ShowTopic&amp;TId=".$Topic->getId()."'>".$Topic->getCommentsCount()."</a> </td>
</tr>";

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
