<?php

class Mustache_Loader_Kohana implements Mustache_Loader
{
	private $_base_dir = 'templates';
	private $_extension = 'mustache';
	private $_templates = array();

	public function __construct($base_dir = NULL, $options = array())
	{
		if ($base_dir)
			$this->_base_dir = $base_dir;

		if (isset($options['extension']))
		{
			$this->_extension = '.' . ltrim($options['extension'], '.');
		}
	}

	public function load($name)
	{
		if (!isset($this->_templates[$name]))
		{
			$this->_templates[$name] = $this->_load_file($name);
		}

		return $this->_templates[$name];
	}

	protected function _load_file($name)
	{
		$filename = Kohana::find_file($this->_base_dir, $name, $this->_extension);
		return file_get_contents($filename);
	}
}
