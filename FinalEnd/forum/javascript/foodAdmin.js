

FoodElement= function(Id,Name,Description,Price,Size,Extentions,ExtentsionPrice)
{
    this.Id=Id;
    this.Name=Name;
    this.Description=Description;
    this.Price=Price;
    this.Size=Size;
    this.Extentions=Extentions;
    this.ExtentsionPrice=ExtentsionPrice;
    this.Visile=false;
    
    
    this.write = function(Modus)
	{
	    var Content="";
	    switch(Modus)
	    {   
	        case "FOODORDER":
	        {
	            Content=" <div id='FoodElement"+ this.Id +"' style=\"clear:both;";
	            if (this.Visibel==true)
	            {
	                Content+="display:block;\" >";
	            }
	            else
	            {
	                Content+="display:none;\" >";
	            }
	            Content+="<div style=\"float:left;width:200px;\">"+ this.Name +"</div>";
	            Content+="<div style=\"float:left;width:200px;\">"+ this.Price.toFixed(2) +" €</div>";
	            Content+="<div style=\"float:left;width:100px;\"> "+ this.Size +"</div>";
	            Content+="</div>";
	        } break;
	    case "FOODELEMENTS":
	    {
	    
	    
	    }brak;
	    
	    
	    
        return Content;
    }
    
    this.showElement = function()
    {
        this.Visile=true;
        this.showVisibilState();
    }
    
    this.hideElement = function()
    {
        this.Visile=false;
        this.showVisibilState();
    }
    
    this.getVisibleState= function()
    {
        return this.Visile ;
    }
    
    this.showVisibilState=function()
    {
        if(document.getElementById("FoodElement"+ this.Id))
        {
            if(this.Visile)
            {
                document.getElementById("FoodElement"+ this.Id).style.display= "block";
            }else
            {
                document.getElementById("FoodElement"+ this.Id).style.display= "none";
            }
        
        }
    
    }
    
}


FoodOrder= function(Id,UserName,UserId,Price,IsPaid)
{
    this.Id=Id;
    this.UserName=UserName;
    this.UserId=UserId;
    this.Price=Price;
    this.IsPaid=IsPaid;
    this.FoodElements= new Array();
    this.ElementsCounter=0;

    this.add= function(Element)
    {
        this.FoodElements.push(Element);
        this.ElementsCounter++;
    }
    
    this.getId= function()
    {
        return this.Id;
    }
    
    this.getUserName= function()
    {
        return this.UserName;
    }
    
    this.getAll= function()
    {
        return this.FoodElements;
    }
    
    this.getByIndex = function(Index)
    {
        return this.FoodElements[Index];  
    }

    this.getPaidState= function ()
    {
        return this.IsPaid ;
    }


	this.write = function(Modus)
	{
	var Content="";
	switch (Modus)
	{
	    case "FOODORDER": 
	    {
    		Content=" <div style=\"clear:both\" id='FoodOrder"+ this.Id +"' >";   
	        Content+="<div style=\"float:left;width:200px;\"><a style=\"width:200px;\" href='#' onclick='MyFoodForm.showElementsByFoodOrderId("+ this.Id+")'  >"+ this.UserName  +"</a></div>";
	        Content+="<div style=\"float:left;width:200px;\">"+ this.Price.toFixed(2) +" €</div>";
	        Content+="<div ><select style=\"width:150px;\" onclick=\"\" name=\"Status\" size=\"\" >";
            if (this.IsPaid==0)
            {
                Content+="<option selected=\"selected\" value=\"0\">offen</option>";
            }
            else
            {
                Content+="<option value=\"0\">offen</option>";
            }
          
            if (this.IsPaid==1)
            {
                Content+="<option selected=\"selected\" value=\"1\">Bezahlt</option>";
            }
            else
            {
                Content+="<option value=\"1\">Bezahlt</option>";
            }
               if (this.IsPaid==2)
              {
                Content+="<option selected=\"selected\" value=\"2\">Bestellt</option>";
              }
              else
              {
                Content+="<option value=\"2\">Bestellt</option>";
              }
              Content+="</select></div>";
    	    
	            Content+="</div>";
	        for(i=0;i<this.FoodElements.length;i++)
            {
                Content+=this.FoodElements[i].write(Modus);
            }
	    }break;
	
	    case "FOODELEMENTS": 
	    {
	    	for(i=0;i<this.FoodElements.length;i++)
            {
                Content+=this.FoodElements[i].write(Modus);
            }
	    
	    }break;
	   return Content;
	}

	    
	     
        return Content;
    }
    
    this.showElements= function()
    {
        if(this.ElementsCounter ==0){return false;}
        
        var i=0;
        for(i=0;i<=this.FoodElements.length;i++)
        {
            if (this.FoodElements[i].getVisibleState())
            {
                this.FoodElements[i].hideElement();
            }else
            {
                this.FoodElements[i].showElement();
            }
        }
    
        
    }
    
    
}
 



FoodForm = function(PlaceId)
{
    this.PlaceId=PlaceId;
	this.Collection= new Array();
	this.CollectionCount=0;

	this.add= function(Element)
	{
		this.Collection.push(Element);
		this.CollectionCount++;
	}

	this.write = function()
	{
	  var Content="<div style=\"float:left;width:200px;\"><a href=\"#\" onclick=\"MyFoodForm.write()\">Bestellungen</a></div> <div style=\"float:left;width:200px;\"><a href=\"#\" onclick=\"MyFoodForm.writeOrder()\"> Pizzen</a></div> <div style=\"width:200px;\"> Name: <input onkeyup=\"MyFoodForm.searchByName()\" id=\"SearchName\" onkeyup=\"\" type =\"text\" /></div>";
       Content+=" <br style=\"clear: both;\" /><div style=\"float:left;width:200px;\">User</div> <div style=\"float:left;width:200px;\">Preis </div> <div style=\"float:left;width:100px;\">Status</div>";
       Content+="<hr style = \"clear: both;color:black;height:3px;\" />";
        Content+="<div id='ResultesContainer'/>";
        Content+=this.renderElements(this.Collection,"FOODORDER");
	    Content+="</div>";
	    Content+="</div>";
	    var PlaceElement =  document.getElementById(this.PlaceId);
	    PlaceElement.innerHTML =Content;
	}
	
	
	this.writeOrder= function()
	{
	    var Content="<div style=\"float:left;width:200px;\"><a href=\"#\" onclick=\"MyFoodForm.write()\">Bestellungen</a></div> <div style=\"float:left;width:200px;\"><a href=\"#\" onclick=\"MyFoodForm.writeOrder()\"> Pizzen</a></div> <div style=\"width:200px;\"> Name: <input onkeyup=\"MyFoodForm.searchByName()\" id=\"SearchName\" onkeyup=\"\" type =\"text\" /></div>";
        Content+=" <br style=\"clear: both;\" /><div style=\"float:left;width:200px;\">User</div> <div style=\"float:left;width:200px;\">Preis </div> <div style=\"float:left;width:100px;\">Status</div>";
        Content+="<hr style = \"clear: both;color:black;height:3px;\" />";
        Content+="<div id='ResultesContainer'/>";
        var TempCollection= this.getElementsForOrder();
        Content+=this.renderElements(this.Collection,"FOODELEMENTS");
	    Content+="</div>";
	    Content+="</div>";
	    var PlaceElement =  document.getElementById(this.PlaceId);
	    PlaceElement.innerHTML =Content;
	}
	
	this.getElementsForOrder = function()
	{
		var TempOrders= new Array();
	    for(var i=0;i<this.Collection.length;i++)
	    {
	        if(this.Collection[i].getPaidState()==1)
	        {
	            TempOrders.push(this.Collection[i]);
	        }
	    }
	    return TempOrders;
	
	}
	
	
	this.searchByName= function()
	{
	    if(!document.getElementById("SearchName")){return false;}
	    if(!document.getElementById("ResultesContainer")){return false;}
        var Name=document.getElementById("SearchName").value;
	    var TempOrders= new Array();
	    
	    for(var i=0;i<this.Collection.length;i++)
	    {
	        if(this.Collection[i].getUserName().toLowerCase().search(".*"+Name.toLowerCase()+".*")!=-1)
	        {
	            TempOrders.push(this.Collection[i]);
	        }
	    }
	    
	   document.getElementById("ResultesContainer").innerHTML= this.renderElements(TempOrders);
	
	}
	 
	
	 this.renderElements= function(Collection,Modus)
	 {
	    var Content="";
	 	    for(var i=0;i < Collection.length;i++)
			{
				Control = Collection[i];
		        if(Control != null)
		        {
	                 Content+=  Control.write(Modus);
		        }
			}
			return Content;
	 
	 }
	
	
	this.showElementsByFoodOrderId= function(FoodOrderId)
	{
	var Control;
	     for(var i=0;i < this.Collection.length;i++)
			{
				Control = this.Collection[i];
		        if(Control != null)
		        {
		            if(Control.getId()==FoodOrderId)
		            {
		                Control.showElements();
		            }
	                 
		        }
			}
	}


}














