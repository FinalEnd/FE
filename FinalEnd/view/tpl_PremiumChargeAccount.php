<?php
include("tpl_IngameHeaderNew.php");
?>



<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Settings.png);background-repeat:no-repeat" >

<div style="position:relative;top:30px;left:220px;border-radius:20px;padding:5%;width:720px;height:500px;overflow:auto;background-image:url(./images/design/Transparent.png);">

<h2>:T_PREM_TITLE:</h2>

<p>:T_PREM_DISCRIPT2:</p>

 <b>:T_PREM_DISCRIPT1:</b><br><br>

<table width="60%">
<tr>
 <td class="header" colspan="3">:T_PREM_SPONSORS:</td>

</tr>
<tr>
 <td>1 :T_PREM_SPONSORS_MONT: </td>
 <td><?php echo PREMIUM_1_MONTH_PRICE; ?>  € </td>
 <td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="6KM9D8WU9Z7AE">
<input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form> </td>
</tr>

 <tr>
 <td>2 :T_PREM_SPONSORS_MONT: </td>
 <td><?php echo PREMIUM_2_MONTH_PRICE; ?> € </td>
 <td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="QTZFXXRYHGSL6">
<input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form>
 </td>
</tr>

<tr>
 <td>3 :T_PREM_SPONSORS_MONT: </td>
 <td><?php echo PREMIUM_3_MONTH_PRICE; ?> € </td>
 <td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="MHW4SS57U6MYE">
<input type="image" src="https://www.paypalobjects.com/de_DE/DE/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal.">
<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
</form>
 </td>
</tr>

</table>


<table width="30%" id="Results">

</table>


</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
	


<?php

include("tpl_Footer.php");
?>