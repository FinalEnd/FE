Timer= function()
{
    this.Time=0;
    this.getDifferentTimeString= function(MiliSecondsFrom)
    {
        var Start = new Date(MiliSecondsFrom);
        var Now=new Date();
        var DiffTime=new Date()
        this.Time=Now.getTime()-Start.getTime();
        DiffTime.setTime(this.Time);
        return DiffTime.getMinutes()+":"+DiffTime.getSeconds()+":"+DiffTime.getMilliseconds();
    }  

    this.getDifferentTimeStringSeconds= function(SecondsFrom)
    {
        SecondsFrom=SecondsFrom*1000;
        var Start = new Date(SecondsFrom);
        var Now=new Date();
        var DiffTime=new Date()
        this.Time=Now.getTime()-Start.getTime();
        DiffTime.setTime(this.Time);
        return DiffTime.getHours()+":"+DiffTime.getMinutes()+":"+DiffTime.getSeconds();
    }  

    this.getFinishedTimeInSeconds= function(Seconds)
    {
        SecondsFrom=Seconds*1000;
        var ArrivedTimeString="";
        var FlightTime=Seconds*1000;
        var Now= new Date();
        var ArriveTime=new Date(Now.getTime()+(Seconds*1000));
        if(ArriveTime.getHours()<10)
        {
            ArrivedTimeString+="0"+ArriveTime.getHours().toString();
        }else
        {
            ArrivedTimeString+=ArriveTime.getHours().toString();
        }
        ArrivedTimeString+=":";
        if(ArriveTime.getMinutes()<10)
        {
            ArrivedTimeString+="0"+ArriveTime.getMinutes().toString();
        }else
        {
            ArrivedTimeString+=ArriveTime.getMinutes().toString();
        } 
        ArrivedTimeString+=" ";
        
        if(ArriveTime.getDate()<10)
        {
            ArrivedTimeString+="0"+ArriveTime.getDate().toString();
        }else
        {
            ArrivedTimeString+=ArriveTime.getDate().toString();
        }
        ArrivedTimeString+=".";
         if(ArriveTime.getMonth()+1<10)
        {
            ArrivedTimeString+="0"+(ArriveTime.getMonth()+1).toString();
        }else
        {
            ArrivedTimeString+=(ArriveTime.getMonth()+1).toString();
        }
        ArrivedTimeString+="."+ArriveTime.getFullYear();
        return ArrivedTimeString;
    }  



	this.dateFormat= function(Seconds)
	{
		var TempString="";
		
		var Minuts=Seconds/60; // minuten ausrechnen
		var Hours= (Minuts/60);// stunden ausrechnen
		var RestMinuts= (Minuts-(Hours*60));
		var Seconds=Seconds-((RestMinuts*60)+(Hours*60*60));
		if(Hours.length==1)
		{
			Hours="0".Hours;
		}
		if(RestMinuts.length==1)
		{
			RestMinuts="0".RestMinuts;
		}
		if((Seconds.length)<=1)
		{
			TempSeconds= Seconds;
			Seconds="0".TempSeconds;
		}else
		{
			Seconds= Seconds;
		}
		return Hours+":"+RestMinuts+":"+Seconds;
	}


}




CountDown= function(HH,MM,SS,HTMLId,Name)
{
    this.HH=HH;
    this.MM=MM;
    this.SS=SS;
    this.HTMLId=HTMLId;
    this.Name=Name;
    this.Interval=null;
    this.IsFinished=false;

    this.start= function()
    {
        this.Interval= window.setInterval(this.Name+".count()",1000);
        this.count
    }

    this.count= function()
    {
    if(this.IsFinished==true){return true;}
    
    var TempString="";
        this.SS--;
        if(this.SS==-1)
        {
             this.SS=59;
             this.MM--;
        }

        if(this.MM==-1)
        {
             this.MM=59;
             this.HH--;
        }
        
        
        if(String(this.SS).length<2)
        {
            this.SS=String("0"+this.SS);
        }
         if(String(this.MM).length<2)
        {
            this.MM=String("0"+this.MM);
        }
        
         if(String(this.HH).length<2)
        {
            this.HH=String("0"+this.HH);
        }
        
        TempString=this.HH+":"+this.MM+":"+this.SS;

        if(this.HH<=0 && this.MM<=0 && this.SS<=0)
        {
            TempString=":T_JAVA_READY:";
            this.IsFinished=true;
            window.clearInterval(this.Interval); 
        }
        if(!document.getElementById(this.HTMLId)){return false;}
        document.getElementById(this.HTMLId).innerHTML=TempString;
    }


}