<?php

class InviteCollection extends Collection
{
	public function add(Invite $Invite)
	{
		parent::add($Invite);
	}

	public function getByIndex($Index)
	{
		if ($this->countElements() <= 0)
			return Invite::getEmptyInstance();

		return $this->Elements[$Index];
	}
	
}
?>