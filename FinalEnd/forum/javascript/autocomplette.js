// erstellt eine select auswahl
Choise  = function(Color)
{
	this.Color=Color;
	this.Parent="";
	this.Id="Choise";
	
	//erstellt ein select auswahl und h�ngt sie in an einen html Knoten an
	this.createChoise = function(HTMLElementId)
	{
		if(document.getElementById(this.Id)){this.remove();}
		if(!document.getElementById(HTMLElementId)){return false;}
		HTMLElement=document.getElementById(HTMLElementId);
		this.Parent=HTMLElement;
		var newDiv = document.createElement("div");
		Attribut=document.createAttribute("id");// onclick ereigniss erstellen
    	Attribut.nodeValue=	"Choise";
    	newDiv.setAttributeNode(Attribut);
    	if(!HTMLElement.style.zIndex)// z Index setzen
    	{
    		newDiv.style.zIndex=99
    	}else
    	{
    		newDiv.style.zIndex = HTMLElement.style.zIndex+1;
    	}
    	newDiv.className="DivOptionGroup";
		HTMLElement.parentNode.appendChild(newDiv);
		newDiv.style.width=200+	"px";					// noch anpassen wo er stehen soll
    	newDiv.style.position= 	"absolute";
    	newDiv.style.top = HTMLElement.offsetTop+HTMLElement.offsetHeight+"px";
    	newDiv.style.left = HTMLElement.offsetLeft+"px";
	}
	//entfernt die auswahl von der html seite wieder
	this.remove = function()
	{
		if(!document.getElementById(this.Id)){return true;}
		document.getElementById(this.Id).parentNode.removeChild(document.getElementById(this.Id));// l�scht die auswahl wieder
	}
	
	// macht die select unsichbar
	this.hide = function()
	{
		if(!document.getElementById(this.Id)){return false;}
		document.getElementById(this.Id).style.display= "none";
	}
	
	// macht das select wieder sichtbar
	this.show = function()
	{
		if(!document.getElementById(this.Id)){return false;}
		document.getElementById(this.Id).style.display= "block";
		document.getElementById(this.Id).style.top = this.Parent.offsetTop+this.Parent.offsetHeight;
    	document.getElementById(this.Id).style.left = this.Parent.offsetLeft;
	}
	
	// l�schte alle eintr�ge des selectes
	this.deleteOptions = function()
	{
		if(!document.getElementById(this.Id)){return false;}
		ChoiseElement=document.getElementById(this.Id);
		
			ChoiseElement.innerHTML="";

		return ChoiseElement;
	}
	
	// f�gt neue optionen in das select ein
	this.createOptions = function(Options)
	{
		if(!document.getElementById(this.Id)){return false;}
		var Element=document.getElementById(this.Id);
		for(i=0;i<Options.length;i++)
    	{
    		if(i>=10)
    		{
    			HTMLOption="<div class=\"DivOptionPoint\" >... </div>";
     			Element.innerHTML += HTMLOption;// hinzuf�gen und einen index vergeben
     			break;// schleife abbrechen
    		}
    		
    			HTMLOption="<div class=\"DivOptionPoint\" onMouseOut=\"this.style.background=''\"  onmouseover=\"this.style.background='"+this.Color+"'\"  onclick=\"AutoComplete.insert(this)\">"+Options[i]+"</div>";
     			Element.innerHTML += HTMLOption;// hinzuf�gen und einen index vergeben
    		
    	}
		HTMLOption="<div class=\"DivCloseButton\" onclick=\"AutoComplete.Choise.hide()\"> schlissen</div>";
     	Element.innerHTML += HTMLOption;// hinzuf�gen und einen index vergeben
	}
	
	this.setSize = function(Size)
	{
		if(!document.getElementById(this.Id)){return false;}
		
		if (parseInt(Size) >= 10)
		{
			document.getElementById(this.Id).style.height ="100px";
		}else
		{
			document.getElementById(this.Id).style.height = parseInt(Size)+"0px";
		}
		
		return true;
	}
}

AutoComplete = function(WordCach,Color)
{
	this.Color=Color || "#FFBF00";
	this.WordCach=WordCach;
	this.Choise=null;				// die auswahl an sich
	this.AktivHTMLElement=null;	  //das element wo die auswahl angezeigt wird
	if(this.Choise== null)
	{
		this.Choise= new Choise(this.Color);
	}
	
	//f�hrt die auto ver  vollst�ndigung aus
	this.complete= function(HTMLElementId)
	{
		if(!document.getElementById(HTMLElementId)){return false;}
		HTMLElement=document.getElementById(HTMLElementId);
		this.AktivHTMLElement=HTMLElement;
		this.Choise.createChoise(HTMLElementId);
		this.Choise.deleteOptions();
	    SearchResult=this.searchContent(HTMLElement.value,WordCach.getByHTMLId(HTMLElementId));
	    if(SearchResult.length)// nur wenn etwas in der auswahl steht oder estwas zum anbieten verf�gbar ist
	    {
	    	this.Choise.createOptions(SearchResult);
	    }
	    if(SearchResult.length)
	    {
	    	this.Choise.show();
	    	this.Choise.setSize(SearchResult.length+1);
	    }else
	    {
	    	this.Choise.hide();
	    }
	    //this.Chois=null;
	}

	//das erste ist der such begriff der im array gefunden werden soll
	// gibt ein array zurück
	this.searchContent = function(Search,SearchArray)
	{
		var Length=Search.length;
		var TempResult = new Array();
		if(Search.length<=0){return SearchArray;}
		var Eintrag=null;
		for(i=0;i<SearchArray.length;i++)
		{
			TempArrayContent=SearchArray[i].toLowerCase();
			TempVariabele="^"+Search.toLowerCase();
			ergebniss=TempArrayContent.search(TempVariabele);
			if(ergebniss!=-1)
			{
				Eintrag=SearchArray[i];
				if(SearchArray[i].toLowerCase()!=Search.toLowerCase()) // wenn berlin drinnen steht muss berlin nicht angezeigt werden
				{
					TempResult.push(Eintrag);
				}
			}
		}
		return TempResult.sort();
	}
	
	// fügt content in die suchleiste ein
	this.insert= function(Value)
	{
		if(!this.AktivHTMLElement){return false;}
		this.AktivHTMLElement.value=Value.innerHTML;
		this.Choise.hide();
		this.AktivHTMLElement.focus();
		return true;
	}
	
	this.checkForOptions= function(HTMLElementId)
	{
		if(!document.getElementById(HTMLElementId)){return false;}
		HTMLElement=document.getElementById(HTMLElementId);
		if(HTMLElement.value === "")
		{
			this.AktivHTMLElement=HTMLElement;
			this.Choise.createChoise(HTMLElementId);
			this.Choise.deleteOptions();
			SearchResult=this.searchContent(HTMLElement.value,WordCache.getByHTMLId(HTMLElementId));
			if(SearchResult.length && HTMLElement.value.length === 0)// nur wenn etwas in der auswahl steht oder estwas zum anbieten verf�gbar ist
	    	{
	    		this.Choise.createOptions(SearchResult);
	    	}
		    if(SearchResult.length)
		    {
		    	this.Choise.show();
		    	this.Choise.setSize(SearchResult.length+1);
		    }else
		    {
		    	this.Choise.hide();
		    }
		}
		//this.Chois=null;
	}

}

//dafür das mehrere wortArrays zu verwalten geeignet wenn mehrere autocomp felder vorhanden sind
WordCache= function ()
{
	this.Elements=new Array();
	this.add=function(HTMLID,ArrayElement)
	{
		var TempArray= new Array(HTMLID,ArrayElement)
		this.Elements.push(TempArray);
	}
	
	this.getByHTMLId=function(HTMLID)
	{
		for(i=0;i<this.Elements.length;i++)
		{
			if(this.Elements[i][0]==HTMLID)
			{
				return this.Elements[i][1];
			}
		}
		
	}
}








