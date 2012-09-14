function load(Name,Much,Time)
{
    this.Time=Time ? 0 : Time;
    if(!document.getElementById("tb_"+Name)){return flase;}
    //if(!document.getElementById('l_'+Name))	{return false;}
	var TimeElement=document.getElementById('l_'+Name); 
	var Element=document.getElementById('tb_'+Name);
	var Temp=Element.value
	if(isNaN(document.getElementById("tb_"+Name).value))
	{   
	    document.getElementById("tb_"+Name).value=Much;
	    if(!(new Timer())){return false;}
	    var MyTimer= new Timer();
	    //TimeElement.innerHTML= MyTimer.getFinishedTimeInSeconds((Element.value*1)*Time);
	    return true;
	}

	Element.value=Temp*1+Much*1;

	   if(!(new Timer())){return false;}
	   var MyTimer= new Timer();
	   //TimeElement.innerHTML= MyTimer.getFinishedTimeInSeconds((Element.value*1)*Time);
}


function calculatePeople(Element)
{
    var TempCount=0;
    var CountElements=$$("ShipCount");
    var CrewElements=$$("ShipCrew");
        for(var i=0;i<CountElements.length;i++)
        {
            if(!CountElements[i]){continue;}
            TempCount+=CountElements[i].value*CrewElements[i].value; 
        }
    if(!$("PeopleCount")){return false;}
    $("PeopleCount").innerHTML=TempCount;
}



function loadRessource(Name,Much)
{
	if(!document.getElementById(Name))	{return false;}
	   var Element=document.getElementById(Name);
	   var Temp=Element.value
	  Element.value=Temp*1+Much*1;
}

function clearRessource(Name)
{
	if(!document.getElementById(Name))	{return false;}
	   var Element=document.getElementById(Name);
	   var Temp=Element.value
	  Element.value=0;
}