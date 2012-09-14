// benötigt Units.js
MapLayer= function()
{
    this.PlanetCollection=new PlanetCollection();
    this.LayerColor="#a00";
    this.MyAllianz=false;
    this.PointCollection= new PointCollection();
    
    this.renderTemp= function()
    {
        this.MyMap.beginPath();
        this.MyMap.moveTo(5, 5);
        this.MyMap.lineTo(300, 300);
        this.MyMap.lineTo(500, 500);
        this.MyMap.fillStyle = "#ffffff";
        this.MyMap.fillStyle = this.LayerColor;
        this.MyMap.fill();
        this.MyMap.stroke();
        
        
          /*  this.drawLine(this.MyMap, 20, 100, 70, 100, "#ff0");
         this.drawLine(this.MyMap, 70, 100, 20, 50, "#FF9F00");
        this.drawLine(this.MyMap, 20, 50, 70, 50, "#f00");
        this.drawLine(this.MyMap, 70, 50, 45, 25, "#f0f");
        this.drawLine(this.MyMap, 45, 25, 20, 50, "#00f");
        //this.drawLine(this.MyMap, 20, 50, 20, 100, "#0f0");
        //this.drawLine(this.MyMap, 20, 100, 70, 50, "#009F00");
        this.drawLine(this.MyMap, 70, 50, 70, 100, "#7F7F7F");*/
        
    }
    
 
    
    this.render= function()
    {
        this.calculate();

        //this.renderTemp();
        
        this.MyMap.beginPath();
        // Startposition festlegen
        var Point=this.PointCollection.getByIndex(0);
        if(!Point.getX()|| !Point.getY()){return false;}
        this.MyMap.moveTo(Point.getMapLeft(), Point.getMapTop());// der erste punk 
        // Trapez beschreiben
        this.MyMap.closePath();
        this.MyMap.beginPath();
        this.drawLine( 20, 100, 70, 100, "#ff0");
         this.drawLine( 70, 100, 20, 50, "#FF9F00");
        this.drawLine( 20, 50, 70, 50, "#f00");
        this.drawLine(70, 50, 45, 25, "#f0f");
        this.drawLine(45, 25, 20, 50, "#00f");
        //this.drawLine(this.MyMap, 20, 50, 20, 100, "#0f0");
        //this.drawLine(this.MyMap, 20, 100, 70, 50, "#009F00");
        this.drawLine( 70, 50, 70, 100, "#7F7F7F");
        this.MyMap.closePath();
        
        for(var i=1;i<this.PointCollection.getCount();i++)
        {
            this.drawLine( 70, 50, 70, 100, "#7F7F7F");
            Point=this.PointCollection.getByIndex(i);
            Point.calculateMapPosition();
            if(Point.getObjectType()=="Point")
            {
                this.MyMap.lineTo(parseInt(Point.getMapLeft()), parseInt(Point.getMapTop()));
            }
        }

        
        if(this.MyAllianz)
        {
            this.MyMap.fillStyle = "#189CDF";
        }else
        {
            this.MyMap.fillStyle = this.LayerColor;
        }
        this.MyMap.strokeStyle = "#7F7F7F";
        this.MyMap.fill();
        this.MyMap.stroke();
        
        
        for(var i=1;i<this.PointCollection.getCount();i++)
        {
            Point=this.PointCollection.getByIndex(i);
            Point.calculateMapPosition();
            
            if(Point.getObjectType()=="Elips")
            {
                Point.render();
            }
        }
        
        return true;
    }

    this.setMyAllianz= function(MyAllianz)
    {
        this.MyAllianz=MyAllianz;
    }

    this.setPlanectCollection= function(PlanetCollection)
    {
        this.PlanetCollection=PlanetCollection;
    }

    this.setLayerColor= function(Color)
    {
        this.LayerColor=Color;
    }


    this.calculate= function()
	{
	    for (var i=0;i<this.PlanetCollection.getCount();i++)
	    {
	        var Planet=this.PlanetCollection.getByIndex(i);
	        var TempPlanetCollection=this.PlanetCollection.getElementCollectionByKoordinateAndRange(Planet.getX(),Planet.getY(),3000);
	        
	        if(TempPlanetCollection.getCount()==1)
	        {
	            
	            var MyPoint = new Elips(TempPlanetCollection.getByIndex(0).getX(),TempPlanetCollection.getByIndex(0).getY());
	            MyPoint.setMap(this.MyMap);
	            MyPoint.setZoom(this.Zoom);
	            MyPoint.setKorrection(this.KorrectionX,this.KorrectionY);
	            MyPoint.calculateMapPosition();
	            MyPoint.setColor(this.Color);
	            this.PointCollection.add(MyPoint);
	        
	        }
	        
	        var RightElement=TempPlanetCollection.getElementonRightSide(Planet);
	        
	       if(i==0)// den ersten punkt mit nehmen
	       {
	            var MyPoint = new Point(Planet.getX(),Planet.getY());
	            MyPoint.setMap(this.MyMap);
	            MyPoint.setZoom(this.Zoom);
	            MyPoint.setKorrection(this.KorrectionX,this.KorrectionY);
	            MyPoint.calculateMapPosition();
	            this.PointCollection.add(MyPoint);
	       }
	        var MyPoint = new Point(RightElement.getX(),RightElement.getY());
	        MyPoint.setMap(this.MyMap);
	        MyPoint.setZoom(this.Zoom);
	        MyPoint.setKorrection(this.KorrectionX,this.KorrectionY);
	        MyPoint.calculateMapPosition();
	        this.PointCollection.add(MyPoint);
	        
	        
	    }
	
	}

   this.setZoom= function(Zoom)
   {
        this.Zoom=Zoom;
        this.PointCollection.setZoom(Zoom);
   } 

    this.setMap = function(MyMap) 
    {
        this.MyMap=MyMap;
         this.PointCollection.setMap(MyMap);
    }

    this.setKorrection = function(X, Y) 
    {
        this.KorrectionX = X;
        this.KorrectionY = Y;
        this.PointCollection.setKorrection(X, Y);
    }

}
 MapLayer.prototype = new RenderObject();
 
 Point=function(X,Y)
 {
     this.X=X;
     this.Y=Y;
     this.ObjectType="Point";
     
     this.render= function()
     {  
        this.MyMap.lineTo(parseInt(this.X), parseInt(this.Y));
     }
     
    this.setKorrection = function(X, Y) 
    {
        this.KorrectionX = X;
        this.KorrectionY = Y;
        
    }
     
     this.calculateMapPosition=function()
    {
        this.MapLeft=((this.X-this.KorrectionX))/this.Zoom;
        this.MapTop=((this.Y-this.KorrectionY))/this.Zoom;
    } 
    
    this.render= function()
    {
        this.MyMap.lineTo(parseInt(this.getMapLeft()), parseInt(this.getMapTop()));
    }
     
 }
 Point.prototype = new RenderObject();
 
 
 Elips= function(X,Y)
 {
     this.X=X;
     this.Y=Y;
     this.Color="#fffff";
     this.ObjectType="Elips";
     
     this.render= function()
     {
          var intRadius = 50;
          this.MyMap.beginPath();
          this.MyMap.moveTo(parseInt(this.Width/2) + intRadius, 15 + intRadius);
          //objContext.arc(35, 40, 25, 0, 2*Math.PI, true);
          this.MyMap.arc(this.MapLeft, this.MapTop, intRadius, 0, 2*Math.PI, true);
          this.MyMap.fillStyle = this.Color;
          this.MyMap.fill();
      }
      
      this.setColor= function (Color)
    {
        this.Color=Color;
    }
 }
 
 Elips.prototype = new RenderObject();
 
 
 
 
 PointCollection = function()
{
	this.CollectionElements= new Array();
	this.CollectionState=null;
	this.IdIndex=new Array();
	
	
	
	
	
	this.render= function()
    {  
        this.MyMap.beginPath();
        
    }
	
	
	

} 
PointCollection.prototype = new Collection(); 
 
 
 
 MapLayerCollection = function()
{
	this.CollectionElements= new Array();
	this.CollectionState=null;
	this.IdIndex=new Array();
	

     this.setShowIdentificationMark=function(IdentificationMark)
     {
        for(var i=0;i<this.CollectionElements.length;i++)
		{
		    this.CollectionElements[i].setShowIdentificationMark(IdentificationMark);
		}
        
     }
     
   
     
     
} 
MapLayerCollection.prototype = new Collection(); 