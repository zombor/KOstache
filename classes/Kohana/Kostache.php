<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mustache templates for Kohana.
 *
 * @package    Kostache
 * @category   Base
 * @author     Jeremy Bush <jeremy.bush@kohanaframework.org>
 * @author     Woody Gilk <woody.gilk@kohanaframework.org>
 * @copyright  (c) 2010-2012 Jeremy Bush
 * @copyright  (c) 2011-2012 Woody Gilk
 * @license    MIT
 */
abstract class Kohana_Kostache {

	const VERSION = '4.0.0';

	public static function engine($template_name)
	{
		$m = new Mustache_Engine(
			array(
				'loader' => new Mustache_Loader_Kohana(),
				'partials_loader' => new Mustache_Loader_Kohana('templates/partials'),
				'escape' => function($value) {
					return html::chars($value);
				},
			)
		);

		return $m->loadTemplate($template_name);
	}
}
