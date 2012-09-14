<?php

include("view/tpl_Header.php");

?>
<SCRIPT LANGUAGE="JavaScript1.1" TYPE="text/javascript">
<!--
function farbe(farbe)
{
    eing=prompt("text eingeben","");
    if(eing != false || eing != "")
    {
        document.getElementById("rtb_Content").value += "[color="+farbe+"]"+eing+"[/b]"+" ";
        document.getElementById("rtb_Content").focus();
    }
}


function fett()
{
    eing=prompt("text eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Content").value += "[b]"+eing+"[/b]"+" ";
        document.getElementById("rtb_Content").focus();
    }
}

function kursiv()
{
    eing=prompt("text eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Content").value += "[i]"+eing+"[/i]"+" ";
        document.getElementById("rtb_Content").focus();
    }
}
function ustrich()
{
    eing=prompt("text eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Content").value += "[u]"+eing+"[/u]"+" ";
        document.getElementById("rtb_Content").focus();
    }
}
function img()
{
    eing=prompt("bild adresse eingeben","http://");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Content").value += "[img]"+eing+"[/img]"+" ";
        document.getElementById("rtb_Content").focus();
    }
}
function http()
{
    eing=prompt("link adresse eingeben","http://");
    if((eing !="") && (eing !=null))
    {
        eins = "[a]"+eing+"[/a]"+"";
        document.getElementById("rtb_Content").focus();
    }
    eing=prompt("namen des links eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Content").value +=eins+eing+"[/1a]"+" ";
        document.getElementById("rtb_Content").focus();
    }
}

function smile(thesmilie)
{
			document.getElementById("rtb_Content").value += thesmilie+" ";
			document.getElementById("rtb_Content").focus();
}

//-->
</script>
<noscript></noscript>
<h1 class="ForumHeader">Thread erstellen</h1>





<form action="index.php?section=Forum&Action=CreateThread&amp;ThreadId=<?php echo $this->ThreadId;?>" method="post" target="">
<table class="ForumHeader" border="0">
<tr>
 <td>Name: </td>
 <td colspan="2"><input type="Text" name="tb_Name" value="" size="60" maxlength=""> </td>
</tr>
<tr>
 <td >Beschreibung: </td>
 <td colspan="2"><input type="Text" name="tb_Description" value="" size="60" maxlength=""> </td>
</tr>
<tr>
 <td colspan="3"><table >
<tr>
 <td><input type="button" style='cursor: pointer;width:55px;height:27px;padding-left: 2px;' onClick="fett()" value="Fett"> </td>
 <td><input type="button" style='cursor: pointer;width:65px;height:27px;padding-left: 2px;' onClick="kursiv()" value="Kursiv"> </td>
 <td><input type="button" style='cursor: pointer;width:150px;height:27px;padding-left: 2px;' onClick="ustrich()" value="Unterstrichen"> </td>
 <td><input type="button" style='cursor: pointer;width:45px;height:27px;padding-left: 2px;' onClick="img()" value="Bild"> </td>
 <td><input type="button" style='cursor: pointer;width:65px;height:27px;padding-left: 2px;' onClick="http()" value="Link"></td>
 <td><input type="button" style='cursor: pointer;width:100px;height:22px;padding-left: 2px;' onClick="tube()" value="Youtube"></td>
<td><iframe src="http://pic-upload.eu/index.php?Section=Picture&Action=m&c=000000" scrolling="no" frameborder="0" width="360" height="50" name=""></iframe> </td>
</tr>
<tr>
			<td colspan="4"><textarea id="rtb_Content" name="rtb_Content" cols="100" rows="16"></textarea> </td>
			<td colspan="3"><table width="100%" >
<tr  align="center" >
 <td> <a href="javascript:smile(':)')"><img src='./images/smile/1.gif'></a> </td>
 <td> <a href="javascript:smile(':weis:')"><img src='./images/smile/3.gif'></a></td>
 <td> <a href="javascript:smile(':crazy:')"><img src='./images/smile/4.gif'></a></td>
 <td> <a href="javascript:smile(':arsch:')"><img src='./images/smile/5.gif'></a></td>
</tr>
<tr align="center" >
 <td> <a href="javascript:smile(':axt:')"><img src='./images/smile/7.gif'></a></td>
 <td> <a href="javascript:smile(':weisnicht:')"><img src='./images/smile/9.gif'></a></td>
 <td> <a href="javascript:smile(':teufel:')"><img src='./images/smile/10.gif'></a></td>
 <td> <a href="javascript:smile(':grun:')"><img src='./images/smile/11.gif'></a></td>
</tr>
<tr align="center">
 <td> <a href="javascript:smile(':kuss:')"><img src='./images/smile/19.gif'></a></td>
 <td> <a href="javascript:smile(':krank2:')"><img src='./images/smile/21.gif'></a></td>
 <td> <a href="javascript:smile(':blau:')"><img src='./images/smile/13.gif'></a></td>
 <td> <a href="javascript:smile(':zwei:')"><img src='./images/smile/33.gif'></a></td>
</tr>
<tr align="center">
 <td> <a href="javascript:smile(':rubel:')"><img src='./images/smile/25.gif'></a></td>
 <td> <a href="javascript:smile(':trink:')"><img src='./images/smile/26.gif'></a></td>
 <td> <a href="javascript:smile(':brille:')"><img src='./images/smile/27.gif'></a></td>
 <td> <a href="javascript:smile(':rot:')"><img src='./images/smile/28.gif'></a></td>
</tr>
<tr align="center">
 <td> <a href="javascript:smile(':komisch:')"><img src='./images/smile/31.gif'></a></td>
 <td> <a href="javascript:smile(';)')"><img src='./images/smile/14.gif'></a></td>
 <td> <a href="javascript:smile(':horer:')"><img src='./images/smile/34.gif'></a></td>
 <td> <a href="javascript:smile(':keule:')"><img src='./images/smile/35.gif'></a></td>
</tr>
<tr align="center">
 <td> <a href="javascript:smile(':lachen:')"><img src='./images/smile/37.gif'></a></td>
 <td> <a href="javascript:smile(':)')"><img src='./images/smile/38.gif'></a></td>
 <td> <a href="javascript:smile(':tele:')"><img src='./images/smile/29.gif'></a></td>
 <td> <a href="javascript:smile(':bier:')"><img src='./images/smile/30.gif'></a></td>
</tr>
 <tr align="center">
 <td> <a href="javascript:smile(':un:')"><img src='./images/smile/6.gif'></a></td>
  <td> <a href="javascript:smile(':wut:')"><img src='./images/smile/12.gif'></a></td>
  <td> <a href="javascript:smile(':mord:')"><img src='./images/smile/18.gif'></a></td>
  <td> <a href="javascript:smile(':stock:')"><img src='./images/smile/24.gif'></a></td>
 </tr>
 <tr align="center">
 <td> <a href="javascript:smile(':lol:')"><img src='./images/smile/22.gif'></a></td>
 <td> <a href="javascript:smile(':krank:')"><img src='./images/smile/20.gif'></a></td>
 <td> <a href="javascript:smile(':ironi:')"><img src='./images/smile/15.gif'></a></td>
 <td> <a href="javascript:smile(':ahnung:')"><img src='./images/smile/23.gif'></a></td>
 </tr>
 </table> </td>
</tr>
<?php
if($this->User->check(10))
{
echo '<tr>
 <td>Modus: </td>
			<td colspan="6">
    <select name="cb_Modus" size="">
     <option value="0">für alle sichtbar                     | User/Moderator/Admin darf schreiben</option>
     <option value="1">für alle sichtbar                     | Moderator/Admin darf schreiben</option>
     <option value="2">für alle sichtbar                     | Admin darf schreiben</option>
     <option value="3">Nur Für User oder höher sichtbar      | User/Moderator/Admin darf schreiben</option>
     <option value="4">Nur Für User oder höher sichtbar      | Moderator/Admin darf schreiben     </option>
     <option value="5">Nur Für User oder höher sichtbar      | Admin darf schreiben     </option>
     <option value="6">Nur Für Moderator oder höher sichtbar | Moderator/Admin darf schreiben     </option>
     <option value="7">Nur Für Admin sichtbar                | Admin darf schreiben     </option>
    </select>
  </td>
</tr>
	<tr>
	<td>Strucktur? (Gibt an ob in der unteren ebene Postings [ ] oder weitere Threads [x] erstellt werden können) </td>
			<td colspan="6"><input type="Checkbox" name="cb_Struct" value="1"> </td>
	</tr>';
}
?>
</table>
 <input type="Submit" style='cursor: pointer;width:115px;height:25px;' name="" value="Erstellen">
</form>

