<?php

class Kostache extends Mustache
{
	public static function factory($path, $template = null, $view = null, $partials = null)
	{
		$class = 'View_'.str_replace('/', '_', $path);
		return new $class($template, $view, $partials);
	}

	public function __construct($template = null, $view = null, $partials = null)
	{
		parent::__construct($template, $view, $partials);

		$this->_charset = Kohana::$charset;

		// Override the template location to match kohana's conventions
		if ( ! $this->_template)
		{
			$foo = explode('_', get_class($this));
			array_shift($foo);
			$view_location = strtolower(implode('/', $foo));
		}
		else
		{
			$view_location = $this->_template;
		}

		$template = Kohana::find_file('templates', $view_location, 'mustache');

		if ($template)
			$this->_template = file_get_contents($template);
		else
			throw new Kohana_Exception('Template file not found: templates/'.$view_location);
	}
}