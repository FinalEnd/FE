RenderObject = function(X, Y) 
{
    this.X = X;
    this.Y = Y;
    this.Width=0;
    this.Zoom=1;
    this.MapLeft=0;
    this.MapTop=0;
    this.State=0;
    this.MyMap=null;

    this.KorrectionX = 0;
    this.KorrectionY = 0;
    this.IsSelected=false;
    this.IsShow=true;
    this.ObjectType="RenderObject";

    this.getObjectType= function()
    {
        return this.ObjectType;
    }

    this.setIsSelected = function(IsSelected) 
    {
        this.IsSelected=IsSelected;
    }

   this.setMap = function(MyMap) 
    {
        this.MyMap=MyMap;
    }

    this.getX = function() {
        return this.X;
    }


   this.drawLine= function(intMoveX, intMoveY, intDestX, intDestY, strColor)
   {
        // Neuen Arbeitspfad anlegen
      this.MyMap.beginPath();
      this.MyMap.moveTo(intMoveX, intMoveY);
      this.MyMap.lineTo(intDestX, intDestY);
      this.MyMap.strokeStyle = strColor;
      this.MyMap.stroke();
    }
    
    this.drawText= function(X, Y, Color, Text,Size,Font,Align)
   {
        this.MyMap.font = Size+"px 'Font'";
        this.MyMap.fillStyle = Color;
        this.MyMap.textAlign = Align;
        this.MyMap.textBaseline = 'middle';
        this.MyMap.fillText(Text, X, Y);
    }
    

     this.renderBorder=function()
     {
            if(this.Zoom<15 && this.MyMap)
            {
                    this.MyMap.lineWidth = 1;
                    this.MyMap.strokeStyle = "#FFFFFF";
                    this.MyMap.strokeRect(this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2),this.Width,this.Width);
            }
     }


   this.getId = function() 
   {
        return 0;
    }

    this.getY = function() 
    {
        return this.Y;
    }

    this.getState = function() 
    {
        return this.State ;
    }


    this.setState = function(State) 
    {
        this.State=State;
    }

    this.toString = function() {
        var TempString = "";
        TempString += "X:" + this.X + " Y:" + this.Y;
        return TempString;
    }
    
    this.setKoorddinates = function(X, Y) 
    {
        this.X = X;
        this.Y = Y;
    }
    
    this.setKorrection = function(X, Y) 
    {
        this.KorrectionX = X;
        this.KorrectionY = Y;
    }
    
    this.render= function()
    {
        return true;
    }  
    
   this.setZoom= function(Zoom)
   {
        this.Zoom=Zoom;
   } 
    
    
 this.isOnMap=function()
 {
    var TempX=((this.X-this.KorrectionX)-this.Width)/this.Zoom;
    var TempY=((this.Y-this.KorrectionY)-this.Width)/this.Zoom;
    var MyMap=getMap(0,0);
    if(TempX <-50){return false;}
    if(TempX>MyMap.getWidth()+50){return false;}
    if(TempY<-50){return false;}
    if(TempY>MyMap.getHeight()+50){return false;}
    return true;
 }   
   
  this.calculateMapPosition=function()
  {
    this.MapLeft=((this.X-this.KorrectionX))/this.Zoom;
    this.MapTop=((this.Y-this.KorrectionY))/this.Zoom;
  
  } 
    
     this.getMapLeft= function()
    {
       return this.MapLeft;
    }
    
         this.getMapTop= function()
    {
       return this.MapTop;
    }
    
    this.getName= function()
    {
       return this.Name;
    }

    this.getOwner= function()
    {
       return this.Owner;
    }
    
    this.getAllianzName= function()
    {
       return this.AllianzName;
    }   
}
   
Collection = function()
{
	this.CollectionElements= new Array();
	this.CollectionState=null;
	this.IdIndex={};
	
	this.add = function (Element)
	{
		this.CollectionElements.push(Element);
		this.IdIndex[Element.getId()]=this.CollectionElements.length-1;
		return true;
	}
	
	this.getByType=function(Type)
    {
       var MyCollection= new Collection();
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getObjectType()==Type)
		    {
    		    MyCollection.add(this.CollectionElements[i]);
		    }	
		}
		return MyCollection;
    }
	
	this.getElementByKoordinateAndRange= function(X,Y,Range)
	{
		for(var i=0;i<this.CollectionElements.length;i++)
		{
		    Element=this.CollectionElements[i];
			if(Element.getX()>X-Range && Element.getX()<X+Range && Element.getY()>Y-Range && Element.getY()<Y+Range
			)
			{
			    return Element;
			}
		}
		return new Unit(0,"","", 0,0,0,0,0,0,0,0,0,0,0,0,0,0,false,"",0,"","");
	}
	
	
	this.getElementCollectionByKoordinateAndRange= function(X,Y,Range)
	{
	    var MyCollection=new Collection();
		for(var i=0;i<this.CollectionElements.length;i++)
		{
		    var Element=this.CollectionElements[i];
		    if(Range>=Math.sqrt(Math.pow(Element.getX()-X,2)+Math.pow(Element.getY()-Y,2)))
			{
			   MyCollection.add(Element);
			}
		}
		return MyCollection;
	}
	

	this.getElementonRightSide= function(Element)
	{
	    var SmalerElement=Element;
	    var ElementArray= {};
	    var Alpha=99;
		for(var i=0;i<this.CollectionElements.length;i++)
		{
		    var TempElement=this.CollectionElements[i];
		    var X=Element.getX()-TempElement.getX();
		    var Y=Element.getY()-TempElement.getY();
		    if(!X || !Y){continue;}
		    // anstieg ermitteln
		    if(Alpha>Math.atan(Y/X))
		    {
		        SmalerElement=TempElement;
		        Alpha=Math.atan(Y/X);
		    }
		}
		return TempElement;
	}
	
	
	this.deleteById=function(Id)
    {
        var TempArray= new Array();
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getId()!=Id)
		    {
    		    TempArray.push(this.CollectionElements[i]);
		    }	
		}
		this.CollectionElements=TempArray;
    }
	
	this.getByIndex= function(Index)
	{
        return this.CollectionElements[Index];
	}
	
	
    this.setMap = function(MyMap) 
    {
        for(var i=0;i<this.CollectionElements.length;i++)
		{
				this.CollectionElements[i].setMap(MyMap);
		}
    }
	
	
	this.setZoom= function (Zoom)
	{
		for(var i=0;i<this.CollectionElements.length;i++)
		{
            this.CollectionElements[i].setZoom(Zoom);
		}
	}
	
	this.getById= function(Id)
	{
		return this.CollectionElements[this.IdIndex[Id]];
	}
	
	
	this.getOnMap= function()
	{
	    var TempCollection= new Collection();
		for(var i=0;i<this.CollectionElements.length;i++)
		{
			if(this.CollectionElements[i].isOnMap())
			{
				TempCollection.add(this.CollectionElements[i]);
			}
		}
		return TempCollection;
	}
	
	this.getIndexById= function(Id)
	{
		if(this.IdIndex[Id])
		{
				return this.IdIndex[Id];
		}
		return 0;
	}
	
	this.merge= function(OtherCollection)
	{
	    var Element=null;
	    var Index=null;
		for(var i=0;i<OtherCollection.getCount();i++)
		{
		    Element=OtherCollection.getByIndex(i);
			if(this.getById(Element.getId()))
			{
			    // das Element Updaten
			    Index=this.getIndexById(Element.getId());
				this.CollectionElements[Index].State=Element.getState();
				this.CollectionElements[Index].X=Element.getX();
				this.CollectionElements[Index].Y=Element.getY();
				this.CollectionElements[Index].Stored=Element.Stored;
			}else
			{
			    // hinzufügen
			    this.add(Element);
			}
		}
	}
	
	
	this.getCount= function()
	{
	    return this.CollectionElements.length;
	}
	
	
	this.render= function()
	{
		for(var i=0;i<this.CollectionElements.length;i++)
		{
				this.CollectionElements[i].render();
		}
	}	
	
	this.clear= function()
	{
		this.CollectionElements= new Array();
	    this.CollectionState=null;
	    this.IdIndex=new Array();
	}
	
	this.setKorrection = function(X, Y) 
    {
        for(var i=0;i<this.CollectionElements.length;i++)
		{
		        try
		        {
				    this.CollectionElements[i].setKorrection(X, Y);
				}catch(E)
				{
				    //alert("fehler");
				    Y++;
				}
		}
    }
	
	this.getDivCollectionString= function()
	{
	    var TempString="";
	        for(var i=0;i<this.CollectionElements.length;i++)
		{
				TempString+=this.CollectionElements[i].renderforCollection();
		}
	    return TempString;
	}
	
	this.getElementList= function()
	{
	    var TempString="";
	        for(var i=0;i<this.CollectionElements.length;i++)
		{
				TempString+=this.CollectionElements[i].renderforList();
		}
	    return TempString;
	}
	
	
	this.deSelectAll= function()
	{
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
				this.CollectionElements[i].deSelect();
		}
	}
	
    this.select= function()
	{
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
				this.CollectionElements[i].select();
		}
	}
	
	this.deSelect= function()
	{
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
				this.CollectionElements[i].deSelect();
		}
	}
	
	this.hide= function()
	{
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
				this.CollectionElements[i].hide();
		}
	}
	
	
	this.getByKoordinate= function(X,Width,Y,Height)
	{
        var MyCollection= new Collection();
		for(var i=0;i<this.CollectionElements.length;i++)
		{
		    var Element=this.CollectionElements[i];
			if(Element.getX()>X && Element.getX()<X+Width && Element.getY()>Y && Element.getY()<Y+Width)
			{
			    // das Element Updaten
			    MyCollection.add(Element);
			}
		}
		return MyCollection;
	}
	
	this.getElementByKoordinate= function(X,Width,Y,Height)
	{
		for(var i=0;i<this.CollectionElements.length;i++)
		{
		    var Element=this.CollectionElements[i];
			if(Element.getX()>X && Element.getX()<X+Width && Element.getY()>Y && Element.getY()<Y+Width)
			{
			    return Element;
			}
		}
		return false;
	}
	
	this.getElementByRange= function(X,Y,Range)
	{
		for(var i=0;i<this.CollectionElements.length;i++)
		{
		    var Element=this.CollectionElements[i];
			if(Math.sqrt(Math.pow(this.CollectionElements[i].getX() - X, 2 ) + Math.pow( this.CollectionElements[i].getY() - Y, 2 )  ) < Range)
			{
			    return Element;
			}
		}
		return false;
	}
	

	
	
	
}  
   
 
PlanetCollection = function(JasonObject)
{

	this.CollectionElements= new Array();
	this.CollectionState=null;
	this.IdIndex=new Array();
	
	//this.Colors= new Array("#E54C00","#4169E1","##F5F5DC","##696969","#B22222","#FF00FF","#6495ED","#F8F8FF","#98FB98","#D8BFD8","#00FFFF","#FFD700","#00FF00","#AFEEEE","#FF6347","#00008B","#DAA520","#B8860B","#008000","#FF00FF","#FFDAB9","#FFFFFF","#CD853F","#800000","#ADFF2F","#A9A9A9","#006400","#F0FFF0","#66CDAA","#FFC0CB","#000000");
	this.mergeJason=function(JasonObject)
    {
        for(var i=0;i<JasonObject.CollectionElements.length;i++)
		{
            this.add(new Planet(JasonObject.CollectionElements[i].Id,JasonObject.CollectionElements[i].Name,JasonObject.CollectionElements[i].X,
            JasonObject.CollectionElements[i].Y,JasonObject.CollectionElements[i].PicturString,JasonObject.CollectionElements[i].Owner,
            JasonObject.CollectionElements[i].AllianzName,
            JasonObject.CollectionElements[i].MyPlanet,
            JasonObject.CollectionElements[i].MyAllianz,
            JasonObject.CollectionElements[i].EmptyPlanet
            ));
        }
	    this.CollectionState=JasonObject.CollectionState;
	    this.IdIndex=JasonObject.IdIndex;
    }
   
   	if(JasonObject)// wenn was über jason rein kommt
	{
	    this.mergeJason(JasonObject);
	}
    
	
	this.rePlacePlanet=function(Planet)
    {
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getId()==Planet.getId())
		    {
    		    this.CollectionElements[i]=null;
    		    this.CollectionElements[i]=Planet;
		    }	
		}
    }
    

    
    this.deSelect=function()
    {
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    this.CollectionElements[i].deSelect();
		}
    }
    
     this.setShowIdentificationMark=function(IdentificationMark)
     {
        for(var i=0;i<this.CollectionElements.length;i++)
		{
		    this.CollectionElements[i].setShowIdentificationMark(IdentificationMark);
		}
        
     }
     
    this.renderArea= function()
    {
        for(var i=0;i<this.CollectionElements.length;i++)
		{
				this.CollectionElements[i].renderArea();
		}
    }
    
    this.getByAllianzName= function(AllianzName)
    {
        var TempCollection= new PlanetCollection();
        for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getAllianzName()==AllianzName)
		    {
		        TempCollection.add(this.CollectionElements[i]);
		    }	
		}
		return TempCollection;
    } 
    
    this.getAllianzNameArray= function()
    {
        var NameArray= new Array();
        for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(!NameArray.isIn(this.CollectionElements[i].getAllianzName()) && this.CollectionElements[i].getAllianzName()!="")
		    {
		        NameArray.push(this.CollectionElements[i].getAllianzName());
		    }	
		}
		return NameArray;
    } 
    
    
    
    
    this.getMapLayer= function()
    {
        var TempMapLayer= new MapLayer();
        var TempMapLayerCollection= new MapLayerCollection();
        var AllianzArray=this.getAllianzNameArray();
        
        for(var i=0;i<AllianzArray.length;i++)
		{
            var MyMapLayer= new MapLayer();
            MyMapLayer.setPlanectCollection(this.getByAllianzName(AllianzArray[i]));
            MyMapLayer.setLayerColor(this.Colors[i]);
            if(this.getByAllianzName(AllianzArray[i]).getByIndex(0).isMyAllianz())
            {
                MyMapLayer.setMyAllianz(true);
            }
            TempMapLayerCollection.add(MyMapLayer);
        }
        
        return TempMapLayerCollection;
    }
    
    
    
}  


   
PlanetCollection.prototype = new Collection(); 
 
 Planet= function(Id,Name,X,Y,PicturString,Owner,AllianzName,MyPlanet, MyAllianz,EmptyPlanet,UserPictureString)
 {
      this.Id=Id;
      this.Name = Name;
      this.Owner=Owner;
      this.setKoorddinates(X,Y);
      this.PicturString = PicturString;
      this.Width=50; // die weite einer Planeten hälfte
      this.MapLeft=0;
      this.MapTop=0;
      this.AllianzName=AllianzName;
      this.MyPlanet=MyPlanet;
      this.MyAllianz=MyAllianz;
      this.EmptyPlanet=EmptyPlanet;
      this.ShowIdentificationMark=true;
      this.BigPicture=getPicturLoader().getPic("./images/planets/"+this.PicturString);
      this.SmallPicture=getPicturLoader().getPic("./images/Map/ObjectsSmall/"+this.PicturString); 
      this.ObjectType="Planet";
      this.UserPictureString=UserPictureString;
       
     this.getUserPictureString=function()
     {
        return this.UserPictureString;
     } 
       
        
     this.setShowIdentificationMark=function(IdentificationMark)
     {
         this.ShowIdentificationMark=IdentificationMark;
     }
 
       this.isMyAllianz=function()
     {
        return this.MyAllianz;
     }
 
      this.getAllianzName=function()
     {
        return this.AllianzName;
     }
 
     this.getId=function()
     {
        return this.Id;
     }
     
   this.setZoom= function(Zoom)
   {
       this.Width=150-Zoom*10;
        this.Zoom=Zoom;
   } 
     
     
     this.renderBorder=function()
     {
            if(this.Zoom<15)
            {
                      this.MyMap.lineWidth = 1;
                     this.MyMap.strokeStyle = "#FFFFFF";
                    this.MyMap.strokeRect(this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2),this.Width,this.Width);
              
            }
     }
    
    this.render= function()
    {
        this.calculateMapPosition();
        if(!this.IsShow ){return false;}
        if(this.isOnMap())// wenn auf der karte angezeigt dann mal das ding
        {
        var Temp=0;

        if(this.Zoom<9)
        {
            MyImage = this.BigPicture;
        }else
        {
            MyImage = this.SmallPicture;
        }
        if(MyImage.complete)
        {
            this.MyMap.drawImage(MyImage,  this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2),this.Width,this.Width);
        } 
        if(this.IsSelected && this.isOnMap())
        {
            this.renderBorder();
        }

        if(!this.ShowIdentificationMark)
        {
            return true;
        }
            if(this.MyAllianz && !this.MyPlanet)
            {
            var BlueLayer= getPicturLoader().getPic("./images/Map/ObjectsSmall/BlueLayer.png");
                if(BlueLayer.complete)
                {
                    this.MyMap.drawImage(BlueLayer,this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2),this.Width,this.Width);
                }
                return true;
            }
            
            if(this.MyPlanet)
            {
            var BlueLayer= getPicturLoader().getPic("./images/Map/ObjectsSmall/GreenLayer.png");
                if(BlueLayer.complete)
                {
                    this.MyMap.drawImage(BlueLayer,this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2),this.Width,this.Width);
                }
                return true;
            }
            
            if(this.EmptyPlanet)
            {
            var WhiteLayer= getPicturLoader().getPic("./images/Map/ObjectsSmall/WhiteLayer.png");
                if(WhiteLayer.complete)
                {
                this.MyMap.drawImage(WhiteLayer,this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2),this.Width,this.Width);
                }
                return true;
            }
            if(!this.MyPlanet)
            {
                var RedLayer= getPicturLoader().getPic("./images/Map/ObjectsSmall/RedLayer.png");
                if(RedLayer.complete)
                {
                    this.MyMap.drawImage(RedLayer,this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2),this.Width,this.Width);
                }
            } 
        }


        return true;
       }
    
    this.Type=function()
     {
        return this.Type;
     }
    
    
    this.drawEllipse=function(Color)
	{
      // Radius des Kreises
      var intRadius = 50;
      this.MyMap.beginPath();
      this.MyMap.moveTo(parseInt(this.Width/2) + intRadius, 15 + intRadius);
      //objContext.arc(35, 40, 25, 0, 2*Math.PI, true);
      this.MyMap.arc(this.MapLeft, this.MapTop, intRadius, 0, 2*Math.PI, true);
      this.MyMap.fillStyle = Color;
      this.MyMap.fill();
    }
    
    
    this.hide= function()
    {
        if(!document.getElementById("Planet"+this.Id)){return false;}
        document.getElementById("Planet"+this.Id).style.display="none";
        return true;
    }
      
    this.getPicturString= function()
    {
        return this.PicturString;
    }
    
     this.isOnMap=function()
     {
        var TempX=((this.X-this.KorrectionX)-this.Width)/this.Zoom;
        var TempY=((this.Y-this.KorrectionY)-this.Width)/this.Zoom;
    var MyMap=getMap(0,0);
    if(TempX <-200){return false;}
    if(TempX>MyMap.getWidth()+200){return false;}
    if(TempY<-200){return false;}
    if(TempY>MyMap.getHeight()+200){return false;}
        return true;
     }   
    
    
    this.getDescription= function()
    {
        var TempSting="<table border='0' id='PlanetDescription"+this.Id+"' >";
        TempSting+=" <tr><td>Planet: </td><td width='500' >"+this.Name+" </td>";
        TempSting+="<td rowspan='6' > <img height='200' width='200' src='./images/"+this.PicturString+"' title='"+this.Name+"' ondblclick='getMap().showMapOnKoordianteXY("+this.X+","+this.Y+")' /> </td>";
        TempSting+="</tr><tr><td>Besitzer: </td><td>"+this.Owner+" <a href='index.php?Section=Messages&PlayerName="+this.Owner+"'><img height='15' width='25' src='./images/Msg.jpg' title='Nachricht schicken' /></a></td></tr><tr><td>Koord: </td><td>"+this.X+" : "+this.Y+" </td>";
        TempSting+="</tr>";
        TempSting+="<tr><td>Allianz</td><td><a href='index.php?Section=Allianz&Action=ShowForeignAllianz&s_Name="+this.AllianzName+"'>"+this.AllianzName+"</a></td></tr>";
        TempSting+="<tr><td colspan='2' ><input type='button' colspan='2' name='' onclick='getMap().showMapOnKoordianteXY("+this.X+","+this.Y+")' value='Zentrieren'></td></tr>";
        if(getMap().getUserName()==this.Owner)
        {
            TempSting+="<tr><td colspan='2' ><a href='index.php?Section=ChangeActivePlanet&amp;D=Map&amp;cb_Planet="+this.Id+"'>Planeten Auswählen</a></td></tr>";
        }
       TempSting+=" </table>";// beschreibung machen
       return TempSting;
    } 
    
    this.renderforCollection= function()
    {
        var TempString="";
        TempString+="<table class='DataTable' style='width:100%;' ><tr>";
        TempString+="<td style='text-align: center;width:49px;'><img title='"+this.Name+" "+this.X+":"+this.Y+"' onmouseover='this.style.cursor = \"pointer\"' ondblclick='getMap().showMapOnKoordianteXY("+this.X+","+this.Y+")' onclick='getMap().selectPlanet("+this.Id+")' id='CollectionDivPlanet"+this.Id+"' width='49px' height='49px' src='./images/planets/"+this.PicturString+"'  /></td>";// planet machen
        TempString+="<td style='text-align: center;' onmouseover='this.style.cursor = \"pointer\"' ondblclick='getMap().showMapOnKoordianteXY("+this.X+","+this.Y+")' onclick='getMap().selectPlanet("+this.Id+")'>"+this.Name+"</td>";
        TempString+="</tr></table>";
        return TempString;
    }
 
 
    this.renderforList= function()
    {
        var TempString="";
        TempString+="<table class='DataTable' style='width:100%;' ><tr>";
        TempString+="<td style='text-align: center;width:49px;'><img title='"+this.Name+" "+this.X+":"+this.Y+"' onmouseover='this.style.cursor = \"pointer\"' ondblclick='getMap().showMapOnKoordianteXY("+this.X+","+this.Y+")' onclick='getMap().selectPlanet("+this.Id+")' id='CollectionDivPlanet"+this.Id+"' width='49px' height='49px' src='./images/planets/"+this.PicturString+"'  /></td>";// planet machen
        TempString+="<td style='text-align: center;' onmouseover='this.style.cursor = \"pointer\"' ondblclick='getMap().showMapOnKoordianteXY("+this.X+","+this.Y+")' onclick='getMap().selectPlanet("+this.Id+")'>"+this.Name+"</td>";
        TempString+="</tr></table>";
        return TempString;
    }
 
    this.select= function()
    {
        this.setIsSelected(true);
        /*var ElementArray= document.getElementById("UserUnitContainer").getElementsByTagName("img");
        if(document.getElementById("CollectionDivPlanet"+this.Id))
        {
              document.getElementById("CollectionDivPlanet"+this.Id).style.border="solid white 1px";
         }*/
    }
 
    this.deSelect= function()
    {
        if(this.IsSelected)
        {
            this.setIsSelected(false);
            var ElementArray= document.getElementById("UserUnitContainer").getElementsByTagName("img");
            if(document.getElementById("CollectionDivPlanet"+this.Id))
            {
                  document.getElementById("CollectionDivPlanet"+this.Id).style.border="solid white 0px";
            } 
         }   
    }
    
 }
 
 
 
 Planet.prototype = new RenderObject();
 

 
 
    
    
Unit = function(Id,Name,Units, Damage, Amor,  Speed,Healts, UserId,ExtentionOne,ExtentionTwo,X,Y,State,Storage,Stored,Exp,Level,IsMyUnit,UserName,IsAllianzUnit,Picture,AllianzName,UserPictureString) 
    {
        this.Id=Id;
        this.Name = Name;
        this.Units = Units;
        this.Damage = Damage;
        this.Amor = Amor;
        this.Speed = Speed;
        this.Healts = Healts;
        this.UserId = UserId; 
        this.ExtentionOne = ExtentionOne;
        this.ExtentionTwo = ExtentionTwo;
        this.setKoorddinates(X,Y);
        this.State = State;
        this.Storage = Storage;
        this.Stored = Stored;
        this.Exp = Exp;
        this.Level = Level;
        this.IsMyUnit=IsMyUnit;
        this.Width=25; 
        this.UserName=UserName|| "";
        this.IsAllianzUnit=IsAllianzUnit|| false;
        this.Picture=Picture;
        this.AllianzName=AllianzName;
        this.Owner=UserName|| "";
        this.MyPicture=null;
        this.ObjectType="Unit";
        this.UserPictureString=UserPictureString;
 
 this.getUserPictureString=function()
     {
        return this.UserPictureString;
     } 
 
 
this.Type=function()
     {
        return this.Type;
     }

    this.setPicture= function()
    {
         if(!this.IsMyUnit && this.IsAllianzUnit)
        {
        
            this.Picture="./images/units/"+this.Picture+"_A.png";
            return true;
        }
        
         if(this.IsMyUnit)
            {
                this.Picture="./images/units/"+this.Picture+"_F.png";
            }else
            {
                this.Picture="./images/units/"+this.Picture+"_E.png";
            }
    }

    this.setPicture();
    

   this.setWidth= function(Width)
    {
       this.Width=Width;
    }

     this.getIsMyUnit=function()
     {
        return this.IsMyUnit;
     }

     this.getIsAllianzUnit=function()
     {
        return this.IsAllianzUnit;
     }

     this.getId=function()
     {
        return this.Id;
     }

    this.hide= function()
    {
        this.setIsSelected(false);
    }

    this.getState= function()
    {
    return this.State*100 +"%";
    }

    this.renderforCollection= function()
    {
         if(!this.State){return "";}
        var TempString="";
        TempString+="<table class='DataTable' style='width:100%;'><tr>";
        TempString+="<td style='text-align: center;width:49px;'><img title='"+this.Name+" "+this.X+":"+this.Y+"' onmouseover='this.style.cursor = \"pointer\"' ondblclick='getMap().showMapOnKoordianteXY("+this.X+","+this.Y+")' onclick='getMap().selectUnit("+this.Id+")' id='CollectionDivUnit"+this.Id+"' width='49px' height='49px' src='"+this.Picture+"'  /></td>";// planet machen
        TempString+="<td style='text-align: center;' onmouseover='this.style.cursor = \"pointer\"' ondblclick='getMap().showMapOnKoordianteXY("+this.X+","+this.Y+")' onclick='getMap().selectUnit("+this.Id+")'>"+this.Name+"</td>";
        TempString+="</tr></table>";
        return TempString;
    }


    this.renderforList= function()
    {
        if(!this.State){return "";}
        var TempString="";
        TempString+="<table class='DataTable' style='width:100%;'><tr>";
        TempString+="<td style='width:49px;'>";
        TempString+="<img title='"+this.Name+" "+this.X+":"+this.Y+"' onmouseover='this.style.cursor = \"pointer\"' ondblclick='getMap().showMapOnKoordianteXY("+this.X+","+this.Y+")' onclick='getMap().selectUnit("+this.Id+")' id='CollectionDivUnit"+this.Id+"' width='49px' height='49px' src='"+this.Picture+"'  /></td>";// planet machen
        TempString+="<td style='text-align: center;width:300px;' onmouseover='this.style.cursor = \"pointer\"' ondblclick='getMap().showMapOnKoordianteXY("+this.X+","+this.Y+")' onclick='getMap().selectUnit("+this.Id+")'>"+this.Name+"</td>";
        TempString+="<td style='text-align: center;width:35px;' onclick='getMap().selectUnit("+this.Id+")'>"+this.getStateInPercent()+"</td>";
        if(getMap(0,0).getTaskByUnitId(this.Id).getId())
        {
        var Task=getMap(0,0).getTaskByUnitId(this.Id);
            TempString+="<td style='text-align: center;width:32px;' onclick='getMap().selectUnit("+this.Id+")'><img title='"+this.Name+" "+Task.getX()+":"+Task.getY()+"' src='./images/design/icons/tomapwithTask.png' /></td>";
        }else
        {
            TempString+="<td style='text-align: center;width:32px;' onclick='getMap().selectUnit("+this.Id+")'></td>";
        }
        TempString+="</tr></table>";
        return TempString;
    }

    this.select= function()
    {
        this.setIsSelected(true);
        var Task= getMap().getTaskByUnitId(this.Id);
        if(!Task || !this.IsMyUnit){return false;}
        Task.show();
    }
 
    this.deSelect= function()
    {
        var ElementArray= document.getElementById("UserUnitContainer").getElementsByTagName("img");
        this.setIsSelected(false);
        for(var i=0;i<ElementArray.length;i++)
        {
            if(ElementArray[i].id=="CollectionDivUnit"+this.Id)
            { 
                    ElementArray[i].style.border="solid white 0px";
            }
       } 

        var Task= getMap().getTaskByUnitId(this.Id);
        if(!Task){return false;}
        Task.hide();
    }

    this.getTimeToTaskArrived= function()
    {
    }
      
    this.render= function()
    {
        if(!this.IsShow ){return false;}
        if(this.State<=0){return false;}
        this.calculateMapPosition();
        if(this.isOnMap())// wenn auf der karte angezeigt dann mal das ding
        {
            if(this.IsSelected)
            {
                // rahmen zeichen
                this.MyMap.strokeStyle = "#ffffff";
                this.MyMap.lineWidth = 1;
                this.MyMap.beginPath();
                this.MyMap.arc(this.MapLeft-(this.Width/2)+12.5,this.MapTop-(this.Width/2)+12.5,13,Math.PI*2,0,false);
                this.MyMap.stroke();         
            }
            var Temp=0;
            //var MyImage = getPicturLoader().getPic(this.Picture);
           // MyImage.src = ;
            if(!this.MyPicture)
            {
                this.MyPicture = getPicturLoader().getPic(this.Picture);
            }
            if(this.MyPicture.complete)
            {
               this.MyMap.save();
               this.MyMap.translate(this.MapLeft-(this.Width/2)+12.5,this.MapTop-(this.Width/2)+12.5);
               var Angle=this.getAngle();
               this.MyMap.rotate(Angle);
               this.MyMap.drawImage(this.MyPicture,  -12.5,-12.5,this.Width,this.Width);
               this.MyMap.restore();
               
               // healt zeichen
               //this.MyMap.lineWidth = 1;
               //this.MyMap.strokeStyle = "#00E533";
               
                //weite berechnen
               // 100%
                var Health= this.Width*this.State;
               this.MyMap.fillStyle = "#00E533";
               this.MyMap.fillRect(this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2)-5,Health,2);
               this.MyMap.fillStyle = "#00E533";
            }
        }
        return true;
    }
   
   // gibt den winkel in rad zurück
   this.getAngle= function()
   {
        //5*Math.PI/16
        var Angel=0;
        var Task= getMap().getTaskByUnitId(this.Id);
        if (Task.getId()==0){return 0}
        
        var A=Task.getX()-this.getX();
        var B=Task.getY()-this.getY();
        
        if(Task.getY()>this.getY())
        {
            return Math.atan(A/B)*-1+Math.PI;
        }
        
        if(Task.getX()>this.getX() && Task.getY()>this.getY() )
        {
            return Math.atan(A/B)*-1+Math.PI;
        }
        if(A ==0|| B==0){return 0;}
        return Math.atan(A/B)*-1;
   }
    
    
    this.getElementByKoordinate= function(X,Width,Y,Height)
	{
		for(var i=0;i<this.CollectionElements.length;i++)
		{
		    Element=this.CollectionElements[i];
			if(Element.getX()>X && Element.getX()<X+Width && Element.getY()>Y && Element.getY()<Y+Width)
			{
			    return Element;
			}
		}
		return new Unit(0,"","", 0,0,0,0,0,0,0,0,0,0,0,0,0,0,false,"",0,"","");
	}
    

    
    
    
    this.getDescription= function()
    {
        return "";
    }
    
    this.getFlightTime=function()
    {
        var Task= getMap().getTaskByUnitId(this.Id);
        if(Task.getUnitId()==0)
        {
            return "";
        }
        var Distance=Math.sqrt(Math.pow(this.X-Task.getX(),2)+Math.pow(this.Y-Task.getY(),2));
        var Now= new Date();
        var FlightTime=Distance/(this.Speed/60/60);
        var ArriveTime=new Date(Now.getTime()+(FlightTime*1000));
        
        var ArrivedTimeString="";
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
        
        if(!document.getElementById("i_FlightTimeId")){return false;}
        document.getElementById("i_FlightTimeId").innerHTML=ArrivedTimeString;
        return true;
    }



    this.getExtensionForDescription=function()
    {
        var  TempString="";
        if(this.ExtentionOne==10)
        {
            TempString+="<tr>";
                    TempString+="<td colspan='2'><input type='button' id='btn_ScannButton"+this.Id+"' name='' onmouseover='getMap().showScannerLayer()' onmouseout='getMap().hideLayer()' onclick='getMap().scanArea("+this.Id+")' value='Scannen'> </td>";
                    TempString+="</tr>";
                    TempString+="<tr>";
                    TempString+="<td></td>";
                    TempString+=" <td></td>";
                    TempString+="</tr>";
        }
        if(this.ExtentionOne==20)
        {
            TempString+="<tr>";
                    TempString+="<td colspan='2'><input type='button' id='btn_RaidButton"+this.Id+"' name='' onmouseover='getMap().showRaidLayer()' onmouseout='getMap().hideLayer()' onclick='getMap().raidPlanet("+this.Id+")' value='Überfallen'> </td>";;
                    TempString+="</tr>";
                    TempString+="<tr>";
                    TempString+="<td> </td>";
                    TempString+=" <td></td>";
                    TempString+="</tr>";
        }
        return TempString;
    }
    this.getStorage = function() 
    {
         return this.Storage;
    }


   this.getStoredElement= function(ElementString,Mode)
   {
	    var TempArray=this.Stored.split(";");
		for(var i=0;i<TempArray.length;i++)
		{
			if(TempArray[i].match(ElementString))
			   {
					Temp2=TempArray[i].split(":");
					if(Mode)
					{
						return parseInt( Temp2[1]);
					}else
					{
						return Temp2[1];
					}
				}
		}
		return 0;
	}


    this.getStored = function() 
    {
         return this.Stored;
    }

    this.getExp = function() 
    {
         return this.Exp;
    }

    this.getLevel = function() 
    {
         return this.Level;
    }


    this.getName = function() 
    {
         return this.Name;
    }

    this.getStateInPercent = function() 
    {
        return Math.round(this.State *100) +"%";
    }


    this.getState = function() 
    {
        return this.State;
    }

    this.getDamage = function() 
    {
        return this.Damage;
    }

    this.getAmor = function() 
    {
        return this.Amor;
    }

    this.getSpeed = function()
    {
        return this.Speed;
    }

        this.getHealts = function() 
        {
            return this.Healts;
        }

        this.getExtentionTwo = function() 
        {
            return this.ExtentionTwo;
        }

         this.getExtentionOne = function() 
        {
         return this.ExtentionOne;
        }

        this.getUnits = function() 
        {
            return this.Units;
        }
}
Unit.prototype = new RenderObject();

DeathStar = function(Id,Name,Units, Damage, Amor,  Speed,Healts, UserId,ExtentionOne,ExtentionTwo,X,Y,State,Storage,Stored,Exp,Level,IsMyUnit,UserName,IsAllianzUnit,Picture,AllianzName,UserPictureString) 
    {
        this.Id=Id;
        this.Name = Name;
        this.Units = Units;
        this.Damage = Damage;
        this.Amor = Amor;
        this.Speed = Speed;
        this.Healts = Healts;
        this.UserId = UserId; 
        this.ExtentionOne = ExtentionOne;
        this.ExtentionTwo = ExtentionTwo;
        this.setKoorddinates(X,Y);
        this.State = State;
        this.Storage = Storage;
        this.Stored = Stored;
        this.Exp = Exp;
        this.Level = Level;
        this.IsMyUnit=IsMyUnit;
        this.Width=50;
        this.UserName=UserName|| "";
        this.IsAllianzUnit=IsAllianzUnit|| false;
        this.Picture=Picture;
        this.AllianzName=AllianzName;
        this.Owner=UserName|| "";
        this.ObjectType="DeathStar";
        this.UserPictureString=UserPictureString;
        
    this.setPicture();
    

    this.render= function()
    {
        if(!this.IsShow ){return false;}
        if(this.State<=0){return false;}
        this.calculateMapPosition();
        if(this.isOnMap())// wenn auf der karte angezeigt dann mal das ding
        {
            if(this.IsSelected)
            {
                // rahmen zeichen
                this.MyMap.strokeStyle = "#ffffff";
                this.MyMap.lineWidth = 1;
                this.MyMap.beginPath();
                this.MyMap.arc(this.MapLeft-(this.Width/2)+25,this.MapTop-(this.Width/2)+25,27,Math.PI*2,0,false);
                this.MyMap.stroke();         
            }
            var Temp=0;
            var MyImage = getPicturLoader().getPic(this.Picture);
            if(MyImage.complete)
            {
               this.MyMap.drawImage(MyImage,  this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2),this.Width,this.Width);
               
               
               var Health= this.Width*this.State;
               this.MyMap.fillStyle = "#00E533";
               this.MyMap.fillRect(this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2)-5,Health,2);
               this.MyMap.fillStyle = "#00E533";
               
            }
        }
        return true;
    }

}
DeathStar.prototype = new Unit();

UnitCollection = function()
{
    this.CollectionElements= new Array();
	this.CollectionState=null;
	this.IdIndex=new Array();
	
    this.getAreMyUnit=function()
    {
        for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(!this.CollectionElements[i].getIsMyUnit())
		    {
    		    return false;
		    }	
		}
		return true;
    }

	this.rePlaceUnit=function(Unit)
    {
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getId()==Unit.getId())
		    {
    		    this.CollectionElements[i]=null;
    		    this.CollectionElements[i]=Unit;
		    }	
		}
    }
    
    this.deSelect=function()
    {
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    this.CollectionElements[i].deSelect();
		}
    }
    
    this.select=function()
    {
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    this.CollectionElements[i].select();
		}
    }

}
UnitCollection.prototype = new Collection();  



Task= function(Id,Action,X,Y,UnitId)
{
    this.Id=Id;
    this.Action=Action;
    this.X=X;
    this.Y=Y;
    this.UnitId=UnitId;
    this.Width=5; // die weite des bildes für den task /2
    this.Height=20; // die höhe des bildes für den task
    this.IsShow=false;
this.ObjectType="Task";
    this.getId= function()
    {
        return this.Id;
    }
    
    this.getAction= function()
    {
        return this.Action;
    }

    this.getX= function()
    {
        return this.X;
    }

    this.getY= function()
    {
        return this.Y;
    }

    this.getUnitId= function()
    {
        return this.UnitId;
    }

    this.show=function()
    {
        this.IsShow=true;
    }
    
    this.hide=function()
    {
        this.IsShow=false;
    }

    this.render= function()
    {
        this.calculateMapPosition();
        if(!this.IsShow ){return false;}
        if(!this.isOnMap() ){return false;}
        var MyImage = getPicturLoader().getPic('./images/Goal.png');
            if(MyImage.complete)
            {
               this.MyMap.drawImage(MyImage,  this.MapLeft-this.Width,this.MapTop-this.Height);
            }
       // UnitContainer.innerHTML+="<img width='10px' height='20px' src= id='Goal"+this.Id+"' style='display:none;position:absolute;left:"+this.MapLeft+"px;top:"+this.MapTop+"px;z-index:21;)' > ";// ziel setzen wenn vorhanden
        
        return true;
    }


}
Task.prototype = new RenderObject();


TaskCollection = function()
{

    this.deleteByUnitId=function(UserId)
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
    
    this.getByUnitId=function(UserId)
    {
        var TempArray= new Array();
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getUnitId()==UserId)
		    {
    		    return this.CollectionElements[i];
		    }	
		}
		return new Task(0,"",0,0,0);
    }



}
TaskCollection.prototype = new Collection(); 


BuildingCollection = function()
{

}     
BuildingCollection.prototype = new Collection(); 
 
 Building= function(Id,Name,Description)
 {
      this.Id=Id;
       this.Name=Name;
      this.Description = Description;
      this.ObjectType="Building";
     this.getId=function()
     {
        return this.Id;
     }
       this.getDescription=function()
     {
        return this.Description;
     }
     
        this.getName=function()
     {
        return this.Name;
     }
       
 }
 
 Building.prototype = new RenderObject();
 
 
 ReSearchCollection = function()
{

}     
ReSearchCollection.prototype = new Collection(); 
 
 ReSearch= function(Id,Name,Description)
 {
     this.Id=Id;
     this.Name=Name;
     this.Description = Description;
     this.ObjectType="ReSearch";
     this.getId=function()
     {
        return this.Id;
     }
      this.getName=function()
     {
        return this.Name;
     }
     this.getDescription=function()
     {
        return this.Description;
     }  
 }
 
 ReSearch.prototype = new RenderObject();
 
 
 MyImage= function(Id,StartX,StartY,Picture)
{
    this.Id=Id;
    this.StartX=StartX;
    this.StartY=StartY;
    this.Picture=Picture;
    this.ObjectType="MyImage";
    
    this.setStart = function(StartX,StartY)
    {
        this.StartX=StartX;
        this.StartY=StartY;
    }
    
    this.update = function()
    {  
        if(!document.getElementById(this.Id)){return false;}
        document.getElementById(this.Id).style.backgroundImage="url(index.php?Section=Map&Action=GetPic&X="+this.StartX+"&Y="+this.StartY+")";
    }
    
    this.getPicture = function()
    {
        return this.Picture;
    }
    
    this.render= function()
    {
        this.calculateMapPosition();
        var Temp=0;
        var MyImage = new Image();
        MyImage.src = "./images/Map/"+this.PicturString;
        if(MyImage.complete)
        {
           this.MyMap.drawImage(MyImage,  this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2),this.Width,this.Width);
        } 

        return true;
    }
    
    
}
 MyImage.prototype = new RenderObject();
 
 
 MapObject= function(Id,X,Y,Width,Height,PictureString)
{
    this.Id=Id;
    this.X=X;
    this.Y=Y;
    this.Width=Width/2;
    this.Height=Height/2; // die höhe des bildes für den task
    this.IsShow=true;
    this.PictureString=PictureString
    this.Type=0;
    this.ObjectType="MapObject";

    this.getId= function()
    {
        return this.Id;
    }
    

    
    this.getType= function()
    {
        return this.Type;
    }
    
    this.getAction= function()
    {
        return this.Action;
    }

    this.getX= function()
    {
        return this.X;
    }

    this.getY= function()
    {
        return this.Y;
    }

    this.show=function()
    {
        this.IsShow=true;
    }
    
    this.hide=function()
    {
        this.IsShow=false;
    }

    this.render= function()
    {
        this.calculateMapPosition();
        if(!this.IsShow ){return false;}
        if(!this.isOnMap() ){return false;}
        if(!this.MyMap ){return false;}
        var MyImage = getPicturLoader().getPic('./images/Map/'+this.PictureString);
        if(MyImage.complete)
        {
            this.MyMap.drawImage(MyImage,  this.MapLeft-(this.Width/2),this.MapTop-(this.Height/2),this.Height,this.Width);
        }
        return true;
    }
}
MapObject.prototype = new RenderObject();

Astroid= function(Id,X,Y,Width,Height,PictureString)
{
    this.Id=Id;
    this.X=X;
    this.Y=Y;
    this.Width=Width/2;
    this.Height=Height/2; // die höhe des bildes für den task
    this.IsShow=false;
    this.PictureString=PictureString;
    this.IsAstroid=true;
    this.Type=2;
    this.ObjectType="Astroid";
}
Astroid.prototype = new MapObject();

Wast= function(Id,X,Y,Width,Height,PictureString)
{
    this.Id=Id;
    this.X=X;
    this.Y=Y;
    this.Width=Width/2;
    this.Height=Height/2; // die höhe des bildes für den task
    this.IsShow=false;
    this.PictureString=PictureString;
    this.IsAstroid=true;
    this.Type=1;
    this.ObjectType="Wast";
    this.IsAstroid=function()
    {
        return true;
    }
    
}
Wast.prototype = new MapObject();


MapObjectCollection = function()
{

	/*this.mergeJason=function(JasonObject)
    {
        if(!JasonObject.CollectionElements){return;}
        for(var i=0;i<JasonObject.CollectionElements.length;i++)
		{
		
		    switch(JasonObject.CollectionElements[i].ObjectType)
		    {
		        case"Sun":
		        {
    		    this.add(new Sun(JasonObject.CollectionElements[i].Id,
    		    JasonObject.CollectionElements[i].X,
    		    JasonObject.CollectionElements[i].Y,
    		    JasonObject.CollectionElements[i].Width,
    		    JasonObject.CollectionElements[i].Height,
    		    JasonObject.CollectionElements[i].PictureString,
    		    JasonObject.CollectionElements[i].Name));
		        }break;
		    }
        }
	    //this.CollectionState=JasonObject.CollectionState;
	    //this.IdIndex=JasonObject.IdIndex;
    }
   
   	if(JasonObject)// wenn was über jason rein kommt
	{
	    this.mergeJason(JasonObject);
	}*/



    this.deleteByUnitId=function(UserId)
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
    
    this.add = function (Element)
	{
	    if(!this.IdIndex[Element.getId()])
		{
		    this.CollectionElements.push(Element);
		    this.IdIndex[Element.getId()]=this.CollectionElements.length-1;
		}
		return true;
	}
    
    
    this.showByType=function(Type)
    {
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getType(Type))
		    {
		        this.CollectionElements[i].show();
		    }
		}
    }
    
    this.hideByType=function(Type)
    {
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getType(Type))
		    {
		        this.CollectionElements[i].hide();
		    }
		}
    }
    
    this.show=function()
    {
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    this.CollectionElements[i].show();
		}
    }
    
    this.getByUnitId=function(UserId)
    {
        var TempArray= new Array();
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getUnitId()==UserId)
		    {
    		    return this.CollectionElements[i];
		    }	
		}
		return new MapObject(0,"",0,0,0);
    }
	this.merge= function(OtherCollection)
	{
	    var Element=null;
	    var Index=null;
		for(var i=0;i<OtherCollection.getCount();i++)
		{
		    Element=OtherCollection.getByIndex(i);
			if(!this.IdIndex[Element.getId()])
			{
			    this.add(Element);
			}
		}
	}


   this.calculateSuns=function(UserId)
    {
        var SunCollection= this.getByType("Sun");
        SunCollection=SunCollection.getOnMap();
        var MySun=null;
        for(var i=0;i<SunCollection.getCount();i++)
		{
		     MySun= this.getByIndex(i);
            MySun.setRenderInfo(true);
		}
        
	    /*for(var i=0;i<SunCollection.getCount();i++)
		{
		    MySun= this.getByIndex(i);
            var TempCollection=SunCollection.getElementCollectionByKoordinateAndRange(MySun.getX(),MySun.getY(),2500);
            if(TempCollection.getCount()>1)
            {
                for(var j=0;j<TempCollection.getCount()-1;j++)
                {
                   var MyTempSun= this.getByIndex(j);
                   //MyTempSun.setSunCollection(TempCollection);
                   MyTempSun.setRenderInfo(false);
                }
                //MyTempSun.setRenderInfo(true);
            }
		}*/
		//return SunCollection;
    }

    this.getByType=function(Type)
    {
       var MyMapObjectCollection= new MapObjectCollection();
	    for(var i=0;i<this.CollectionElements.length;i++)
		{
		    if(this.CollectionElements[i].getObjectType()==Type)
		    {
    		    MyMapObjectCollection.add(this.CollectionElements[i]);
		    }	
		}
		return MyMapObjectCollection;
    }


}
MapObjectCollection.prototype = new Collection();



Sun= function(Id,X,Y,Width,Height,PictureString,Name)
{
    this.Id=Id;
    this.X=X;
    this.Y=Y;
    this.Width=Width/2;
    this.Height=Height/2; // die höhe des bildes für den task
    this.IsShow=true;
    this.PictureString=PictureString;
    this.IsAstroid=false;
    this.Type=3;
    this.OrginalWidth=Width/2;
    this.ObjectType="Sun";
    this.Name=Name;
    this.SunCount=1;
    this.SunCollection= new SunCollection();
    this.RenderInfo=true;
    
   this.setRenderInfo= function(RenderInfo)
   {
       this.RenderInfo=RenderInfo;
   } 
    
   this.setSunCollection= function(SunCollection)
   {
       this.SunCollection=SunCollection;
       this.SunCount=this.SunCollection.getCount();
   } 
    
    this.render= function()
    {
        this.calculateMapPosition();
        if(!this.isOnMap() ){return false;}
        if(!this.MyMap ){return false;}
                var MyImage=getPicturLoader().getPic("./images/Map/"+this.PictureString);
        if(this.Zoom<26)
        {
            MyImage = getPicturLoader().getPic("./images/Map/"+this.PictureString);
        }else
        {
            MyImage = getPicturLoader().getPic("./images/Map/ObjectsSmall/"+this.PictureString);
        }
        //MyImage.src = ;
        
        
        if(this.Zoom>14 && this.RenderInfo)
        {
            this.renderInfo();
        }
        
        if(MyImage.complete)
        {
           
            this.MyMap.drawImage(MyImage,  this.MapLeft-(this.Width/2),this.MapTop-(this.Width/2),this.Width,this.Width); 
            return;
            
            //this.MyMap.drawImage(MyImage,  this.MapLeft-(this.Width/(this.Zoom/2)),this.MapTop-(this.Width/(this.Zoom/2)),this.Width*this.Zoom,this.Width*this.Zoom); 
        }
        

        
        return true;
    }
    
   this.setZoom= function(Zoom)
   {
       this.Width=this.OrginalWidth-Zoom*10;
        this.Zoom=Zoom;
   } 
    
    
   this.renderInfo= function()
   {
        this.MyMap.beginPath();

        this.MyMap.fillStyle = "rgba(65, 0, 0, 0.7)";
        this.MyMap.strokeStyle = "#00000";

        this.MyMap.rect(this.MapLeft+(60-this.Zoom*2), this.MapTop-100, 80+this.Name.length*7.5, 40);
        this.MyMap.fill();
        
        this.drawLine(this.MapLeft,this.MapTop, this.MapLeft+(60-this.Zoom), this.MapTop-60, "#ffffff");  
        
        
        
        
        this.drawText(this.MapLeft+35, this.MapTop-80,  "#ffffff", this.Name , 20 ,"sans-serif","Center");
        
   } 
    
     this.isOnMap=function()
     {
        var TempX=((this.X-this.KorrectionX)-this.Width)/this.Zoom;
        var TempY=((this.Y-this.KorrectionY)-this.Width)/this.Zoom;
        var MyMap=getMap(0,0);
        if(TempX <-400){return false;}
        if(TempX>MyMap.getWidth()+400){return false;}
        if(TempY<-400){return false;}
        if(TempY>MyMap.getHeight()+400){return false;}
        return true;
     }   
    
    this.getName= function()
    {
        return this.Name;
    }
}
Sun.prototype = new MapObject();

SunCollection = function()
{

   
    this.calculateSystems=function()
    {
    
    }
    
   


}
SunCollection.prototype = new Collection();