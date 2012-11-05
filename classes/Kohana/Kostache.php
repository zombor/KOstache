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
class Kohana_Kostache {

	const VERSION = '4.0.0';

	protected $_engine;

	public static function factory()
	{
		$m = new Mustache_Engine(
			array(
				'loader' => new Mustache_Loader_Kohana(),
				'partials_loader' => new Mustache_Loader_Kohana('templates/partials'),
				'escape' => function($value) {
					return HTML::chars($value);
				},
				'cache' => APPPATH.'cache/mustache',
			)
		);

		$class = get_called_class();
		return new $class($m);
	}

	public function __construct($engine)
	{
		$this->_engine = $engine;
	}

	public function render($class, $template = NULL)
	{
		if ($template == NULL)
		{
			$template = explode('_', get_class($class));
			array_shift($template);
			$template = implode('/', $template);
		}

		return $this->_engine->loadTemplate($template)->render($class);
	}
}
