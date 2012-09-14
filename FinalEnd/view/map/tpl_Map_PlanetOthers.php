
<table class="Table" border="0" width="100%">
<tr><td colspan='4' align="left" ><input type='button' colspan='2' name='' onclick='getMap().showMapOnKoordianteXY(<?php echo $this->Planet->getX(); ?>,<?php echo $this->Planet->getY(); ?>)' value=':T_PLAN_CENTER:'></td></tr>
<tr>
 <td class='header' style="width:20%;">:T_PLAN_NAME::</td>
 <td><?php echo $this->Planet->getName(); ?></td>
 <td rowspan="5" width="120px"><a href="index.php?Section=Map&amp;X=<?php echo $this->Planet->getX();?>&amp;Y=<?php echo $this->Planet->getY();?>"><img width="120px" height="120px" src="images/planets/<?php echo $this->Planet->getPicture(); ?>"></a> </td>
</tr>
<tr>
 <td class='header'>:T_PLAN_OWNER:: </td>
 <td><a href="index.php?Section=User&amp;Action=ShowCompareStats&tb_Player='<?php echo $this->Planet->getUser()->getName().'\'"> '.$this->Planet->getUser()->getName(); ?>  </a><a href='index.php?Section=Messages&PlayerName=<?php echo $this->Planet->getUser()->getName(); ?>'><a href='index.php?Section=Messages&PlayerName=<?php echo $this->Planet->getUser()->getName(); ?>'>
		<img height='15' width='25' src='./images/Msg.jpg' title=':T_ALLIANZFOREIGEN_SEND_MSG:' /></a></td>
</tr>

<tr>
	<td class='header'>:T_ALLIANZNOALLIANZ_HEADER::</td>
	<td><a href='index.php?Section=Allianz&Action=ShowForeignAllianz&s_Name=<?php echo $this->Planet->getUser()->getAllianzName(); ?>'><?php echo $this->Planet->getUser()->getAllianzName(); ?></a></td>
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
 <td class='header'>:T_MAP_COORD:: </td>
 <td><?php echo $this->Planet->getX().":".$this->Planet->getY(); ?> </td>
</tr>



</table>
