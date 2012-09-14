<?php
include("tpl_IngameHeaderNew.php");
?>

<script type="text/javascript">

function showElement(Id)
{
	if(document.getElementById(Id))
	{
		if(document.getElementById(Id).style.display=="none")
		{
			document.getElementById(Id).style.display="block";
			return true;
		}
		document.getElementById(Id).style.display="none";
	}
}


 function setRequest(From,Subject)
{

		if(document.getElementById('tb_Resiver'))
		{
			document.getElementById('tb_Resiver').value=From;	
		}
		 if(document.getElementById('tb_Header'))
		{
			document.getElementById('tb_Header').value='Re:'+Subject;
		}
		 
		 if(document.getElementById('rtb_Message'))
		{
			document.getElementById('rtb_Message').focus();
		}

		
}



	function selectAll()
{
	 //var i=;
	var State= false;
	if(document.getElementById("cb_State").checked)
{
		State=true;
}else
{
		State=false;
}
	
	for(var i=0;i<document.getElementsByName("Id[]").length;i++)
	{
			document.getElementsByName("Id[]")[i].checked = State;
	}
}

</script>


<div class ="BuildingBackground" style="margin:auto;padding:0px;width:1280px;height:720px;background-image:url(./images/design/Message.png);background-repeat:no-repeat" >

<div style="position:relative;top:42px;left:220px;border-radius:20px;padding:5%;width:720px;height:490px;overflow:auto;background-image:url(./images/design/Transparent.png);">



<div >
<h2>:T_MESSAGE_MESSAGE:</h2>

<?php
if($this->ErrorString)
{
	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
}
?>

<h2><a href="index.php?Section=Messages&amp;Show=Exit">:T_MESSAGE_OUTBOX:</a> | <a href="index.php?Section=Messages&amp;Show=UnRead">:T_MESSAGE_INBOX:</a> | <a href="index.php?Section=Messages&amp;Show=Archiv">:T_MESSAGE_ARCHIVE:</a></h2>

<form action="index.php?Section=Messages&amp;Action=WorkOnMessage<?php if($this->Exit){echo "&amp;Mode=Exit" ;}?>" method="post" target="">
<table width='100%'>
    		<tr id='titel' width="250px"><td valign='top' ><font size="+1"><b><u><?php
    		
    		if($this->Exit)
    		{	
    			echo ":T_MESSAGE_TO:";
    		}else
    		{
    			echo ":T_MESSAGE_FROM:";
    		}
    		?>
					</u></b></font></td>
			<td valign='top' ></td>
     		<td valign='top' width="250px"><font size="+1"><b><u>:T_MESSAGE_TEXT:</u></b></font></td>
      		<td valign='top' width="160px"><font size="+1"><b><u>:T_MESSAGE_TIMESTAMP:<u/></b></font></td>
			<td valign='top' align='center' >
				
				<input type="Checkbox" id="cb_State" onChange="selectAll()" name="" value="v"> 
			</td>
			<td width="160px" valign='top' ><select name="cb_Mode" size="">
			<?php
				
				if(!$this->Exit)
				{
				echo '<option value="0">:T_MESSAGE_INBOX:</option>
							<option value="1">:T_MESSAGE_ARCHIVE:</option>';
				}		
						
				?>		
						  <option value="2">:T_MESSAGE_DELETE:</option>
				</select> <input type="Submit" name="btn_WorkOn" value=":BT_MESSAGE_EDIT:" /> </td>
		</tr>
<?php 

if($this->MessageCollection->getCount()!=0)
{
	foreach ($this->MessageCollection as $Message)
	{
		echo "<tr style='background-color:#DFDFDF;color:black;margin-bottom:10px' >  
				<td valign='top' onclick=\"showElement('Message".$Message->getId()."')\" style='cursor:pointer;' >";	
			if($this->Exit)
    		{	
    			echo $Message->getTo();
    		}else
    		{
    			echo $Message->getFrom();
    		}	
		echo"</td>
				<td width='25px'> <img style='cursor:pointer;' height='15' width='25' src='./images/Msg.jpg' title=':T_MESSAGE_REPLY:' onclick=\"setRequest('";
				if($this->Exit)
    		{	
    			echo $Message->getTo();
    		}else
    		{
    			echo $Message->getFrom();
    		}
				
				
				echo "','".$Message->getHeader()."')\" /></td>
				<td valign='top' onclick=\"showElement('Message".$Message->getId()."')\" style='cursor:pointer;' >".$Message->getHeader()."</td>
				<td valign='top' onclick=\"showElement('Message".$Message->getId()."')\" style='cursor:pointer;' >".$Message->getDate()."</td>
				<td  valign='top' align='center' >
					<input type='checkbox' name='Id[]' value='".$Message->getId()."' />
				</td>
				
				<td></td>
				
			</tr>
			<tr >
			<td colspan='6'>
				<div  id='Message".$Message->getId()."' style='width:100%;display:none'>
					".$Message->getContent()."
				</div>
			</td>	
			</tr>";
	}	
}else
{
	echo "<tr><td colspan='5'>:T_MESSAGE_NOMESSAGESFOUND:</td></tr>";
}	


if($this->LastPageView)
{
	echo "<tr><td ><a href='index.php?Section=Messages&amp;Show=".$this->Show."&amp;i_Page=".$this->LastPage."'>:T_GROUP_BACK:</a></td>";
}else
{
	echo "<tr><td ></td>";
}

echo "<td colspan='3'></td>";

if($this->NextPage)
{
	echo "<td ><a href='index.php?Section=Messages&amp;Show=".$this->Show."&amp;i_Page=".$this->NextPage."'>:T_GROUP_GOON:</a></td></tr>";
}else
{
	echo "<td ></td></tr>";
}


	
?>
			 	
</form>
	
<form action='index.php?Section=Messages&amp;Action=InsertMessage' method='post' target=''>	
		<tr><td colspan="7"><b>:T_MESSAGE_WRITEONE:</b></td></tr>
		<tr><td >:T_MESSAGE_RECIP::</td> <td colspan="5" align="left"><input name="tb_Resiver" id="tb_Resiver" value="<?php echo $this->PlayerName; ?>" maxlength="50" size="30" autocomplete="off" /></td></tr>
		<tr><td >:T_MESSAGE_SUBJ::</td> <td colspan="5" align="left"> <input name="tb_Header" id="tb_Header" value="" maxlength="50" size="30" autocomplete="off" /></td></tr>
		<tr><td colspan="7"><textarea id="rtb_Message" name='rtb_Text' cols='60' rows='7'></textarea></td></tr>
		<tr><td align="left" colspan="7"><input class='button' type='Submit' name='abschicken' value=':T_MESSAGE_SEND:'></td></tr>
	</table>		
		</form>	
	</div>	
</div>
</div>	
	<?php
	include("tpl_Panel.php");
	?>
<?php

include("tpl_Footer.php");
?>