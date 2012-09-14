
Article= function(Name,Price)
{
    this.Name=Name;
    this.Price=Price

    this.getName= function()
    {
       return this.Name; 
    }
    
    this.getPrice= function(Float)
    {
        if(Float)
        {
            return this.Price.replace(",", ".");; 
        }
       return this.Price; 
    }
    
    this.render= function()
    {
        Temp="<tr>";
        Temp+="<td >"+this.Name+" </td>";
        Temp+="<td>"+this.Price+" €</td>"; 
        Temp+="</tr>"; 
        return Temp;
    }

    
}



CasshBox= function()
{

    this.Elements=new Array();
    
    
    this.add= function(Element)
    {
       this.Elements.push(Element);
       this.render(); 
    }

    this.render= function()
    {
        var HTMLElement= document.getElementById("Results");
        var Temp="";
        HTMLElement.innerHTML="";
        Temp+="<tr class='header'>";
         Temp+="<td width='80%'>Artikel </td>";
         Temp+="<td >Preis </td>";
        Temp+="</tr>";
    	for(var i=0;i<this.Elements.length;i++)
		{
           Temp+= this.Elements[i].render();
		}
		
		Temp+="<tr>";
        Temp+="<td colspan='2'><hr /> </td>";
        Temp+="</tr>";
		
		Temp+="<tr>";
        Temp+="<td >Gesamt: </td> ";
        Temp+="<td>"+this.getPrice()+" €</td>";
        Temp+="</tr>";
		
		HTMLElement.innerHTML=Temp;    
    }

    this.getPrice= function()
    {
        var Price=0;
    	for(var i=0;i<this.Elements.length;i++)
		{
           Price+= this.Elements[i].getPrice(true)*1;
		}
        return Price;
    }


}
