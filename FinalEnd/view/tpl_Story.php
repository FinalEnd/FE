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
<meta name="page-type" content="Software Download" />
<meta name="audience" content="Alle" />
<meta http-equiv="content-language" content="de" />
<meta name="robots" content="index, follow" />
<script type="text/javascript" src="javascript/Time.js"></script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"  />
<link rel="stylesheet" type="text/css" href="css/default.css"  />

<script type="text/javascript" src="javascript/mootools-core.js"></script>
<script type="text/javascript" src="javascript/mootools-more.js"></script>
<script type="text/javascript">
(function () 
{

window.addEvent('domready', 
	function () 
	{
		var y = 10,
			scrollheight = $('Story').getSize().y + 100,
			
			storyInterval = (function () {
				$('StoryContainer').scrollTo(0,y+=1);
				if (y > scrollheight) clearInterval(storyInterval);
			}).periodical(145)
	}
);

	window.addEvent('domready', 
	function () 
	{
		var src = 'sound/ultimatum.' + ( (Browser.ie) ? 'mp3' : 'ogg' );
		$('audio1').set('src', src);
		var src2 = 'sound/text_ger.' + ( (Browser.ie) ? 'mp3' : 'ogg' );
		$('audio2').set('src', src2);
		
		var StartText=(function()
		{
			$('audio2').play();
		}
		).delay(5000);
		
		
	}
);

})()
</script>



</head>
<body id="starsbackground">


<audio id="audio1" loop controls="controls" autoplay="autoplay">
:T_ERROR_AUDIOFAILS:.
</audio><br />

<audio id="audio2" start="3" controls="controls" >
:T_ERROR_AUDIOFAILS:.
</audio>
<h1 style="text-align: center;font-size:2.2em;font-weight:bold">Final End</h1>
<div id="fadeContainer">
<img id="topfade" src="images/fader-top.png">
<img id="bottomfade" src="images/fader-bottom.png">

<div id="StoryContainer">
<div id="Story">


<p>:T_STORY_TITLE:</p>
<p style="margin-bottom:60px;">:T_STORY_1: </p>
<p style="margin-bottom:60px;">:T_STORY_2: </p>
<p style="margin-bottom:60px;">:T_STORY_3: </p>
<p style="margin-bottom:70px;">:T_STORY_4:</p>
 <p>:T_STORY_5: </p> 
</div>


</div></div>
<a href="index.php?Section=Login&Action=ShowRegister" style="position:absolute; right:20%;">:T_GROUP_GOON:</a>

</div>
		<!-- end content -->
		<!-- start sidebars -->
		
		<div style="clear: both;">&nbsp;</div>
		
		</div></div></div>
		</div>
	<!-- end page -->
</div>
<div id="footer">
	<p class="copyright">&nbsp;&nbsp;<a href="index.php?Section=Help">:T_HELP:</a>&nbsp;&nbsp;<a href="index.php?Section=Ranking">:T_RANKING:</a>&nbsp;&nbsp;<a href="./forum/index.php" target="_Blank">:T_FORUM:</a>&nbsp;&nbsp;<a href="index.php?Section=Impressum">:T_ABOUT:</a>&nbsp;&nbsp;<?php echo Controler_Main::getInstance()->getEndTime()."  ";?></p>
</div>
  <script type="text/javascript" src="javascript/StateLine.js"></script>


</body>
</html>