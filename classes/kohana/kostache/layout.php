<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Kostache_Layout extends Kostache {

	/**
	 * @var  string  partial name for content
	 */
	const CONTENT_PARTIAL = 'content';

	/**
	 * @var  string  layout path
	 */
	protected $_layout = 'layout';

	public function render()
	{
		if ( ! $this->_layout)
		{
			return parent::render();
		}

		$partials = $this->_partials;

		$partials[Kostache_Layout::CONTENT_PARTIAL] = $this->_template;

		$template = $this->_load($this->_layout);

		return $this->_stash($template, $this, $partials)->render();
	}

}
