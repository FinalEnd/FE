<?php 

/**
 * dint zur speicherung einer nachricht von spieler zu speiler
 *
 */
class Message extends ParseAbleObject implements i_CollectionElement
{
	private $Id;
	private $From;
	private $To;
	private $Content;
	private $Header;
	private $Listen;
	private $Date;
	private $FromView;
	private $FromDelete;


	private $ToView;
	private $ToDelete;
	
	public function __construct($Id,$From,$To,$Content,$Header,$Date,$FromView,$FromDelete,$ToView,$ToDelete)
	{
		$this->Id=$Id;
		$this->From=$From;
		$this->To=$To;
		$this->Content=$Content;
		$this->Header=$Header;	
		$this->Listen=$Listen;
		$this->Date=$Date;
		
		$this->FromView=$FromView;
		$this->FromDelete=$FromDelete;
		
		$this->ToView=$ToView;
		$this->ToDelete=$ToDelete;	
	}
	
	public static function getEmptyInstance()
	{
		return new Message(0,"","","","","",0,0,0,0);
	}
	
	
	
	public function getHeader()
	{
		return $this->Header;
	}
	
	public function getTo()
	{
		return $this->To;
	}
	
	
	public function getContent()
	{
		return $this->Content;
	}
	
	public function getFrom()
	{
		return $this->From;
	}
	
	public function getDate()
	{
		return $this->Date;
	}
	
		public function getId()
	{
		return $this->Id;
	}
	
	
	/**
	 * Parst smiles tabulatoren und schlechte wörter aus den nachrichten heraus
	 *
	 */
	public function Parse()
	{
		$this->Content=$this->parseBadWords($this->Content);
		$this->Content=$this->parseBBCode($this->Content);
		$this->Content=$this->parseSmile($this->Content);
		$this->Content=$this->parseTabulators($this->Content);
	}
	
	
	protected function parseTabulators($String)
	{
		if($this->From!="System")
		{
			$String=str_replace("\r\n","<br />",$String);
			$String=str_replace("\n","<br />",$String); 
			
		}
		$String=str_replace("\t","&nbsp;&nbsp;&nbsp;&nbsp;",$String);
		return $String;
	}
	
}





?>