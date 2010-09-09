<?php defined('SYSPATH') or die('No direct script access.');

class View_Kohana_Layout extends Kostache
{
	protected $_layout = 'layout';

	/**
	 * @var string template title
	 */
	public $title = 'Brought to you by KOstache!';

	/**
	 * Put contents into this layout
	 */
	public function after($rendered_string)
	{
		if ($this->_layout === NULL)
			return $rendered_string;

		// Add body as a property
		$this->body = $rendered_string;

		// Put this class into a layout view
		$layout = new Kostache($this->_layout, $this);

		return $layout->render();
	}
} // End View_Layout
