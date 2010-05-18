<?php

class View_Singular extends Kostache
{
	protected $_pragmas = array(Kostache::PRAGMA_DOT_NOTATION => TRUE);

	public $thing_id = NULL;
	public $title = 'Testing';

	public function thing()
	{
		return new Model_Test($this->thing_id);
	}
}