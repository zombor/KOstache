<?php

class Kohana_Kostache extends Mustache
{
	const VERSION = 1.3;

	protected $_partials_processed = FALSE;

	/**
	 * KOstache class factory constructor.
	 *
	 * This method accepts a $template string and a $view object. Optionally, pass an associative
	 * array of partials as well.
	 *
	 * @access public
	 * @param string $path the path of the class to load
	 * @param string $template (default: null)
	 * @param mixed $view (default: null)
	 * @param array $partials (default: null)
	 * @return void
	 */
	public static function factory($path, $template = null, $view = null, $partials = null)
	{
		$class = 'View_'.str_replace('/', '_', $path);

		if ( ! class_exists($class))
			throw new Kohana_View_Exception('Missing Kostache View Class for ":class"', array(':class' => $class));

		return new $class($template, $view, $partials);
	}

	/**
	 * KOstache class constructor.
	 *
	 * This method accepts a $template string and a $view object. Optionally, pass an associative
	 * array of partials as well.
	 *
	 * @access public
	 * @param string $template (default: null)
	 * @param mixed $view (default: null)
	 * @param array $partials (default: null)
	 * @return void
	 */
	public function __construct($template = null, $view = null, $partials = null)
	{
		parent::__construct($template, $view, $partials);

		$this->_charset = Kohana::$charset;
	}

	/**
	 * Assigns a variable by name.
	 *
	 *     // This value can be accessed as {{foo}} within the template
	 *     $view->set('foo', 'my value');
	 *
	 * You can also use an array to set several values at once:
	 *
	 *     // Create the values {{food}} and {{beverage}} in the template
	 *     $view->set(array('food' => 'bread', 'beverage' => 'water'));
	 *
	 * @param   string   variable name or an array of variables
	 * @param   mixed    value
	 * @return  $this
	 */
	public function set($key, $value = NULL)
	{
		if (is_array($key))
		{
			foreach ($key as $name => $value)
			{
				$this->{$name} = $value;
			}
		}
		else
		{
			$this->{$key} = $value;
		}

		return $this;
	}

	/**
	 * Assigns a value by reference. The benefit of binding is that values can
	 * be altered without re-setting them. It is also possible to bind variables
	 * before they have values. Assigned values will be available as a
	 * variable within the template file:
	 *
	 *     // This reference can be accessed as {{ref}} within the template
	 *     $view->bind('ref', $bar);
	 *
	 * @param   string   variable name
	 * @param   mixed    referenced variable
	 * @return  $this
	 */
	public function bind($key, & $value)
	{
		$this->{$key} =& $value;

		return $this;
	}

	/**
	 * Magic method, returns the output of [View::render].
	 *
	 * @return  string
	 * @uses    View::render
	 */
	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch (Exception $e)
		{
			// Display the exception message
			Kohana::exception_handler($e);

			return '';
		}
	}

	public function render($template = null, $view = null, $partials = null)
	{
		if (NULL === $template)
		{
			// Override the template location to match kohana's conventions
			if ( ! $this->_template)
			{
				$foo = explode('_', get_class($this));
				array_shift($foo);
				$view_location = strtolower(implode('/', $foo));
			}
			else
			{
				$view_location = $this->_template;
			}

			$this->_template = Kohana::find_file('templates', $view_location, 'mustache');

			if ( ! $this->_template AND ! $template)
				throw new Kohana_Exception('Template file not found: templates/'.$view_location);

			$this->_template = file_get_contents($this->_template);
		}

		// Convert partials to expanded template strings
		if ( ! $this->_partials_processed)
		{
			foreach ($this->_partials as $key => $partial_template)
			{
				if ($location = Kohana::find_file('templates', $partial_template, 'mustache'))
				{
					$this->_partials[$key] = file_get_contents($location);
				}
			}

			$this->_partials_processed = TRUE;
		}

		return parent::render($template, $view, $partials);
	}
}
