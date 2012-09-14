/**
*	dient al ajax schnittstelle
*	@param query 	string 		die parameter die übergeben werden sollen
*	@param Func		string 		stellt die Callback funcktion dar
*	@param Url		string		die adresse die geladen werden soll
*	@param	Method	string 		die methode wie das formular verschickt werden soll
*	@param	Header	string 		sendet den Header an die Url ein standart ist vordefiniert
*	@param	Sync	string		gibt an ob asyncron oder nicht
*/


AjaxRequest = function(Query,Func, Url, Method, Header, Sync)
{    
	this.Query        = Query || null;
	this.Url        = Url || "deinedatei.php"; //pfad zu deiner datei    
	this.Method        = Method || "POST"; //daten in der php datei unter $_POST[] abrufbar    
	this.Headers    = Header || ['Content-Type', 'application/x-www-form-urlencoded']; //header für "post"    
	this.Sync        = Sync || true;    
	this.Req = (window.XMLHttpRequest) ? new XMLHttpRequest() : ((window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : false);
	    
	this.doRequest = function()    
	{        
		this.Req.open(this.Method,this.Url,this.Sync);        
		if (this.Headers)        
		{            
			for (var i=0; i<this.Headers.length; i+=2)            
			{                
				this.Req.setRequestHeader(this.Headers[i],this.Headers[i+1]);            
			}        
		}        
		this.Req.onreadystatechange = Func;                
		this.Req.send(this.Query);    
	}        

    this.doRequestSyncron = function()    
	{        
		this.Req.open(this.Method,this.Url,false);                                     
        this.Req.send(null);
        return this.Req.responseText;   
	}
	
	this.doRequestSyncronPost = function(Param)    
	{        
		this.Req.open("POST",this.Url,false);
		this.Req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        this.Req.setRequestHeader("Content-length", Param.length);
        this.Req.setRequestHeader("Connection", "close");                    
        this.Req.send(Param);
        return this.Req.responseText;   
	}

}