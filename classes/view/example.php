<?php

class View_Example extends Kostache
{
	public $title = 'Testing';

	public function things()
	{
		return Inflector::plural(get_class(new Model_Test));
	}

	public function tests()
	{
		$tests = array();
		foreach (AutoModeler::factory('test')->fetch_all() as $test)
		{
			$tests[] = $test->as_array();
		}
		return $tests;
	}
}