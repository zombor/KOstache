KOstache
============

KOstache is a kohana module for using [Mustache](http://defunkt.github.com/mustache/) templates in your application.

Mustache is a logic-less template class. It is impossible to embed logic into mustache files.

Usage & Simple Example
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

Complex Example
-----

Model (This example uses [AutoModeler](http://github.com/zombor/Auto-Modeler)):

	<?php

	class Model_Test extends AutoModeler
	{
		protected $_table_name = 'tests';

		protected $_data = array(
			'id' => '',
			'name' => '',
			'value' => '',
		);

		protected $_rules = array(
			'name' => array('not_empty'),
			'value' => array('not_empty'),
		);
	}

View:

	<?php

	class View_Example extends Kostache
	{
		public $title = 'Testing';

		public function things()
		{
			return Inflector::plural(get_class(new Model_Test));
		}

		public function tests()
		{
			$tests = array();
			foreach (AutoModeler::factory('test')->fetch_all() as $test)
			{
				$tests[] = $test->as_array();
			}
			return $tests;
		}
	}

Template:

	<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8" />
			<title>{{title}}</title>
		</head>
		<body>
			<h1>{{title}}</h1>
			<p>Here are all my {{things}}:</p>
			<ul>
				{{#tests}}
				<li><strong>{{id}}:</strong> ({{name}}:{{value}})</li>
				{{/tests}}
			</ul>
		</body>
	</html>

Controller:

	<?php

	class Controller_Welcome extends Controller {

		public function action_index()
		{
			echo new View_Example;
		}

	} // End Welcome

Grabbing a single model value
-----

Model (This example uses [AutoModeler](http://github.com/zombor/Auto-Modeler)):

	<?php

	class Model_Test extends AutoModeler
	{
		protected $_table_name = 'tests';

		protected $_data = array(
			'id' => '',
			'name' => '',
			'value' => '',
		);

		protected $_rules = array(
			'name' => array('not_empty'),
			'value' => array('not_empty'),
		);
	}

View:

	<?php

	class View_Singular extends Kostache
	{
		protected $_pragmas = array(Kostache::PRAGMA_DOT_NOTATION => TRUE);

		public $thing_id = NULL;
		public $title = 'Testing';

		public function thing()
		{
			return new Model_Test($this->thing_id);
		}
	}

Template:

	<!DOCTYPE html>
	<html lang="en">
		<head>
			<meta charset="utf-8" />
			<title>{{title}}</title>
		</head>
		<body>
			<h1>{{title}}</h1>
			<p>This is just one thing:</p>
			<h2>{{thing.id}}</h2>
			<ul>
				<li>Name: {{thing.name}}</li>
				<li>Value: {{thing.value}}</li>
			</ul>
		</body>
	</html>

Controller:

	<?php defined('SYSPATH') or die('No direct script access.');

	class Controller_Welcome extends Controller {

		public function action_singular($id)
		{
			$view = new View_Singular;
			$view->thing_id = $id;
			echo $view;
		}
	} // End Welcome

Using the View_Layout class
---

KOstache comes with a View_Layout class instead of a template controller. This allows your layouts to be more OOP and self contained, and they do not rely on your controllers so much.

To use it, have your view extend the View_Layout class. You can then specify your own layout file by placing it in templates/layout.mustache. At a minimum, it needs to have a {{>body}} partial defined in it.

For specific usage and documentation, see:

[PHP Mustache](http://github.com/bobthecow/mustache.php)

[Original Mustache](http://defunkt.github.com/mustache/)