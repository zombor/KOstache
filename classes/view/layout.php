<?php defined('SYSPATH') or die('No direct script access.');

class View_Layout extends Kostache
{
	const LAYOUT = 'layout';

	/**
	 * @var string template title
	 */
	public $title = 'Brought to you by KOstache!';

	/**
	 * Renders the body template into the layout
	 */
	public function render($template = null, $view = null, $partials = null)
	{
		// Turn the child template into a partial
		$foo = explode('_', get_class($this));
		array_shift($foo);
		$view_location = strtolower(implode('/', $foo));

		$this->_partials+=array(
			'body' => file_get_contents(Kohana::find_file('templates', $view_location, 'mustache'))
		);

		// Make the layout view the child class's template
		$this->_template = file_get_contents(Kohana::find_file('templates', self::LAYOUT, 'mustache'));

		return parent::render($template, $view, $partials);
	}

} // End View_Layout