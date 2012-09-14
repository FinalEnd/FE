<?php
echo '
<form action="indexAdmin.php?Section=Login" method="post" >
<table><tr>
<td>:T_LOGIN_NAME: </td>
       <td colspan="2"><input style="width:95%;" type="text" id="tb_Name" name="tb_NameAdmin" value="" size="" maxlength="" /> </td>
 </tr>
 <tr>
         <td>:T_LOGIN_PASS: </td>
         <td colspan="2"><input style="width:95%;" type="password" name="tb_PassAdmin" value="" size="" maxlength=""  /> </td>
 </tr>
	 <tr>
         <td>:T_LOGIN_GALAXY: </td>
         <td colspan="2"><select style="width:95%;" name="i_Server" size="">
		  <option value="1">:T_LOGIN_BETAVERSE:</option>
		  <option value="2"   >:T_LOGIN_MILYWAY:</option>
		 </select> </td></tr></table><input type="submit" name="" value=":BTN_LOGIN_LOGIN:" /> </form>';
	
?>