
HTMLElement.prototype.hide = function() 
{ 
    this.style.display="none";
    this.style.zIndex=-500;
}

HTMLElement.prototype.show = function() 
{ 
    this.style.display="block";
    this.style.zIndex=500;
}

HTMLElement.prototype.setWidth = function(Width) 
{ 
    this.style.width=Width;

}

HTMLElement.prototype.setHeight = function(Height) 
{ 
    this.style.height=Height;

}

HTMLElement.prototype.getTop =function()
{
    if(this.tagName != 'BODY')
    {
        return this.offsetTop+this.offsetParent.getTop();
    }else
    {
        return 0;
    }
}


HTMLElement.prototype.getLeft =function()
{
    if(this.tagName != 'BODY')
    {
        return this.offsetLeft+this.offsetParent.getTop();
    }else
    {
        return 0;
    }
}

HTMLElement.prototype.addEvent =function(EventType, Function )
{
   if (this.addEventListener) {
      this.addEventListener( EventType, Function, false );
   } else if (obj.attachEvent) {
      this["e"+EventType+Function] = Function;
      this[EventType+Function] = function() { this["e"+EventType+Function]( window.event ); }
      this.attachEvent( "on"+type, this[EventType+Function] );
   }
}

Storage.prototype.setObject = function(key, value) 
{
    this.setItem(key, JSON.stringify(value));
}

Storage.prototype.getObject = function(key) 
{
    var value = this.getItem(key);
    return value && JSON.parse(value);
}



function changeOpac(opacity,Element) 
{
 var objs = Element.style;
 objs.opacity = (opacity/100);
 objs.MozOpacity = (opacity/100);
 objs.KhtmlOpacity = (opacity/100);
 objs.filter = "alpha(opacity="+opacity+")";
}

HTMLElement.prototype.fadeIn =function(Time)
{
    var me = this;
    var TempTime=Time/100;
    this.Fader=true;
    window.setTimeout(function (TempTime) { me.fadeInInterval(TempTime)}, TempTime); 
}

HTMLElement.prototype.fadeInInterval =function(Time)
{
    if(this.style.opacity>=1 && this.Fader){return true;}
        opacity=0.02;
        var me = this;
        this.style.opacity = this.style.opacity*1+opacity;
        this.style.MozOpacity = this.style.MozOpacity*1+opacity;
        this.style.KhtmlOpacity = this.style.KhtmlOpacity*1+opacity;
        this.style.filter = "alpha(opacity="+(this.style.opacity*1+opacity*100)+")";
    window.setTimeout(function () {me.fadeInInterval(Time)}, Time);
   
}

HTMLElement.prototype.fadeOut =function(Time)
{
    var me = this;
    var TempTime=Time/100;
    this.Fader=true;
    window.setTimeout(function (TempTime) { me.fadeOutInterval(TempTime)}, TempTime); 
}

HTMLElement.prototype.fadeOutInterval =function(Time)
{
    if(this.style.opacity<=0 && this.Fader){this.hide();return true;}
        opacity=0.02;
        var me = this;
        this.style.opacity = this.style.opacity*1-opacity;
        this.style.MozOpacity = this.style.MozOpacity*1-opacity;
        this.style.KhtmlOpacity = this.style.KhtmlOpacity*1-opacity;
        this.style.filter = "alpha(opacity="+(this.style.opacity*1-opacity*100)+")";
    window.setTimeout(function () {me.fadeOutInterval(Time)}, Time);
   
}

/*  Transparency=1 => 100%     0 => 0%  */
HTMLElement.prototype.transparency =function(Transparency)
{
     this.Fader=false;
     this.style.opacity = Transparency;
     this.style.MozOpacity = Transparency;
     this.style.KhtmlOpacity = Transparency;
     this.style.filter = "alpha(opacity="+(Transparency*100)+")";
}


Array.prototype.isIn= function(Text)
{
    for(var i=0;i<this.length;i++)
    {
        if(this[i]==Text)
        {
            return true;
        }
    }
    return false;
}

function $(Search)
{
    var Element=   document.getElementById(Search);
    //Element.alert= function{}
    return Element;
}

    var CSSElements= new Array();
    function search(HtmlElement,SearchString)
    {
        if(HtmlElement.className==SearchString)
        {
            this.CSSElements.push(HtmlElement);
        }
        if(HtmlElement.children.length==0){return true;}
        for(var i=0;i<HtmlElement.children.length;i++)
        {
            this.search(HtmlElement.children[i],SearchString);
        }  
    }

function $$(Search)
{
    CSSElements= new Array();
    var HTMLElement=document.body;
    search(HTMLElement,Search);
    return CSSElements;
}


System= function ()
{

    this.delay=function(prmSec)
    {
	    var eDate = null;
	    var eMsec = 0;
    	
	    var sDate = new Date();
	    var sMsec = sDate.getTime();
    	
	    do {
		    eDate = new Date();
		    eMsec = eDate.getTime();
    		
	    } while ((eMsec-sMsec)<prmSec);
    }

    






    function getSystem()
    {
        if(!MySystem)
        {
          MySystem= new System();
        }
        return MySystem;
    }
}


function getTop(HTMLElement)
{
    if(HTMLElement.tagName != 'BODY')
    {
        return HTMLElement.offsetTop+getTop(HTMLElement.offsetParent);
    }else
    {
        return 0;
    }
}


function getLeft(HTMLElement)
{
    if(HTMLElement.tagName != 'BODY')
    {
        return HTMLElement.offsetLeft+getLeft(HTMLElement.offsetParent);
    }else
    {
        return 0;
    }
}


function getBrowserView(X)
{
  var myWidth = 0, myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) 
  {
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) 
  {
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) 
  {
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  if(X)
  {
    return myWidth;
  }
  return myHeight;
}


