Writer= function(Text,HTMLId)
{

    this.Text=Text;
    this.HTMLId=HTMLId;
    this.Counter=0;
    this.Intervall=null;
   
    
    this.render= function()
    {
        if(!document.getElementById(this.HTMLId)){return false;}
        
        document.getElementById(this.HTMLId).innerHTML+=this.Text[this.Counter];
        if((this.Counter+1)==this.Text.length)
        {
            window.clearInterval(this.Intervall);
            return true;
        }
        this.Counter++;
        
    }  

    this.renderText= function()
    {
        this.Counter=0;
        this.Intervall=window.setInterval("getWriter().render()", 50);
    }  

}

function getWriter(Text,HTMLId)
{
    if(!MyWriter)
    {
        MyWriter= new Writer(Text,HTMLId);
    }
    return MyWriter;
}