<?php

class TextParser
{
	
	public static function ParsNewLine($Text)
	{
		return 	str_replace("\n", "<br />", $Text);
	}	
	
	
}

?>