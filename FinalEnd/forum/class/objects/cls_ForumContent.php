<?php


class ForumContent extends ParseAbleObject implements i_CollectionElement
{
	Private $Id;
	private $ThreadId;
	private $User;
	private $Content;
	private $CreateDate;
	
	
	function __construct($Id,$ThreadId,User $User,$Content,$CreateDate) 
	{
		$this->Id=$Id;
		$this->ThreadId=$ThreadId;
		$this->User=$User;
		$this->Content=$Content;
		$this->CreateDate=$CreateDate;
	}
	
	public static function getEmptyInstance()
	{
		return new ForumContent(0,0,User::getEmptyInstance(),"","");
	}
	
	
	public function getId()
	{
		return $this->Id;	
	}
	
	public function getThreadId()
	{
		return $this->ThreadId;	
	}
	
	/**
	 * gibt den ersteller des beitrags zurück
	 *
	 * @return User 
	 *
	 */
	public function getUser()
	{
		return $this->User;	
	}
	
	public function getContent()
	{
		return $this->Content;	
	}
	
	public function getCreateDate()
	{
		if($this->CreateDate==""){return "00.00.0000 00:00:00";}
		$TempString=explode(" ",$this->CreateDate);
		$Time=$TempString[1];
		$Date=$TempString[0];
		$TempDate= explode("-",$Date);
		return $TempDate[2].".".$TempDate[1].".".$TempDate[0]." ".$Time;	
	}
	
	
	/**
	 * prüft ob das aktuelle element neuer als das übergebene element ist
	 *
	 * @param ForumContent $ForumContent 
	 * @return bool 
	 *
	 */
	public function isThisDateNewer(ForumContent $ForumContent)
	{
		if($this->getCreateDate()==""){return true;}
		if($ForumContent->getCreateDate()==""){return false;}
		$ThisDate=$this->getCreateDate();
		$ElementDate=$ForumContent->getCreateDate();
		
		$ThisDateTemp=explode(" ",$ThisDate);
		$ThisDateTemp2=explode(".",$ThisDateTemp[0]);
		$ThisDateTemp3=explode(":",$ThisDateTemp[1]);
		
		$ElementDateTemp=explode(" ",$ElementDate);
		$ElementDateTemp2=explode(".",$ElementDateTemp[0]);
		$ElementDateTemp3=explode(":",$ElementDateTemp[1]);

		if($ThisDateTemp2[2]<$ElementDateTemp2[2])
		{
			return true;	
		}
		if($ThisDateTemp2[1]<$ElementDateTemp2[1] && $ThisDateTemp2[2]<=$ElementDateTemp2[2])
		{
			return true;	
		}
		if($ThisDateTemp2[0]<$ElementDateTemp2[0] && $ThisDateTemp2[1]<=$ElementDateTemp2[1] && $ThisDateTemp2[2]<=$ElementDateTemp2[2])
		{
			return true;	
		}
		if($ThisDateTemp3[2]<$ElementDateTemp3[2] && $ThisDateTemp2[0]<=$ElementDateTemp2[0] && $ThisDateTemp2[1]<=$ElementDateTemp2[1] && $ThisDateTemp2[2]<=$ElementDateTemp2[2])
		{
			return true;	
		}
		
		if($ThisDateTemp3[1]<$ElementDateTemp3[1] && $ThisDateTemp3[2]<=$ElementDateTemp3[2] && $ThisDateTemp2[0]<=$ElementDateTemp2[0] && $ThisDateTemp2[1]<=$ElementDateTemp2[1] && $ThisDateTemp2[2]<=$ElementDateTemp2[2])
		{
			return true;	
		}
		
		if($ThisDateTemp3[0]<$ElementDateTemp3[0] && $ThisDateTemp3[1]<=$ElementDateTemp3[1] && $ThisDateTemp3[2]<=$ElementDateTemp3[2] && $ThisDateTemp2[0]<=$ElementDateTemp2[0] && $ThisDateTemp2[1]<=$ElementDateTemp2[1] && $ThisDateTemp2[2]<=$ElementDateTemp2[2])
		{
			return true;	
		} 
		return false;
	}
	
	/**
	 *  parst smiles tabs und alles andere aus den beiträgen
	 *
	 * @return void 
	 *
	 */
	public function Parse()
	{
		$this->Content=$this->parseAll($this->Content);
	}
	
}

?>