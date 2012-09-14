StateLine= function(Text)
{
    this.Text=Text;
    this.Counter=0;
    this.Interval=null;
    this.Time=150;
    this.Width=100;
    this.HTMLElement=null;





    this.render=function()
    {
        this.HTMLElement.innerHTML = this.Text.substring(this.Counter,this.Counter+this.Width);
        this.Counter++;
        if(this.Counter+1 >this.Text.length)
        {
            this.Counter=0;
        }
    }
    

    this.init=function()
    {
        this.HTMLElement=document.getElementById("Ticker");
        window.setInterval("getStateLine().render()", this.Time);
    }
    
}
var MyStateLine=null;

    function getStateLine(Text)
    {
        if(!MyStateLine)
        {
          MyStateLine= new StateLine(Text);
        }
        return MyStateLine;
    }