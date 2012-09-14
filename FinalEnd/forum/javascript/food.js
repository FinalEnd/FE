
FoodPrice= function(MyNameOne,MyPriceOne,MyNameTow,MyPriceTow,MyNameThree,MyPriceThree)
{
	this.NameOne=MyNameOne || "Normal";
	this.PriceOne=MyPriceOne || "0,00";
	this.NameTow=MyNameTow || "";
	this.PriceTow=MyPriceTow || "";
	this.NameThree=MyNameThree || "";
	this.PriceThree=MyPriceThree || "";
	
	this.write= function (Id)
	{
		var Content="<select id='SelectFoodPrice"+ Id +"' onchange='MyFoodForm.changePrice("+ Id +",this)'";  
		if ( this.NameOne != "" && this.NameTow == "" && this.NameThree == "")
		{
			Content+="style='display:none' >";
		}else
		{
			Content+=">";
		}
		Content+="<option selected value='"+ this.NameOne +"' >"+ this.NameOne +"</option>";
		if (this.NameTow!= ""){Content+="<option value='"+ this.NameTow +"'>"+ this.NameTow +"</option>";}
		if (this.NameThree!= ""){Content+="<option value='"+ this.NameThree +"'>"+ this.NameThree +"</option>";}
		Content+="</select>"
		return Content;
	}
	
	this.getPrice= function(Name)
	{
		if(!Name){return this.PriceOne;}
		if (this.NameOne== Name){return this.PriceOne;}
		if (this.NameTow== Name){return this.PriceTow;}
		if (this.NameThree== Name){return this.PriceThree;}
	}	
	
}


FoodElement= function(Id,Name,Price,Description,Extendable)
{
	this.Id=Id|| 0;
	this.Name=Name|| "";
	this.Price=Price|| new FoodPrice();
	this.Description=Description|| "";
	this.Extendable=Extendable|| false;

	this.write= function()
	{
		var Content="<div id=FoodElement"+ this.Id +"  style='display:none'>";
		Content+= "<div class='FoodName' style='float:left;width:100px'><b>" +this.Name+ "</b></div>" +" <div class='FoodDescription' style='float:left;width:250px'>"+ this.Description +"</div><div id='FoodPrice"+ this.Id+"' class='FoodPrice' style='float:left;width:150px'>"+ this.Price.getPrice() +" &euro;</div><div id='FoodSize' class='FoodPrice' style='float:left;width:150px'>"+  this.Price.write(this.Id)  +"</div><div class='FoodCount' style='float:left;width:50px' ><input type='button' onclick='MyFoodForm.addFoodToShop("+ this.Id +")' value='in Warenkorb' style='width:100px' name='"+ this.Id +"' /></div><br style='clear: both;'/>";
		Content+="</div>";
		return 	Content
	}
	
	this.getId= function ()
	{
		return this.Id;
	}
	
	this.getName= function ()
	{
		return this.Name;
	}
	
	this.show=function()
	{
		if (document.getElementById("FoodElement" + this.Id).style.display=="block")
		{
			document.getElementById("FoodElement" + this.Id).style.display="none";
		}else
		{
			document.getElementById("FoodElement" + this.Id).style.display="block";
		}
	}
	
	this.getDescription= function()
	{
		return this.Description
	}
	
	this.getExtendable= function()
	{
		return this.Extendable
	}
	
}


Collection = function (Name,Description)
{
	this.Name=Name || "";
	this.Description=Description || "";
	this.Elements=new Array();
	this.ElementCount= 0;
	
	
	this.add= function(Element)
	{
		this.Elements.push(Element);
		this.ElementCount++;
	}

	this.getAll= function()
	{
		return this.Elements;
	}

	this.getCount= function()
	{
		return this.ElementCount;
	}
	
	this.write= function()
	{
		var Content="<div style=''>";
		Content+= "<div class='FoodName' style='float:left;width:100px;'><b style='cursor:pointer;' onclick=\"MyFoodForm.showCollectionByName(\'"+ this.Name + "\')\">" +this.Name+ "</b></div>" +" <div class='FoodDescription' style='float:left;width:250px'>"+ this.Description +"</div><div class='FoodPrice' style='float:left;width:150px'>Preis</div><div class='FoodCount' style='float:left;width:100px' >Gr&ouml;&szlig;e</div>";
		Content+="<hr style='clear:both;'/>";
		//Content+="<tr colspan='4' ><hr></tr>";
		
		     for(var i=0;i < this.Elements.length;i++)
			{
				Control = this.Elements[i];
		        if(Control != null)
		        {
	                 Content+=  Control.write();
		        }
			}
		Content+="</div>";
		return Content
	}
	
	
	this.getById= function(Id)
	{
			for(var i=0;i < this.Elements.length;i++)
			{
				Control = this.Elements[i];
		        if(Control.getId() == Id)
		        {
	                return Control;
		        }
			}
			return false;
	}
	
	this.getName=function () 
	{
		return this.Name;
	}
	
	
	this.showCollection= function()
	{
		for(var i=0;i < this.Elements.length;i++)
		{
			this.Elements[i].show();
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
	  var Content="<div>";
	        for(var i=0;i < this.Collection.length;i++)
			{
				Control = this.Collection[i];
		        if(Control != null)
		        {
	                 Content+=  Control.write();
		        }
			}
	    Content+="</div>";
	    var PlaceElement =  document.getElementById(this.PlaceId)
	    PlaceElement.innerHTML =Content;
	}

	
	this.changePrice = function(Id,Select)
	{
		// Element aus Collection Holen
		
		var MyElement=this.getElementById(Id);
		//alert(Size);
		var Size="";
			Size=Select.value;
		var Price=MyElement.Price.getPrice(Size);
		//alert(Price);
		if (document.getElementById("FoodPrice" + Id))
		{
			document.getElementById("FoodPrice" + Id).innerHTML=Price +" €";
		}
		
		
	}
	
	this.getElementById= function(Id)
	{
		    for(var i=0;i < this.Collection.length;i++)
			{
				var Element=this.Collection[i].getById(Id);
				if (Element!= false)
				{
					return Element
				}
			}
		return false;
	}
	
	this.showCollectionByName= function(Name)
	{
			for(var i=0;i < this.Collection.length;i++)
			{
				var Element=this.Collection[i];
				if (Element.getName() == Name)
				{
					Element.showCollection();
				}
			}
	}
	
	this.addFoodToShop= function(ElementId)
	{
		var Shop= ShopCage.getInstance();
		var Element= this.getElementById(ElementId);
		var Size= document.getElementById("SelectFoodPrice"+ ElementId).value || "0,00";
		var Price=Element.Price.getPrice(Size);
		var MyShopElement= new ShopElement(ElementId,Element.getName(),Size,Price,Element.getDescription(),Element.getExtendable());
		Shop.addElement(MyShopElement);
	}
	
}

ShopElement= function(Id,Name,Size,Price,Description,Extendable)
{
	//this.prototype = new FoodElement(Id,Name,new FoodPrice(),Description,Extendable);
	this.Id=Id || 0;
	this.Name=Name || "";
	this.Description=Description || "";
	this.Extendable=Extendable || false;
	this.Size=Size || "Klein";
	this.Price=Price || "0,00"; 
	
	
	this.getPrice= function()
	{
		return this.Price;
	}	
	
	this.getSize= function()
	{
		return this.Size;
	}
	
	this.write= function()
	{
		var Content="<div id=CageFoodElement"+ this.Id +" >";
		Content+= "<div class='CageFoodName' style='width:100px'><img onclick='ShopCage.getInstance().reMoveElementById("+ this.Id +")' src='images/losch.gif' alt='entfernen' /><b>" + this.Name + "</b>  "+ this.Size +"</div> <div class='CageFoodDescription' style='float:left;width:250px'>"+ this.Description +"</div><div id='CageFoodPrice"+ this.Id +"' class='CageFoodPrice' style='float:left;width:150px'>"+ this.getPrice() +" &euro;</div><br style='clear: both;'/>";
		Content+="</div>";
		return 	Content
	}
	
	this.getHTML= function()
	{
		var Content="";
		Content+= "<input style='display:none' type='text' name='FoodId[]' value='"+ this.Id +"' /><input style='display:none' type='text' name='FoodSize[]' value='"+ this.Size +"' />";
		return 	Content
	}
	
	this.getId= function()
	{
		return this.Id;
	}
	
	this.getName= function()
	{
		return this.Name;
	}
}




ShopCage = function(PlaceId)
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
	  var Content="<div>";
	  Content="<div class='WarenKorb'> <h1>Warenkorb</h1></div>";
	        for(var i=0;i < this.Collection.length;i++)
			{
				Control = this.Collection[i];
		        if(Control != null)
		        {
	                 Content+=  Control.write();
		        }
			}
		Content+="<div class='WarenKorb'><hr /></div>";	
		Content+="<div class='WarenKorb'>gesammt: "+ this.calculateElements() +" &euro;  <input type='button' onclick='ShopCage.getInstance().sendContent()' value='bestellen' /></div>";
	    Content+="</div>"; 
	    Content+="<div id='SendContent' style='display:none'>";
		if (document.getElementById(this.PlaceId))
		{
			document.getElementById(this.PlaceId).innerHTML =Content;
		}
	    
	}
	
	this.sendContent= function()
	{
	    if (!document.getElementById("SendContent")){return false;}
	    
	        var TempString="<form method='post' id='ShopCageForm' action='index.php?section=food&action=addFoodOrder' >";
	        for(var i=0; i< this.Collection.length;i++)
	        {
    	        TempString+=this.Collection[i].getHTML();
	        }
    			
	        TempString+="</form>";
	       document.getElementById("SendContent").innerHTML= TempString;
	       document.getElementById("ShopCageForm").submit();
	   
	}
	
	
	this.calculateElements= function()
	{
		var Price=0;
	    for(var i=0;i < this.Collection.length;i++)
		{
			Control = this.Collection[i];
			if(Control != null)
		    {
	            Price+= Number(Control.getPrice());
		    }
		}
	    return Price.toFixed(2);
	}
	
	
	this.getElementById= function(Id)
	{
		    for(var i=0;i < this.Collection.length;i++)
			{
				var Element=this.Collection[i].getById(Id);
				if (Element!= false)
				{
					return Element
				}
			}
		return false;
	}	
	
	this.addElement= function(ShopElement)
	{
		this.Collection.push(ShopElement);
		this.CollectionCount++;
		this.write();
	}
	
	
	this.reMoveElementById= function(ElementId)
	{
		var TempArray= new Array();
		this.CollectionCount=0;
		for(var i=0;i < this.Collection.length;i++)
		{
			var Element=this.Collection[i];
			if (Element.getId()!= ElementId)
			{
				TempArray.push(Element);
				this.CollectionCount++;
			}
		}
		this.Collection=TempArray;
		this.write();
		return true;
	}
	
	
	
	this.showAddExtentions= function(ElementId)
	{
		// div machen dinger platzieren 
	
	}
	
}
ShopCage.Instance = null;
ShopCage.getInstance = function(HTMLID) 
{
	ID=HTMLID||"ShopId";// platzierung
    if (ShopCage.Instance == null) 
	{
            ShopCage.Instance = new ShopCage(ID);
    }
    return ShopCage.Instance;
}