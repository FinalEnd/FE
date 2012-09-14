<?php
include("view/tpl_Header.php");
?>	   

<body onload="setRes()">
<script type="text/javascript" src="javascript/prototype.js"></script>
<script type="text/javascript" src="javascript/scriptaculous.js?load=effects,builder"></script>
<script type="text/javascript" src="javascript/lightbox.js"></script>
<script type="text/javascript" src="javascript/System.js"></script>
 
<div id="Main" style="height:750px;margin-left:auto;margin-rigth:auto;background-image: url(./images/login2.jpg);background-repeat:no-repeat;background-position:center 00px; ">
	
			 <div  style="margin-left:2px;position:absolute;top:180px;height:270px;width:380px;background-image: url(./images/LoginScreenShots.png);background-repeat:no-repeat;padding:3px;">
                		<table style="height:90%;margin:20px;width:90%">
	                         <tr>
	                                 <td style="width:150px;" ><h2>:T_LOGIN_TITLE:</h2></td>        
	                         </tr>
							<tr>
	                                <td  align ="left">
										<a style="color:white" href="index.php?Section=Login&amp;Action=ShowStory">
											:T_LOGIN_TEXT:
										</a>
									</td>
	                         </tr>
							
							<tr>
	                                <td  align ="left">
										<a style="color:white" href="index.php?Section=Login&amp;Action=ShowStory">
											<h3>:T_LOGIN_GOTO: <b><u>:T_LOGIN_INTRO:</u></b></h3>
										</a>
									</td>
	                         </tr>
							
	                 </table>
	</div>
	
	
	 <div  style="margin-left:2px;position:absolute;top:450px;height:270px;width:380px;background-image: url(./images/LoginScreenShots.png);background-repeat:no-repeat;padding:3px;">
                		<table style="height:90%;margin-left:10px;">
	                         <tr>
	                                 <td style="width:150px;" colspan="2"><h2>:T_LOGIN_SCREENSHOTS:</h2></td>        
	                         </tr>
							
							<tr>
	                                <td  >
										<a href="images/ScreenShots/Screen1.png" rel="lightbox[1]" title="Final-end.de Screenshot" >
											<img  alt="" src="./images/ScreenShots/T_Screen1.png" />
										</a>
									</td>
									<td  >
										<a href="images/ScreenShots/Screen2.png" rel="lightbox[1]" title="Final-end.de Screenshot">
											<img  alt="" src="./images/ScreenShots/T_Screen2.png" />
										</a>
									</td>
									<td  >
										<a href="images/ScreenShots/Screen3.png" rel="lightbox[1]" title="Final-end.de Screenshot">
											<img  alt="" src="./images/ScreenShots/T_Screen3.png" />
										</a>
									</td>        
	                         </tr>
	                 </table>
	</div>
	
	
	 <div  style="margin-left:93%;position:absolute;top:0px;height:20px;width:60px;padding:3px;">
           <table >
	                         <tr>
									<td align="left"><a href="index.php?Section=Statics"><u>:T_LOGIN_STATISTIC:</u></a> </td>
	                                 <td align="left">:T_LOGIN_ONLINECOUNT: </td>
	                                 <td ><?php echo $this->OnlinePlayer;?> </td>
	                         </tr>
	       </table>     			
	</div>
	
	<div  style="left:opx;position:absolute;top:0px;height:20px;width:60px;padding:3px;">
           <table >
	                         <tr>
									<td > <a href="index.php?Lang=Ger"> <img src ="./images/flags/flag-de.png" title ="Deutsche Sprache wählen" alt ="Deutsche Sprache wählen" /></a></td>
	                                <td ><a href="index.php?Lang=Eng"> <img src ="./images/flags/flag-gb.png" title ="Select English language" alt ="Select English language" /></a> </td>
	                         </tr>
	       </table>     			
	</div>
	
	 <div  style="margin-left:75%;position:absolute;top:200px;height:195px;width:160px;background-repeat:no-repeat;padding:3px;">
                		
		<div id="fb-root"></div>
			<script>(function(d){
			  var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
			  js = d.createElement('script'); js.id = id; js.async = true;
			  js.src = "//connect.facebook.net/de_DE/all.js#xfbml=1";
			  d.getElementsByTagName('head')[0].appendChild(js);
			}(document));</script>
			<div class="fb-like-box" data-href="http://www.facebook.com/pages/final-endde/158317620897735?ref=ts" data-width="292" data-colorscheme="dark" data-show-faces="true" data-stream="true" data-header="true"></div>	
							
	</div>
	
	
	
	
	<div  style="margin-left:44%;position:absolute;top:390px;height:200px;width:270px;background-image: url(./images/LoginContainer.png);padding-top:10px;background-repeat:no-repeat;">
         <form action="index.php?Section=Login&amp;Action=UserLogin" method="post" >
                		<table   style="margin-left:30px;">
	                          <tr>
	                                 <td colspan="4"><h1>:T_LOGIN_LOGIN:</h1> </td>    
	                         </tr>
							
							<tr>
	                                 <td>:T_LOGIN_NAME: </td>
	                                 <td colspan="2"><input style="width:95%;" type="text" id="tb_Name" name="tb_Name" value="<?php echo $this->LoginName;?>" size="" maxlength="" /> </td>
	                         </tr>
	                         <tr>
	                                 <td>:T_LOGIN_PASS: </td>
	                                 <td colspan="2"><input style="width:95%;" type="password" name="tb_Pass" value="" size="" maxlength=""  /> </td>
	                         </tr>
								 <tr>
	                                 <td>:T_LOGIN_GALAXY: </td>
	                                 <td colspan="2"><select style="width:95%;" name="i_Server" size="">
										<option value="2">:T_LOGIN_MILYWAY:</option>
									  <option value="1">:T_LOGIN_BETAVERSE:</option>
									 </select>
									<input type ="hidden" id="RessX" name="RessX" value="" />
									<input type ="hidden" id="RessY" name="RessY" value="" />
									
									 </td>
	                         </tr>
							<tr>
	                                 <td> </td>
	                                 <td><input type="submit" name="" value=":BTN_LOGIN_LOGIN:" /> </td>
									<td ><a href="index.php?Section=Login&amp;Action=ShowRegister" class='VIPLink'>:BTN_LOGIN_REGISTER:</a> </td>
	                         </tr>
							
							<tr>
	                                 
									<td colspan="3" align="center"><a id="TestAccount" href="index.php?Section=Login&amp;Action=UserLogin&amp;tb_Name=TestAccount&amp;tb_Pass=123456&amp;i_Server=1" class='VIPLink'>:BTN_LOGIN_TESTLOGIN:</a> </td>
	                         </tr>
							
	                 </table>
					 <input type ="hidden" id="ResX" name="ResX" value="" />
					<input type ="hidden" id="ResY" name="ResY" value="" />
         </form>
	</div>

</div>


<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style" style="margin-left:auto;margin-rigth:auto;">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
</div>




<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4d79e74b1b6291a4"></script>
<!-- AddThis Button END -->
<div align="center" style="margin-left:auto;margin-rigth:auto;" >
	<p style="margin-left:auto;margin-rigth:auto;">
		<img src="images/Footer.png" style="margin-left:auto;margin-rigth:auto;" alt=" " />
	</p>
	<p style="margin-left:auto;margin-rigth:auto;">
		<a target="_blank" href="http://final-end.de/wiki">:T_WIKI:</a>&nbsp;&nbsp;<a href="./forum/index.php" >:T_FORUM:</a> <a href="index.php?Section=ImpressumExtern">:T_ABOUT:</a> <a href="index.php?Section=AGB">:T_TERMS:</a>  
	</p>
</div>

 <script type="text/javascript">
		document.getElementById("tb_Name").focus();
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

<script type="text/javascript" >

function setRes()
{
	if(document.getElementById('ResX'))
	{
		document.getElementById('ResX').value=getBrowserView(1);
		document.getElementById('TestAccount').href+="&ResX="+getBrowserView(1);
	}
	if(document.getElementById('ResY'))
	{
		document.getElementById('ResY').value=getBrowserView();
		document.getElementById('TestAccount').href+="&ResY="+getBrowserView();
	}
}
</script>


</body>
</html>