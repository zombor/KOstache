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
	 * @var  boolean  render template in layout?
	 */
	public $render_layout = TRUE;

	/**
	 * @var  string  layout path
	 */
	protected $_layout = 'layout';

	public function render($class, $template = NULL)
	{
		if ( ! $this->render_layout)
		{
			return parent::render($class, $template);
		}

		$this->_engine->setPartials(
			array(
				Kostache_Layout::CONTENT_PARTIAL => parent::render($class, $template)
			)
		);

		return $this->_engine->loadTemplate($this->_layout)->render($class);
	}

}
