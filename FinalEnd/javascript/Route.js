
RoutPoint=function(Id,Action,X,Y,Extension,RoutId,Order,Ressource)
{	
    this.X = X;
    this.Y = Y;
    this.Width=5;
    this.Height=20;
    this.Zoom=1;
    this.MapLeft=0;
    this.MapTop=0;
    this.State=0;
    this.MyMap=null;
    this.KorrectionX = 0;
    this.KorrectionY = 0;
    this.IsSelected=false;
    this.Action=Action;
	this.Extention=Extension;
	this.RouteId=RoutId;
	this.Order=Order;
    this.Resource= Ressource ? Ressource : "m"; 
    this.Language=null;

    this.setLanguage= function(Language)
    {
        this.Language=Language;
    }


    this.setResource=function(Resource)
    {
        this.Resource=Resource;
    }

    this.setAction=function(Action)
    {
        this.Action=Action;
    }

    this.getAction=function()
    {
      return this.Action;
    }

    this.getExtensionString=function()
    {
        if(!this.Extention){return "n";}
        return this.Resource+":"+this.Extention;
    }
    this.setExtention=function(Extention)
    {
        this.Extention=Extention;
    }

    this.renderHTML=function()
    {
        var HTML="";
        HTML+='<div id="Element'+this.Order+'">';
         HTML+='<div style="width:40px;float:left" align="center"><img width="25px" height="25px" src="./images/system/close32.png" onclick="getMap().getRoute().deleteByOrder(\''+this.Order+'\')" alt="Wegpunkt entfernen" title="Wegpunkt entfernen" border="0"> </div>';
        
       var Planet= getMap().getPlanetCollection().getElementByRange(this.X,this.Y,20);
        if(Planet)
        {
            HTML+='<div style="width:130px;float:left;text-align:left;" align="center"><img src="./images/Map/ObjectsSmall/'+Planet.getPicturString()+'" alt="" border="0" style="width:25px;height:25px;">  '+Planet.getName()+'</div>';
        }else
        {
            HTML+='<div style="width:130px;float:left;text-align:left;" align="center"> '+this.X+' : '+this.Y+'</div>';
        }
         HTML+='<div style="width:130px;float:left" align="center">';
	        HTML+='<select name="cb_RouteAction'+this.Order+'" id="cb_RouteAction'+this.Order+'" onchange="getMap().getRoute().viewWayPointExtention('+this.Order+');getMap().getRoute().setWayPointAction(this.value,'+this.Order+')" size="">';
			         
			if(this.Action==1)
            {
                HTML+='<option  selected value="1">'+this.Language.CBMove+'</option>';
            }else
            {
                HTML+='<option value="1">'+this.Language.CBMove+'</option>';
            }  
			         
			 if(this.Action==2)
            {
                HTML+='<option  selected value="2">'+this.Language.CBLoad+'</option>';
            }else
            {
                HTML+='<option value="2">'+this.Language.CBLoad+'</option>';
            }          
			          
	        if(this.Action==3)
            {
                HTML+='<option  selected value="3">'+this.Language.CBUnload+'</option>';
            }else
            {
                HTML+='<option value="3">'+this.Language.CBUnload+'</option>';
            }           
	                             
	        if(this.Action==4)
            {
                HTML+='<option  selected value="4">'+this.Language.CBScan+'</option>';
            }else
            {
                HTML+='<option value="4">'+this.Language.CBScan+'</option>';
            }           
	                
	        if(this.Action==5)
            {
                HTML+='<option  selected value="5">'+this.Language.CBRaid+'</option>';
            }else
            {
                HTML+='<option value="5">'+this.Language.CBRaid+'</option>';
            }  
	         
	         HTML+='</select>';
         HTML+='</div>';
         HTML+='<div style="width:130px;float:left" align="center" >';
         
            HTML+='<select name="cb_RouteEntry'+this.Order+'" id="cb_RouteEntry'+this.Order+'" style="display:';
            if(this.Action==2 || this.Action==3)
            {
                HTML+='block;';
            }else
            {
                HTML+='none;';
            }
            HTML+='" size="" onchange="getMap().getRoute().setWayPointResource(this.value,'+this.Order+')">';
            if(this.Resource=="m")
            {
                HTML+='<option  selected value="m">'+this.Language.TMetal+'</option>';
            }else
            {
                HTML+='<option value="m">'+this.Language.TMetal+'</option>';
            }
			 
			if(this.Resource=="c")
            {
                HTML+='<option  selected value="c">'+this.Language.TCrystal+'</option>';
            }else
            {
                HTML+='<option value="c">'+this.Language.TCrystal+'</option>';
            }
			 
			if(this.Resource=="t")
            {
                HTML+='<option  selected value="t">'+this.Language.THydrogen+'</option>';
            }else
            {
                HTML+='<option value="t">'+this.Language.THydrogen+'</option>';
            }         
	                  
	        if(this.Resource=="b")
            {
                HTML+='<option  selected value="b">'+this.Language.TBiomas+'</option>';
            }else
            {
                HTML+='<option value="b">'+this.Language.TBiomas+'</option>';
            }          
	                  
	                 
	         HTML+='</select>';
        HTML+='</div>';
        HTML+='<div style="width:100px;float:left" align="center"><input onkeyup="getMap().getRoute().setWayPointExtention(this.value,'+this.Order+')" style="display:';
        if(this.Action==2 || this.Action==3)
        {
            HTML+='block;';
        }else
        {
            HTML+='none;';
        }
        HTML+='width:100px;" id="cb_RouteEntryMass'+this.Order+'" name="cb_RouteEntryMass'+this.Order+'" type="text" value="'+this.Extention+'" />    </div>';
        
        HTML+='<hr style="clear:both;" />';
        HTML+='</div>';
        return HTML;
    }

    this.getOrder=function()
    {
        return this.Order;
    }

    this.deleteMe=function()
    {   
        var Childe=document.getElementById("Element"+this.Order);
        if(!Childe){return false;}
        document.getElementById("RouteTable").removeChild(Childe);// löscht den knoten
    }

}
RoutPoint.prototype=new Task();

RoutPointCollection = function()
{

    this.add=function(WayPoint)
    {
        this.CollectionElements.push(WayPoint);
    }

    this.setLanguage= function(Language)
    {
        for(var i=0;i<this.CollectionElements.length;i++)
		{   
    		    this.CollectionElements[i].setLanguage(Language);	
		}
    }
    this.deleteById=function(Id)
    {
        var TempArray= new Array();
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getUnitId()!=UserId)
		    {
    		    TempArray.push(this.CollectionElements[i]);
		    }	
		}
		this.CollectionElements=TempArray;
    }
    
    this.show=function()
    {
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    this.CollectionElements[i].show();
		}
    }
    
    this.deleteByOrder=function(OrderId)
    {
       var TempArray= new Array();
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getOrder()==OrderId)
		    {
    		    this.CollectionElements[i].deleteMe();
    		    continue;
		    }
		    TempArray.push(this.CollectionElements[i]);	
		}
		this.CollectionElements=TempArray;// das Allte array verwerfen
		return true;
    }
   
   
    this.getByOrder=function(OrderId)
    {

	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getOrder()==OrderId)
		    {
    		   return this.CollectionElements[i];
		    }

		}
		return new RoutPoint(0,"",0,0,"",0,0);
    }
   
   
    this.clearView=function()
    {
	    for(var i=0;i<this.CollectionElements.length;i++)
		{    
    		    this.CollectionElements[i].deleteMe();  	
		}
		return false;
    } 
    this.renderHTML=function()
    {
        var HTML="";
        for(var i=0;i<this.CollectionElements.length;i++)
		{
		    HTML+=this.CollectionElements[i].renderHTML();
		}
		return HTML;
    }
       
}
RoutPointCollection.prototype = new Collection(); 



Route= function()
{
    this.RoutPointCollection= new RoutPointCollection();
    this.Counter=0;
    this.Language=null;
    this.setLanguage= function(Language)
    {
        this.Language=Language;
    }


    this.setName=function(Name)
    {
        if(!document.getElementById("tb_RouteName")){return false;}
        document.getElementById("tb_RouteName").value=Name;
    }
    this.setRoutPointCollection=function(RoutPointCollection)
    {
        this.RoutPointCollection=RoutPointCollection;
        this.RoutPointCollection.setLanguage(this.Language);
    }

    this.getRoutPointCollection=function()
    {
       return this.RoutPointCollection;
    }

    this.add=function(X,Y)
    {
        this.RoutPointCollection.add(new RoutPoint(0,1,X,Y,"0",0,this.Counter));
        this.Counter++;
        this.RoutPointCollection.setLanguage(this.Language);
    }

    this.setWayPointAction=function(Action,Order)
    {
        var Element=this.RoutPointCollection.getByOrder(Order);
        Element.setAction(Action);
    }

    this.setWayPointResource=function(Resource,Order)
    {
        var Element=this.RoutPointCollection.getByOrder(Order);
        Element.setResource(Resource);
    }

    this.setWayPointExtention=function(Extention,Order)
    {
        var Element=this.RoutPointCollection.getByOrder(Order);
        Element.setExtention(Extention);
    }

    this.setWayPointExtention=function(Extention,Order)
    {
        var Element=this.RoutPointCollection.getByOrder(Order);
        Element.setExtention(Extention);
    }

    this.clearAll=function()
    {
        this.clearView();// die tabelle löschen das neu gezeichnet werden kann 
        this.RoutPointCollection.clear();
    }

    this.clearView=function()
    {
        this.RoutPointCollection.clearView();// die tabelle löschen das neu gezeichnet werden kann  
    }

    this.deleteByOrder=function(OrderID)
    {
        this.RoutPointCollection.deleteByOrder(OrderID);// aus Collection löschen
    }


    this.viewWayPointExtention=function(OrderID)
    {
        var HtmlElement1= document.getElementById("cb_RouteAction"+OrderID);
        var HtmlElement2= document.getElementById("cb_RouteEntry"+OrderID);
        var HtmlElement3= document.getElementById("cb_RouteEntryMass"+OrderID);
        
        // aus html Löschen
        switch(HtmlElement1.selectedIndex)
        {
            case 1:
            {
                HtmlElement2.style.display="block";
                HtmlElement3.style.display="block";
            }break
            case 2:
            {
                HtmlElement2.style.display="block";
                HtmlElement3.style.display="block";
            }break;
            
            default:
                HtmlElement2.style.display="none";
                HtmlElement3.style.display="none";
        }
    }



    this.render=function()
    {
        this.clearView();
        this.RoutPointCollection.setLanguage(this.Language);
        this.renderHTML();
    }


    this.renderHTML=function()
    {
       var HTMLElement= document.getElementById("RouteTable");
        var HTML="";

        HTMLElement.innerHTML+=this.RoutPointCollection.renderHTML();
    
    }


}