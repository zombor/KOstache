# Kostache Examples

## Complex Example

Model (This example uses [AutoModeler](http://github.com/zombor/Auto-Modeler)):

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

	class Controller_Welcome extends Controller {

		public function action_index()
		{
			echo new View_Example;
		}

	} // End Welcome

## Grabbing a single model value

Model (This example uses [AutoModeler](http://github.com/zombor/Auto-Modeler)):

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

	class Controller_Welcome extends Controller {

		public function action_singular($id)
		{
			$view = new View_Singular;
			$view->thing_id = $id;
			echo $view;
		}
	} // End Welcome
