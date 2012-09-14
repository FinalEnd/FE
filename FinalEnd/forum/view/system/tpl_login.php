<?php
	include "view/tpl_Menu.php";
?>
<fieldset style="width: 90%; border: 4px solid ;background-color:rgb(255, 255, 224);">
          Du bist nicht angemeldet. Bitte fülle die Felder unten auf der Seite aus und versuche es erneut.<br />

          <form action='index.php?section=login' method='post'>
          <table align="center">
          <tr><td><h2>Login</h2></td></tr>
			<tr><td><input style="background-image:url(./images/name_03.jpg);background-repeat:no-repeat;" type='text' name='name' value='' onfocus='this.style.backgroundImage=""' maxlength='25' /></td></tr>
			<tr><td><input style="background-image:url(./images/pw_03.jpg);background-repeat:no-repeat;" type='password' name='pass' onfocus='this.style.backgroundImage=""' value='' maxlength='25' /></td></tr>
			<tr><td><input type='submit' style='cursor: pointer;background: transparent url(./images/Login.png);border:none;width:60px;height:27px;padding-left: 20px;'  class='button' name='login' value='' /><a href='index.php?section=Register'><img src='./images/registry.png' alt='Registrieren' /></a></td></tr>
           </table>
          </form>
     </fieldset>