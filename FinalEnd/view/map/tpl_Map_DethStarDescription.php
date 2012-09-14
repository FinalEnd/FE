 <?php

 if($this->OwneUnit)
 {
 ?>

<table width='100%'> 
	<tr>
		<td width='50%'>
			<table width='100%' >
				<tr>
					 <td width='30%'>:T_GROUP_NAME:</td> <td><?php echo $this->Unit->getName();?> <img style="width:20px" src ="./images/units/Level/<?php echo $this->Unit->getLevel();?>.png" title =":T_GROUP_LEVEL: <?php echo $this->Unit->getLevel();?>" /> </td>
				</tr>
				<tr>
					 <td>:T_GROUP_DMG:</td>  <td><?php echo $this->Unit->getDmg();?> </td>
				</tr>
				<tr>
					 <td>:T_GROUP_SPEED:</td>  <td><?php echo $this->Unit->getSpeed();?> </td>
				</tr>
				<tr>
					 <td>:T_GROUP_ARMOR:</td><td><?php echo $this->Unit->getAmor();?>  </td>
				</tr>
				<tr>
					 <td>:T_GROUP_HITP:</td> <td><?php echo $this->Unit->getHealts();?> </td>
				</tr>
				<tr>
					 <td>:T_GROUP_HEALTH:</td>  <td><?php echo $this->Unit->getStateInPercent();?> </td>
				 </tr>
				 <tr>
					 <td>:T_MAP_COORD:</td>  <td><?php echo $this->Unit->getXRounded();?> : <?php echo $this->Unit->getYRounded();?></td>
				 </tr>
			 <tr>
				 <td>:T_GROUP_PAY:</td>  <td><?php echo $this->Unit->getPay();?> :T_PLAN_CPERH: </td>
			 </tr>

			 <tr>

        </tr>     
        </table></td>
 	    <td valign='top' width="50%">
		<table >

		<?php
		if($this->Unit->getTask()->getId())
		{  
		?>
            <tr>
            <td colspan='2'>:T_GROUP_HASTASK: </td>
            </tr>
            <tr>
            <td >:T_MAP_COORD:: </td>
             <td ><?php echo $this->Unit->getTask()->getX();?>:<?php echo $this->Unit->getTask()->getY();?> </td>
            </tr>
            <tr>
            <td >:T_GROUP_ARRIVAL:: </td>
             <td id="i_FlightTimeId"> </td>
            </tr>
			<?php
		}else
		{
		?>
            <tr>
            <td colspan='2'>:T_GROUP_HASNOTASK: </td>
            </tr>
            <tr>
            <td><table >
            
            </table> 
            </td>
             <td></td>
            </tr>
        <?php
       }
        ?>
		
<tr><td colspan='2'>		


	</td>
            </tr>	
        </tr>
	    <tr>
        <td >
		<table><tr>
       <td><img src='./images/units/DeathStar_F.png' style="width:100px" alt='' title=':T_DEATH_TITLE:' border='0' > </td>
		 </tr></table>
        </td>
		<td valign="top">
		
		<input type='button' name='' title=':T_DEATH_DISC2:!' onclick='getMap().destroyPlanet(<?php echo $this->Unit->getId();?>)' value=':T_DEATH_DISC2_TITLE:' />
		
		 </td>
        </tr>
        </table> </td>
	    </table>
		<?php
		return true;
	}	
	?>
         <table width='100%' > 
	     <tr>
	     <td width='50%'><table width='100%' >
         <tr>
         <td width='30%'>:T_GROUP_NAME:</td> <td><?php echo $this->Unit->getName();?> <img style="width:20px" src ="./images/units/Level/<?php echo $this->Unit->getLevel();?>.png" title =":T_GROUP_LEVEL: <?php echo $this->Unit->getLevel();?>" /> </td>
         </tr>
          <tr><td>Besitzer: </td><td><?php echo $this->Unit->getUser()->getName();?> <a href='index.php?Section=Messages&PlayerName=<?php echo $this->Unit->getUser()->getName();?>'><img height='15' width='25' src='./images/Msg.jpg' title=':T_ALLIANZFOREIGEN_SEND_MSG:' /></a></td></tr> 
         <tr>
         <td>:T_GROUP_DMG:</td>  <td><?php echo $this->Unit->getDMG();?> </td>
         </tr>
          <tr>
         <td>:T_GROUP_SPEED:</td>  <td><?php echo $this->Unit->getSpeed();?> </td>
         </tr>
         <tr>
         <td>:T_GROUP_ARMOR:</td><td><?php echo $this->Unit->getAmor();?> </td>
         </tr>
         <tr>
         <td>:T_GROUP_HITP:</td> <td><?php echo $this->Unit->getHealts();?> </td>
         </tr>
         <tr>
         <td>:T_GROUP_HEALTH:</td>  <td><?php echo $this->Unit->getStateInPercent();?> </td>
         </tr>
          <tr>
         <td>:T_MAP_COORD:</td>  <td><?php echo $this->Unit->getXRounded();?> : <?php echo $this->Unit->getYRounded();?></td>
         </tr>
         
         <tr>
         <td>:T_GROUP_RANK:</td> <td><?php echo $this->Unit->getLevel();?></td>
         </tr>
         
         <tr><td>:T_ALLIANZNOALLIANZ_HEADER:</td><td><a href='index.php?Section=Allianz&Action=ShowForeignAllianz&s_Name=<?php echo $this->Unit->getUser()->getAllianzName();?>'><?php echo $this->Unit->getUser()->getAllianzName();?></a></td></tr>
        </table></td>
 	    <td valign='top'><table >
        <tr>
		
        <table><tr>
       <td><img src='./images/units/DeathStar_F.png' style="width:100px" alt='' title=':T_DEATH_TITLE:' border='0' > </td>
		 </tr></table>
	</tr>
        <tr>
        <td>
        </td>
        </tr>
        </table> </td>
	    </tr>
	    </table>