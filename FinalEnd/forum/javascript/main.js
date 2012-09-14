/**
 * Programm: erstellen dynamischer forms in javascript
 * Type: IDomainObject, BaseControl, Collection
 * Description: mit diesem script ist es mglich dynamisch html forms zu erstellen die
 * sich selbst abfragen ob diese einen wert eingetragen bekommen haben. wenn ein input feld nicht mit einem wert belegt wurde wird das script nicht versendet
 * und alle falsch ausgefï¿½hlten felder markiert.
 * diese script kann dynamisch textareas erstellen die mann dann bearbeiten kann (BBCODE) über de ableitungen der klassen
 * IButtonControl
 * Copyrihgt:  06.06.2007
 * Autor: Matthias Herzog
 **/

    function instanceOf(object, constructor)  // nur ff und opera kein ie
    {
        while (object != null) 
        {
            if (object == constructor.prototype)
                return true;
           		object = object.__proto__;
        }
        return false;
    }






IDomainObject = function(Id,Name,Description)
{
    this.Name=Name;
    this.Id=Id;
    this.Description=Description;
	this.validateState = null;
}
IDomainObject.prototype.Write = function()
{
	return "";
}
IDomainObject.prototype.CheckValidate = function()
{   
	return false;
}
IDomainObject.prototype.CheckValidationState = function()
{
	return false;
}
IDomainObject.prototype.ShowValidState = function()
{
	return false;
}
// validate 
// write

/* Basis */
BaseControl = function(Id,Name,Description,Format,Type,Style,Readonly)
{
this.Style=Style;
this.Format=Format;
this.Type=Type;
this.Readonly=Readonly;
this.constructor(Id,Name,Description);

}
BaseControl.prototype = new IDomainObject();
BaseControl.prototype.CheckValidate = function()
{
    MyNode = document.getElementById(this.Id);
    this.validateState= false;
		 if(!MyNode){return false;}
         if(MyNode.value.search(this.Format)!=-1)
         {
        	    this.validateState = true;
        	    this.ShowValidState(); 
        	    return true;
         }
    this.ShowValidState();    
    return false;
}
BaseControl.prototype.Write = function()
{
	if(this.Readonly==true)
	{
		Readonly='readonly';
	}
	else
	{
		Readonly='';
	}
	
	
	switch(this.Type)
	{
	
		case "check":
			return '<div class="'+this.Style+'"><div class="Description_'+this.Style+'" id="Description_'+this.Id+'">'+this.Description+'</div><input type="Checkbox" name="Check_'+this.Name+'" value="true" id="'+this.Id+'" '+Readonly+' class="checkbox"></div>';
		break;
	
		case "time":
			return '<div class="'+this.Style+'"><div class="Description_'+this.Style+'" id="Description_'+this.Id+'">'+this.Description+'</div><input type="Text" name="'+this.Name+'" value="" size="" id="'+this.Id+'" '+Readonly+' class="'+this.Style+'">MM:HH </div>';
		break;
		case "date":
			return '<div class="'+this.Style+'"><div class="Description_'+this.Style+'" id="Description_'+this.Id+'">'+this.Description+'</div><input type="Text" name="'+this.Name+'" value="" size="" id="'+this.Id+'" '+Readonly+' class="'+this.Style+'">DD.MM.JJJJ </div>';
		break;
		case "text":
			return '<div class="'+this.Style+'"><div class="Description_'+this.Style+'" id="Description_'+this.Id+'">'+this.Description+'</div><input type="Text" name="'+this.Name+'" value="" size="" id="'+this.Id+'" '+Readonly+' class="'+this.Style+'"> </div>';
		break;
		case "textarea":
			return '<div class="'+this.Style+'"><div class="Description_'+this.Style+'" id="Description_'+this.Id+'">'+this.Description+'</div><textarea name="'+this.Name+'" value="" size="" id="'+this.Id+'" col="'+this.Col+'" row="'+this.Row+'" '+Readonly+' class="'+this.Style+'"></textarea> </div>';
		break;
		
		case "div":
			return '<div class="'+this.Style+'"><div class="Description_'+this.Style+'" id="Description_'+this.Id+'">'+this.Description+'</div><div name="'+this.Name+'" id="'+this.Id+'"  class="'+this.Style+'">'+this.Text+'</div> </div>';
		break;
		
		case "hidden":
			return '<input type="hidden" name="'+this.Name+'" value="'+this.Value+'"  id="'+this.Id+'" >';
		break;

		
	default:
	alert('leider nich in der switch');	
	}		
}

BaseControl.prototype.ShowValidState = function()
{
	MyNode = document.getElementById('Description_'+this.Id);
	if(!MyNode){return false;}
	if(this.validateState===false)
	{
		//alert('fehler gefunden');
		MyNode.style.color="red";
     	MyNode.style.fontWeight="bold";
	}
	else
	{
		MyNode.style.color="";
     	MyNode.style.fontWeight="";
	}
}



/**/
Collection = function()
{
	this.Controls= new Array();
	this.CollectionState=null;
}
Collection.prototype = new IDomainObject();
Collection.prototype.add = function (Object)
{
	if(document.all)
	{
		this.Controls.push(Object);
		return true;
	}

    if(!instanceOf(Object,IDomainObject))
    {
        alert("obejkt  wurde nicht hinzugefügt!\n es ist nicht vom typ basicControl "+Object.Name);
        return false;
    }
    
  	this.Controls.push(Object);
}

Collection.prototype.Write = function()
{
         for(TempI=0;TempI < this.Controls.length;TempI++)
		{
			Control = this.Controls[TempI];
	        if(Control != null)
	        {
                 	NewContent+=  Control.Write(this.Id,TempI);
	        }
		}
		return NewContent;
		
}
Collection.prototype.CheckValidate = function()
{
	
         for(TempI=0;TempI < this.Controls.length;TempI++)
		{
			Control = this.Controls[TempI];
	        if(Control != null)
	        {
                 	if(Control.CheckValidate()===false)
                 	{
                 		this.CollectionState=false;
                 	} 
	        }
		}
		if(this.CollectionState===false)
		{
		return false
		}
}

    Collection.prototype.DeleteOneElement = function(DeletedId,FormName)
   {

            for(i=0;i < this.Controls.length;i++)
	    {

	            Control = this.Controls[i];
	            if(Control.Id === DeletedId)
	            {
                          this.Controls.splice(i,1); // das element löschen
                          this.Controls.splice(i,1);   // den button löschen
	            }
	    }

	FormName.Write();
   }





/* Basis Funktionen von */
//##### Ende Basis ###########


  /**
 *  DynamicForm
 *  erstellt ein form zum rendern auf die html seite
 *
 *
 *  @param string PlaceId    //die Id wo das form platziert werden soll

 */




DynamicForm = function(PlaceId)
{
    this.PlaceId=PlaceId;
    this.constructor(1,'MyForm1','Description');
}
DynamicForm.prototype = new Collection()
{
}

DynamicForm.prototype.Write = function()
{
    Content="<div>";
        for(TempI=0;TempI < this.Controls.length;TempI++)
		{
			Control = this.Controls[TempI];
	        if(Control != null)
	        {
                 Content+=  Control.Write(this.Id,TempI);
	        }
		}
    Content+="</div>";
    var PlaceElement =  document.getElementById(this.PlaceId)
    PlaceElement.innerHTML =Content;
}
DynamicForm.prototype.CheckValidate = function()
{
ErrorCnt=0;
     for(TempI=0;TempI < this.Controls.length;TempI++)
		{
			Control = this.Controls[TempI];
	        if(Control != null)
	        {
                 	if(!Control.CheckValidate())
                 	{
                 	    ErrorCnt++;
                 	}
	        }
		}
	if(ErrorCnt>0)
	{
		return false;
	}
	else
	{
		return true;
	}
}

/*
* class inputTextControl
*	erstellt eine textarea
*
*	@param int Id				die eindeutige ID der Textarea
*	@param string Name			der name der Textarea
*	@param string Description	die schrift die über der textarea steht	
*	@param string Style			gibt die css klasse der textarea an	
*	return string 
*/

inputTextControl = function(Id,Name,Description,Style)
{
	this.Type="text";
	this.Style=Style;
	this.Format='\\w{1,}';
	this.Name=Name;
	this.Id=Id;
	this.Description= Description;
	this.Readonly=false;	
	//this.constructor(Id,Name,Description,Format,Type,Style);
}
inputTextControl.prototype = new BaseControl()
{
}
inputTextControl.prototype.Insert = function()
{
	return false;
}

/*
* class textControl
*	erstellt eine textarea
*
*	@param int Id				die eindeutige ID der Textarea
*	@param string Name			der name der Textarea
*	@param string Description	die schrift die über der textarea steht	
*	@param string Style			gibt die css klasse der textarea an	
*   @param int row				gibt die zeilen der textarea an	
*   @param int col				gibt die zeichen der textarea an
*	return string 
*/

textControl = function(Id,Name,Description,Style,Row,Col)
{
	this.Row=Row;
	this.Col=Col;
	this.Type="textarea";  // kleinschreibung bitte
	this.Style=Style;
	this.Format='\\w{1,}';
	this.Name=Name;
	this.Id=Id;
	this.Description= Description;	
	this.Readonly=false;
	//this.constructor(Id,Name,Description,Format,Type,Style);
}
textControl.prototype = new BaseControl()
{
}
textControl.prototype.Insert = function()
{
	return false;
}

/*
* class dateControl
*	erstellt ein kleines input feld worin nur ein datum eingegeben werden kann 
*
*	@param int Id				die eindeutige ID des input feldes
*	@param string Name			der name der input feldes
*	@param string Description	die schrift die über dem input feldes 
*	@param string Style			gibt die css klasse des input feldes an	
*	return string 
*/

dateControl = function(Id,Name,Description,Style)
{

	this.Type="date";  // kleinschreibung bitte
	this.Style=Style;
	this.Format='([0-9]{2}[./-]{1}[0-9]{2}[./-]{1}[0-9]{4})';
	this.Name=Name;
	this.Id=Id;
	this.Description= Description;	
	this.Readonly=false;
	//this.constructor(Id,Name,Description,Format,Type,Style);
}
dateControl.prototype = new BaseControl()
{
}
dateControl.prototype.Insert = function()
{
	return false;
}

/*
* class timeControl
*	erstellt ein kleines input feld worin nur eine uhr zeit eingegeben werden kann 
*
*	@param int Id				die eindeutige ID des input feldes
*	@param string Name			der name der input feldes
*	@param string Description	die schrift die über dem input feldes 	
*	@param string Style			gibt die css klasse des input feldes an	
*	return string 
*/

timeControl = function(Id,Name,Description,Style)
{

	this.Type="time";  // kleinschreibung bitte
	this.Style=Style;
	this.Format='([0-9]{2}[:][0-9]{2})';
	this.Name=Name;
	this.Id=Id;
	this.Description= Description;	
	this.Readonly=false;
	//this.constructor(Id,Name,Description,Format,Type,Style);
}
timeControl.prototype = new BaseControl()
{
}
timeControl.prototype.Insert = function()
{
	return false;
}


/*
* class divControl
*	erstellt ein kleines input feld worin nur eine uhr zeit eingegeben werden kann 
*
*	@param int Id				die eindeutige ID des input feldes
*	@param string Name			der name der input feldes
*	@param string Description	die schrift die über dem input feldes 	
*	@param string Style			gibt die css klasse des input feldes an	
*	return string 
*/

divControl = function(Id,Description,Text,Style)
{

	this.Type="div";  // kleinschreibung bitte
	this.Style=Style;
	this.Format='';
	this.Name='';
	this.Text=Text;
	this.Id=Id;
	this.Description= Description;	
	this.Readonly=false;
	//this.constructor(Id,Name,Description,Format,Type,Style);
}
divControl.prototype = new BaseControl()
{
}
divControl.prototype.Insert = function()
{
	return false;
}
divControl.prototype.CheckValidate = function()
{
        	    return true;
}






/*
* class checkControl
*	erstellt ein kleines input feld worin nur eine uhr zeit eingegeben werden kann 
*
*	@param int Id				die eindeutige ID des input feldes
*	@param string Name			der name der input feldes
*	@param string Description	die schrift die über dem input feldes 	
*	@param string Style			gibt die css klasse des input feldes an	
*	return string 
*/

checkControl = function(Id,Name,Description,Style)
{

	this.Type="check";  // kleinschreibung bitte
	this.Style=Style;
	this.Format='';
	this.Name=Name;
	this.Id=Id;
	this.Description= Description;	
	this.Readonly=false;
	//this.constructor(Id,Name,Description,Format,Type,Style);
}
checkControl.prototype = new BaseControl()
{
}

 checkControl.prototype.CheckValidate = function()
{
	this.validateState = false;
     var MyVariable= document.getElementById(this.Id);
     if(!MyVariable){return false;}
     if(MyVariable == null)
     {
     	alert('fehler das objekt gibt es nicht');
		return false;
     }
 
     if(MyVariable.checked == '1')
         {
        	    this.validateState = true;
        	    this.ShowValidState(); 
        	    return true;
         }
    this.ShowValidState();    
    return false;
}

checkControl.prototype.Insert = function()
{
	return false;
}

/*
* class randomControl
*	erstellt ein kleines input feld wo alles nach belieben erstellt werden kann
*
*	@param int Id				die eindeutige ID des input feldes
*	@param string Name			der name der input feldes
*	@param string Description	die schrift die über dem input feldes 	
*	@param string Style			gibt die css klasse des input feldes an	
*	@param string type			gibt die art des controlls an time, date, text, textarea 	
*	@param string Format		gibt die regexp an 
*	@param bool   Optional		gibt an  ob es ein muss feld ist oder nicht 
*	@param bool   Readonly		gibt an  ob das objekt verändert werden kann 
*	return string 
*/

randomControl = function(Id,Name,Description,Style,Type,Format,Optional,Readonly)
{
	this.Type=Type;  // kleinschreibung bitte
	this.Style=Style;
	this.Format=Format;
	this.Name=Name;
	this.Id=Id;
	this.Description= Description;	
	this.Optional=Optional;
	this.Readonly=Readonly;
	//this.constructor(Id,Name,Description,Format,Type,Style);
}
randomControl.prototype = new BaseControl()
{
}

randomControl.prototype.CheckValidate = function()
{
	if(this.Optional== true){return true;}
    MyNode = document.getElementById(this.Id);
    this.validateState= false;
		 if(!MyNode){return false;}
         if(MyNode.value.search(this.Format)!=-1)
         {
        	    this.validateState = true;
        	    this.ShowValidState(); 
        	    return true;
         }
    this.ShowValidState();    
    return false;
}



randomControl.prototype.Insert = function()
{
	return false;
}


/*
* class optionGroupControl
*	erstellt einen container für radioControl's 
*
*	@param int Id				die eindeutige ID des input feldes
*	@param string Name			der name der option Groups wird als legende im fieldset angezeigt
*	@param string Description	die schrift die über dem input feldes 	
*	return string 
*/

optionGroupControl = function(Id,Name,Description)
{
    this.constructor(Id,Name,Description);
    this.Controls= new Array();
}
optionGroupControl.prototype = new Collection()
{
}

optionGroupControl.prototype.Write = function()
{
    RadioContent='<fieldset class="radio"><legend  id="legend_'+this.Id+'">'+this.Description+'</legend>';
        for(RadioI=0;RadioI < this.Controls.length;RadioI++)
		{
			Control = this.Controls[RadioI];
	        if(Control != null)
	        {
				 Control.Name=this.Name;
                 RadioContent+=  Control.Write(this.Id+'_'+RadioI);
	        }
		}
    RadioContent+="</fieldset>";
	return RadioContent;
}
optionGroupControl.prototype.CheckValidate = function()
{
RadioErrorCnt=0;
     for(RadioI=0;RadioI < this.Controls.length;RadioI++)
		{
			Control = this.Controls[RadioI];
	        if(Control != null)
	        {
                 	if(Control.CheckValidate())
                 	{
                 	    RadioErrorCnt++;
                 	}
	        }
		}
	if(RadioErrorCnt>0)
	{
		this.validateState=true;
		this.ShowValidState();
		return true;
	}
	else
	{
		this.validateState=false;
		this.ShowValidState();
		return false;
	}
}

optionGroupControl.prototype.add = function (Object)
{
	if(!Object){return false;}  // gucken ob objekt leer
	if(document.all)   // wenn IE dann sofort einfügen 
	{
		this.Controls.push(Object);
		return true;
	}
    if(!instanceOf(Object,RadioControl))   // gucken ob von typ RadioControl
    {
        alert("obejkt wurde nicht hinzugefügt!\n es ist nicht vom typ RadioControl");
        return false;
    }
    
  	this.Controls.push(Object);
}


optionGroupControl.prototype.ShowValidState = function()
{
	MyNode = document.getElementById('legend_'+this.Id);
	if(!MyNode){return false;}
	if(this.validateState===false)
	{
		//alert('fehler gefunden');
		MyNode.style.color="red";
     	MyNode.style.fontWeight="bold";
	}
	else
	{
		MyNode.style.color="";
     	MyNode.style.fontWeight="";
	}
}


/*
* class optionGroupControl
*	erstellt einen container für radioControl's 
*
*	@param string Value			der wert der durch den radiobutton erhält
*	@param string Style			die css klasse die dem radio control übergene wird	
*	return string 
*/

RadioControl = function(Value,Style)
{
 this.Name='';
 this.Value=Value;
 this.Style=Style;
}
RadioControl.prototype = new BaseControl()

RadioControl.prototype.Write = function(Id)
{
 this.Id=Id;
 return '<div><span class="Description_'+this.Style+'">'+this.Value+'</span><input id="'+Id+'" type="Radio" name="'+this.Name+'" style="'+this.Style+'" value="'+this.Value+'"></div>';
}
RadioControl.prototype.CheckValidate = function()
{
	var MyErrorView= document.getElementById(this.Id);
				if(!MyErrorView){return false;}
	            if(MyErrorView.checked == true)
                {
                   return true;
                }
	return false;
	
	

}


/*
* class textGroupControl
*	erstellt einen container für für alle elemente die hier im script angeboten werden 
*   mit umrandung 
*
*	@param int Id				die eindeutige ID des input feldes
*	@param string Name			der name der textGroupControl 
*	@param string Description	die legende des fieldset's 	
*	return string 
*/

textGroupControl = function(Id,Name,Description)
{
    this.constructor(Id,Name,Description);
    this.Controls= new Array();
}
textGroupControl.prototype = new Collection()
{
}
textGroupControl.prototype.add = function (Object)
{
	if(!Object){return false;}  // gucken ob objekt leer
	if(document.all)   // wenn IE dann sofort einfügen 
	{
		this.Controls.push(Object);
		return true;
	}
    if(!instanceOf(Object,IDomainObject))   // gucken ob von typ RadioControl
    {
        alert("obejkt wurde nicht hinzugefügt!\n es ist nicht vom typ BaseControl");
        return false;
    }
    
  	this.Controls.push(Object);
}

textGroupControl.prototype.Write = function()
{
    textGroupContent='<fieldset class="textControl"><legend  id="legend_'+this.Id+'">'+this.Description+'</legend>';
        for(TextI=0;TextI < this.Controls.length;TextI++)
		{
			Control = this.Controls[TextI];
	        if(Control != null)
	        {
				 //Control.Name=this.Name;  eigentlich ein bug
                 textGroupContent+=  Control.Write();
	        }
		}
    textGroupContent+="</fieldset>";
	return textGroupContent;
}

textGroupControl.prototype.CheckValidate = function()
{
this.textGroupErrorCnt=0;
     for(this.TextI=0;this.TextI < this.Controls.length;this.TextI++)
		{
			Control = this.Controls[this.TextI];
	        if(Control != null)
	        {
                 	if(!Control.CheckValidate())
                 	{
                 	    this.textGroupErrorCnt++;
                 	}
	        }
		}
	if(this.textGroupErrorCnt>0)
	{
		this.validateState=false;
		this.ShowValidState();
		return false;
	}
	else
	{
		this.validateState=true;
		this.ShowValidState();
		return true;
	}
}



textGroupControl.prototype.ShowValidState = function()
{
	MyNode = document.getElementById('legend_'+this.Id);
	if(!MyNode){return false;}
	if(this.validateState===false)
	{
		//alert('fehler gefunden');
		MyNode.style.color="red";
     	MyNode.style.fontWeight="bold";
	}
	else
	{
		MyNode.style.color="";
     	MyNode.style.fontWeight="";
	}
}
/*
* class textGroupWihtOutBorderControl
*	erstellt einen container für für alle elemente die hier im script angeboten werden 
*   ohne fieldset
*
*	@param int Id				die eindeutige ID des input feldes
*	return string 
*/

textGroupWihtOutBorderControl = function(Id)
{
    //this.constructor(Id,Name,Description);
    this.Id=Id;
    this.Controls= new Array();
}
textGroupWihtOutBorderControl.prototype = new textGroupControl()
{
}
textGroupWihtOutBorderControl.prototype.Write = function()
{
    textGroupWithOutBorderContent='';
        for(TextWBI=0;TextWBI < this.Controls.length;TextWBI++)
		{
			Control = this.Controls[TextWBI];
	        if(Control != null)
	        {
				 //Control.Name=this.Name;
                 textGroupWithOutBorderContent+=  Control.Write();
	        }
		}
    textGroupWithOutBorderContent+="";
	return textGroupWithOutBorderContent;
}


 /**
 *  klasse buttonControl
 *  grund klasse fuer die erstllung von button
 *
 *  @param int Id
 *  @param string Name
 *  @param string Value ist der text der auf dem button steht
 *  @param string type der button typ  z.B. submit, button, reset
 *  @param string Style gibt die css klasse an wenn gezeichnet class="eingegebenen style"
 *	
 */

function buttonControl(Id,Name,Value,Type,Style)
{
	this.Name=Name;
	this.Id=Id;
	this.Value=Value;
	this.Style=Style;
	this.Type='';
}
buttonControl.prototype = new IDomainObject()
buttonControl.prototype.Write= function()
{
	return '<div id="div_'+this.Id+'"><div><input type="'+this.Type+'" name="'+this.Name+'" id="'+this.Id+'" value="'+this.Value+'" class="'+this.Style+'" ></input></div></div>';

}
buttonControl.prototype.validate = function()
{
 return true;
}


 /**
 *  klasse deleteButtonControl
 *  erstellt einen lösch button
 *
 *  @param int Id
 *  @param string Name
 *  @param string Value				ist der text der auf dem button steht
 *  @param string Style				gibt die css klasse an wenn gezeichnet class="eingegebenen style"
 *  @param string CollectionName	der name der instance woraus ein element gelöscht werden soll
 *  @param int ControlID			die eindeutige id des zu löschenden 
 *  @param DynamycForm FormName		der name des forms worin die änderung vorgenommen wurde wird benötigt um das form neu zu schreiben
 *	
 */


function deleteButtonControl(Id,Name,Value,Style,CollectionName,ControlID,FormName)
{
	this.Name=Name;
	this.Id=Id;
	this.Value=Value;
	this.Style=Style;
	this.Type='Button';
	this.CollectionName=CollectionName;
	this.ControlID=ControlID;   // ist die id wird inerhalb des Controls array gesucht 
	this.FormName=FormName; // wird gebraucht um die form neu zu schreiben
	//this.constructor(Id,Name,Value,this.Type,'');
	
	
}
deleteButtonControl.prototype = new buttonControl()
deleteButtonControl.prototype.Write= function()
{
	var Event = 'onclick="';
      Event += this.CollectionName+'.DeleteOneElement('+this.ControlID+','+this.FormName+')"';

	return '<div id="div_'+this.Id+'"><div><input type="'+this.Type+'" name="'+this.Name+'" id="'+this.Id+'" value="'+this.Value+'" class="'+this.Style+'" '+Event+' ></input></div></div>';

}
deleteButtonControl.prototype.CheckValidate = function()
{   
	return true;
}


/*
* class hiddenControl
*	erstellt ein hidden input feld
*
*	@param int Id				die eindeutige ID der Textarea
*	@param string Name			der name des inputfeldes
*	@param string Value			der wert der in dem input feld stehen soll

*	return string 
*/


hiddenControl = function(Id,Name,Value)
{
	this.Type="hidden";  // kleinschreibung bitte
	this.Format='';
	this.Name=Name;
	this.Text='';
	this.Id=Id;
	this.Value=Value;
	this.Description= '';	
	this.Readonly=false;
	//this.constructor(Id,Name,Description,Format,Type,Style);
}
hiddenControl.prototype = new BaseControl()
{
}
hiddenControl.prototype.Insert = function()
{
	return false;
}
hiddenControl.prototype.CheckValidate = function()
{
        	    return true;
}



