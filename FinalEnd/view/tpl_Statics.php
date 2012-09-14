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


<h1 style="position:absolute;width:450px;left:42%;font-size: 2em;">:T_LOGIN_STATISTIC:</h1>

<div style="position:absolute;width:450px;top: 25%;left:42%; ">
		<table style="height:90%;margin-left:3px;">
	                         <tr>
	                                 <td style="width:150px;" colspan="2"><h2>:T_Server1:</h2></td>        
	                         </tr>
	                         <tr>
	                                 <td align="left">:T_LOGIN_PLAYERCOUNT: </td>
	                                 <td ><?php echo $this->Player;?> </td>
	                         </tr>
							<tr>
	                                 <td align="left">:T_LOGIN_ONLINECOUNT: </td>
	                                 <td><?php echo $this->OnlinePlayer;?> </td>	
	                         </tr>
							<tr>
	                                 <td align="left">:T_LOGIN_PLANETCOUNT: </td>
	                                 <td><?php echo $this->Planets;?> </td>	
	                         </tr>
							
							<tr>
	                                 <td align="left">:T_LOGIN_UNITCOUNT: </td>
	                                 <td><?php echo $this->Units;?> </td>	
	                         </tr>
							<tr>
	                                 <td align="left">:T_LOGIN_BATTLECOUNT: </td>
	                                 <td><?php echo $this->Battles;?> </td>	
	                         </tr>	
	                 </table>

			<table style="height:90%;margin-left:3px;">
	                         <tr>
	                                 <td style="width:150px;" colspan="2"><h2>:T_Server2:</h2></td>        
	                         </tr>
	                         <tr>
	                                 <td align="left">:T_LOGIN_PLAYERCOUNT: </td>
	                                 <td ><?php echo $this->Player2;?> </td>
	                         </tr>
							<tr>
	                                 <td align="left">:T_LOGIN_ONLINECOUNT: </td>
	                                 <td><?php echo $this->OnlinePlayer2;?> </td>	
	                         </tr>
							<tr>
	                                 <td align="left">:T_LOGIN_PLANETCOUNT: </td>
	                                 <td><?php echo $this->Planets2;?> </td>	
	                         </tr>
							
							<tr>
	                                 <td align="left">:T_LOGIN_UNITCOUNT: </td>
	                                 <td><?php echo $this->Units2;?> </td>	
	                         </tr>
							<tr>
	                                 <td align="left">:T_LOGIN_BATTLECOUNT: </td>
	                                 <td><?php echo $this->Battles2;?> </td>	
	                         </tr>	
	                 </table>

 
</div>

<div style="position:absolute;top: 70%;left:45%; ">
<a href="index.php">:T_BACK:</a>

</div>


<div align="center" style="position:absolute;left:30%;bottom:0;margin:auto;" >
	<p style="margin-left:auto;margin-rigth:auto;">
		<img src="images/Footer.png" style="margin-left:auto;margin-rigth:auto;" alt=" " />
	</p>
	<p style="margin-left:auto;margin-rigth:auto;">
		<a href="./forum/index.php" >:T_FORUM:</a> <a href="index.php?Section=ImpressumExtern">:T_ABOUT:</a> <a href="index.php?Section=AGB">:T_TERMS:</a>  
	</p>
</div>
	
</body>
</html>