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
		$this->_partials+=array(
			'body' => $this->_template
		);

		// Make the layout view the child class's template
		$this->_template = file_get_contents(Kohana::find_file('templates', $this->_layout, 'mustache'));

		return parent::render($template, $view, $partials);
	}

} // End View_Layout