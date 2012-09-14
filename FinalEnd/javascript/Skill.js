Skill= function()
{
    this.split=function(SkillPreFix,KoordinateString)
    {
        var TempString=KoordinateString.split(":");
        if(!TempString[0] || !TempString[1]){return false;}
        document.getElementById(SkillPreFix+"X").value=TempString[0].replace(" ","");
        document.getElementById(SkillPreFix+"Y").value=TempString[1].replace(" ","");
    }
    

}

var MySkill= new Skill();
