<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/WarZone2.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">

<script type="text/javascript" src="javascript/handling.js"></script>

<h2>:T_LOAD_TITLE:</h2>

<?php
if($this->ErrorString)
{
	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
}
?>

<form action="index.php?Section=Dock&amp;Action=Loading&amp;UnitId=<?php echo $this->Unit->getId();?>" method="post" target="">  
<table >
<tr>
 <td><?php echo $this->Unit->getName();?> </td>
 <td>:T_LOAD_AVAILABLE: </td>
 <td>:T_LOAD_CAPACITY:: <?php echo $this->Unit->getStorage();?> </td>
</tr>
 <tr>
 <td>:T_LOAD_FUEL:: </td>
 <td><?php echo $this->Planet->getHydrogen(true);?> </td>
 <td><input type="Text" id="tb_Hydrogen" name="i_PlanetDeuterium" value="<?php echo $this->Unit->getStoredElement("t",true);?>" size="" maxlength="">
	<img src="./images/system/close32.png" width="18px" height="18px" onclick="clearRessource('tb_Hydrogen')" style="cursor: pointer; border: medium none;" title=":T_LOAD_UNLOAD:" />
	<input type="button" onclick="loadRessource('tb_Hydrogen',500)" value="500" />
	<input type="button" onclick="loadRessource('tb_Hydrogen',1000)" value="1k" />
	<input type="button" onclick="loadRessource('tb_Hydrogen',5000)" value="5k" />
	<input type="button" onclick="loadRessource('tb_Hydrogen',10000)" value="10k" />
 </td>
</tr>
<tr>
 <td>:T_HEADER_METAL:: </td>
 <td><?php echo $this->Planet->getMetal(true);?> </td>
 <td><input type="Text" id="tb_Metall" name="i_PlanetMetall" value="<?php echo $this->Unit->getStoredElement("m",true);?>" size="" maxlength=""> 
	<img src="./images/system/close32.png" width="18px" height="18px" onclick="clearRessource('tb_Metall')" style="cursor: pointer; border: medium none;" title=":T_LOAD_UNLOAD:" />
	<input type="button" onclick="loadRessource('tb_Metall',500)" value="500" />
	<input type="button" onclick="loadRessource('tb_Metall',1000)" value="1k" />
	<input type="button" onclick="loadRessource('tb_Metall',5000)" value="5k" />
	<input type="button" onclick="loadRessource('tb_Metall',10000)" value="10k" /></td>
</tr>
<tr>
 <td>:T_HEADER_CRYSTAL:: </td>
 <td><?php echo $this->Planet->getCrystal(true);?> </td>
 <td><input type="Text" id="tb_Crystal" name="i_PlanetKrystal" value="<?php echo $this->Unit->getStoredElement("c",true);?>" size="" maxlength=""> 
	<img src="./images/system/close32.png" width="18px" height="18px" onclick="clearRessource('tb_Crystal')" style="cursor: pointer; border: medium none;" title=":T_LOAD_UNLOAD:" />
	<input type="button" onclick="loadRessource('tb_Crystal',500)" value="500" />
	<input type="button" onclick="loadRessource('tb_Crystal',1000)" value="1k" />
	<input type="button" onclick="loadRessource('tb_Crystal',5000)" value="5k" />
	<input type="button" onclick="loadRessource('tb_Crystal',10000)" value="10k" />
</td>
</tr>
 <tr>
 <td>:T_HEADER_BIOMAS::</td>
 <td><?php echo $this->Planet->getBiomass(true);?> </td>
 <td><input type="Text" id="tb_BioMass" name="i_PlanetBioMass" value="<?php echo $this->Unit->getStoredElement("b",true);?>" size="" maxlength=""> 
	<img src="./images/system/close32.png" width="18px" height="18px" onclick="clearRessource('tb_BioMass')" style="cursor: pointer; border: medium none;" title=":T_LOAD_UNLOAD:" />
	<input type="button" onclick="loadRessource('tb_BioMass',500)" value="500" />
	<input type="button" onclick="loadRessource('tb_BioMass',1000)" value="1k" />
	<input type="button" onclick="loadRessource('tb_BioMass',5000)" value="5k" />
	<input type="button" onclick="loadRessource('tb_BioMass',10000)" value="10k" />
</td>
</tr>
</table>
<input type="Submit" name="" value=":T_LOAD_LOADUNLOAD:">  
</form>  

</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>