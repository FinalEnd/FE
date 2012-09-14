<?php

include("view/tpl_Header.php");

?>
<h2>Forum Suche</h2>





 <form action="index.php?section=Forum&Action=Search" method="post" target="">
<table >
<tr>
 <td>Suche: </td>
 <td><input type="Text" name="tb_Search" value="" size="" maxlength=""> </td>
<td><input type="Submit" name="btn_Search" value="" style='cursor: pointer;background: transparent url(./images/Suchen.png);border:none;width:80px;height:25px;padding-left: 2px;'>  </td>
</tr>
</table>
</form>



<table style="background-color:#000000;width:100%">
	<tr style="color: rgb(255, 255, 255); font-weight: bold; background-image: url(images/site_background2.gif);font-size:18px;"><td> User</td><td>Beitrag</td></tr>
<?php
$i=0;
foreach($this->ForumContentCollection as $ForumContent)
{
	$i++;
	echo "<tr style='background-color: rgb(255, 255, 224);'>";
	echo"<td style='width:15%;' valign='top'><div style='font-size:1.3em'>".$ForumContent->getUser()->getName()."</div><div style='font-size:0.7em'>".$ForumContent->getUser()->getLevelAsString()."<br />erstellt am: ".$ForumContent->getCreateDate()."</div>";
	echo "<h3><a href='index.php?section=Forum&amp;Action=ShowThreadContent&amp;ThreadId=".$ForumContent->getThreadId()."' > Zum Thread</a></h3> 
	</td>";
	echo"<td valign='top'>".$ForumContent->getContent()." </td>";
	echo "</tr>";
	#region Google anzeige
	if($this->Add && $i===1)
	{
		echo "<tr style='background-color: rgb(255, 255, 224);'>";
		echo'<td colspan="2"><script type="text/javascript"><!--
google_ad_client = "pub-9907469491233698";
/* Final-End Forum 728x90, Erstellt 05.10.10 */
google_ad_slot = "3514846594";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script> </td>';
		echo "</tr>";
	}
	#endregion
}
?>
</table>


<?php

include("view/tpl_Footer.php");

?>