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




<div >
<h2>:T_MESSAGE_MESSAGE: von Administrator - Nachrichten an alle versenden</h2>

<?php
if($this->ErrorString)
{
	echo"<h3 class='ErrorHeader'>".$this->ErrorString."</h3>";
}
?>

<h2><a href="indexAdmin.php?Section=Messages&amp;Show=UnRead">:T_MESSAGE_INBOX:</a></h2>

<form action="indexAdmin.php?Section=WorkOnMessage" method="post" target="">
<table width='100%'>
    		<tr id='titel' width="250px"><td valign='top' ><font size="+1"><b><u>
     		:T_MESSAGE_FROM:
					</u></b></font></td>
			<td valign='top' ></td>
     		<td valign='top' width="250px"><font size="+1"><b><u>:T_MESSAGE_TEXT:</u></b></font></td>
      		<td valign='top' width="160px"><font size="+1"><b><u>:T_MESSAGE_TIMESTAMP:<u/></b></font></td>
			<td valign='top' align='center' >
				
				<input type="Checkbox" id="cb_State" onChange="selectAll()" name="" value="v"> 
			</td>
			<td width="160px" valign='top' ><select name="cb_Mode" size="">
				
						  <option value="2">:T_MESSAGE_DELETE:</option>
				</select> <input type="Submit" name="btn_WorkOn" value="bearbeiten" /> </td>
		</tr>
<?php 

if($this->MessageCollection->getCount()!=0)
{
	foreach ($this->MessageCollection as $Message)
	{
		echo "<tr style='background-color:#DFDFDF;color:black;margin-bottom:10px' >  
				<td valign='top' onclick=\"showElement('Message".$Message->getId()."')\" style='cursor:pointer;' >";	
		
			echo $Message->getFrom();
			
		echo"</td>
				<td width='25px'> <img style='cursor:pointer;' height='15' width='25' src='./images/Msg.jpg' title=':T_MESSAGE_REPLY:' onclick=\"setRequest('";
		
			echo $Message->getFrom();
		
		
		
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
	echo "<tr><td ><a href='indexAdmin.php?Section=Messages&amp;Show=".$this->Show."&amp;i_Page=".$this->LastPage."'>:T_GROUP_BACK:</a></td>";
}else
{
	echo "<tr><td ></td>";
}

echo "<td colspan='3'></td>";

if($this->NextPage)
{
	echo "<td ><a href='indexAdmin.php?Section=Messages&amp;Show=".$this->Show."&amp;i_Page=".$this->NextPage."'>:T_GROUP_GOON:</a></td></tr>";
}else
{
	echo "<td ></td></tr>";
}



?>
			 	
</form>
	
<form action='indexAdmin.php?Section=InsertMessage' method='post' target=''>	
		<tr><td colspan="7"><b>:T_MESSAGE_WRITEONE: (alle User)</b></td></tr>
		<tr><td >:T_MESSAGE_RECIP::</td> <td colspan="5" align="left"><input name="tb_Resiver" id="tb_Resiver" value="" maxlength="50" size="30" autocomplete="off" />An alle?<input type='checkbox' name='ToAll' value='true' /></td></tr>
		<tr><td >:T_MESSAGE_SUBJ::</td> <td colspan="5" align="left"> <input name="tb_Header" id="tb_Header" value="" maxlength="50" size="30" autocomplete="off" />Keys Mitsenden?<input type='checkbox' name='WithKeys' value='true' />Gültigkeit(Tage):<input name="tb_KeyLenght" id="tb_KeyLength" value="30" maxlength="50" size="30" autocomplete="off" />Anzahl Keys:<input name="tb_Lenght" id="tb_Length" value="3" maxlength="50" size="30" autocomplete="off" /></td></tr>
		<tr><td colspan="7"><textarea id="rtb_Message" name='rtb_Text' cols='60' rows='7'></textarea></td></tr>
		<tr><td align="left" colspan="7"><input class='button' type='Submit' name='abschicken' value=':T_MESSAGE_SEND:'></td></tr>
	</table>		
		</form>	
	</div>	
</div>
</div>	
	
	
	<form action="indexAdmin.php?Section=MainPage" method="post" >
	<input type="submit" name="" value="Hauptseite Admin" /> </form>