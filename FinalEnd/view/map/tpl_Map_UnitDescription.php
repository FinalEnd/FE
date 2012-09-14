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
					 <td>:T_GROUP_LOADINGBAY:</td>  <td><?php echo $this->Unit->getStorage();?> (Frei <?php echo $this->Unit->getFreeStoredSpaceInPerCent();?>% ) </td>
				 </tr>
			 <tr>
				 <td>:T_GROUP_PAY:</td>  <td><?php echo $this->Unit->getPay();?> :T_PLAN_CPERH: </td>
			 </tr>
			 <tr>
				 <td><?php echo $this->Unit->getExtensionName($this->Unit->getExtentionOne());?></td>  <td><?php echo $this->Unit->getExtensionName($this->Unit->getExtentionTow());?></td>
			 </tr>
			 <tr>
				<td colspan='2'>
				<table width='100%' >
					<tr>
					 <td align='center'><img src='./images/Treibstoff.png' width='20px' height='20px' class='Icons' alt='Deuterium' title=':T_HEADER_HYDROGEN:' /> </td>
					 <td align='center'><img src='./images/metal.png' width='20px' height='20px' class='Icons' alt='Metal' title=':T_HEADER_METAL:' /> </td>
					 <td align='center'><img src='./images/kristal.png' width='20px' height='20px' class='Icons' alt='Kristal' title=':T_HEADER_CRYSTAL:' /> </td>
					 <td align='center'><img src='./images/fleisch.png' width='20px' height='20px' class='Icons' alt='Lebensmittel' title=':T_HEADER_BIOMAS:' /> </td>
				</tr>
			<tr>
				 <td align='center'><?php echo $this->Unit->getStoredHydrogen();?> </td>
				 <td align='center'><?php echo $this->Unit->getStoredElement("m",true);?> </td>
				 <td align='center'><?php echo $this->Unit->getStoredElement("c",true);?> </td>
				 <td align='center'><?php echo $this->Unit->getStoredElement("b",true);?> </td>
			</tr>
</table></td>  
        </tr>     
        </table></td>
 	    <td valign='top' width="50%"><table >
        <tr>
        <td  colspan='2' width="100%"><input type='button' name='' title=':T_ROUTE_CENTERFLEET:.' onclick='getMap().showMapOnKoordianteXY(<?php echo $this->Unit->getX();?>,<?php echo $this->Unit->getY();?>)' value=':T_ROUTE_CENTERFLEET:'>
		
		<input type='button' name='' title=':T_ROUTE_NEWONE:' onclick='getMap().showRout()' value=':T_ROUTE_ROUTENEW:' />
		<input type='button' name='' title=':T_ROUTE_CHANGETHIS:' onclick='getMap().showWorkOnRout()' value=':T_ROUTE_ROUTECHANGE:' />
		
		
		</td>
        </tr>
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
<table >
	<tr>
		<td>:T_ROUTE_ROUTE:</td>
 		<td colspan="4">
  		  <select name="cb_Routes" id="cb_Routes" size="1" style="width:255px">
				 <option value="0">:T_ROUTE_NOROUTE:</option>
				
				<?php
					foreach($this->RouteCollection as $Route)
					{
						echo '<option value="'.$Route->getId().'"';
						if($this->SelectetRoute->getId()==$Route->getId())
						{
						echo "selected";
						}
						
					echo '>'.$Route->getName().' '.$Route->getUnitsOnRoute().'</option>';		
					}
				?>
		  </select>
	</td>
	  </tr>
	 <tr>
	 <td> </td>
	 <td><input type="button" onclick="getMap().addUnitToRoute(1)" name="tb_RouteStart" value=":T_ROUTE_ROUTESTART:" title=":BT_ROUTE_REPEAT:"> </td>
	 <td><input type="button" onclick="getMap().addUnitToRoute(0)" name="tb_RouteStartUniqe" value=":T_ROUTE_ROUTESINGLE:" title=":BT_ROUTE_ONCE:"> </td>
	 <td><input type="button" onclick="getMap().stopUnit()" name="tb_RouteStartUniqe" value=":T_ROUTE_ROUTESTOP:" title=":BT_ROUTE_STOP:"> </td>
	 <td><input type="button" onclick="getMap().deleteRoute()" name="tb_RouteDelete" value=":T_ROUTE_ROUTEDEL:" title=":BT_ROUTE_STOP:"> </td>
	</tr>
</table>

	</td>
            </tr>	
		
        
		<?php
		if($this->Unit->getExtentionOne()==10)
		{
		
			echo "<tr>
           <td colspan='2'><input type='button' id='btn_ScannButton\"+this.Id+\"' name='' onmouseover='getMap().showScannerLayer()' onmouseout='getMap().hideLayer()' onclick='getMap().scanArea(".$this->Unit->getId().")' value=':BT_ROUTE_SCAN:'> </td>
            </tr>
            <tr>
            <td></td>
             <td></td>
            </tr>";
			
		}
		if($this->Unit->getExtentionOne()==20)
		{	
	
			echo " <tr>
           <td colspan='2'><input type='button' id='btn_RaidButton\"+this.Id+\"' name='' onmouseover='getMap().showRaidLayer()' onmouseout='getMap().hideLayer()' onclick='getMap().raidPlanet(".$this->Unit->getId().")' value=':BT_ROUTE_RAID:'> </td>
            </tr>
            <tr>
            <td> </td>
             <td></td>
            </tr>";	
		}
		
		
		if($this->Unit->getExtentionOne()==22 || $this->Unit->getExtentionTow()==22 )
		{	
			
			echo " <tr>
           <td colspan='2'><input type='button' id='btn_recycleButton\"+this.Id+\"' name='' onmouseover='getMap()' onmouseout='getMap()' onclick='getMap().recycleWaste(".$this->Unit->getId().")' value=':BT_ROUTE_COLLECT:'> </td>
            </tr>
            <tr>
            <td> </td>
             <td></td>
            </tr>";

		}
		
		if($this->Unit->getExtentionOne()==24 || $this->Unit->getExtentionTow()==24 )
		{	
			
			echo " <tr>
           <td colspan='2'><input type='button' id='btn_DeathStarButton\"+this.Id+\"' name='' onmouseover='getMap()' onmouseout='getMap()' onclick='getMap().buildDeathStar(".$this->Unit->getId().")' value=':BT_ROUTE_DEATHS:'> </td>
            </tr>
            <tr>
            <td> </td>
             <td></td>
            </tr>";
			
			
		}
		//SPRUNGANTRIEB
		if($this->Unit->getExtentionOne()==25 || $this->Unit->getExtentionTow()==25 )
		{	
			
			echo " <tr>												
           <td colspan='2'><input type='button' id='btn_Jumpengine\"+this.Id+\"' name='' onmouseover='getMap()' onmouseout='getMap()' onclick='getMap().triggerJumpToPosition(".$this->Unit->getId().")' value=':DB_R_JUMPENGINE:'> </td>
            </tr>
            <tr>
            <td> </td>
             <td></td>
            </tr>";
			
			
		}
		
		if($this->Unit->getExtentionOne()==26 || $this->Unit->getExtentionTow()==26 )
		{	
			
			echo " <tr>												
           <td colspan='2'><input type='button' id='btn_EMP\"+this.Id+\"' name='' onmouseover='getMap()' onmouseout='getMap()' onclick='getMap().triggerEMP(".$this->Unit->getId().")' value=':DB_R_EMP:'> </td>
            </tr>
            <tr>
            <td> </td>
             <td></td>
            </tr>";
			
			
		}
		
		?>
        </tr>
	    <tr>
        <td colspan='2'>
        
		
		<table><tr>

       <td><img src='./images/units/BattleShip_F.png' alt='' title=':T_SHIP_NAMEBATTLE:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/Bomber_F.png' alt='' title=':T_SHIP_NAMEBOMB:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/HunterBig_F.png' alt='' title=':T_SHIP_NAMEHHUNTER:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/Hunter_F.png' alt='' title=':T_SHIP_NAMEHUNTER:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/Transporter_F.png' alt='' title=':T_SHIP_NAMEHTRANS:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/TransporterSmall_F.png' alt='' title=':T_SHIP_NAMETRANS:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/Drone_F.png' alt='' title=':T_SHIP_NAMEDRONE:' border='0' class='MapIcon'> </td>
        </tr>
        <tr>
			<td align="center"><?php echo $this->Unit->getShipCountByType("bs");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("b");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("hh");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("sh");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("lt");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("st");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("d");?> </td>
		
		 </tr></table>
        </td>
        </tr>
		<tr>
		<td colspan='2'>
		<?php
		echo $this->Unit->getStateCollectionHTML();
		?>
		</td>
		</tr>
		
				<tr>
		<td colspan='2'>
	   <input type="button" value="::" onclick="getMap.emergencyJump(<?php echo $this->Unit->getId();  ?>)" name="btn_emergencyJump"/> 
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
          <tr><td>:T_PLAN_OWNER:: </td><td><a href="index.php?Section=User&amp;Action=ShowCompareStats&tb_Player='<?php echo $this->Unit->getUser()->getName().'\'"> '.$this->Unit->getUser()->getName(); ?>  </a> <a href='index.php?Section=Messages&PlayerName=<?php echo $this->Unit->getUser()->getName();?>'><img height='15' width='25' src='./images/Msg.jpg' title=':T_ALLIANZFOREIGEN_SEND_MSG:' /></a></td></tr> 
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
         
          <tr>
         <td><?php echo $this->Unit->getExtensionName($this->Unit->getExtentionOne());?></td>  <td><?php echo $this->Unit->getExtensionName($this->Unit->getExtentionTow());?></td>
         </tr>
         <tr><td>:T_ALLIANZNOALLIANZ_HEADER:</td><td><a href='index.php?Section=Allianz&Action=ShowForeignAllianz&s_Name=<?php echo $this->Unit->getUser()->getAllianzName();?>'><?php echo $this->Unit->getUser()->getAllianzName();?></a></td></tr>
        </table></td>
 	    <td valign='top'><table >
        <tr>
        <td colspan='2'><input type='button' name='' onclick='getMap().showMapOnKoordianteXY(<?php echo $this->Unit->getX();?>,<?php echo $this->Unit->getY();?>)' value=':T_PLAN_CENTER:' /> </td>
        </tr>
        <tr>
        <td>
        <table><tr>
       <td><img src='./images/units/BattleShip_F.png' alt='' title=':T_SHIP_NAMEBATTLE:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/Bomber_F.png' alt='' title=':T_SHIP_NAMEBOMB:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/HunterBig_F.png' alt='' title=':T_SHIP_NAMEHHUNTER:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/Hunter_F.png' alt='' title=':T_SHIP_NAMEHUNTER:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/Transporter_F.png' alt='' title=':T_SHIP_NAMEHTRANS:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/TransporterSmall_F.png' alt='' title=':T_SHIP_NAMETRANS:' border='0' class='MapIcon'> </td>
        <td><img src='./images/units/Drone_F.png' alt='' title=':T_SHIP_NAMEDRONE:' border='0' class='MapIcon'> </td>
        </tr>
        <tr>
			<td align="center"><?php echo $this->Unit->getShipCountByType("bs");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("b");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("hh");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("sh");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("lt");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("st");?> </td>
			<td align="center"><?php echo $this->Unit->getShipCountByType("d");?> </td>
		 </tr></table>
        </td>
        </tr>
        </table> </td>
	    </tr>
	    </table>