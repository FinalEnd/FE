
/**
*   Diese Datei benötigt die Units.js
*   Popup Dient zur darstelllung von Popups
*
*
*
*/




Popup= function()
{
    this.ElementCollection=new Collection();
    this.MouseX=0;
    this.MouseY=0;


    this.setCollection=function(MyCollection)
    {
        this.ElementCollection=MyCollection;
    }

    this.showPopUp=function(Id)
    {
        var Element= null;
        Element=this.ElementCollection.getById(Id);
        var Layer=document.getElementById("DetailLayer");
        var TempString="<table width='350px'><tr>";
        TempString+="<td class='header'><h3>"+Element.getName()+"</h3></td>";
        TempString+="</tr><tr>";
        TempString+="<td >"+Element.getDescription()+"</td>";
        TempString+="</tr></table>";
        Layer.innerHTML=TempString;
        Layer.style.left = (this.MouseX + 20) + "px";
		Layer.style.top = (this.MouseY - 80) + "px";
        Layer.style.display="block";


    }
    
    this.hidePopUp=function()
    {
        var Layer=document.getElementById("DetailLayer");
        Layer.innerHTML="";
        Layer.style.display="none";
    }
    this.setMousKoordinates= function(X,Y)
    {
        this.MouseX=X;
        this.MouseY=Y;
        
    }


}
MyPopup=null;
function getPopup()
{
    if(!MyPopup)
    {
      MyPopup= new Popup();
    }
    return MyPopup;
}

function updateMapKoordinate(e) 
{

    x = (document.all) ? window.event.x : e.pageX;
    y = (document.all) ? window.event.y : e.pageY;
    if(x<260 || x>1061) {return false;}
    if(y<185 || y>685) {return false;}
    var MyPopup=getPopup();
    MyPopup.setMousKoordinates(x,y);
    return false;
}


document.onmousemove = updateMapKoordinate;