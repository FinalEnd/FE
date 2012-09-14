
Pic = function(Name, Path, Height, Width, ThumbPath) 
{

    this.Name = Name || "";
    this.Path = Path || "";
    this.Height = Height || 250;
    this.Width = Width || 250;
    this.ThumbPath = ThumbPath || Name;

    this.getWidth = function() {
        if (this.Width > 1024) {
            return 1024;
        }
        return this.Width;
    }
    // hallo
    this.getHeight = function() {
    if (this.Height > 768) {
        return 768;
    }
        return this.Height;
    }

    this.getName = function() {
        return this.Name;
    }

    this.getPath = function() {
        return this.Path;
    }

    this.getThumbPath = function() {
        return this.ThumbPath;
    }

}



Gallery = function(HTMLId, Colls, Description) {
    this.PicCollection = new Array();
    this.HTMLId = HTMLId;
    this.Colls = Colls;
    this.Description = Description;
    this.ThumbWidth = 80;
    this.ThumbHeight = 80;
    this.PicIndex = 0;
    this.FadeInterval;
    this.DiaShowInterval;
    this.FadeState = 0;
    this.Rows = 5;
    this.NextPic;
    this.LastPic;


    this.setRows = function(Rows) {
        this.Rows = Rows;
    }

    this.addPic = function(Pic) {
        this.PicCollection.push(Pic);
    }


    this.setThumbHeight = function(Height) {
        this.ThumbHeight = Height;
    }

    this.setThumbWidth = function(Width) {
        this.ThumbWidth = Width;
    }

    this.render = function(Page) {
        Page = Page || 0;
        var TempString = "";
        var i = 0;
        var TempCount = 0;
        var RowCount = 0;
        TempString += this.Description + "<br />";
        TempString += "<table  class='GalleryTable'><tr>";
        for (i = 0; i < this.PicCollection.length; i++) {
            TempString += "<td class='TableCell' heigth='" + this.ThumbHeight + "' width='" + this.ThumbWidth + "'><img style='cursor:pointer' onclick='MyGallery.showPic(" + i + ")' src='" + this.PicCollection[i].getThumbPath() + "' heigth='" + this.ThumbHeight + "' width='" + this.ThumbWidth + "' title='" + this.PicCollection[i].getName() + "' /> </td>";
            TempCount++;
            if (TempCount == this.Colls) {
                TempString += "</tr><tr>";
                TempCount = 0;
            }
        }
        for (var j = TempCount; j < this.Colls; j++) {
            TempString += "<td></td>";
        }
        TempString += "</tr></table>";

        if (document.getElementById(this.HTMLId)) {
           // alert("hallo vor init");
            TempString += this.inital();
            document.getElementById(this.HTMLId).innerHTML += TempString;
            //alert(document.getElementById(this.HTMLId));
        }

    }

    this.inital = function() {
        var TempString = "";
        TempString += "<div id='MyPic' style='border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:black;border-right-width:1px;border-right-style:solid;border-right-color:black;background-color:white;cursor:pointer;position:absolute;left:0px;top:100px;z-index:199;text-align:center;vertical-align:middle;disply:none'></div>";
        if (document.all) {
            var BGHeigth = document.body.clientHeight;
            var BGWidth = document.body.clientWidth;
        } else {
            var BGHeigth = window.innerHeight;
            var BGWidth = window.innerWidth;
        }
        //alert("BGWidth ist : "+BGWidth);
        TempString += "<div id='BG' onclick='' style='display:none;z-index:198;position:absolute;top:0px;left:0px;background-image:url(./images/bg.png);width:100%;height:100%;'/>";
        TempString += "<img id='CloseId' onclick='MyGallery.hidePic()' src='./images/x.png' style='display:none;cursor:pointer;height:55px;width:55px;position:absolute;top:0px;z-index:1100;left:0px;' />";
        TempString += "<img id='BackId' onclick='MyGallery.showPreviewPic()' src='./images/pfeil_links.png' style='display:none;cursor:pointer;height:67px;width:85px;position:absolute;top:150px;z-index:1101;left:20px;' />";
        TempString += "<img id='NextId' onclick='MyGallery.showNextPic()' src='./images/pfeil_rechts.png' style='display:none;cursor:pointer;height:67px;width:85px;position:absolute;top:150px;z-index:1101;left:" + (BGWidth-105 )+ "px;' />";
       // newxt und last pix
        TempString += "<img id='LastPic' src='' style='display:none;height:1px;width:1px;position:absolute;top:150px;z-index:0;left:20px;' />";
        TempString += "<img id='NextPic' src='' style='display:none;height:1px;width:1px;position:absolute;top:150px;z-index:0;left:20px;' />";
       
        return TempString;
    }

    this.showPic = function(PicIndex) {


        if (this.DiaShowInterval) {
            window.clearInterval(this.DiaShowInterval);
        }
        //hintergund abdunkeln
        // window.innerWidth-125;
        this.PicIndex = PicIndex;
        var TempString = "";

        if (PicIndex < this.PicCollection.length) {

            var NewPicIndex = (PicIndex * 1) + (1 * 1)
            var Pic = this.PicCollection[PicIndex];
            if (document.all) {
                var TempLeft = (document.body.clientWidth / 2) - Pic.getWidth() / 2;
            }
            else {
                var TempLeft = (window.innerWidth / 2) - Pic.getWidth() / 2;
            }
            if (document.getElementById("MyPic") && document.getElementById("BG") && document.getElementById("CloseId")) {
                document.getElementById("MyPic").style.left = TempLeft + "px";
                document.getElementById("MyPic").style.display = "block";
                document.getElementById("BG").style.display = "block";
                document.getElementById("CloseId").style.display = "block";
                document.getElementById("BackId").style.display = "block";
                document.getElementById("NextId").style.display = "block";
                
                document.getElementById("MyPic").innerHTML = "<img id='MyImage' onclick='MyGallery.showNextPic()' src='" + this.PicCollection[PicIndex].getPath() + "' title='" + this.PicCollection[PicIndex].getName() + "' style='width:" + Pic.getWidth() + "px;height:" + Pic.getHeight() + "px;left:" + (TempLeft * 1 - 15 * 1) * 1 + "px;' />";
                this.startFadeIn("MyImage");
            }
            //this.DiaShowInterval = window.setInterval("MyGallery.showNextPic()", 5000); // diaschow interval setzen
            this.loadHidePix(this.PicIndex); 
        } else {
            this.hidePic();
        }
    }

    this.showNextPic = function() {
        if (this.DiaShowInterval) {
            window.clearInterval(this.DiaShowInterval);
        }
        this.PicIndex++;
        var TempString = "";

        if (this.PicIndex < this.PicCollection.length && this.PicIndex > 0) {
            // var NewPicIndex = (PicIndex * 1) + (1 * 1)
            var Pic = this.PicCollection[this.PicIndex];
            if (document.all) {
                var TempLeft = (document.body.clientWidth / 2) - Pic.getWidth() / 2;
            }
            else {
                var TempLeft = (window.innerWidth / 2) - Pic.getWidth() / 2;
            }
            if (document.getElementById("MyPic") && document.getElementById("BG") && document.getElementById("CloseId")) {
                document.getElementById("MyPic").style.left = TempLeft + "px";
                document.getElementById("MyPic").style.display = "block";
                document.getElementById("BG").style.display = "block";
                document.getElementById("CloseId").style.display = "block";
                if (document.all) {
                    document.getElementById("MyImage").filter = "alpha(opacity=" + 0 + ")";
                } else {
                    document.getElementById("MyImage").style.opacity = 0;
                }
                //document.getElementById("MyPic").innerHTML = "<img id='MyImage' onclick='MyGallery.showNextPic()' src='" + Pic.getPath() + "' title='" + Pic.getName() + "' style='width:" + Pic.getWidth() + "px;height:" + Pic.getHeight() + "px;left:" + (TempLeft * 1 - 15 * 1) * 1 + "px;' />";
                document.getElementById("MyImage").src = Pic.getPath();
                document.getElementById("MyImage").title = Pic.getName();
                document.getElementById("MyImage").style.height = Pic.getHeight() +"px";
                document.getElementById("MyImage").style.width = Pic.getWidth()+"px";
                document.getElementById("MyPic").style.height = Pic.getHeight() +"px";
                document.getElementById("MyPic").style.width = Pic.getWidth() +"px";
                this.startFadeIn("MyImage");
                //this.DiaShowInterval = window.setInterval("MyGallery.showNextPic()", 5000);
                //letztes und nächstes bild laden
                this.loadHidePix(this.PicIndex); 
            }
        } else {
            this.hidePic();
        }
    }

    this.loadHidePix = function(Index) 
    {
        if(this.PicCollection[Index+1])
        {
            document.getElementById("NextPic").src = this.PicCollection[Index+1].getPath();
        }
        if(this.PicCollection[Index-1])
        {       
            document.getElementById("LastPic").src = this.PicCollection[Index-1].getPath();
        }
    }
    
    this.startFadeIn = function(ObjectId)
    {
        this.FadeState = 0;
        this.FadeInterval = window.setInterval("MyGallery.fadeElementIn('" + ObjectId + "')", 100);
    }

    this.fadeElementIn = function(ObjectId) {
        this.FadeState = this.FadeState * 1 + 0.1;
        
        if (document.getElementById(ObjectId).complete == true) 
        {
//            if (document.all) 
//            {
//               // alert(this.FadeState * 100);
//               var Filter="Alpha(opacity=" +(this.FadeState*100)+ ",finishopacity=0, style=0)";
//                document.getElementById(ObjectId).filter = Filter;
//                alert(document.getElementById(ObjectId).src);
//               // alert(Filter);
//            } else 
//            {
                document.getElementById(ObjectId).style.opacity = this.FadeState;
//            }
            if (this.FadeState > 1) {
                window.clearInterval(this.FadeInterval)
            }
        }

    }


    this.showPreviewPic = function() {
        if (this.DiaShowInterval) {
            window.clearInterval(this.DiaShowInterval);
        }
        this.PicIndex--;
        var TempString = "";

        if (this.PicIndex < this.PicCollection.length && this.PicIndex > -1) {
            // var NewPicIndex = (PicIndex * 1) + (1 * 1)
            var Pic = this.PicCollection[this.PicIndex];
            if (document.all) {
                var TempLeft = (document.body.clientWidth / 2) - Pic.getWidth() / 2;
            }
            else {
                var TempLeft = (window.innerWidth / 2) - Pic.getWidth() / 2;
            }
            if (document.getElementById("MyPic") && document.getElementById("BG") && document.getElementById("CloseId")) {
                document.getElementById("MyPic").style.left = TempLeft + "px";
                document.getElementById("MyPic").style.display = "block";
                document.getElementById("BG").style.display = "block";
                document.getElementById("CloseId").style.display = "block";
                if (document.all) {
                    document.getElementById("MyImage").filter = "alpha(opacity=" + 0 + ")";
                } else {
                    document.getElementById("MyImage").style.opacity = 0;
                }

                // document.getElementById("MyPic").innerHTML = "<img id='MyImage' onclick='MyGallery.showNextPic()' src='" + Pic.getPath() + "' title='" + Pic.getName() + "' style='width:" + Pic.getWidth() + "px;height:" + Pic.getWidth() + "px;left:" + (TempLeft * 1 - 15 * 1) * 1 + "px;' />";
                document.getElementById("MyImage").src = Pic.getPath();
                document.getElementById("MyImage").title = Pic.getName();
                document.getElementById("MyImage").style.height = Pic.getHeight()+"px";
                document.getElementById("MyImage").style.width = Pic.getWidth()+"px";
                document.getElementById("MyPic").style.height = Pic.getHeight()+"px";
                document.getElementById("MyPic").style.width = Pic.getWidth()+"px";


                this.startFadeIn("MyImage");
                this.DiaShowInterval = window.setInterval("MyGallery.showNextPic()", 10000);
            }
        } else {
            this.hidePic();
        }
    }


    this.hidePic = function() {

        if (this.FadeInterval) {
            window.clearInterval(this.FadeInterval)
            this.FadeState = 0;
        }

        if (this.DiaShowInterval) {
            window.clearInterval(this.DiaShowInterval);
        }

        if(document.getElementById("NextId"))
        {
            document.getElementById("NextId").style.display = "none";
            document.getElementById("NextId").style.zindex = 100;
        }

        if (document.getElementById("BackId")) {
            document.getElementById("BackId").style.display = "none";
            document.getElementById("BackId").style.zindex = 100;
        }

        if (document.getElementById("MyPic")) {
            document.getElementById("MyPic").style.display = "none";
            document.getElementById("MyPic").style.zindex = 100;
        }
        if (document.getElementById("CloseId")) {
            document.getElementById("CloseId").style.display = "none";
            document.getElementById("MyPic").style.zindex = 101;
        }
        if (document.getElementById("BG")) {
            document.getElementById("BG").style.display = "none";
            document.getElementById("MyPic").style.zindex = 99;
        }
    }


}
