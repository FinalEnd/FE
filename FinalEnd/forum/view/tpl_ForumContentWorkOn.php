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
        document.getElementById("rtb_Comment").value += "[color="+farbe+"]"+eing+"[/b]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}


function fett()
{
    eing=prompt("text eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Comment").value += "[b]"+eing+"[/b]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}

function kursiv()
{
    eing=prompt("text eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Comment").value += "[i]"+eing+"[/i]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}
function ustrich()
{
    eing=prompt("text eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Comment").value += "[u]"+eing+"[/u]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}
function img()
{
    eing=prompt("bild adresse eingeben","http://");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Comment").value += "[img]"+eing+"[/img]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}
function http()
{
    eing=prompt("link adresse eingeben","http://");
    if((eing !="") && (eing !=null))
    {
        eins = "[a]"+eing+"[/a]"+"";
        document.getElementById("rtb_Comment").focus();
    }
    eing=prompt("namen des links eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Comment").value +=eins+eing+"[/1a]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}

function smile(thesmilie)
{
			document.getElementById("rtb_Comment").value += thesmilie+" ";
			document.getElementById("rtb_Comment").focus();
}

//-->
</script>
<noscript></noscript>
<form action="index.php?section=Forum&Action=UpdateComment&amp;ContentId=<?php echo $this->ContentId;?>&amp;ThreadId=<?php echo $this->ThreadId;?>" method="post" target="">
<table >
<tr>
 <td><input type="button" style=\'cursor: pointer;width:55px;height:27px;padding-left: 2px;\' onClick="fett()" value="Fett"> </td>
 <td><input type="button" style=\'cursor: pointer;width:65px;height:27px;padding-left: 2px;\' onClick="kursiv()" value="Kursiv"> </td>
 <td><input type="button" style=\'cursor: pointer;width:150px;height:27px;padding-left: 2px;\' onClick="ustrich()" value="Unterstrichen"> </td>
 <td><input type="button" style=\'cursor: pointer;width:45px;height:27px;padding-left: 2px;\' onClick="img()" value="Bild"> </td>
 <td><input type="button" style=\'cursor: pointer;width:65px;height:27px;padding-left: 2px;\' onClick="http()" value="Link"></td>
 <td><input type="button" style=\'cursor: pointer;width:100px;height:22px;padding-left: 2px;\' onClick="tube()" value="Youtube"></td>
</tr>
<tr>
			<td colspan="3"><textarea id="rtb_Comment" name="rtb_Comment" cols="60" rows="16"><?php echo $this->ForumComment->getContent();?></textarea> </td>
			<td colspan="2"><table >
<tr align="center" >
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

<tr>
 <td><input type="Submit" style="cursor: pointer;width:110px;height:25px;" name="" value="Bearbeiten"> </td>
</tr>

</table>
  </form>

<?php

include("view/tpl_Footer.php");

?>