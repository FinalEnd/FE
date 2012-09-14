 <?php

 if($this->OwneUnit)
 {
 ?>

<table width='100%' border="0"> 
	<tr>
		<td width='50%'>
			<table width='100%' border="0" >
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
				<td colspan='2'>
				</td>  
        </tr>     
        </table></td>
 	    <td valign='top' width="50%">

		<table border ="0">
		<tr>
        <td  colspan='2' width="100%">:T_DEATH_FLEETSAMONG:
		</td>
        </tr>
		
		<?php

		foreach($this->UnitCollection as $UnitInRange)
		{
			echo "<tr>
			 <td>".$UnitInRange->getName()."</td>
             <td><table width='100%' >
					<tr>
					 <td align='center'><img src='./images/metal.png' width='20px' height='20px' class='Icons' alt='Metal' title=':T_HEADER_METAL:' /> </td>
					 <td align='center'><img src='./images/kristal.png' width='20px' height='20px' class='Icons' alt='Kristal' title=':T_HEADER_CRYSTAL:' /> </td>
				</tr>
			<tr>
				 <td align='center'>".$UnitInRange->getStoredElement('m',true)."</td>
				 <td align='center'>".$UnitInRange->getStoredElement('c',true)." </td>
			</tr>
</table></td>
           <td colspan='2'><input type='button' id='btn_DeathStarButton\"+this.Id+\"'
		 name='' onmouseover='getMap()' title=':T_DEATH_DISC1:.' onmouseout='getMap()' onclick='getMap().loadDeathStar(".$this->Unit->getId().",".$UnitInRange->getId().")' value=':BT_DEATH_FLEETUNLOAD:'> </td>
            </tr>";
			
		}
		echo "</tr>		 
		<tr>
        <td  colspan='2' width='100%'>
		
		<img src='./images/units/DeathStarBuild_F.png' style='width:100px' alt='' title=':T_DEATH_TITLE:' border='0' >
		
		</td>
        </tr>
        </table> </td>
		</tr>


		 <tr>
				<td colspan='2'>
				<h3>Fortschritt</h3>
				</td>  
        </tr>

		 <tr>
				<td colspan='2'>
				
				<div id='ladebalken'>
				   <p style='width: ".$this->Progress."%;'><span>".$this->Progress." %</span></p>
				 </div>
				</td>  
        </tr>    

		 <tr>
				<td >
					:T_MAP_NEED_METAL:   ".$this->NeededMetal."
				</td>  
				<td >
					:T_MAP_NEED_CRYSTAL: ".$this->NeededCristal."
				</td> 
        </tr>    


	    </table>";
	
		return true;
	}
	
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
				<td colspan='2'>
				</td>  
        </tr>     
        </table></td>
 	    <td valign='top' width="50%">
		<table >
        <tr>
        <td  colspan='2' width="100%">
		
		<img src='./images/units/DeathStarBuild_E.png' style="width:100px" alt='' title=':T_DEATH_TITLE:' border='0' >
		
		</td>
        </tr>
		
		<tr>
			<td colspan='2'>
				<h2>Fortschritt</h2>
			</td>  
        </tr>
		
 		 <tr>
				<td colspan='2'>
				
				<div id="ladebalken">
				
				   <p style="width: <?php echo $this->Progress;?>%;"><span><?php echo $this->Progress;?>%</span></p>
				 </div>
				
				</td>  
        </tr>    
		
		</table>
