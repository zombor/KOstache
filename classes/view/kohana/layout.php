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
			'body' => $view_location
		);

		return parent::render($template, $view, $partials);
	}

} // End View_Layout