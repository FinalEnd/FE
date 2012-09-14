<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Final End</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="author" content="Matthias Herzog" />
<meta name="publisher" content="Matthias Herzog" />
<meta name="copyright" content="Matthias Herzog" />
<meta name="description" content="Final-end ein Actiongeladenes online Browsergame, jetzt kostenlos mit spielen." />
<meta name="keywords" content="Browsergame, SiFi, Action, Matthias Herzog,Kostenloses Browsergame, jetzt ausprobieren, Echtzeit Strategie" />
<meta name="page-topic" content="Spiel" />
<meta name="page-type" content="gaming" />
<meta name="audience" content="Alle" />
<meta http-equiv="content-language" content="de" />
<meta name="robots" content="index, follow" />
<script type="text/javascript" src="javascript/Time.js"></script>
<script type="text/javascript" src="javascript/System.js"></script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"  />
<link rel="stylesheet" type="text/css" href="css/default.css"  />
</head>
<body id="starsbackground" onload="setRes()">

<h2 align="center">:T_REGISTER_HEADER: </h2>  

<?php
if($this->ErrorString)
{
	echo"<h3 style='color:red'>".$this->ErrorString."</h3>";
}
?>
<div align="center">
<form action='index.php?Section=Login&amp;Action=Register' name='form' method='POST' target=''>
:T_REGISTER_NAME:	 <br />
<input type='Text' name='tb_Name' value='<?php echo $this->Name; ?>' size='' maxlength='25'><br>
<p>
:T_REGISTER_PASS1:   <br />
<input type='Password' name='tb_Pass' value='' size='' maxlength='25'><br>
:T_REGISTER_PASS2:   <br />
<input type='Password' name='tb_PassConfirme' value='' size='' maxlength='25'>
</p>

<p class="EmailP">
   <label for="email">Ihre eMail wird hier nicht abgefragt, tragen Sie auch hier bitte NICHTS ein:</label>
   <input id="email" name="email" size="60" value="" />
 </p>


<p>
:T_REGISTER_MAIL1:
<br><input type='Text' name='tb_Mail' value='<?php echo $this->MyMail; ?>' size='' maxlength='90'><br>
:T_REGISTER_MAIL2:
<br><input type='Text' name='tb_MailConfirme' value='<?php echo $this->MyMail; ?>' size='' maxlength='90'><br>
</p>
:T_REGISTER_GALAXY:
<br><select name="i_Server" size="">
	<option value="2" >Milchstraße</option>
      <option value="1">BetaVersum</option>
      
     </select>
	<br>



<input type ="hidden" id="ResX" name="ResX" value="" />
<input type ="hidden" id="ResY" name="ResY" value="" />




:T_REGISTER_ACCEPT: <a href="index.php?Section=AGB" target="_blank">:T_TERMS:</a></br></br></br>
<p><input type='Submit' class='submit' name='btn_Register' value='Registrieren'></p>
</form>
<br />
<br />
<a href="index.php">:T_REGISTER_START:</a>
 </div>


<script type="text/javascript" >
function setRes()
{
	if(document.getElementById('ResX'))
	{
		document.getElementById('ResX').value=getBrowserView(1);
	}
	if(document.getElementById('ResY'))
	{
		document.getElementById('ResY').value=getBrowserView();
	}
}
</script>

<!-- Piwik --> 
 <script type="text/javascript">
 var pkBaseURL = (("https:" == document.location.protocol) ? "https://analytics.ice-online.de/" : "http://analytics.ice-online.de/");
 document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
 </script><script type="text/javascript">
 try {
 var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
 piwikTracker.trackPageView();
 piwikTracker.enableLinkTracking();
 } catch( err ) {}
 </script><noscript><p><img src="http://analytics.ice-online.de/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
 <!-- End Piwik Tracking Code -->


</body>
</html>