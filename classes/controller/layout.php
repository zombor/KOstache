<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Layout extends Controller {

	/**
	 * @var  string  page layout
	 */
	public $template = 'layout';

	/**
	 * @var  boolean  auto render layout
	 **/
	public $auto_render = TRUE;

	/**
	 * Loads the template [View] object.
	 */
	public function before()
	{
		if ($this->auto_render === TRUE)
		{
			// Load the layout
			$view_class = 'View_'.$this->template;
			$this->template = new $view_class;
		}

		return parent::before();
	}

	/**
	 * Assigns the layout [View] as the request response.
	 */
	public function after()
	{
		if ($this->auto_render === TRUE)
		{
			$this->request->response = $this->template;
		}

		return parent::after();
	}

} // End Controller_Layout
