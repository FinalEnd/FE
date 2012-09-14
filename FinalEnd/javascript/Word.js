function color(farbe)
{
    eing=prompt("text eingeben","");
    if(eing != false || eing != "")
    {
        document.getElementById("rtb_Comment").value += "[color="+farbe+"]"+eing+"[/b]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}


function fat()
{
    eing=prompt("text eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Comment").value += "[b]"+eing+"[/b]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}

function italic()
{
    eing=prompt("text eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Comment").value += "[i]"+eing+"[/i]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}
function underlined()
{
    eing=prompt("text eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Comment").value += "[u]"+eing+"[/u]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}
function img()
{
    eing=prompt("bild adresse eingeben","http://");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Comment").value += "[img]"+eing+"[/img]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}
function http()
{
    eing=prompt("link adresse eingeben","http://");
    if((eing !="") && (eing !=null))
    {
        eins = "[a]"+eing+"[/a]"+"";
        document.getElementById("rtb_Comment").focus();
    }
    eing=prompt("namen des links eingeben","");
    if((eing !="") && (eing !=null))
    {
        document.getElementById("rtb_Comment").value +=eins+eing+"[/1a]"+" ";
        document.getElementById("rtb_Comment").focus();
    }
}