var MyPicturLoader=null;
PictureLoader= function()
{
    this.PicArray= new Array();
    this.StringArray= new Array();
    this.ElementCount=0;
    
    this.getPic=function(PictureString)
    {
        var MyImage=this.getByString(PictureString);
        if(!MyImage.src)// wenn es nicht da ist dann in die Collection aufnehmen
        {
            var MyImage= new Image();
            MyImage.src = PictureString;
            this.add(MyImage);
            this.StringArray.push(PictureString);
        }
        return MyImage;
    }
    this.add = function (Element)
	{
		this.PicArray.push(Element);
		this.ElementCount++;
		return true;
	}
 
    this.getByString= function(String)
	{
		for(var i=0;i<this.PicArray.length;i++)
		{
			if(this.StringArray[i]==String)
			{
				return this.PicArray[i];
			}
		}
		return new Image();
	}
}

function getPicturLoader()
{
    if(!MyPicturLoader)
    {
      MyPicturLoader= new PictureLoader();
    }
    return MyPicturLoader;
}