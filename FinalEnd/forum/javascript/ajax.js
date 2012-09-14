/**
*	dient als ajax schnittstelle
*	@param query 	string 		die parameter die übergeben werden sollen
*	@param Func		string 		stellt die Callback funcktion dar
*	@param Url		string		die adresse die geladen werden soll
*	@param	Method	string 		die methode wie das formular verschickt werden soll
*	@param	Header	string 		sendet den Header an die Url ein standart ist vordefiniert
*	@param	Sync	string		gibt an ob asyncron oder nicht
*/


AjaxResponse = function(Query,Func, Url, Method, Header, Sync)
{    
	this.Query        = Query || null;
	this.Url        = Url || "index.php";   
	this.Method        = Method || "POST";    
	this.Headers    = Header || ['Content-Type', 'application/x-www-form-urlencoded']; 
	this.Sync        = Sync || true;    
	this.Req = (window.XMLHttpResponse) ? new XMLHttpResponse() : ((window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : false);    
	this.doResponse = function()    
	{        
		this.Req.open(this.Method,this.Url,this.Sync);        
		if (this.Headers)        
		{            
			for (var i=0; i<this.Headers.length; i+=2)            
			{                
				this.Req.setResponseHeader(this.Headers[i],this.Headers[i+1]);            
			}        
		}        
		this.Req.onreadystatechange = Func;                
		this.Req.send(this.Query);    
	}        

}