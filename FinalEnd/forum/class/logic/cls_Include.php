<?php

function __autoload($Class)
{
	$BasicInclueConst =  Basic_include_const::getInstance();
	if (isset($BasicInclueConst->PathArray[$Class]) && file_exists($BasicInclueConst->PathArray[$Class]))
	{
		try {
			require_once($BasicInclueConst->PathArray[$Class]);	
			}
			catch (Exception $e)
			{
			echo "datei konnte nicht gefunden werden ". $Class."<br />der name der Klasse";
			}	
	}else 
	{
		echo "ein include Datei wurde nicht gefunden ". $Class."<br />der name der Klasse";
		
		
		//var_dump($BasicInclueConst);
		
		
		
		//die();
	}

}


 class  Basic_include_const
{
	
	
	public $PathArray=null;
    private static $Instance=null;
	
	
	
	private function __construct()
	{
		$this->createPathArray();
	}
	
	public static function getInstance()
	{
		{
			if(self::$Instance === NULL)
			{
				self::$Instance = new Basic_include_const;
			}

			return self::$Instance;
		}
	}
		
	private function createPathArray()
	{
		
		$this->PathArray['GroupFinder']="class/DatabaseObjects/cls_GroupFinder.php";
		$this->PathArray['Group']='class/objects/cls_Group.php';
		$this->PathArray['GroupCollection']='class/objects/cls_GroupCollection.php';
		
		
		$this->PathArray['i_CollectionElement']='class/objects/i_CollectionElements.php';
		$this->PathArray['Request']='class/logic/cls_Request.php';

		
	 	$this->PathArray['MySqlExeption']='class/db/cls_mysql_exeption.php';
		$this->PathArray['MySqldb']='class/class_db/cls_mysql.php';
		$this->PathArray['Click']='class/objects/cls_Click.php';
		$this->PathArray['ClickManager']='class/DatabaseObjects/cls_ClickManager.php';

		#region User Objekte
		$this->PathArray['User']='class/objects/cls_User.php';

		$this->PathArray['UserCollection']='class/objects/cls_UserCollection.php';
		$this->PathArray['UserFinder']='class/DatabaseObjects/cls_UserFinder.php';
		$this->PathArray['UserManager']='class/DatabaseObjects/cls_UserManager.php';
		#endregion
		
		
		$this->PathArray['Quote']='class/objects/cls_Quote.php';
		$this->PathArray['QuoteFinder']='class/DatabaseObjects/cls_QuoteFinder.php';
		

		$this->PathArray['Controler_Main']='class/logic/cls_Controler_Main.php';
		$this->PathArray['Controler_Login']='class/logic/cls_Controler_Login.php';		
		$this->PathArray['Controler_User']='class/logic/cls_Controler_User.php';	
		$this->PathArray['Controler_Forum']='class/logic/cls_Controler_Forum.php';


		$this->PathArray['ForumThread']='class/objects/cls_ForumThread.php';
		$this->PathArray['ForumThreadCollection']='class/objects/cls_ForumThreadCollection.php';
		$this->PathArray['ForumContent']='class/objects/cls_ForumContent.php';
		$this->PathArray['ForumContentCollection']='class/objects/cls_ForumContentCollection.php';
		$this->PathArray['ForumThreadFinder']='class/DatabaseObjects/cls_ForumThreadFinder.php';
		$this->PathArray['ForumContentFinder']='class/DatabaseObjects/cls_ForumContentFinder.php';
		$this->PathArray['ForumThreadManager']='class/DatabaseObjects/cls_ForumThreadManager.php';
		$this->PathArray['ForumContentManager']='class/DatabaseObjects/cls_ForumContentManager.php';


		$this->PathArray['SystemFinder']='class/DatabaseObjects/cls_SystemFinder.php'; 
		$this->PathArray['SystemManager']='class/DatabaseObjects/cls_SystemManager.php';
		$this->PathArray['Collection']='class/objects/cls_AbstractCollection.php'; 
		$this->PathArray['ParseAbleObject']='class/objects/cls_ParseAbleObject.php'; //parse object
		
		$this->PathArray['Template']='class/objects/cls_Template.php'; 
		$this->PathArray['Date']='class/objects/cls_Date.php';

		
		$this->PathArray['Message']="class/objects/cls_Message.php";
		$this->PathArray['MessageCollection']="class/objects/cls_MessageCollection.php";
		$this->PathArray['MessageFinder']="class/DatabaseObjects/cls_MessageFinder.php";
		$this->PathArray['MessageManager']="class/DatabaseObjects/cls_MessageManager.php";
		
		
		$this->PathArray['NewsCollection']="class/objects/cls_system_NewsCollection.php";
		$this->PathArray['News']="class/objects/cls_system_News.php";
		$this->PathArray['NewsManager']="class/DatabaseObjects/cls_NewsManager.php";
		$this->PathArray['NewsFinder']="class/DatabaseObjects/cls_NewsFinder.php";
		

		 


	}
	
	
	
}

















?>