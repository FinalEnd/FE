</div>
		<div style="clear: both;">&nbsp;</div>
		
		</div></div></div>
		</div>
</div>
<div id="footer">
	<p class="copyright">&nbsp;&nbsp;<a target="_blank" href="http://final-end.de/wiki">:T_WIKI:</a>&nbsp;&nbsp;<a href="index.php?Section=Ranking">:T_RANKING:</a>&nbsp;&nbsp;<a href="./forum/index.php" target="_Blank">:T_FORUM:</a>&nbsp;&nbsp;<a href="index.php?Section=Impressum">:T_ABOUT:</a>&nbsp;&nbsp;<?php echo Controler_Main::getInstance()->getEndTime()."  ";?></p>
</div>

  <?php 

  if(!$this->User->isPremium())
  {
  	echo "
	 <script type=\"text/javascript\">
	<!--
	setTimeout(\"self.location.href='index.php?Section=Login&Action=Logout'\",1000*60*35);
	//-->
	</script> ";
  	
  }
  ?>
  <script type="text/javascript" src="javascript/StateLine.js"></script>


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