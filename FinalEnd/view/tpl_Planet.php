<?php
include("tpl_IngameHeaderNew.php");
?>

<script type="text/javascript">
<!--
function show(ElementId)
{
	if(!document.getElementById(ElementId))
	{
		return false;
	}
	document.getElementById(ElementId).style.display='block';
}


function hide(ElementId)
{
	if(!document.getElementById(ElementId))
	{
		return false;
	}
	document.getElementById(ElementId).style.display='none';
}
//-->
</script>


<style type="text/css">
.border {
	border-width:1px;
	border-style:solid;
	border-color:blue;
</style>

<div class="" style="position:relative;width:100%;height:100%;text-align:center" id="Main">
 

	<div class="" id="OverView" style="margin:auto;width:1280px;height:720px;background-image:url(./images/design/Background.png);background-repeat:no-repeat">
	
	<div style="position:relative;top:236px;left:84px;width:103px;height:128px;float:left;"  >
		<div style="position:relative;width:103px;height:128px;float:left;"  
		onmouseover="show('SettingsPic')" 
		class=""
		onmouseout="hide('SettingsPic')">
		<a href="index.php?Section=User&amp;Action=ShowSettings" title=":T_NAVI_SETTINGS:"><img id="SettingsPic" style="display:none;" src="./images/design/SettingsMarked.png"></a>
		</div>
		</div>
	
		<div style="position:relative;width:81px;height:110px;float:left;top:228px;left:125px;"  >
		<div style="position:relative;width:81px;height:110px;"  
		onmouseover="show('SkillPic')" 
		class=""
		onmouseout="hide('SkillPic')">
		<a href="index.php?Section=Skill&Action=ShowUserSkills" title=":T_NAVI_SKILL:"><img id="SkillPic" style="display:none;" src="./images/design/SkillsMarked.png"></a>
		</div>
		</div>
	
	
	
	
	
		<div style="position:relative;width:70px;height:96px;float:left;top:222px;left:150px;"  >
		<div style="position:relative;width:70px;height:96px;"  
		onmouseover="show('TradePic')" 
		class=""
		onmouseout="hide('TradePic')">
		<a href="index.php?Section=Trade" title=":T_NAVI_TRADE:"><img id="TradePic" style="display:none;" src="./images/design/TradeMarked.png"></a>
		</div>
		</div>
	
		
		<div style="position:relative;width:187px;height:154px;float:left;top:134px;left:227px;" >
		<div style="position:relative;width:187px;height:154px;"  
		onmouseover="show('BuildingPic')" 
		class=""
		onmouseout="hide('BuildingPic')">
		<a href="index.php?Section=Building" title=":T_NAVI_BUILDINGS:"><img id="BuildingPic" style="display:none;" src="./images/design/BuildingsMarked.png"></a>
		</div>
		</div>
		
		<div style="position:relative;width:123px;height:96px;float:left;top:270px;left:354px;" >
		<div style="position:relative;width:123px;height:96px;"  
		onmouseover="show('LabPic')" 
		class=""
		onmouseout="hide('LabPic')">
		<a href="index.php?Section=ReSearch" title=":T_NAVI_RESEARCH:"><img id="LabPic" style="display:none;" src="./images/design/LabMarked.png"></a>
		</div>
		</div>
		
		
		<div style="position:relative;width:117px;height:76px;float:left;top:210px;left:413px;" >
		<div style="position:relative;width:117px;height:76px;"  
		onmouseover="show('MSGPic')" 
		class=""
		onmouseout="hide('MSGPic')">
		<a href="index.php?Section=Messages" title=":T_NAVI_MSG:"><img id="MSGPic" style="display:none;" src="./images/design/MessageMarked.png"></a>
		</div>
		</div>	
	
		<div style="position:relative;width:125px;height:77px;float:left;top:212px;left:441px;" >
		<div style="position:relative;width:125px;height:77px;"  
		onmouseover="show('AllianzPic')" 
		class=""
		onmouseout="hide('AllianzPic')">
		<a href="index.php?Section=Allianz" title=":T_NAVI_ALLIANZ:"><img id="AllianzPic" style="display:none;" src="./images/design/AllianzMarked.png"></a>
		</div>
		</div>
		
		
		<div style="position:relative;width:323px;height:78px;float:left;top:301px;left:-360px;" >
		<div style="position:relative;width:323px;height:78px;"  
		onmouseover="show('DockPic')" 
		class=""
		onmouseout="hide('DockPic')">
		<a href="index.php?Section=Ships&amp;Action=ShowDock" title=":T_NAVI_SHIPYARD:"><img id="DockPic" style="display:none;" src="./images/design/Warzone2Marked.png"></a>
		</div>
		</div>
		
		
		
		
		<div style="position:relative;width:321px;height:87px;float:left;top:321px;left:-116px;" >
		<div style="position:relative;width:321px;height:87px;"  
		onmouseover="show('ShipYardPic')" 
		class=""
		onmouseout="hide('ShipYardPic')">
		<a href="index.php?Section=Dock" title=":T_NAVI_DOCK:"><img id="ShipYardPic" style="display:none;" src="./images/design/WarzoneMarked.png"></a>
		</div>
		</div>
		
		<div style="position:relative;width:537px;height:169px;float:left;top:320px;left:626px;" >
		<div style="position:relative;width:537px;height:169px;"  
		onmouseover="show('MapPic')" 
		class=""
		onmouseout="hide('MapPic')">
		<a href="index.php?Section=Map" title=":T_NAVI_MAP:"><img id="MapPic" style="display:none;" src="./images/design/MapMarked.png"></a>
		</div>
		</div>
		
		<div style="position:relative;top:298px;left:-472px;width:657px;height:208px;float:left;"  class="">
		<div style="position:relative;width:200px;height:208px;float:left;"  onmouseover="show('ExitPic')" 
		class=""
		 onmouseout="hide('ExitPic')">
		<a href="index.php?Section=Login&amp;Action=Logout" title=":T_HEADER_LOGOUT:"><img id="ExitPic" style="display:none;" src="./images/design/Exit.png"></a>
		</div>
		<div style="position:relative;width:200px;height:208px;z-index:5;left:158px;"  onmouseover="hide('ExtiPic')" class="" />
		</div>
	
		
	</div>
	
	</div>
	
	
	</div>
	<div style="clear:both"></div>
	<?php
	include("tpl_Panel.php");
	?>
	
</div>

<?php

include("tpl_Footer.php");
?>