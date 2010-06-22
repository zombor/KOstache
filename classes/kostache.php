<?php

class Kostache extends Mustache
{
	public static function factory($path, $template = null, $view = null, $partials = null)
	{
		$class = 'View_'.str_replace('/', '_', $path);
		return new $class($template, $view, $partials);
	}

	public function __construct($template = null, $view = null, $partials = null)
	{
		parent::__construct($template, $view, $partials);

		$this->_charset = Kohana::$charset;

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

		$template = Kohana::find_file('templates', $view_location, 'mustache');

		if ($template)
			$this->_template = file_get_contents($template);
		else
			throw new Kohana_Exception('Template file not found: templates/'.$view_location);
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
}
