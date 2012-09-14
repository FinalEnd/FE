<?php
include("tpl_IngameHeaderNew.php");
?>

<script type="text/javascript" src="javascript/Time.js"></script>
<script type="text/javascript" src="javascript/Skill.js"></script>
<script type="text/javascript">
	var MyTimer= new Timer();
	var MySkill= new Skill();

</script>

<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Skills.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">



<div id="Main">
  <h2>:T_SKILL_TITLE:</h2>
<?php
if($this->ErrorString)
{
	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
}
?>
<table class="Table" width='90%' border="0" >

<?php
$TempCollection= $this->SkillCollection;
for($i=0;$i<$TempCollection->getCount();$i++)   // war vorher foreeach hat aber den 4 punkt übersprungen warum auch immer eval
{
	$Skill=$TempCollection->getByIndex($i);
	echo $Skill->getHTML();
}

?>
</table>
</div>

</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>