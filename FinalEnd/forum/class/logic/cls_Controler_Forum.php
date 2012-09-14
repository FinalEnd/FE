<?php

class Controler_Forum
{
	private $TempString;
	
	
	private $CommentsPerPage;
	
	
	/**
	 * cls_Controler_Gbook constructor
	 *
	 * @param 
	 */
	function __construct() 
	{
		$this->CommentsPerPage=FORUM_COMMENTS_PER_PAGE;
		if(!is_int($this->CommentsPerPage))
		{
			$this->CommentsPerPage=30;
		}
	}
	
	
	public function start()
	{
		$Request= new Request();
		switch($Request->getAsString('Action'))
		{
			case "ShowSearch":
			{
				$this->showSearch();
			}break;
			
			case "UpdateComment":
			{
				$this->updateComment();
			}break;
			
			case "ShowContentWorkOn":
			{
				$this->showContentWorkOn();
			}break;
			
			case "DeleteContent":
			{
				$this->deleteContent();
			}break;
			
			case "DeleteThread":
			{
				$this->deleteThread();
			}break;
			
			case "ShowCreateThread":
			{
				$this->showCreateThread();
			}break;
			
			case "ShowWorkOnThread":
			{
				$this->showWorkOnThread();
			}break;
			
			case "WorkOnThread":
			{
				$this->workOnThread();
			}break;
			
			case "AddComment":
			{
				$this->addComment();
			}break;
			case "ShowThreadContent":
			{
				$this->showThreadContent();
			}break;
			case "CreateThread":
			{
				$this->createThread();
			}break;
			case "upThread":
			{
				$this->upThread();
			}break;
			
			case "downThread":
			{
				$this->downThread();
			}break;		
			default:
				$this->showThreads();	
		}
	}
	
	private function updateComment()
	{
		$Request= new Request();
		$ContentId=$Request->getAsInt("ContentId");
		$ThreadId=$Request->getAsInt("ThreadId");
		$ForumContentFinder= new ForumContentFinder();
		$ForumComment=$ForumContentFinder->findById($ContentId);
		$User= Controler_Main::getInstance()->getUser();
		$ForumContentManager= new ForumContentManager();
		$ForumContent= new ForumContent($ContentId,$ThreadId,$ForumComment->getUser(),$Request->getAsString("rtb_Comment"),"");
		if(!$User->check(0))
		{
			$this->showThreads();
			return false;
		}
		
		if(!$User->check(10))
		{
			if($ForumComment->getUser()->getId()!= $User->getId() || $ForumComment->getId()==0)
			{
				$this->showThreads();
				return false;
			}
		}
		
		
		$ForumContentManager->updateContent($ForumContent);
		$this->showThreadContent();
		
	}
	
	
	private function showSearch()
	{
		// findet auch beiträge die nicht gefunden werden dürfen -> benutzer level
		$Request= new Request();
		$Template= Template::getInstance("tpl_ForumSearch.php");
		$Template->assign("ForumContentCollection",new ForumContentCollection());
		if($Request->getAsString("tb_Search"))
		{
			// Collection suchen
			$ForumContentFinder= new ForumContentFinder();
			$TempCollection=$ForumContentFinder->findByContent($Request->getAsString("tb_Search"));
			$TempCollection->parse();
			$Template->assign("ForumContentCollection",$TempCollection);
		}
		$Template->render();
	}
	
	
	
	private function showContentWorkOn()
	{
		$Request= new Request();
		$ContentId=$Request->getAsInt("ContentId");
		$ThreadId=$Request->getAsInt("ThreadId");
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThread=$ForumThreadFinder->findById($ThreadId);
		$ForumContentFinder= new ForumContentFinder();
		$ForumComment=$ForumContentFinder->findById($ContentId);
		$User= Controler_Main::getInstance()->getUser();
		
		if(!$User->check(0))
		{
			$this->showThreadContent();
			return false;
		}
		
		if(!$User->check(10))
		{
			if($ForumComment->getUser()->getId()!= $User->getId() || $ForumComment->getId()==0)
			{
				$this->showThreadContent();
				return false;
			}
		}

		$Template= Template::getInstance("tpl_ForumContentWorkOn.php");
		$Template->assign("IsAdmin",$User->check(10));
		$Template->assign("User",$User);
		$Template->assign("ThreadId",$ThreadId);
		$Template->assign("ContentId",$ContentId);
		$Template->assign("ForumComment",$ForumComment);
		$Template->render();
		
	}
	
	private function deleteContent()
	{
		$User= Controler_Main::getInstance()->getUser();
		if(!$User->check(10))
		{
			$this->showThreadContent();
			return false;
		}
		$Request = new Request();
		$ForumManager= new ForumThreadManager();
		$ForumContentManager= new ForumContentManager();
		$ThreadId=$Request->getAsInt("ThreadId");
		$ContentId=$Request->getAsInt("ContentId");
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThread=$ForumThreadFinder->findById($ThreadId);
		$ForumContentManager->deleteById($ContentId);
		$Request->setPost("ThreadId",$ForumThread->getThreadId());
		$this->showThreads();
	}
	
	
	
	private function deleteThread()
	{
		$User= Controler_Main::getInstance()->getUser();
		if(!$User->check(10))
		{
			$this->showThreads();
			return false;
		}
		$Request = new Request();
		$ForumManager= new ForumThreadManager();
		$ForumContentManager= new ForumContentManager();
		$ThreadId=$Request->getAsInt("ThreadId");
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThread=$ForumThreadFinder->findById($ThreadId);
		if($ForumThread->getSubThreadCount()>0)
		{
			$Template= Template::getInstance("tpl_Forum.php");
			$Template->renderError("Beim Löschen des Threads","Solange dieser Thread Unterknoten enthät kann der Thread nicht gelöscht werden","index.php?section=Forum&ThreadId=".$ThreadId);
			return false;
		}
		$ForumManager->deleteThreadById($ThreadId);
		$ForumContentManager->deleteThreadById($ThreadId);
		$Request->setPost("ThreadId",$ForumThread->getThreadId());
		$this->showThreads();
	}

	private function createThread()
	{
		$User= Controler_Main::getInstance()->getUser();
		if(!$User->check(0))
		{
			$this->showThreads();
			return false;
		}
		$Request = new Request();
		$IsStruct=0;
		$Modus=0;
		if ($User->check(10))
		{
			$IsStruct=$Request->getAsInt("cb_Struct");
			$Modus=$Request->getAsInt("cb_Modus");
		}

		if(!$Request->getAsString("tb_Name") || !$Request->getAsString("rtb_Content"))
	    {
			$ErrorString="Der Thread konnte nicht angelegt werden.<br />";
			if(!$Request->getAsString("tb_Name"))
			$ErrorString.="Der Name des Threads wurde nicht angegeben.<br />";
			if(!$Request->getAsString("rtb_Content"))
			$ErrorString.="Ihr beitrag ist zu kurz.<br />";
			$this->showThreads($ErrorString);
			return false;
		}



		$FroumThread= new ForumThread(0,$Request->getAsString("tb_Name"),$Request->getAsInt("ThreadId"),$Request->getAsString("tb_Description"),"",$User,$Modus,0,new ForumContentCollection(),$IsStruct,0,0, new ForumContent(0,0,new User(0,"","","",""),"",""));
		$ForumManager= new ForumThreadManager();
		$ForumManager->insertThread($FroumThread);
		$ThreadId=$ForumManager->getLasId();
		$ForumContentManager= new ForumContentManager();
		if (!$IsStruct)
		{
			// comment eintragen
			$ForumContent= new ForumContent(0,$ThreadId,$User,$Request->getAsString("rtb_Content"),"");
			$ForumContentManager->insertContent($ForumContent);
			$Request->setPost("ThreadId",$ThreadId);
			$this->showThreadContent();
			return true;
		}
		$Request->setPost("ThreadId",$Request->getAsInt("ThreadId"));
		$this->showThreads();
	}
	
	private function showWorkOnThread()
	{
		$User= Controler_Main::getInstance()->getUser();
		if(!$User->check(10))
		{
			$this->showThreads();
			return false;
		}
		$Request = new Request();
		$ThreadId=$Request->getAsInt("ThreadId");
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThread=$ForumThreadFinder->findById($ThreadId);
		$Template= Template::getInstance("tpl_ForumWorkOnThread.php");
		$Template->assign("ThreadId",$ThreadId);
		$Template->assign("Thread",$ForumThread);
		$Template->render();
	}
	
	private function workOnThread()
	{
		$User= Controler_Main::getInstance()->getUser();
		if(!$User->check(10))
		{
			$this->showThreads();
			return false;
		}
		$Request = new Request();
		$ThreadId=$Request->getAsInt("ThreadId");
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThread=$ForumThreadFinder->findById($ThreadId);
		$ThreadManager= new ForumThreadManager();
		$ForumThread->setDescription($Request->getAsString("tb_Description"));
		$ForumThread->setName($Request->getAsString("tb_Name"));
		$ForumThread->setModus($Request->getAsString("cb_Modus"));
		$ThreadManager->updateThread($ForumThread);
		$_POST['ThreadId']=$ForumThread->getThreadId();
		$this->showThreads();
	}
	
	
	
	/**
	 * gibt die pfad angabe des jeweiligen threads zurück
	 *
	 * @param int $ThreadId 
	 * @return string 
	 *
	 */
	private function getPathString($ThreadId)
	{
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThread=$ForumThreadFinder->findById($ThreadId);
		if ($ThreadId===0 || $ForumThread==null)
		{
			$FinalString = "";
			$FinalString = "<a href='index.php?section=Forum&amp;ThreadId=0'>".FORUM_PATH_NAME."</a>".$this->TempString;
			$this->TempString="";
			return $FinalString;
		}
		
		if($ForumThread->IsStruct())
		{
			$this->TempString=" >> <a href='index.php?section=Forum&amp;ThreadId=".$ForumThread->getId()."'>".$ForumThread->getName()."</a>".$this->TempString;
		}else
		{
			$this->TempString=" >> <a href='index.php?section=Forum&amp;Action=ShowThreadContent&amp;ThreadId=".$ForumThread->getId()."'>".$ForumThread->getName()."</a>".$this->TempString;
		}
		
		
		return $this->getPathString($ForumThread->getThreadId());
	}
	
	private function addComment()
	{
		$Request= new Request();
		$User= Controler_Main::getInstance()->getUser();
		if(!$User->check(0))
		{
			$ErrorString="Der Beitrag konnte nicht eingetragen werden.";
			$Template->assign("ThreadId",0);
			$this->showThreads($ErrorString);
			return false;
		}
		if(strlen($Request->getAsString("rtb_Comment"))==0)
		{
			$ErrorString="Der Beitrag ist zu kurz und konnte nicht eingetragen werden.";
			$this->showThreadContent($ErrorString);
			return false;
		}
		
		
		$ThreadId=$Request->getAsInt("ThreadId");
		$Comment=$Request->getAsString("rtb_Comment");
		$ForumContent= new ForumContent(0,$ThreadId,$User,$Comment,"");
		$ForumContentManager= new ForumContentManager();
		$ForumContentManager->insertContent($ForumContent);
		$Request->setPost("ThreadId",$ThreadId);
		$this->showThreadContent();
		return true;
		
	}
	
	private function showCreateThread()
	{
		$Request= new Request();
		$ThreadId=$Request->getAsInt("ThreadId");
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThread=$ForumThreadFinder->findById($ThreadId);
		$User= Controler_Main::getInstance()->getUser();
		
		if(!$User->check(0))
		{
			$this->showThreads();
			return false;
		}
		
		if($ForumThread->getModus()=="2" && $ForumThread->getModus()=="4" && $ForumThread->getModus()=="4" && $ForumThread->getModus()=="5" && $ForumThread->getModus()=="6" && !$User->check(10))
		{
			$this->showThreads();
			return false;
		}
		$Template= Template::getInstance("tpl_ForumCreateThread.php");
		$Template->assign("IsAdmin",$User->check(10));
		$Template->assign("User",$User);
		$Template->assign("ThreadId",$ThreadId);
		$Template->render();
	}

	private function getPageString($Max,$Have,$Is,$ThreadId)
	{
		if($Have==0){return "";}
		if($Max==0){return "";}
		$Sides=(int) $Have/$Max;
		$Sides=$Sides+0.999999999;
		settype($Sides,"integer");
		$TempString="";
		for($i=1;$i<$Sides+1;$i++)
		{
			if($i==$Sides && $i==1)
			{
				$TempString.="<a href='index.php?section=Forum&amp;Action=ShowThreadContent&amp;ThreadId=".$ThreadId."&amp;i_Page=".($i-1)."'>1</a> ";
				return $TempString;
			}
			if($i==$Sides)
			{
				$TempString.="<a href='index.php?section=Forum&amp;Action=ShowThreadContent&amp;ThreadId=".$ThreadId."&amp;i_Page=".($i-1)."'>Letzte</a> ";
				return $TempString;
			}
			if($i>5)
			{
				continue;
			}
			$TempString.="<a href='index.php?section=Forum&amp;Action=ShowThreadContent&amp;ThreadId=".$ThreadId."&amp;i_Page=".($i-1)."'>".$i."</a> ";
		}
		
		return "";
	}



	/**
	 * wenn ein Thread dierekt angesehen werden soll
	 *
	 * @return void grafik ausgabe
	 *
	 */
	private function showThreadContent()
	{
		$Request= new Request();
		$ThreadId=$Request->getAsInt("ThreadId");
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThread=$ForumThreadFinder->findById($ThreadId,$Request->getAsInt("i_Page")*$this->CommentsPerPage,$this->CommentsPerPage);
		$ForumManager= new ForumThreadManager();
		$ForumManager->incrementViewById($ThreadId);
		$ForumThread->parse();
		if($ForumThread->getModus()>=6 && !$User->check(ADMIN_LEVEL))
		{
			$Request->setPost("ThreadId",0);
			$this->showThreads();
			return false;	
		}
		
		$User= Controler_Main::getInstance()->getUser();
		$Template= Template::getInstance("tpl_ForumThreadContent.php");
		$ForumContentFinder= new ForumContentFinder();
		$CommentHave=$ForumContentFinder->countAllByThreadID($ThreadId);
		
		$Template->assign("PageString",$this->getPageString($this->CommentsPerPage,$CommentHave,$Request->getAsInt("i_Page"),$ThreadId));
		$Template->assign("User",$User);
		$Template->assign("ThreadId",$ThreadId);
		$Template->assign("Thread",$ForumThread);
		//$TempString=$this->getPathString($ThreadId);
		$Template->assign("Path",$this->getPathString($ThreadId));
		
		$MainControler=Controler_Main::getInstance();
		
		if($User->check(ADMIN_LEVEL))
		{
			$Template->assign("Admin",true);
			$Template->assign("Write",true);
		}
		if($User->check(USER_LEVEL) && $ForumThread->getModus()==0 || $User->check(USER_LEVEL) && $ForumThread->getModus()==3)
		{
			// hier müsste noch auf letzte seite gecheckt werden darf nur auf der letzten seite weiter geschrieben werden
			$Template->assign("Write",true);
		}
		if(!$User->isPremium())
		{
			$Template->assign("Add",true);
		}
		$Template->render();
	}
	
	/**
	 * start function für das forum 
	 *
	 * @return mixed This is the return value description
	 *
	 */
	private function showThreads($ErrorString="")
	{
		$Request= new Request();
		$ThreadId=$Request->getAsInt("ThreadId");
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThreadCollection=$ForumThreadFinder->findByThreadId($ThreadId);
		$ForumManager= new ForumThreadManager();
		$ForumManager->incrementViewById($ThreadId);
		$User= Controler_Main::getInstance()->getUser();
		$Template= Template::getInstance("tpl_Forum.php");
		
		$Template->assign("User",$User);
		$Template->assign("ThreadId",$ThreadId);
		$Template->assign("ErrorString",$ErrorString);
		if($ThreadId==0)
		{
			$Collection=$ForumThreadFinder->findFiveLastComentet();
			//var_dump($Collection);
			$Template->assign("ThreadCollectionLastCommented",$Collection);
			$Template->assign("ThreadCollectionLastCommentedShow",true);
		}
		$ForumThreadCollection->setShowRigths($User);
		$Template->assign("ThreadCollection",$ForumThreadCollection);
		$Template->assign("Path",$this->getPathString($ThreadId));
		$ForumThread=$ForumThreadFinder->findById($ThreadId);
		
		if($User->check(USER_LEVEL) && $ForumThread->getModus()==0 || $User->check(USER_LEVEL) && $ForumThread->getModus()==3)
		{
			$Template->assign("CanCreate",true);
		}
		
		if($User->check(ADMIN_LEVEL))
		{
			$Template->assign("CanDelete",true);
			$Template->assign("CanWorkOn",true);
			$Template->assign("CanCreate",true);
		}  
		
		
		if($ForumThread->IsStruct()==1)
		{
			$Template->assign("ThreadsView","Themen");
			$Template->assign("ThreadsViewCount",$ForumThread->getSubThreadCount());
		}else
		{
			$Template->assign("ThreadsView","View");
			$Template->assign("ThreadsViewCount",$ForumThread->getViews());
		}
		$Template->render();		
	}
	
	
	
	/**
	 * setzt den thread eine stufe nach oben
	 *
	 * @return viod This is the return value description
	 *
	 */
	private function upThread()
	{
		$User= Controler_Main::getInstance()->getUser();
		if(!$User->check(10))
		{
			$this->showThreads();
			return false;
		}
		$Request = new Request();
		$ForumManager= new ForumThreadManager();
		$ForumContentManager= new ForumContentManager();
		$ForumThreadManager= new ForumThreadManager();
		$ThreadId=$Request->getAsInt("ThreadId");
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThread=$ForumThreadFinder->findById($ThreadId);
		//$ForumManager->setThreadUpById($ThreadId);
		$HighestForumThread=$ForumThreadFinder->findHighestThread($ForumThread->getThreadId());
		if($ForumThread->getId()!=$HighestForumThread->getId())// prüfen ob der thread nach oben gesetzt werden kann
		{
			//  vertauschen
			$TempThread=$ForumThreadFinder->findThreadByThreadIdAndSort($ForumThread->getThreadId(),$ForumThread->getSort()+1);
			$ForumThreadManager->updateSortIndex($ForumThread->getId(),$ForumThread->getSort()+1);
			$ForumThreadManager->updateSortIndex($TempThread->getId(),$ForumThread->getSort());	
		}
		
		$Request->setPost("ThreadId",$ForumThread->getThreadId());
		$this->showThreads();
	}
	
	
	private function downThread()
	{
		$User= Controler_Main::getInstance()->getUser();
		if(!$User->check(10))
		{
			$this->showThreads();
			return false;
		}
		$Request = new Request();
		$ForumManager= new ForumThreadManager();
		$ForumContentManager= new ForumContentManager();
		$ForumThreadManager= new ForumThreadManager();
		$ThreadId=$Request->getAsInt("ThreadId");
		$ForumThreadFinder= new ForumThreadFinder();
		$ForumThread=$ForumThreadFinder->findById($ThreadId);
		
		$LowestForumThread=$ForumThreadFinder->findLowestThread($ForumThread->getThreadId());
		if($ForumThread->getId()!=$LowestForumThread->getId())// prüfen ob der thread nach oben gesetzt werden kann
		{
			//  vertauschen
			$TempThread=$ForumThreadFinder->findThreadByThreadIdAndSort($ForumThread->getThreadId(),$ForumThread->getSort()-1);
			$ForumThreadManager->updateSortIndex($ForumThread->getId(),$ForumThread->getSort()-1);
			$ForumThreadManager->updateSortIndex($TempThread->getId(),$ForumThread->getSort());	
		}
		
			
		$Request->setPost("ThreadId",$ForumThread->getThreadId());
		$this->showThreads();
		
	}
	
}

?>