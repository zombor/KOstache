<?php defined('SYSPATH') or die('No direct script access.');

class View_Kohana_Layout extends Kostache
{
	protected $_layout = 'layout';

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
		// This should change, because if the child changes the template name to a non-standard name, this breaks
		$foo = explode('_', get_class($this));
		array_shift($foo);
		$view_location = strtolower(implode('/', $foo));

		$this->_partials+=array(
			'body' => $view_location
		);

		// Make the layout view the child class's template
		$this->_template = file_get_contents(Kohana::find_file('templates', $this->_layout, 'mustache'));

		return parent::render($template, $view, $partials);
	}

} // End View_Layout