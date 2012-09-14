<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Final End</title>
<meta name="keywords" content="" />
<meta name="Gestured" content="" />
<link href="./css/default.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body scroll="no">





<script type="text/javascript" src="javascript/System.js"></script>
<script type="text/javascript" src="javascript/PicLoader.js"></script>
<script type="text/javascript" src="javascript/ajax.js"></script>
<script type="text/javascript" src="javascript/Units.js"></script>
<script type="text/javascript" src="javascript/Route.js"></script>
<script type="text/javascript" src="javascript/Maplayer.js"></script>
<script type="text/javascript" src="javascript/Map.js"></script>
<script type="text/javascript" src="javascript/Skill.js"></script>

<!--[if IE]><script type="text/javascript" src="javascript/excanvas.js"></script><![endif]-->



  <style type="text/css">

	html, body, textarea {


  scrollbar-base-color:#000000;
  scrollbar-3d-light-color:#FFFFFF;
  scrollbar-arrow-color:#FFFFFF;
  scrollbar-darkshadow-color:#000000;
  scrollbar-face-color:#000000;
  scrollbar-highlight-color:#FFFFFF;
  scrollbar-shadow-color:#FFFFFF;
  scrollbar-track-color:#000000;
}



</style>
<div id="DetailLayer"  style="position:absolute;background-color:#000000;border-width:1px;border-style:solid;border-color:344849;" onmousemove="getMap().hideLayer()"></div>
<div id="CollectionContainer" style="display:none;position:absolute ; top:0px; 0px;background-color:#000000;" ></div>

	<div id="DetailsContainerWrapper" style="top:50px;position:absolute;width:570px;height:335px;display:none">
		<div><img src="./images/system/close32.png" onclick="$('DetailsContainerWrapper').hide();" alt ="close" title="Close" style="width:25px;height:25px;" /></div>
	
		<div id="DetailsContainer" style="width:570px;height:335px;background-color:#000000;border-width:1px;border-style:solid;border-color:344849;" ></div>
	</div>
<div id="ControlPanel" style="position:absolute ; top:<?php echo $this->ResY-110;?>px; left:<?php echo $this->ResX-170;?>px;z-index:5;">
	<table >
	<tr>
	 <td><input onclick="getMap().ZoomIn()" style="background: transparent url(./images/Map/Plas.png);border:none;width:50px;height:50px;" type="button" name="" value=""> </td>
	 <td><input onclick="getMap().setUp()" style="background: transparent url(./images/Map/Top.png);border:none;width:50px;height:50px;" type="button" name="" value=""> </td>
	 <td><input onclick="getMap().ZoomOut()" style="background: transparent url(./images/Map/Minus.png);border:none;width:50px;height:50px;" type="button" name="" value=""><br /></td>
	</tr>
	<tr>
	 <td><input onclick="getMap().setLeft()" style="background: transparent url(./images/Map/Left.png);border:none;width:50px;height:50px;" type="button" name="" value=""></td>
	 <td><input onclick="getMap().setDown()" style="background: transparent url(./images/Map/Down.png);border:none;width:50px;height:50px;" type="button" name="" value=""></td>
	 <td><input onclick="getMap().setRight()" style="background: transparent url(./images/Map/Right.png);border:none;width:50px;height:50px;" type="button" name="" value=""></td>
	</tr>
	</table>
	</div>   
</div>

<div class ="BuildingBackground" style="z-index:1;margin:auto;padding:0px;" >

<div style="">

<div id="Main" style="background-image:url(./images/design/Transparent.png);width:533px;height:25px;">

<div id="MapHeader" style="background-image:url(./images/Map/header.png);position:absolute ;top:5px;width:832px;height:45px;z-index:1;padding-top:7px;padding-left:40px;background-repeat:no-repeat;">
	<div style="left:20px;width:100px;z-index:1;float:left;" id="KoordinateDiv">:T_MAP_COORD::</div>
	
	<div style="top:3px;left:220px;float:left;" >
	X<input id="i_KoorX" onkeyup='MySkill.split("i_Koor",this.value)' type="text" name="i_X" value="" size="" maxlength="">
	Y<input id="i_KoorY" type="text" name="i_Y" value="" size="" maxlength="" />
	<input onclick="getMap().showMapOnKoordiante()" type="submit" name="" value=":T_MAP_SHOW:" />
	</div>
<div style="width:100px;float:left;" id="IdentificationMarkDiv"><input type="checkbox" checked="checked" name="" id="IdentificationMark" onclick="getMap().checkIdentificationMark()" value="v">:T_MAP_MARKING:</div>
<div style="width:100px;float:left;" id="cb_ShowAstroidsDiv"><input type="checkbox" checked="checked" name="" id="cb_ShowAstroids" onclick="getMap().checkAstroids()" value="v">:T_MAP_OBJECTS:</div>
</div>


		<canvas id="MapContainer" OnMouseWheel="getMap().handleWheel()"   ondblclick="getMap().centerMapOnKoordiante()" width="<?php echo $this->ResX; ?>" height="<?php echo $this->ResY; ?>" style="border-width:1px;border-style:solid;border-color:grey;" >
			
		</canvas>

<div id="RightMenuPanel" style="position:absolute;top:0px; left:<?php echo $this->ResX-20;?>px;">


	<div  id="UserUnitContainerButton" style="background-image:url(./images/Map/all.png);width:20px;height:160px;" ></div>

	<div  id="UserPlanetContainerButton" style="background-image:url(./images/Map/planets.png);position:absolute;top:170px; left:0px;width:20px;height:160px;"></div>

	<div  id="UserFleetsContainerButton" style="background-image:url(./images/Map/fleets.png);position:absolute;top:340px; left:0px;width:20px;height:160px;"></div>


	<div  id="UserUnitContainer" class="border" style="overflow:auto;position:absolute;display:none;top:40px; left:-180px;background-color:#000000;width:180px;height:600px;" ></div>

	<div  id="UserPlanetContainer" class="border" style="overflow:auto;position:absolute;display:none;top:40px; left:-180px;background-color:#000000;width:180px;height:600px;" ></div>

	<div  id="UserFleetsContainer" class="border" style="overflow:auto;position:absolute;display:none;top:40px; left:-180px;background-color:#000000;width:180px;height:600px;" ></div>


</div>

</div>
</div>	

<div id="PanelMapDivButton" style="position:absolute;left:<?php echo $this->ResX/2-72;?>px;top:<?php echo $this->ResY-35;?>px;width:145px;height:40px;background-image:url(./images/Map/middelfader.png);"></div>

<div id="PanelMapDiv" style="position:absolute ;display:none; top:<?php echo $this->ResY-115;?>px;width:99%;height:100px;" >
	<?php
	include("tpl_Panel.php");
	?>
</div>



<script type="text/javascript" language="JavaScript">

   var MyMap= getMap(<?php echo $this->X.",".$this->Y;?>);
	MyMap.setWidth(<?php echo $this->ResX;?>);
	MyMap.setHeight(<?php echo $this->ResY;?>);
	// sprache setzen
	
	MyMap.setLanguage({
	NeedMoreRessourceForDeathStar:":T_MAP_NEED_MORE_RES_FOR_DEATH_STAR:",
	Name : ":T_MAP_NAME:",
	Owner : ":T_MAP_OWNER:",
	Allianz : ":T_MAP_ALLIANZ:",
	Coordinates:":T_MAP_COORDINATES:",
	NeedMoreRessourceToBuildDeathStar:":T_MAP_NEED_MORE_RES_TO_BUILD_DEATH_STAR:",
	DestroyPlanet:":T_MAP_DESTROY_PLANET:",
	NoPlanetInRange:":T_MAP_NO_PLANET_IN_RANGE:",
	NewBrowser:":T_MAP_WRONG_BROWSER:",
	CBMove:":CB_ROUTE_MOVE:",
	CBRaid:":CB_ROUTE_RAID:",
	CBScan:":CB_ROUTE_SCAN:",
	CBLoad:":CB_ROUTE_LOAD:",
	CBUnload:":CB_ROUTE_UNLOAD:",
	TMetal:":T_HEADER_METAL:",
	TCrystal:":T_HEADER_CRYSTAL:",
	THydrogen:":T_HEADER_HYDROGEN:",
	TBiomas:":T_HEADER_BIOMAS:"
	});
	
	
	
	
	 <?php echo $this->MyTaskCollection->getJs();?>
	  MyMap.setTaskCollection(MyTaskCollection);
	
	
	 <?php echo $this->PlanetCollection->getJs();?>
	MyMap.setPlanetCollection(MyPlanetCollection);
	
	 <?php echo $this->MyUnitCollection->getJs($this->User);?>
	MyMap.setUnitCollection(MyUnitCollection);
	
	MyPlanetCollection.clear();
	MyPlanetCollection=null;
	<?php echo $this->UserPlanetCollection->getJs();?>
	MyMap.setUserPlanetCollection(MyPlanetCollection);
	
	
	MyMapObjectCollection=null;
	<?php echo $this->MapObjectCollection->getJs();?>
	MyMap.setMapObjectCollection(MyMapObjectCollection);
	
	MyUnitCollection=null;
	  <?php echo $this->UserUnitCollection->getJs($this->User);?>
	MyMap.setUserUnitCollection(MyUnitCollection);
	MyMap.setUserName("<?php echo $this->User->getName();?>");
	MyMap.setBackgroundPicture(<?php echo Controler_Main::getInstance()->getDataBaseId();?>); 
	MyMap.start(); 
	MyMap.render();
	MyMap.fillCollectionDiv();
	MyMap.fillUserDivWithOwnerPlanets();
	/*MyMap.fillUserDivWithOwneUnits();*/
	
	
if (document.layers)
{
  document.captureEvents(Event.MOUSEDOWN); 
}
var IsClicked=false;

window.onresize =function(){getMap().reSizeMap();}


function click (e) 
{
 if(IsClicked){return false;}
	IsClicked=true;
  if (!e)
    e = window.event;
  if ((e.type && e.type == "contextmenu") || (e.button && e.button == 2) || (e.which && e.which == 3)) {
	getMap().RightClick=true;
	getMap().mapClick();// mapklick machen
	IsClicked=false;
    return false;
  }
	getMap().RightClick=false;
	clickDown(e);
	getMap().mapClick();
	IsClicked=false;
}

function keyClick(e) 
{
	event = e || window.event;
	if(event.keyCode==17 || event.keyCode==18)
	{
		getMap().StrgPush=true;
	}
}

function keyUp(e) 
{

		getMap().StrgPush=false;
}

function no(e) 
{
	return false;	
}

if (document.layers)
  document.captureEvents(Event.MOUSEDOWN);

	document.oncontextmenu = no;
	document.getElementById("MapContainer").onmouseup =  clickUp;
	document.getElementById("MapContainer").onmousedown =  click;
	document.getElementById("MapContainer").onmousemove = showLayer;
	document.onmousemove = updateMapKoordinate;
	
	document.onkeydown = keyClick;
document.onkeyup = keyUp;

if ($("MapContainer").addEventListener)
{
    $("MapContainer").addEventListener('DOMMouseScroll', getMap().handleWheel, false);
}
$("MapContainer").onmousewheel = $("MapContainer").onmousewheel = getMap().handleWheel;

//*************************************************

var UserUnitContainerButtonTimeOut=null;
$("UserUnitContainerButton").addEvent("mouseover",function()
{
	$("UserUnitContainer").show();
	window.clearTimeout(UserUnitContainerButtonTimeOut);
});

$("UserUnitContainerButton").addEvent("mouseout",function()
{
	UserUnitContainerButtonTimeOut=window.setTimeout(function(){$("UserUnitContainer").hide()},100);
});

$("UserUnitContainer").addEvent("mouseover",function()
{
	$("UserUnitContainer").show();
	window.clearTimeout(UserUnitContainerButtonTimeOut);
});

$("UserUnitContainer").addEvent("mouseout",function()
{
	UserUnitContainerButtonTimeOut=window.setTimeout(function(){$("UserUnitContainer").hide()},100);
	
	});

//******************************


var UserPlanetContainerButtonTimeOut=null;
$("UserPlanetContainerButton").addEvent("mouseover",function()
{
	$("UserPlanetContainer").show();
	window.clearTimeout(UserPlanetContainerButtonTimeOut);
});

$("UserPlanetContainerButton").addEvent("mouseout",function()
{
	//$("UserPlanetContainer").hide();
	UserPlanetContainerButtonTimeOut=window.setTimeout(function(){$("UserPlanetContainer").hide()},100);
});


$("UserPlanetContainer").addEvent("mouseover",function()
{

	$("UserPlanetContainer").show();
	window.clearTimeout(UserPlanetContainerButtonTimeOut);
});

$("UserPlanetContainer").addEvent("mouseout",function()
{
	UserPlanetContainerButtonTimeOut=window.setTimeout(function(){$("UserPlanetContainer").hide()},100);
});


//***********************
var UserFleetsContainerButtonTimeOut=null;
$("UserFleetsContainerButton").addEvent("mouseover",function()
{
	$("UserFleetsContainer").show();
	getMap().fillUserDivWithUnitsViewAble();
	window.clearTimeout(UserFleetsContainerButtonTimeOut);
});

$("UserFleetsContainerButton").addEvent("mouseout",function()
{

	UserFleetsContainerButtonTimeOut=window.setTimeout(function(){$("UserFleetsContainer").hide()},100);
});


$("UserFleetsContainer").addEvent("mouseover",function()
{
	$("UserFleetsContainer").show();
	getMap().fillUserDivWithUnitsViewAble();
	window.clearTimeout(UserFleetsContainerButtonTimeOut);
});

$("UserFleetsContainer").addEvent("mouseout",function()
{
	UserFleetsContainerButtonTimeOut=window.setTimeout(function(){$("UserFleetsContainer").hide()},100);
});


var PanelMapDivButtonTimeOut=null;
$("PanelMapDivButton").addEvent("mouseover",function()
{
	$("PanelMapDiv").show();
	window.clearTimeout(PanelMapDivButtonTimeOut);
});

$("PanelMapDivButton").addEvent("mouseout",function()
{

	PanelMapDivButtonTimeOut=window.setTimeout(function(){$("PanelMapDiv").hide()},2000);
});


$("PanelMapDiv").addEvent("mouseover",function()
{
	$("PanelMapDiv").show();
	window.clearTimeout(PanelMapDivButtonTimeOut);
});

$("PanelMapDiv").addEvent("mouseout",function()
{
	PanelMapDivButtonTimeOut=window.setTimeout(function(){$("PanelMapDiv").hide()},100);
});


</script>

</body>
</html>