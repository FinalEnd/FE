<?php
include("tpl_IngameHeaderNew.php");
?>
<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Allianz.png);background-repeat:no-repeat" >

<div style="position:relative;top:55px;left:220px;border-radius:20px;padding:5%;width:720px;height:450px;overflow:auto;background-image:url(./images/design/Transparent.png);">


 <h2>:T_ALLIANZNOALLIANZ_HEADER:</h2>

<p>:T_ALLIANZNOALLIANZ_T1:</p>
<p>:T_ALLIANZNOALLIANZ_T2:</p>
 <br />
<p><a href ="index.php?Section=Allianz&amp;Action=ShowCreateAllianz" class="VIPLink">:BTN_ALLIANZNOALLIANZ_CREATE_ALLIANZ:</a>  </p>

<p>:T_ALLIANZNOALLIANZ_SEARCH_ALLIANZ:</p>


 <form action="" method="post" >
      <input type="Text" name="s_Name" value="" size="" maxlength="">
      <input type="Submit" name="" value=":BTN_ALLIANZNOALLIANZ_SEARCH:">
</form>

	  <table  class="Table" width="50%" >
<tr>
 
 <td >:T_ALLIANZNOALLIANZ_NAME:</td>
 <td >:T_ALLIANZNOALLIANZ_MEMBERCOUNT:</td>
</tr>

   <?php

		foreach($this->AllianzCollection as $Allianz)
		{
   	echo" <tr>
			 <td ><a href='index.php?Section=Allianz&Action=ShowForeignAllianz&s_Name=".$Allianz->getName()."'>".$Allianz->getName()."</a></td>
			 <td >".$Allianz->getUserCount()."</td>
			</tr>  ";
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