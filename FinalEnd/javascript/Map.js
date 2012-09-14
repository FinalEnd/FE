GameMap= function(StartX,StartY)
{
    this.StartX=StartX;
    this.StartY=StartY;
    this.MouseX=StartX;
    this.MouseY=StartY;
    this.ImageCollection=new Array();
    this.PlanetCollection= /*(sessionStorage && sessionStorage.getObject('PlanetCollection'))? new PlanetCollection(sessionStorage.getObject('PlanetCollection')):*/ new PlanetCollection();
    this.UnitCollection= new UnitCollection();
    this.MapObjectCollection=/* (sessionStorage && sessionStorage.getObject('MapObjectCollection'))? new MapObjectCollection(sessionStorage.getObject('MapObjectCollection')):*/ new MapObjectCollection();
    this.SelectetElementCollection=new UnitCollection();
    this.SelectetElementCollection.clear();
    this.SelectetPlanet=null; 
    this.TaskCollection= new TaskCollection();// was die einheiten gerade machen
    this.KoordinateX=0;
    this.KoordinateY=0;
    // this.UpdateIntervall = window.setInterval("getMap().updateMapUnits()", 15000);
	var me = this;
	
	this.UpdateIntervall = setInterval(function () { me.updateMapUnits() 	}, 15000);
    this.RenderIntervall = setInterval(function () { me.render() 			}, 510);
    this.XDiffStart=0;
    this.YDiffStart=0;
    this.MoveMapState=false;
    this.LastRefresh= new Date().getTime();
    var UserPlanetCollection=null;
    UserPlanetCollection= new PlanetCollection();
    this.UserUnitCollection= new UnitCollection();
    this.Zoom=1;
    this.LastUnitRefresh= new Date().getTime();
    this.SelfUnit=false;
    this.CanUpdate=true;
    this.UserName="";
    this.ShowLayer=true;
    this.MyMap=null;
    this.BackgroundPicture=0;
    this.RouteState=false;
    this.Route= new Route();
    this.RightClick=false;
    this.StrgPush=false;
    this.ShowIdentificationMark=true; 
    this.ShowAstroids=true;
    this.Language=null;
    this.TriggerJump=false;
    this.Width=0;
    this.Height=0;
    this.BackgroundMapString="";
    this.MapLayerCollection= new MapLayerCollection();
    
    
    this.setWidth=function(Width)
    {
        this.Width=Width;
    }
    
    this.reSizeMap=function()
	{
	    this.setWidth(getBrowserView(1));
	    this.setHeight(getBrowserView(0));
	    $("MapContainer").width=getBrowserView(1)-5;
	    $("MapContainer").height=getBrowserView(0)-5;
	    
	    
	    $("PanelMapDivButton").style.left=(getBrowserView(1)/2-72)+"px";
	    $("PanelMapDivButton").style.top=(getBrowserView(0)-40)+"px";
	    
	    //$("PanelMapDiv").style.left=getBrowserView(1)/2-115+"px";
	    $("PanelMapDiv").style.top=getBrowserView(0)-123+"px";

	    $("RightMenuPanel").style.left=(getBrowserView(1)-28)+"px";
	    //$("RightMenuPanel").style.top=(getBrowserView(0)-35)+"px";
	    
	    $("ControlPanel").style.left=(getBrowserView(1)-175)+"px";
	    $("ControlPanel").style.top=(getBrowserView(0)-115)+"px";
	    this.renderMapUnits();
	}
    
    
    this.getWidth =function()
    {
        return this.Width;
    }
    
    
    this.setHeight= function(Height)
    {
        this.Height=Height;
    }
     this.getHeight = function()
    {
        return this.Height;
    }
    
    // den sprung abschicken
    this.jumpToPosition= function(UnitId)
    {
        var Unit=this.UnitCollection.getById(UnitId);
        if(!Unit){return false;}
       	var Ajax= new AjaxRequest("",Func,document.URL+"&Action=JumpToPosition&UId="+UnitId+"&X="+this.KoordinateX+"&Y="+this.KoordinateY);
	    this.CanUpdate=false;
	    var HTML=Ajax.doRequestSyncron(); 
        var DetailLayer = document.getElementById("DetailsContainer");
        if(!document.getElementById("DetailsContainer")){return false;}
        //this.updateMap();
        DetailLayer.innerHTML=HTML;
        this.TriggerJump=false;
        this.updateMapUnits();// flotten aktualisieren
    }
    
    
        this.emergencyJump= function(UnitId)
    {
        var Unit=this.UnitCollection.getById(UnitId);
        if(!Unit){return false;}
       	var Ajax= new AjaxRequest("",Func,document.URL+"&Action=JumpToPosition&UId="+UnitId+"&X="+this.KoordinateX+"&Y="+this.KoordinateY);
	    this.CanUpdate=false;
	    var HTML=Ajax.doRequestSyncron(); 
        this.updateMapUnits();// flotten aktualisieren
        this.showMapOnKoordianteXY(Unit.getX(), Unit.getY());
        
    }
    
    this.triggerJumpToPosition= function(Language)
    {
        if(this.TriggerJump==false)
        {
            this.TriggerJump=true;
        }else
        {
            this.TriggerJump=false;
        }
    }
    
    this.setLanguage= function(Language)
    {
        this.Language=Language;
        this.Route.setLanguage(this.Language);
    }
    
    this.getLanguage= function()
    {
       return  this.Language;

    }
    
    
    this.setCookie= function()
    {
        var Now = new Date();
        var Auszeit = new Date(Now.getTime()+(900000000*1));
        document.cookie = "t="+this.ShowIdentificationMark+";expires="+Auszeit.toGMTString();
        document.cookie = "z="+this.Zoom+";expires="+Auszeit.toGMTString();
        document.cookie = "a="+this.ShowAstroids+";expires="+Auszeit.toGMTString();
    }
    
    this.getMyMap= function()
    {
        return this.MyMap; 
    }
    
    this.checkIdentificationMark= function()
    {
        if(!document.getElementById("IdentificationMark")){return false;}
        if(document.getElementById("IdentificationMark").checked)
        {
            this.PlanetCollection.setShowIdentificationMark(true);
            this.ShowIdentificationMark=true;
        }else
        {
            this.PlanetCollection.setShowIdentificationMark(false);
            this.ShowIdentificationMark=false;
        }
        this.render();
        this.setCookie();
    }   
    
    this.checkAstroids= function()
    {
        if(!document.getElementById("cb_ShowAstroids")){return false;}
        if(document.getElementById("cb_ShowAstroids").checked)
        {
            this.MapObjectCollection.showByType(1);
            this.MapObjectCollection.showByType(2);
            this.ShowAstroids=true;
        }else
        {
            this.MapObjectCollection.hideByType(1);
            this.MapObjectCollection.hideByType(2);
            this.ShowAstroids=false;
        }
        this.render();
        this.setCookie();
    }   
    
    
    this.getPlanetCollection= function()
    {
        return this.PlanetCollection; 
    }
    
    this.getMapObjectCollection= function()
    {
        return this.MapObjectCollection; 
    }
    
    this.getUserPlanetCollection= function()
    {
        return UserPlanetCollection;
    } 
    
     this.getRoute= function()
    {
        return this.Route; 
    }
    
    this.setRoute= function(Route)
    {
        this.Route=Route; 
    }
    
    this.getSelectetElement= function()
    {
        return this.SelectetElement; 
    }
     
    this.setShowLayer= function(ShowLayer)
    {
        this.ShowLayer=ShowLayer; 
    }
    this.getShowLayer= function()
    {
        return this.ShowLayer; 
    } 
   
    this.setUserName= function(UserName)
    {
        this.UserName=UserName; 
    }
    this.getUserName= function()
    {
        return this.UserName; 
    }
   
   this.deleteTaskById=function(Id)
   {
        this.TaskCollection.getById(Id).hide();
        this.refreshUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());
   }
   
  
  this.stopUnit=function()
  { 
        for(var i=0;i<this.SelectetElementCollection.getCount();i++)
        {
           var Ajax= new AjaxRequest("","",document.URL+"&Action=StopUnit&UId="+this.SelectetElementCollection.getByIndex(i).getId());    
	       eval(Ajax.doRequestSyncron());
	       var Task= this.TaskCollection.deleteByUnitId(this.SelectetElementCollection.getByIndex(i).getId());
	       if(Task)
	       {
	            Task.hide();
	       }
	   }
	   this.refreshUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());
  } 
   
  this.deleteRoute=function()
  {
       var ReQuest= confirm("Sind Sie sicher das Sie diese Route Löschen wollen?");
       if(!ReQuest){return false;}
       var RouteId=document.getElementById("cb_Routes").value;
       if(!RouteId){return false;}
       var Ajax= new AjaxRequest("","",document.URL+"&Action=DeleteRoute&RId="+RouteId); 
       Ajax.doRequestSyncronPost("");   
	   var Task= this.TaskCollection.deleteByUnitId(this.SelectetElementCollection.getByIndex(0).getId());
	   if(Task && this.RouteState)
	   {
	        Task.hide();
	   }
	   this.refreshUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());
  } 
    
    
  this.addRoute=function()
  {
        var RouteName=document.getElementById("tb_RouteName").value;
       if(!RouteName){return false;}
       var ElementCount=this.Route.getRoutPointCollection().getCount();
       var PostRequest="&RouteName="+RouteName+"&ElementCount="+ElementCount;
       for(var i=0;i<ElementCount;i++)
       {
            var RoutePoint=this.Route.getRoutPointCollection().getByIndex(i);
            PostRequest+="&"+i+"EX="+RoutePoint.getX()+"&"+i+"EY="+RoutePoint.getY()+"&"+i+"Action="+RoutePoint.getAction()+"&"+i+"Extention="+RoutePoint.getExtensionString();
       } 
       var Ajax= new AjaxRequest("","",document.URL+"&Action=AddRoute");    
	   var HTML= Ajax.doRequestSyncronPost(PostRequest);// befahl abschicken
	   this.RouteState=false;
       //this.setHTMLInContainer(HTML);
       this.refreshUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());
  }    
   
  this.addUnitToRoute=function(Loop)
  {
       if(!document.getElementById("cb_Routes")){return false;}
       if(!this.SelectetElementCollection.getByIndex(0)){return false;}
       var RouteId=document.getElementById("cb_Routes").value;
       var Ajax= new AjaxRequest("","",document.URL+"&Action=SetUnitToRoute&RId="+RouteId+"&UId="+this.SelectetElementCollection.getByIndex(0).getId()+"&Loop="+Loop);    
	   eval(Ajax.doRequestSyncron());// befehl abschicken
	   this.refreshUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());
  }  
   
   this.deleteTaskCollection=function()
   { 
        this.TaskCollection= new TaskCollection();
   }
   
   
    this.showRout= function()
    {
        this.RouteState=true;
        //this.Route=null;
        this.Route= new Route();
        this.Route.setLanguage(this.Language);
        this.Route.getRoutPointCollection().clear();
        var DetailLayer = document.getElementById("DetailsContainer");
        var Ajax= new AjaxRequest("","",document.URL+"&Action=GetRoute&Uid="+this.SelectetElementCollection.getByIndex(0).getId());	    
	    var HTML=Ajax.doRequestSyncron();
        DetailLayer.innerHTML=HTML;
        DetailLayer.style.overflow="scroll";
        return true; 
    }
   
   
   
    this.showWorkOnRout= function()
    {
        if(!document.getElementById("cb_Routes")){return fasle;}
        var RouteId=document.getElementById("cb_Routes").value;
        if(RouteId<=0){return false;}
        this.showRout();
        this.RouteState=true;
        //this.Route=null;
        this.Route= new Route();
         this.Route.setLanguage(this.Language);
        var Ajax= new AjaxRequest("","",document.URL+"&Action=WorkOnRoute&Rid="+RouteId);	    
	    var HTML=Ajax.doRequestSyncron();
        eval(HTML);
        return true; 
    }
   
   this.getUserPlanetCollection= function()
   {
        return UserPlanetCollection;
   } 
    
    this.setDown=function()
    {   
        this.StartY=this.StartY+this.Zoom*100;
        this.LastRefresh=0;
        this.updateMap();
        this.fillCollectionDiv();
        this.setRenderUnitsKoordination();
        this.ViewableUnitsCalculated=false;
    }
    
    this.setUp=function()
    {   
        this.StartY=this.StartY-this.Zoom*100;
        this.LastRefresh=0;
        this.updateMap();
        this.fillCollectionDiv();
        this.setRenderUnitsKoordination();
        this.ViewableUnitsCalculated=false;
    }
    
    this.setLeft=function()
    {   
        this.StartX=this.StartX-this.Zoom*100;
        this.LastRefresh=0;
        this.updateMap();
        this.fillCollectionDiv();
        this.setRenderUnitsKoordination();
        this.ViewableUnitsCalculated=false;
    }
    
    this.setRight=function()
    {   
        this.StartX=this.StartX+this.Zoom*100;
        this.LastRefresh=0;
        this.updateMap();
        this.fillCollectionDiv();
        this.setRenderUnitsKoordination();
        this.ViewableUnitsCalculated=false;
    }
    
    this.ZoomIn= function(Count)
    {
        if(!Count){ Count=1;}
        if(this.Zoom==Number.NaN){this.Zoom=1;return true;}
        if(this.Zoom<=1){return true;}
        
        this.Zoom=this.Zoom*1-Count*1;
        this.Zoom=this.Zoom.toFixed(2);
        //this.Zoom=(this.Zoom+"").substr(0, 3);
       if(this.Zoom>3)  
        {
            
                this.MapObjectCollection.hideByType(1);
                this.MapObjectCollection.hideByType(2);
            
        }else
        {
            if(this.ShowAstroids)
            {
                this.MapObjectCollection.showByType(1);
                this.MapObjectCollection.showByType(2);
            }else
            {
                this.MapObjectCollection.hideByType(1);
                this.MapObjectCollection.hideByType(2);
            }
        }
        
        
        // rendern
        if(Count==1)
        {
            this.StartX=this.StartX+(this.Width/2);
            this.StartY=this.StartY+(this.Height/2);
            
        }else
        {
            this.StartX=this.StartX+(this.Width/2)*Count;
            this.StartY=this.StartY+(this.Height/2)*Count;
        }
        this.setZoom(this.Zoom);
        //this.LastRefresh=0;
       //document.getElementById("UnitContainer").innerHTML=""; 
       //this.setLegend();
        if(this.Zoom%1)
        {
           this.updateMap();
        }
        
        
        this.fillCollectionDiv();
       // this.setCookie();
        this.renderMapUnits();
    }
    
    this.setLegend= function()
    {
        //if(this.Zoom%1==0)
       // document.getElementById("Legend").src="images/Map/Width"+this.Zoom+".png";
    }
    
    
    this.ZoomOut= function(Count)
    {
        if(!Count){ Count=1;}
        if(this.Zoom>=29){return true;}
        if(this.Zoom==Number.NaN){this.Zoom=1;return true;}
        this.Zoom=this.Zoom*1+Count*1;
        this.Zoom=this.Zoom.toFixed(2);

         if(this.Zoom>=5)  
        {
                this.MapObjectCollection.hideByType(1);
                this.MapObjectCollection.hideByType(2);
        }else
        {
            if(this.ShowAstroids)
            {
                this.MapObjectCollection.showByType(1);
                this.MapObjectCollection.showByType(2);
            }else
            {
                this.MapObjectCollection.hideByType(1);
                this.MapObjectCollection.hideByType(2);
            }
        }
        
        
        if(this.Zoom%1)
        {
           this.updateMap();
        }
        
        // rendern
        this.StartX=this.StartX-(this.Width/2)*Count;
        this.StartY=this.StartY-(this.Height/2)*Count;
        this.setZoom(this.Zoom);
        //this.LastRefresh=0;
        //document.getElementById("UnitContainer").innerHTML="";
         //this.setLegend();
        //this.updateMap();
       this.fillCollectionDiv();
      // this.setCookie();
        this.renderMapUnits();
    }
    
    
    this.setZoom= function(Zoom)
    {
        this.PlanetCollection.setZoom(this.Zoom);
        this.UnitCollection.setZoom(this.Zoom);
        this.TaskCollection.setZoom(this.Zoom);
        this.MapObjectCollection.setZoom(this.Zoom);
        this.Route.getRoutPointCollection().setZoom(this.Zoom);
        this.setRenderUnitsKoordination();
        this.ViewableUnitsCalculated=false;
    }
    
    
    this.setRenderUnitsKoordination= function ()
    {
        this.UnitCollection.setKorrection(this.StartX,this.StartY);
        this.PlanetCollection.setKorrection(this.StartX,this.StartY);
        this.TaskCollection.setKorrection(this.StartX,this.StartY); 
        this.MapObjectCollection.setKorrection(this.StartX,this.StartY);
        this.MapLayerCollection.setKorrection(this.StartX,this.StartY);
        this.MapObjectCollection.setMap(this.MyMap);
        this.UnitCollection.setMap(this.MyMap);
        this.PlanetCollection.setMap(this.MyMap);
        this.TaskCollection.setMap(this.MyMap);
        this.MapLayerCollection.setMap(this.MyMap);
    }
    
    this.renderSelectet=function()
    {
            this.SelectetElementCollection.select();
            this.SelectetElementCollection.render();
    }
    
    
    this.renderMapUnits= function()
    {
            var MyImage = getPicturLoader().getPic(this.BackgroundMapString);
            if(MyImage.complete)
            {
               this.MyMap.drawImage(MyImage,  0,0);
            }
            MyImage2 = getPicturLoader().getPic("./images/Map/MapObject"+this.BackgroundPicture+".png");
            if(MyImage2.complete)
            {
              // this.MyMap.drawImage(MyImage2,  80,10);
            }
            if(this.Zoom<=5 && this.ShowAstroids)
            {
                this.MapObjectCollection.showByType(1);  
                this.MapObjectCollection.showByType(2);
            }else
            {
                this.MapObjectCollection.hideByType(1);  
                this.MapObjectCollection.hideByType(2);
            }
            
            
            
            if(this.Zoom<15)
            {
            //planeten rendern
                this.PlanetCollection.render();
            }/*else
            {
                this.MapLayerCollection=this.PlanetCollection.getMapLayer();
                this.MapLayerCollection.setMap(this.MyMap);
                this.MapLayerCollection.setZoom(this.Zoom);
                this.MapLayerCollection.setKorrection(this.StartX,this.StartY);
                this.MapLayerCollection.render();
            }*/
            
            if(this.Zoom<15)
            {
                this.UnitCollection.deSelect();
                this.UnitCollection.render();
                this.SelectetElementCollection.select();
                this.SelectetElementCollection.render();
            }
            if(this.SelectetPlanet && this.Zoom<=14 && this.SelectetPlanet.getId())
            {
                this.SelectetPlanet.select();
                this.SelectetPlanet.renderBorder();
            }
            /*if(this.Zoom>14)
            {
                this.MapObjectCollection.calculateSuns();
            }*/
            
            this.MapObjectCollection.getOnMap().render();// mapobjekts rendern
           
          
            if(this.RouteState==false)
            {
                this.TaskCollection.render();
            }else
            {
                this.Route.getRoutPointCollection().setMap(this.MyMap);
                this.Route.getRoutPointCollection().setKorrection(this.StartX,this.StartY);
                this.Route.getRoutPointCollection().show(); // alle tasks sichtbar machen
                this.Route.getRoutPointCollection().render();
            }
            //var MyLegend = getPicturLoader().getPic("./images/Map/Width"+this.Zoom+".png");
            //if(MyLegend.complete)
            //{
              // this.MyMap.drawImage(MyLegend,  2,this.Height-80);
            //}  
            this.Zoom=this.Zoom*1;
            this.Zoom=this.Zoom.toFixed(2);
            Temp=parseInt(this.Zoom*100);
            this.drawText(35, this.Height-40,  "#ffffff", Temp , 20 ,"sans-serif","Center");
    }
    
    
    this.fillUserDiv= function()
    {
        if(!document.getElementById("UserUnitContainer")){return false;}
        document.getElementById("UserUnitContainer").innerHTML="";
        document.getElementById("UserUnitContainer").innerHTML+=UserPlanetCollection.getDivCollectionString();   // planeten 
        document.getElementById("UserUnitContainer").innerHTML+=this.UserUnitCollection.getDivCollectionString(); // Einheiten erstellen
    } 
    
    
    this.fillUserDivWithPlanetsViewAble= function()
    {
        if(!document.getElementById("UserUnitContainer")){return false;}
        document.getElementById("UserUnitContainer").innerHTML="";
        for(var i=0;i<UserPlanetCollection.getCount();i++)
        {
            if(this.PlanetCollection.getByIndex(i).isOnMap())
            {
                document.getElementById("UserUnitContainer").innerHTML+=this.PlanetCollection.getByIndex(i).renderforCollection();   // planeten
            } 
        }
    } 
    
    
    this.fillUserDivWithOwnerPlanets= function()
    {
        if(!document.getElementById("UserPlanetContainer")){return false;}
        document.getElementById("UserPlanetContainer").innerHTML="";
        document.getElementById("UserPlanetContainer").innerHTML+=UserPlanetCollection.getDivCollectionString();   // planeten 
    } 
    
    this.fillUserDivWithOwneUnits= function()
    {
        if(!document.getElementById("UserFleetsContainer")){return false;}
        document.getElementById("UserFleetsContainer").innerHTML="";
        this.UserUnitCollection.setKorrection(this.StartX,this.StartY);
        this.UserUnitCollection.setZoom(this.Zoom);
        for(var i=0;i<this.UserUnitCollection.getCount();i++)
        {
                document.getElementById("UserFleetsContainer").innerHTML+=this.UserUnitCollection.getByIndex(i).renderforCollection(); // Einheiten erstellen 
        }
    }
    
    this.fillUserDivWithOwneUnitsViewAble= function()
    {
        if(!document.getElementById("UserUnitContainer")){return false;}
        document.getElementById("UserUnitContainer").innerHTML="";
        this.UserUnitCollection.setKorrection(this.StartX,this.StartY);
        this.UserUnitCollection.setZoom(this.Zoom);
        for(var i=0;i<this.UserUnitCollection.getCount();i++)
        {
            if(this.UserUnitCollection.getByIndex(i).isOnMap())
            {
                document.getElementById("UserUnitContainer").innerHTML+=this.UserUnitCollection.getByIndex(i).renderforCollection(); // Einheiten erstellen
            } 
        }
    }
    
    this.fillUserDivWithEnemyUnitsViewAble= function()
    {
        if(!document.getElementById("UserUnitContainer")){return false;}
        document.getElementById("UserUnitContainer").innerHTML="";
        this.UnitCollection.setKorrection(this.StartX,this.StartY);
        this.UnitCollection.setZoom(this.Zoom);
        for(var i=0;i<this.UnitCollection.getCount();i++)
        {
            if(this.UnitCollection.getByIndex(i).isOnMap() && !this.UnitCollection.getByIndex(i).getIsMyUnit())
            {
                document.getElementById("UserUnitContainer").innerHTML+=this.UnitCollection.getByIndex(i).renderforCollection(); // Einheiten erstellen
            } 
        }
    }
    
    this.fillUserDivWithUnitsViewAble= function()
    {
        if(!document.getElementById("UserFleetsContainer")){return false;}
        if(this.ViewableUnitsCalculated){return false;}
        document.getElementById("UserFleetsContainer").innerHTML="";
        this.UnitCollection.setKorrection(this.StartX,this.StartY);
        this.UnitCollection.setZoom(this.Zoom);
        for(var i=0;i<this.UnitCollection.getCount();i++)
        {
            if(this.UnitCollection.getByIndex(i).isOnMap())
            {
                document.getElementById("UserFleetsContainer").innerHTML+=this.UnitCollection.getByIndex(i).renderforCollection(); // Einheiten erstellen
            } 
        }
        this.ViewableUnitsCalculated=true;
    }
    
    
    
    
     this.setUserPlanetCollection= function(MyUserPlanetCollection)
    {
        UserPlanetCollection.hide();
        UserPlanetCollection.merge(MyUserPlanetCollection); 
        UserPlanetCollection.setMap(this.MyMap);
    }
    
    this.setUserUnitCollection= function(UserUnitCollection)
    {
        //this.UserUnitCollection.hide();
        this.UserUnitCollection=UserUnitCollection; 
         this.UserUnitCollection.setMap(this.MyMap);
    }
   
    this.getUserUnit= function(UnitId)
    {
        if(this.UserUnitCollection.getById(UnitId))
        {
            return this.UserUnitCollection.getById(UnitId);
        }
        return new Unit(0,"","", 0,0,0,0,0,0,0,0,0,0,0,0,0,0,false,"",0,"","");
    } 
    
    this.updateMap= function()
    {
			    Func =  function()
			    {
				    switch(Ajax.Req.readyState)
				    {
					    case 4://Abgeschlossen
					    if(Ajax.Req.status == 200) //Anfrage erfolgreich
					    {
                            eval(Ajax.Req.responseText);
                            this.CanUpdate=true;
                            this.LastRefresh=0;
                            if(sessionStorage =="undefined"){return;}
                            //sessionStorage.setObject("MapObjectCollection",getMap().getMapObjectCollection());
                            //sessionStorage.setObject("PlanetCollection",getMap().getPlanetCollection());
					    }
				    }
			    }
			    var TempTime= new Date().getTime();
			    if(this.LastRefresh+1000>TempTime && !this.CanUpdate)
			    {
			        return false;
			    }
			    var Ajax= new AjaxRequest("",Func,document.URL+"&Action=GetByKoord&X="+this.StartX+"&Y="+this.StartY+"&Zoom="+this.Zoom);
			    this.CanUpdate=false;
			    Ajax.doRequest();
			    this.LastRefresh=TempTime;
	    this.setRenderUnitsKoordination();
    }



    this.updateMapUnits= function()
    {
			    Func =  function()
			    {
				    switch(Ajax.Req.readyState)
				    {
					    case 4://Abgeschlossen
					    if(Ajax.Req.status == 200) //Anfrage erfolgreich
					    {
                            eval(Ajax.Req.responseText);
                            this.CanUpdate=true;
                            this.LastRefresh=0;
					    }
				    }
			    }
			    var TempTime= new Date().getTime();
			    if(this.LastRefresh+1000>TempTime && !this.CanUpdate)
			    {
			        return false;
			    }
			    var Ajax= new AjaxRequest("",Func,document.URL+"&Action=GetAllUnitsKoord&X="+this.StartX+"&Y="+this.StartY+"&Zoom="+this.Zoom);
			    this.CanUpdate=false;
			    Ajax.doRequest();
			    this.LastRefresh=TempTime;
	    this.setRenderUnitsKoordination();
    }

    this.scanArea=function(UnitId)
    {
       	var Ajax= new AjaxRequest("",Func,document.URL+"&Action=ScanArea&UI="+UnitId);
	    this.CanUpdate=false;
	    Ajax.doRequest(); 
        if(!document.getElementById("btn_ScannButton"+UnitId)){return false;}
        document.getElementById("btn_ScannButton"+UnitId).disabled=true;
    }


    this.recycleWaste=function (UnitId)
    {
        var Unit=this.UnitCollection.getById(UnitId);
        if(!Unit){return false;}
       	var Ajax= new AjaxRequest("",Func,document.URL+"&Action=RecycleWaste&UI="+UnitId);
	    this.CanUpdate=false;
	    this.MapObjectCollection.deleteById(this.MapObjectCollection.getElementByKoordinateAndRange(Unit.getX(),Unit.getY(),20));
	    var HTML=Ajax.doRequestSyncron(); 
        var DetailLayer = document.getElementById("DetailsContainer");
        if(!document.getElementById("DetailsContainer")){return false;}
        eval(HTML);
        this.render();   
    }
    
    
    this.buildDeathStar=function (UnitId)
    {
        var Unit=this.UnitCollection.getById(UnitId);
        if(!Unit){return false;}

	   if( Unit.getStoredElement('t')<50000 ||Unit.getStoredElement('b')<50000 || Unit.getStoredElement('c')<50000 || Unit.getStoredElement('m')<50000)
	   {
	        alert(this.Language.NeedMoreRessourceToBuildDeathStar);
	        return false;
	   }
	    var Ajax= new AjaxRequest("",Func,document.URL+"&Action=BuildDeathStar&UI="+UnitId);
	    var HTML=Ajax.doRequestSyncron(); 
	    this.CanUpdate=false;
	    Unit.Picture="./images/units/DeathStarBuild_F.png";
	    Unit.setWidth(50);
        var DetailLayer = document.getElementById("DetailsContainer");
        if(!document.getElementById("DetailsContainer")){return false;}
        eval(HTML);
        this.render();   
    }
    
    
    this.triggerEMP=function (UnitId)
    {
        var Unit=this.UnitCollection.getById(UnitId);
        if(!Unit){return false;}
	    var Ajax= new AjaxRequest("",Func,document.URL+"&Action=EmpNearbyShips&UId="+UnitId);
	    var HTML=Ajax.doRequestSyncron(); 
	    this.CanUpdate=false;
	    //Unit.Picture="./images/units/DeathStarBuild_F.png";
        var DetailLayer = document.getElementById("DetailsContainer");
        if(!document.getElementById("DetailsContainer")){return false;}
        DetailLayer.innerHTML=HTML;
        this.render();   
    }
    
    
    
    this.destroyPlanet=function (DeathStarId)
    {
        var Unit=this.UnitCollection.getById(DeathStarId);
        if(!Unit ){return false;}
        var Planet=this.PlanetCollection.getElementByKoordinateAndRange(Unit.getX(),Unit.getY(),50);
        if(!Planet.getId())
        {
            alert(this.Language.NoPlanetInRange);
            return false;
        }
	   if( !confirm(this.Language.DestroyPlanet))
	   {
	        return false;
	   }
	   
	    var Ajax= new AjaxRequest("",Func,document.URL+"&Action=DestroyPlanet&UI="+DeathStarId);
	    var HTML=Ajax.doRequestSyncron(); 
	    this.CanUpdate=false;
        var DetailLayer = document.getElementById("DetailsContainer");
        if(!document.getElementById("DetailsContainer")){return false;}
        // den planeten auf 0:0 setzen und löschen   
        UserPlanetCollection.clear();
        this.PlanetCollection.clear();
        this.updateMap();
        this.render(); 
    }
    
    this.loadDeathStar=function (DeathStarId,UnitId)
    {
        var Unit=this.UnitCollection.getById(UnitId);
        var DeathStar=this.UnitCollection.getById(DeathStarId);
        if(!Unit || !DeathStar){return false;}

	   if( Unit.getStoredElement('c')==0 && Unit.getStoredElement('m')==0)
	   {
	        alert(this.Language.NeedMoreRessourceForDeathStar);
	        return false;
	   }
	   
	    var Ajax= new AjaxRequest("",Func,document.URL+"&Action=LoadDeathStar&UI="+DeathStarId+"&TransporterId="+UnitId);
	    var HTML=Ajax.doRequestSyncron(); 
	    this.CanUpdate=false;
        var DetailLayer = document.getElementById("DetailsContainer");
        if(!document.getElementById("DetailsContainer")){return false;}
        DetailLayer.innerHTML=HTML;
        //eval(HTML);
        this.render();   
    }
    
//this.SelectetElementCollection.getByIndex(0)
    this.raidPlanet=function(UnitId)
    {
        var Unit=this.UnitCollection.getById(UnitId);
        if(!Unit){return false;}
       	var Ajax= new AjaxRequest("",Func,document.URL+"&Action=RaidPlanet&UI="+UnitId);
	    this.CanUpdate=false;
	    var HTML=Ajax.doRequestSyncron(); 
        var DetailLayer = document.getElementById("DetailsContainer");
        if(!document.getElementById("DetailsContainer")){return false;}
        //this.updateMap();
        DetailLayer.innerHTML=HTML;
    }


    this.setTaskCollection= function(TaskCollection)
    {
        this.TaskCollection.hide();
        this.TaskCollection.merge(TaskCollection);
        this.TaskCollection.setMap(this.MyMap);  
    }

    this.setHost= function(Host)
    {
        this.Host=Host; 
    }



    this.setPlanetCollection= function(PlanetCollection)
    {
        this.PlanetCollection.hide();
        this.PlanetCollection.merge(PlanetCollection);
        this.PlanetCollection.setMap(this.MyMap);
        this.PlanetCollection.setShowIdentificationMark(this.ShowIdentificationMark);
        
    }

    this.setUnitCollection= function(UnitCollection)
    {
        this.UnitCollection.hide();
        this.UnitCollection.merge(UnitCollection);
        this.UnitCollection.setMap(this.MyMap);
       
    }

    this.setMapObjectCollection= function(MapObjectCollection)
    {
        this.MapObjectCollection.merge(MapObjectCollection);
        this.MapObjectCollection.setMap(this.MyMap); 
        // was nicht gezeigt werden soll ausblenden
        if(!this.ShowAstroids)
        {
            this.MapObjectCollection.hideByType(1);
            this.MapObjectCollection.hideByType(2); 
        }
    }

    this.checkInVisUnits= function(ElementCollection,CollectionName)
    {
       var Element= null;
       var MapCollection=null; 
        switch(CollectionName)
        {
            case "PlanetCollection":
            {
                MapCollection= this.PlanetCollection;
            }break;
                    case "UnitCollection":
            {
                MapCollection= this.UnitCollection;
            }break;
                    case "UserPlanetCollection":
            {
                MapCollection= this.UserPlanetCollection;
            }break;
                    case "UserUnitCollection":
            {
                MapCollection= this.UserUnitCollection;
            }break;
        }
        
		    for(var i=0;i<MapCollection.getCount();i++)
		    {
		        Element=MapCollection.getByIndex(i);
		        if(!ElementCollection.getById(Element.getId()))
		        {
		            Element.hide();
		        }
              
		    }
    }


    this.render= function()
    { 
        this.setZoom(this.Zoom);  
        this.renderMapUnits();
    }

    this.fillCollectionDiv= function()
    {
       if(!document.getElementById("CollectionContainer")){return false;}
       document.getElementById("CollectionContainer").innerHTML="";
       if(this.SelectetPlanet)
       {
            document.getElementById("CollectionContainer").innerHTML+=this.SelectetPlanet.renderforCollection(); 
       }
       document.getElementById("CollectionContainer").innerHTML+=this.SelectetElementCollection.getDivCollectionString();   //die selectrierten flotten
    }
    
    this.moveUnit= function()
    {
        if(this.SelectetElementCollection.getCount()==0){return false;}
        if(!this.SelectetElementCollection.getAreMyUnit()){return false;}
        if(this.SelectetPlanet){return false;} // wenn ein planet ausgewählt wurde
        var TempTime= new Date().getTime(); 
        if(this.LastUnitRefresh+100>TempTime){return false;} // wenn ein planet ausgewählt wurde
        if(this.SelfUnit){return false;}  

        for (var i=0;i<this.SelectetElementCollection.getCount();i++)
        {
            this.moveUnitQuery(this.KoordinateX,this.KoordinateY,this.SelectetElementCollection.getByIndex(i).getId());
            this.TaskCollection.deleteByUnitId(this.SelectetElementCollection.getByIndex(i).getId());
            var LastTask=this.TaskCollection.getByUnitId(this.SelectetElementCollection.getByIndex(i).getId());
            var TaskId=LastTask.getId();
            if(TaskId==0)
            {   
               var TaskId=this.SelectetElementCollection.getByIndex(0).getId();
            } 
            var MyTask= new Task(TaskId,"move",this.KoordinateX,this.KoordinateY,this.SelectetElementCollection.getByIndex(i).getId());
            MyTask.setZoom(this.Zoom);
            this.TaskCollection.add(MyTask);
        }
        this.TaskCollection.setKorrection(this.StartX,this.StartY); 
        MyTask.show();
        //this.refreshUnitDesciption(this.SelectetElement.getId());
        this.getUserUnit(this.SelectetElementCollection.getByIndex(0).getId()).getFlightTime();  
    }
    
    
     this.showSelectetUnitDesciption= function()
     {
        this.RouteState=false;
        this.showUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());
     }      
       

     this.showElementSelection = function(ElemetnCollection)
     {
        if(!$('DetailsContainer')){return false;}
        $('DetailsContainer').inerHTML="";
        $('DetailsContainer').show();
        $("DetailsContainer").style.overflow="scroll";
       //$('DetailsContainer').inerHTML=ElemetnCollection.getElementList();
        this.setDetailHTML(ElemetnCollection.getElementList());
     }  
       
       
    this.mapClick= function()
    {
        // keine einheit ausgewählt
        // einheit anwählen
        this.UnitCollection.setKorrection(this.StartX,this.StartY);
        if(!this.RightClick)// wenn meherer element übereinander liegen
        {
          var ElementCollection= this.UnitCollection.getElementCollectionByKoordinateAndRange(this.KoordinateX,this.KoordinateY,15*this.Zoom);
          var ElementPlanetCollection=this.PlanetCollection.getOnMap().getElementCollectionByKoordinateAndRange(this.KoordinateX,this.KoordinateY,90+10*this.Zoom);
          ElementCollection.merge(ElementPlanetCollection);
          if(ElementCollection.getCount()>1)
          {
            // auswahlbildschirm zeigen
            this.showElementSelection(ElementCollection);
            return true;
          }
          
        }
        var Element=this.UnitCollection.getOnMap().getElementByKoordinateAndRange(this.KoordinateX,this.KoordinateY,15*this.Zoom);
        //this.UnitCollection.deSelect();
        
        if(this.TriggerJump  && this.SelectetElementCollection.getAreMyUnit())
        {    
            this.jumpToPosition(this.SelectetElementCollection.getByIndex(0).getId());
            this.TriggerJump=false;
            return true;
        }
        
        if(this.RouteState && this.RightClick)
        {    
            // wenn zoom und ein Planet in der nähe ist dann die Koorekten Planeten koords nehemen 
            var TempPlanet= this.PlanetCollection.getElementByRange(this.KoordinateX,this.KoordinateY,25*this.Zoom);
             if(TempPlanet)
            {
                this.Route.add(TempPlanet.getX(),TempPlanet.getY());
            }else
            {
                this.Route.add(this.KoordinateX,this.KoordinateY);
            }
            this.Route.render();
            return true;
        }
        //----------------- Route
        
        if(this.SelectetElementCollection.getCount()==0 &&  Element && Element.getIsMyUnit() && !this.StrgPush)// wenn keine Flotte ausgewählt ist und eine Flotte des User ausgewählt wurde 
         {
            // in den Einheiten gucken 
                this.SelectetElementCollection.clear();
                this.render();
                if(this.SelectetPlanet)
                {
                    this.SelectetPlanet.deSelect(); //deselectieren
                    this.SelectetPlanet=null;
                }
                this.SelectetElementCollection.add(Element);
                this.render();
                this.showUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());
                return true;
           
         } 
         
         if(this.SelectetElementCollection.getCount()==1 &&  Element && this.SelectetElementCollection.getByIndex(0).getId()==Element.getId() && !this.StrgPush)// wenn keine Flotte ausgewählt ist und eine Flotte des User ausgewählt wurde 
         {
            // in den Einheiten gucken 
                this.SelectetElementCollection.clear();
                this.render();
                if(this.SelectetPlanet)
                {
                    this.SelectetPlanet.deSelect(); //deselectieren
                    this.SelectetPlanet=null;
                }
                 $("DetailsContainerWrapper").hide();
                this.render();
                return true;
         } 
         
         // bei einer umplatzierung der flotten
         if(!Element && this.SelectetElementCollection.getAreMyUnit() &&  this.RightClick) // flotten bewegen wenn es eine eigene Einheit ist und keine andere ausgewählt wurde
            { 
                this.moveUnit();
                this.render();
                return true;
            }
         
         // wenn gegnerische flotte angegriffen werden soll
            if(Element  && this.SelectetElementCollection.getAreMyUnit() &&  this.RightClick) // flotten bewegen wenn es eine eigene Einheit ist und keine andere ausgewählt wurde
            { 
                this.moveUnit();
                this.render();
                return true;
            }
  
  
          if(this.SelectetElementCollection.getCount()>0 &&  Element && Element.getIsMyUnit() && this.StrgPush && this.SelectetElementCollection.getAreMyUnit()) // wenn mehrere Flotten ausgewählt wurden
         {
            // in den Einheiten gucken 
                //this.SelectetElementCollection.clear();
                if(this.SelectetPlanet)
                {
                    this.SelectetPlanet.deSelect(); //deselectieren
                    this.SelectetPlanet=null;
                }
                
                if(!this.SelectetElementCollection.getById(Element.getId()))
                {
                    this.SelectetElementCollection.add(Element);
                }else
                {
                    this.SelectetElementCollection.deleteById(Element.getId());
                }
                this.render();
                this.clearDetailContainer();
                // this.showUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());
                // hier anzeige hin das mehrere einheiten ausgewählt sind
                return true;
           
         } 
  
         if(Element && Element.getIsMyUnit() && !this.StrgPush)// wenn keine Flotte ausgewählt ist und eine Flotte des User ausgewählt wurde 
         {
            // in den Einheiten gucken 
                this.SelectetElementCollection.clear();
                this.render();
                if(this.SelectetPlanet)
                {
                    this.SelectetPlanet.deSelect(); //deselectieren
                    this.SelectetPlanet=null;
                }
                this.SelectetElementCollection.add(Element);
                this.render();
                this.showUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());
                return true;
           
         } 

        if(Element && Element.getId()!=0 && !Element.getIsMyUnit())// wenn keine Flotte ausgewählt ist und eine Flotte des User ausgewählt wurde 
         {
            // in den Einheiten gucken 
                this.SelectetElementCollection.clear();// alle flotten aus der auswahl löchen
                this.render();
                if(this.SelectetPlanet)
                {
                    this.SelectetPlanet.deSelect(); //deselectieren
                    this.SelectetPlanet=null;
                }
                this.SelectetElementCollection.add(Element);
                this.render();
                this.showUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());
                return true; 
         } 
         var Planet=this.PlanetCollection.getOnMap().getElementByKoordinateAndRange(this.KoordinateX,this.KoordinateY,90+10*this.Zoom);
         if(!Planet || Planet.getId()==0)
         { 
            var TempUnit=this.SelectetElementCollection.getByIndex(0);
            if(TempUnit)
            {
                TempUnit.getObjectType();
                if(TempUnit && TempUnit.getId()!=0 && TempUnit.getObjectType()=="Unit")
                {
                    return true;
                }            
            }
            if(this.SelectetPlanet)
            {
                this.SelectetPlanet.deSelect();
                this.SelectetPlanet=null;
                this.render();
                $("DetailsContainerWrapper").hide();
                return true;
            }
         }

         
         
         if(this.SelectetPlanet &&this.SelectetPlanet.getId()==Planet.getId())
         {
            this.SelectetPlanet.deSelect();
            this.SelectetPlanet=null;
            this.render();
            $("DetailsContainerWrapper").hide();
            return true;
         }
         Planet.select();
         this.SelectetPlanet=Planet;
         this.SelectetElementCollection.clear();
         this.PlanetCollection.deSelect();
         this.PlanetCollection.rePlacePlanet(Planet); 
         this.render();
         this.showPlanetDesciption(Planet.getId());
    }     
       
     this.clearDetailContainer=function()
     {
        document.getElementById("DetailsContainer").innerHTML="";
     }  
       
       
        
    this.getTaskByUnitId= function(UnitId)
    {
        this.TaskCollection.setKorrection(this.StartX,this.StartY);
        this.TaskCollection.setZoom(this.Zoom);
        return this.TaskCollection.getByUnitId(UnitId);
    }

    this.refreshUnitDesciption= function(UnitId)
    {
        this.showUnitDesciption(UnitId);
    }


    this.showUnitDesciption= function(UnitId)
    {
        this.RouteState=false;
        var TempUnit= this.UnitCollection.getById(UnitId);
        if(!TempUnit)
        {
            if(!TempUnit)
            {
                var TempUnit=this.UserUnitCollection.getById(UnitId);
                if(!TempUnit)
                {
                    return false;
                }
            }
        }
        if(!document.getElementById("DetailsContainer")){return false;}
        
                Func =  function()
			    {
				    switch(Ajax.Req.readyState)
				    {
					case 4://Abgeschlossen
					    if(Ajax.Req.status == 200) //Anfrage erfolgreich
					    {
                            getMap().setDetailHTML(Ajax.Req.responseText);
                            getMap().getUserUnit(TempUnit.getId()).getFlightTime();
					    }
				    }
			    }
        
        this.setDetailHTML("<p style='text-align: center;vertical-align:middle;'><img   src='images/Map/Loading.gif' width='100px' height='22px' /></p>");
        var Ajax= new AjaxRequest("",Func,document.URL+"&Action=GetUnitDescription&UId="+UnitId);    
	    var HTML=Ajax.doRequest();
        document.getElementById("DetailsContainer").style.overflow="hidden";
        this.getUserUnit(UnitId).getFlightTime();
    }
    
    this.selectUnit= function(UnitId)
       {
            var Element=this.UnitCollection.getById(UnitId);
            if(!Element)
            {
                var Element=this.UserUnitCollection.getById(UnitId);
                if(!Element)
                {
                    return false;
                }
                this.SelectetElementCollection.add(Element);
            }
            if(this.SelectetPlanet)
            {
                this.SelectetPlanet.deSelect();// das alte Element Deselectieren
            }
            this.SelectetPlanet=null;
            
            
         if(this.SelectetElementCollection.getCount()>0 &&  Element && Element.getIsMyUnit() && this.StrgPush && this.SelectetElementCollection.getAreMyUnit()) // wenn mehrere Flotten ausgewählt wurden
         {           
                if(!this.SelectetElementCollection.getById(Element.getId()))
                {
                    this.SelectetElementCollection.add(Element);
                }else
                {
                    this.SelectetElementCollection.deleteById(Element.getId());
                    Element.deSelect();
                }
                this.render();
                if(this.SelectetElementCollection.getCount()==1)
                {
                    this.showUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());  
                }else
                {
                    this.clearDetailContainer();
                }
                this.fillCollectionDiv();
                return true; 
         } 
            
            
            if(this.SelectetElementCollection.getByIndex(0))
            { 
                this.SelectetElementCollection.deSelect();// das alte Element Deselectieren
            }
            
            if(this.SelectetElementCollection && this.SelectetElementCollection.getByIndex(0) && this.SelectetElementCollection.getByIndex(0).getId()== Element.getId())
            {
                this.SelectetElementCollection.clear();
                this.render();
                return false;
            }
            this.SelectetElementCollection.clear();
            this.SelectetElementCollection.add(Element);
            Element.deSelect();
            
            this.fillCollectionDiv();
            this.showUnitDesciption(this.SelectetElementCollection.getByIndex(0).getId());          
            this.render();
       }
       

       this.selectPlanet= function(PlanetId)
       {
            var Planet=this.PlanetCollection.getById(PlanetId);
            if(!Planet)
            {
                var Planet=UserPlanetCollection.getById(PlanetId);
                if(!Planet)
                {
                    return false;
                }
            }  
        if(!Planet){return true;} 
        
        this.SelectetElementCollection.deSelect();
        this.SelectetElementCollection.clear();
         if(this.SelectetPlanet && this.SelectetPlanet.getId()==Planet.getId())
         {
            this.SelectetPlanet.deSelect();
            this.SelectetPlanet=null;
            this.render();
            return true;
         }
        
         Planet.select();
         this.SelectetPlanet=Planet;
         this.PlanetCollection.deSelect();
         this.PlanetCollection.rePlacePlanet(Planet); 
         this.showPlanetDesciption(Planet.getId());
         this.render();
          //alert("planet gewählt");
          //eventuell ausgewählte element löschen
         //this.render();
       }
    
    
    
    this.setHTMLInContainer=function(HTML)
    {
        if(!document.getElementById("DetailsContainer")){return false;}
        if(!HTML){return false;}
        document.getElementById("DetailsContainer").innerHTML=HTML;
    }
    
    this.isUserUnit= function(UnitId)
    {
      var TempUnit= this.UserUnitCollection.getById(UnitId);
            try
        {
            if(UnitId=TempUnit.getId())
            {
                return true;
            }else
            {
                return false;
            }
        }catch (e) 
        {
            return false;
        }
    }
    
    
    this.showUnitDesciptionMap= function(UnitId)
    {
        try
        {
            if(this.SelectetElement && this.SelectetElement.getId()!=UnitId && this.isUserUnit(this.SelectetElement.getId()))// wenn einheit einem selber gehört dann beweg das ding
            {
                if(this.isUserUnit(UnitId) && this.isUserUnit(this.SelectetElement.getId()))
                {
                    this.showUnitDesciption(UnitId);
                    return false;
                }
                // Einheit bewegen
                this.moveUnit();
                return true;
            }

       this.showUnitDesciption(UnitId);
       }catch(e)
       {
            this.showUnitDesciption(UnitId);
       }
    }
    
    

    this.showPlanetDesciption= function(PlanetId)
    {
        var Planet= this.PlanetCollection.getById(PlanetId);
        if(!Planet)
        {
            return false;
        }
        if(!document.getElementById("DetailsContainer")){return false;}
        
        Func =  function()
			    {
				    switch(Ajax.Req.readyState)
				    {
					case 4://Abgeschlossen
					    if(Ajax.Req.status == 200) //Anfrage erfolgreich
					    {
                            getMap().setDetailHTML(Ajax.Req.responseText);
					    }
				    }
			    }
        
        this.setDetailHTML("<p style='text-align: center;vertical-align:middle;'><img   src='images/Map/Loading.gif' width='100px' height='22px' /></p>");
        var Ajax= new AjaxRequest("",Func,document.URL+"&Action=GetPlanetDescription&PId="+PlanetId);    
	    var HTML=Ajax.doRequest();
	    
        document.getElementById("DetailsContainer").style.overflow="scroll";
    }

    this.showPlanetDesciptionMap= function(PlanetId)
    {
        try{
            if(this.SelectetElement && this.isUserUnit(this.SelectetElement.getId()))// wenn einheit einem selber gehört dann beweg das ding
            {
                // Einheit bewegen
                this.moveUnit();
                return true;
            }
            this.showPlanetDesciption(PlanetId);
        }catch(e)
        {
            this.showPlanetDesciption(PlanetId);
        }
    }

    this.setDetailHTML= function(HTML)
    {
        if(!document.getElementById("DetailsContainer")){return false;}
        $("DetailsContainerWrapper").show();
        document.getElementById("DetailsContainer").innerHTML=HTML;
    }

    this.loadCookie= function()
    {
       // alert(document.cookie);
      if(document.cookie)
      {
        MyArray=document.cookie.split(";");
        var Temp="";
        for(var i =0;i<MyArray.length;i++)
        {
            Temp=MyArray[i].split("=");
            if(Temp[0]=="t" || Temp[0]==" t")
            {
                if(Temp[1]=="true" )
                {
                    this.ShowIdentificationMark=true;
                }else
                {
                    this.ShowIdentificationMark=false;
                }
            }
            if(Temp[0]=="z" || Temp[0]==" z" )
            {
            var OldZoom=Temp[1];
            var NewZoom=Temp[1]*1;
                if(OldZoom!=NewZoom || parseInt(Temp[1])==Number.NaN)
                {
                    this.Zoom=1;
                }else
                {
                    this.Zoom=parseInt(Temp[1]);
                }
            }  
            
            if(Temp[0]=="a" || Temp[0]==" a" )
            {
                this.ShowAstroids=true;
            }  
        }
      }
        
        
    }

    this.start= function()
    {
        var TempCounter=0;
        var StartX=this.StartX;
        var StartY=this.StartY;
        var Canvas = document.getElementById('MapContainer');
        if(Canvas) 
        {
            if (Canvas.getContext)
            {
                this.MyMap = Canvas.getContext('2d'); // 2d mod starten
            }else
            {
               this.MyMap = G_vmlCanvasManager.initElement(Canvas);
               alert(this.Language.NewBrowser);
               this.stop();
               return false;
            }
        }
        this.loadPics();
        this.fillUserDiv();
        this.loadCookie();
        this.initPanel();
         
         if(this.Resx<1921 || this.Res<1051)
         {
            this.BackgroundMapString="./images/Map/MapBackGround1.png";
         }else
         {
            this.BackgroundMapString="./images/Map/MapBackGroundHighRes.png";// wenn die auflösung zu groß ist dann anderes hintergund bild laden
         }
         
        this.StartX=this.StartX-(this.Width/2)*(this.Zoom-1);
        this.StartY=this.StartY-(this.Height/2)*(this.Zoom-1);
        if(this.Zoom!=1)
        {
            this.updateMap();
        }
        this.reSizeMap();
        //this.BackgroundPicture=Math.round(Math.random()*10);
    }


    this.initPanel = function()
    {
          if(this.ShowIdentificationMark)
          {
               if($("IdentificationMark"))
                  {
                    $("IdentificationMark").checked=true;
                  }
             }else
             {
                  if($("IdentificationMark"))
                  {
                    $("IdentificationMark").checked=false;
                  }
             }
             
             if(this.ShowIdentificationMark)
             {
                  if($("cb_ShowAstroids"))
                  {
                    $("cb_ShowAstroids").checked=true;
                  }
             }else
             {
                  if($("cb_ShowAstroids"))
                  {
                    $("cb_ShowAstroids").checked=false;
                  }
             }
    }

    this.stop=function()
    {
        window.clearInterval(this.UpdateIntervall);
        window.clearInterval(this.RenderIntervall);
    }

    this.setBackgroundPicture= function (BackgroundPicture)
    {
        this.BackgroundPicture=BackgroundPicture;
    }


    this.loadPics= function()
    {
        var MySystem= new System();
        var MyImage=new Array();
        for(var i =0;i<=79;i++)
        {
            //MyImage[i] = new Image();
            getPicturLoader().getPic("./images/Map/ObjectsSmall/Planet"+i+".png");
            //MyImage[i].src = "./images/Map/ObjectsSmall/Planet"+i+".png";
        }
      
        getPicturLoader().getPic("./images/Map/sun1.png");
        getPicturLoader().getPic("./images/Map/ObjectsSmall/sun1.png");
    
        getPicturLoader().getPic("./images/Map/sun2.png");
        getPicturLoader().getPic("./images/Map/ObjectsSmall/sun2.png");

        getPicturLoader().getPic("./images/Map/sun3.png");
        getPicturLoader().getPic("./images/Map/ObjectsSmall/sun3.png");

         
    }


    this.showLayer=function()
    {   
        var Element= null;
        if(!this.ShowLayer){return false;}
        if(this.Zoom>15){return false;}
        Element=this.UnitCollection.getOnMap().getElementByKoordinate(this.KoordinateX-(25*this.Zoom),50*this.Zoom,this.KoordinateY-(25*this.Zoom),50*this.Zoom);
        if(!Element)
        {
            Element=this.PlanetCollection.getOnMap().getElementByKoordinate(this.KoordinateX-(12.5*this.Zoom),25*this.Zoom,this.KoordinateY-(12.5*this.Zoom),50*this.Zoom);
        }
        
        if(!Element)
        {
            Element=this.MapObjectCollection.getOnMap().getElementByKoordinate(this.KoordinateX-(12.5*this.Zoom),25*this.Zoom,this.KoordinateY-(12.5*this.Zoom),50*this.Zoom);
            if(!Element || Element.getObjectType()!="Sun")
            {
                document.getElementById("DetailLayer").style.display="none";
                return false;
            }
            if(Element.getObjectType()!="Sun")
            {
                document.getElementById("DetailLayer").style.display="none";
                return false;
            }


               var Layer=document.getElementById("DetailLayer");
              var TempString="<table border='0' width='170px'><tr>";
                    TempString+="<td class='header' style='width:20%;'>"+Element.getName()+"</td>";
                    TempString+="</tr><tr>";
                    TempString+="<td >"+Math.round(Element.getX())+":"+Math.round(Element.getY())+"</td>";
                    TempString+="</tr></table>";
                    Layer.innerHTML=TempString;
                    Layer.style.left = (this.MouseX + 20) + "px";
		            Layer.style.top = (this.MouseY - 140) + "px";
                    Layer.style.display="block"; 
                    return true;
        }
        
        
        if(!Element)
        {
            document.getElementById("DetailLayer").style.display="none";
            return false;
        }
        
        var Layer=document.getElementById("DetailLayer");
        var TempString="<table border='0' width='170px'><tr>";
        TempString+="<td class='header' style='width:20%;'>"+this.Language.Name+": </td><td >"+Element.getName()+"</td>";
        TempString+="<td rowspan='4' style='width:20%;'><img src='"+Element.getUserPictureString()+"' style='width:100px;height:100px;' /> </td>";
        
        TempString+="</tr><tr>";
        TempString+="<td class='header' style='width:20%;'>"+this.Language.Owner+": </td><td >"+Element.getOwner()+"</td>";
        TempString+="</tr><tr>";
        TempString+="<td class='header' style='width:20%;'>"+this.Language.Allianz+": </td><td >"+Element.getAllianzName()+"</td>";
        TempString+="</tr><tr>";
        TempString+="<td class='header' style='width:20%;'>"+this.Language.Coordinates+": </td><td >"+Math.round(Element.getX())+":"+Math.round(Element.getY())+"</td>";
        TempString+="</tr></table>";
        Layer.innerHTML=TempString;
        Layer.style.left = (this.MouseX + 20) + "px";
		Layer.style.top = (this.MouseY - 140) + "px";
        Layer.style.display="block";  
    }
    
    this.showScannerLayer=function()
    {   
        var Element= null;
        var Layer=document.getElementById("DetailLayer");
        var TempString="<table border='1' width='270px'><tr><td >Führt einen Scannvorgang aus der in der nähe befindliche Planeten analysiert.</td></tr><tr>";
        TempString+="<td>Der Planet muss sich innerhalb von 100 Distanzeinheiten befinden.</td></tr></table>";
        Layer.innerHTML=TempString;
        Layer.style.left = (this.MouseX + 20) + "px";
		Layer.style.top = (this.MouseY - 80) + "px";
        Layer.style.display="block";  
    }
    
    
    
    this.showRaidLayer=function()
    {   
        var Element= null;
        var Layer=document.getElementById("DetailLayer");
        var TempString="<table border='1' width='270px'><tr><td >Führt einen Überfall auf in der näheliegenden Planeten aus</td></tr><tr>";
        TempString+="<td>Die Einheit wird mit Rohstoffen des Planeten beladen</td></tr></table>";
        Layer.innerHTML=TempString;
        Layer.style.left = (this.MouseX + 20) + "px";
		Layer.style.top = (this.MouseY - 80) + "px";
        Layer.style.display="block";  
    } 

    this.hideLayer=function()
    {
        var Layer=document.getElementById("DetailLayer");
        Layer.innerHTML="";
        Layer.style.display="none";
    
    }

    this.upDate= function()
    {
         for(var i=0;i<30;i++)
         {    
               this.ImageCollection[i].update();
         }
    }
    
    this.setMousKoordinates= function(X,Y)
    {
        this.MouseX=X;
        this.MouseY=Y;
        this.updateKoordinates();
        // prüfen ob neu gezeichnet werden soll
        if(!this.MoveMapState){return false;}
        this.moveMap();
        this.render();
        this.ViewableUnitsCalculated=false;
    }
    
    this.updateKoordinates= function()
    {
        if(!document.getElementById("KoordinateDiv")){return false};
        var TempCoorection=0;
        var Top= getTop(document.getElementById("MapContainer"));
        var left= getLeft(document.getElementById("MapContainer"));
        
        this.KoordinateX=this.Zoom*(this.MouseX-left)+this.StartX;
        this.KoordinateY=this.Zoom*(this.MouseY-Top)+this.StartY;
        var TempX=Math.round(this.KoordinateX);
        var TempY=Math.round(this.KoordinateY);
        document.getElementById("KoordinateDiv").innerHTML=TempX+" : "+ TempY;
    }
    
    this.moveMap= function()
    {
	        //document.body.style.cursor ="hand";
	        if(this.MoveMapState==false){return true;}
		    if(	this.XDiffStart==getMap().KoordinateX && getMap().YDiffStart==getMap().KoordinateY){return false;}
		    var DiffX=this.XDiffStart-this.KoordinateX;
		    var DiffY=this.YDiffStart-this.KoordinateY;
            this.StartX=this.StartX+DiffX;
            this.StartY=this.StartY+DiffY;
            // nur neu zeichen nicht neu holen
            
            //this.updateMap();
            return false;
    }
    
    this.centerMapOnKoordiante= function()
    {
         this.StartX=this.KoordinateX-(this.Width/2)*this.Zoom;
         this.StartY=this.KoordinateY-(this.Height/2)*this.Zoom;
         this.updateMap();
         return false;
    }
    
    
    this.showMapOnKoordiante= function()
    {
        if(!Number(document.getElementById("i_KoorX").value)){return false;}
        if(!Number(document.getElementById("i_KoorY").value)){return false;}
         this.StartX=document.getElementById("i_KoorX").value-(this.Width/2)*this.Zoom;
         this.StartY=document.getElementById("i_KoorY").value-(this.Height/2)*this.Zoom;
         this.updateMap();
         return false;
    }
    
    this.showMapOnKoordianteXY= function(X,Y)
    {
        if(!Number(X)){return false;}
        if(!Number(Y)){return false;}
         this.StartX=X-(this.Width/2)*this.Zoom;
         this.StartY=Y-(this.Height/2)*this.Zoom;
         this.updateMap();
         return false;
    }
    
    
    this.moveUnitQuery = function(X,Y,UnitId)
    {
		
			Func =  function()
			{
				switch(Ajax.Req.readyState)
				{
					case 4://Abgeschlossen
					if(Ajax.Req.status == 200) //Anfrage erfolgreich
					{
                        eval(Ajax.Req.responseText);
					}
				}
			}
			var Ajax= new AjaxRequest("",Func,document.URL+"&Action=MoveUnit&X="+X+"&Y="+Y+"&UId="+UnitId);
			this.setHTMLInContainer(Ajax.doRequestSyncron());	
	}
	
	this.handleWheel = function(event)
	{
	    var delta = 0;
        if (!event) /* For IE. */
                event = window.event;
        if (event.wheelDelta) { /* IE/Opera. */
                delta = event.wheelDelta/120;

        } else if (event.detail) { 
                delta = -event.detail/3;
        }
        if (delta)
        {
                if(delta<0)
                {
                    getMap().ZoomOut(0.2);
                }else
                {
                    getMap().ZoomIn(0.2);
                }       
        }
        if (event.preventDefault)
        {
                event.preventDefault();
        }
	    event.returnValue = false;
	}
	
	

	
	
}
GameMap.prototype = new RenderObject(0,0);
var MyMapEngine=null; // init für das singelton

function getMap(StartX,StartY)
{
    if(!MyMapEngine)
    {
      MyMapEngine= new GameMap(StartX,StartY);
    }
    return MyMapEngine;
}


function updateMapKoordinate(e) 
{
    x = (document.all) ? window.event.x : e.pageX;
    y = (document.all) ? window.event.y : e.pageY;
    /*var Top= getTop(document.getElementById("MapContainer"));
    var left= getLeft(document.getElementById("MapContainer"));
     var MyMap=getMap(0,0);
    if(x<left || x>(left+MyMap.getWidth())) {return false;}
    if(y<Top || y>(Top+MyMap.getHeight())) {return false;}
   */
    MyMap.setMousKoordinates(x,y);
    return false;
}


function updateMapClick(e) 
{
    x = (document.all) ? window.event.x : e.pageX;
    y = (document.all) ? window.event.y : e.pageY;
    var MyMap=getMap(0,0);
    MyMap.moveUnit(e);
    return false;
}

function clickDown(e)
{
    getMap().setShowLayer(false);
    getMap().hideLayer();
	if (navigator.appName != 'Microsoft Internet Explorer' && e.which == 1 )
	{
		getMap().XDiffStart=getMap().KoordinateX;
		getMap().YDiffStart=getMap().KoordinateY;
		document.body.style.cursor ="move";
		$("MapContainer").style.cursor ="move";
		getMap().MoveMapState=true;
	    return false;
	
	}else
	{
		if (navigator.appName == 'Microsoft Internet Explorer' && event.button == 1) 
		{
			getMap().XDiffStart=getMap().KoordinateX;
			getMap().YDiffStart=getMap().KoordinateY;
			document.body.style.cursor ="move";
			$("MapContainer").style.cursor ="move";
			getMap().MoveMapState=true;
			return false;
		}
		//getMap().mapClick();
		return false;
	}
   //getMap().mapClick();
    return false;
}


function clickUp(e)
{
    getMap().setShowLayer(true);
        document.body.style.cursor ="default";
        $("MapContainer").style.cursor ="default";
        getMap().MoveMapState=false;
        //if(!document.getElementById("UnitContainer")){return false;}
        //document.getElementById("UnitContainer").focus();
        getMap().RightClick=false;
        MyMap.updateMap();
        MyMap.fillCollectionDiv();
        return false;
}

function showLayer(e)
{
        MyMap.showLayer();
        return false;
}


