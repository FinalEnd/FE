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
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="css/default.css" />
</head>
<body id="starsbackground">
<script type="text/javascript" src="javascript/Effects.js"></script>

<!-- Beginn des FRAMEBrecher JavaScript --> 
    <SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript"> 
    <!-- 
    if(top.frames.length > 0) top.location.href=self.location; 
    // --> 
    </SCRIPT> 
 <!-- Ende JavaScript -->



<div style="position:absolute;top: 5%;left:30%; ">	

 </div>	 


	  <div style="position:absolute;height:200px;width:450px;top: 35%;left:35%; ">
	<h2>
:T_BENEFIT_TITLE_COM: <?php echo $this->User->getName();?> :T_BENEFIT_TITLE_COM_PART2:!</h2>
<?php
if($this->CanBenefit)
{
	echo '<p>:T_BENEFIT_1:  '. $this->User->getName().' :T_BENEFIT_2: '.$this->Crediits.' :T_BENEFIT_3:. </p>';
}else
{
	echo '<p>:T_BENEFIT_CANTDO:.</p>';
}
?>
<p>:T_BENEFIT_REGISTERNOW: <h2><a href="index.php?Section=Login&Action=ShowRegister">:T_BENEFIT_REGISTER:</a></h2></p>

<h3>:T_BENEFIT_TITLE:</h3>	

		<p>:T_BENEFIT_TEXTBLOCK:.</p>	
			  
			<p></p>
      </div>

<img style="position:absolute;bottom:0;right:0;" src="./images/bg/BackGroundGame4.png" />

<div style="position:absolute;top: 85%;left:30%; ">	

 </div>	 
<!--<script type="text/javascript" src="http://www.sponsorads.de/script.php?s=160429"></script>-->




<div align="center" style="position:absolute;left:30%;bottom:0;margin:auto;" >
	<p style="margin-left:auto;margin-rigth:auto;">
		<img src="images/Footer.png" style="margin-left:auto;margin-rigth:auto;" alt=" " />
	</p>
	<p style="margin-left:auto;margin-rigth:auto;">
		<a href="./forum/index.php" >:T_FORUM:</a> <a href="index.php?Section=ImpressumExtern">:T_ABOUT:</a> <a href="index.php?Section=AGB">:T_TERMS:</a>  
	</p>
</div>
	
	
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