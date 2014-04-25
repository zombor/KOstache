<?php defined('SYSPATH') or die('No direct script access.');

// Load Mustache for PHP
if ( ! class_exists('Mustache_Engine')) {
	include Kohana::find_file('vendor', 'mustache/src/Mustache/Autoloader');
	Mustache_Autoloader::register();
}
