<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mustache templates for Kohana.
 *
 * @package    Kostache
 * @category   Base
 * @author     Jeremy Bush <jeremy.bush@kohanaframework.org>
 * @copyright  (c) 2010-2012 Jeremy Bush
 * @license    MIT
 */
class Kohana_Kostache_Layout extends Kohana_Kostache {

	/**
	 * @var  string  partial name for content
	 */
	const CONTENT_PARTIAL = 'content';

	/**
	 * @var  string  layout path
	 */
	protected $_layout = 'layout';

	public static function factory($layout = 'layout')
	{
		$k = parent::factory();
		$k->set_layout($layout);
		return $k;
	}

	public function set_layout($layout)
	{
		$this->_layout = (string) $layout;
	}

	public function render($class, $template = NULL)
	{
		$content = $this->_engine
			->getLoader()
			->load($this->_detect_template_path($class));

		$this->_engine->setPartials(array(
			Kostache_Layout::CONTENT_PARTIAL => $content
		));

		return $this->_engine->loadTemplate($this->_layout)->render($class);
	}

}
