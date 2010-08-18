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
		// Override the template location to match kohana's conventions
		if ( ! $this->_template)
		{
			$foo = explode('_', get_class($this));
			array_shift($foo);
			$this->_template = strtolower(implode(DIRECTORY_SEPARATOR, $foo));
		}

		$this->_partials+=array(
			'body' => $this->_template
		);

		// Make the layout view the child class's template
		$this->_template = $this->_layout;

		return parent::render($template, $view, $partials);
	}

} // End View_Layout
