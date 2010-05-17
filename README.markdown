KOstache
============

KOstache is a kohana module for using [Mustache](http://defunkt.github.com/mustache/) templates in your application.

Mustache is a logic-less template class. It is impossible to embed logic into mustache files.

Usage
-----

View classes go in classes/view/

classes/view/example.php

	<?php

	class View_Example extends Kostache
	{
		public $foo = 'bar';
	}

Template files go in templates/

templates/example.mustache

	This is a {{foo}}

In your controller, just do:

	$view = new View_Example;
	echo $view;

And you get:

	"This is a bar"

For specific usage and documentation, see 

[PHP Mustache](http://github.com/bobthecow/mustache.php)

[Original Mustache](http://defunkt.github.com/mustache/)