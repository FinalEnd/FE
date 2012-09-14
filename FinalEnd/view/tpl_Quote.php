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
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"  />
<link rel="stylesheet" type="text/css" href="css/default.css"  />
</head>
<body id="starsbackground">
<script type="text/javascript" src="javascript/Effects.js"></script>
	 <div style="position:relative;margin:auto;width:100%">
	<div>
		<!-- BEGIN ADKLICK.NET MULTIAD BANNERCODE --><script src="http://partners.adklick.de/multiad.php?id=12553&data=7b3e46e9307a5243aceefe4d8ad698e5&site=11377&catid=9&auswahl=1&width=468&height=60" language="JavaScript"></script><!-- END ADKLICK.NET MULTIAD BANNERCODE -->
	 </div>
	</div>

	<div style="position:relative;top: 150px;margin:auto; ">
		<a href="http://www.pic-upload.eu" target="_blank" ><img src="http://www.pic-upload.eu/img/pic-upload-banner.gif" alt="www.pic-upload.eu" style="border: 0px; width: 468px; height: 60px;" /></a>
	 </div>
	
<div style="position:relative;top: 150px;margin:auto; ">
		<a href="http://www.ByteBox.eu" target="_blank" ><img src="./images/Banner.png" alt="www.ByteBox.eu" style="border: 0px; width: 468px; height: 60px;" /></a>
	 </div>
	
	  <div style="position:absolute;height:200px;width:450px;top: 35%;left: 35%; ">

            <?php
				echo '<script type="text/javascript" language="JavaScript">
				var MyWriter=getWriter("'.$this->Quote->getContent().'","Content");
				MyWriter.renderText();</script>';
            ?>

			 <p id="Content"></p>
			
			
			
			<p>
			
			<?php
			echo $this->Quote->getAutor();
			?>
			</p>
			  	   <script src="http://partners.adklick.de/showbanner.php?id=731&user=12553" type="text/javascript"></script>
					
					
			<p><a id="Next" <?php if($this->AdView){echo 'style="display:none;"';}?> href="index.php">:BTN_QUOTE_NEXT:</a></p>
			
					</p>
			  	  <?php
			  	   if($this->AdView)
			  	   {?>
			  	   		<script type='text/javascript' >
							
							window.setTimeout('document.getElementById("Next").style.display="block"',2500);
						</script>
			  	   <?php
			  	  }
			  	  ?>
			
			
			  
			
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