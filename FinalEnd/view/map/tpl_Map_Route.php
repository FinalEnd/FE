<?php





?>

 <table width="100%"  >
<tr>
 <td><input type="Button" name="" onclick="getMap().addRoute()" title=":T_ROUTE_DISCSAVE:." value=":T_ROUTE_SAVE:" /> </td>
 <td>Name: </td>
 <td><input type="text" name="tb_RouteName" id="tb_RouteName"  value="" /> </td>
 <td><input type="Button" name="" title=":T_ROUTE_CHECKPOINTDEL:." value=":T_ROUTE_DELWAYP:" onclick="getMap().getRoute().clearAll()" /> </td>
 <td><input type="Button" name="" title=":T_ROUTE_BACKTOFLEET:" onclick="getMap().showSelectetUnitDesciption()" value=":T_GROUP_BACK:" /> </td>
</tr>
</table>


 
 <div  style="width:40px;float:left"> </div>
 <div style="width:140px;float:left" align="center" >:T_MAP_COORD: </div>
 <div style="width:140px;float:left" align="center" >:T_ROUTE_ACTION: </div>
 <div style="width:140px;float:left" align="center" >:T_ROUTE_RESSOURCE: </div>
 <div style="width:100px;float:left" align="center" >:T_ROUTE_AMOUNT: </div>
  <hr style="clear:both;" />




<div width="100%" id="RouteTable" border="1" >





</div>