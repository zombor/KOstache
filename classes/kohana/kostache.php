<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mustache templates for Kohana.
 *
 * @package    Kostache
 * @category   Base
 * @author     Jeremy Bush <jeremy.bush@kohanaframework.org>
 * @author     Woody Gilk <woody.gilk@kohanaframework.org>
 * @copyright  (c) 2010-2011 Jeremy Bush
 * @copyright  (c) 2011 Woody Gilk
 * @license    MIT
 */
abstract class Kohana_Kostache {

	const VERSION = '2.0.1';

	/**
	 * Factory method for Kostache views. Accepts a template path and an
	 * optional array of partial paths.
	 *
	 * @param   string  template path
	 * @param   array   partial paths
	 * @return  Kostache
	 * @throws  Kohana_Exception  if the view class does not exist
	 */
	public static function factory($template, array $partials = NULL)
	{
		$class = 'View_'.str_replace('/', '_', $template);

		if ( ! class_exists($class))
		{
			throw new Kohana_Exception('View class does not exist: :class', array(
				':class' => $class,
			));
		}

		return new $class($template, $partials);
	}

	/**
	 * @var  string  Mustache template
	 */
	protected $_template;

	/**
	 * @var  array  Mustache partials
	 */
	protected $_partials = array();

	/**
	 * Loads the template and partial paths.
	 *
	 * @param   string  template path
	 * @param   array   partial paths
	 * @return  void
	 * @uses    Kostache::template
	 * @uses    Kostache::partial
	 */
	public function __construct($template = NULL, array $partials = NULL)
	{
		if ( ! $template)
		{
			// Detect the template for this class
			$template = $this->_detect_template();
		}

		// Load the template
		$this->template($template);

		if ($this->_partials)
		{
			foreach ($this->_partials as $name => $path)
			{
				// Load the partials defined in the view
				$this->partial($name, $path);
			}
		}

		if ($partials)
		{
			foreach ($partials as $name => $path)
			{
				// Load the partial
				$this->partial($name, $path);
			}
		}
	}

	/**
	 * Magic method, returns the output of [Kostache::render].
	 *
	 * @return  string
	 * @uses    Kostache::render
	 */
	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch (Exception $e)
		{
			ob_start();

			// Render the exception
			Kohana_Exception::text($e);

			return (string) ob_get_clean();
		}
	}

	/**
	 * Loads a new template from a path.
	 *
	 * @return  Kostache
	 */
	public function template($path)
	{
		$this->_template = $this->_load($path);

		return $this;
	}

	/**
	 * Loads a new partial from a path. If the path is empty, the partial will
	 * be removed.
	 *
	 * @param   string  partial name
	 * @param   mixed   partial path, FALSE to remove the partial
	 * @return  Kostache
	 */
	public function partial($name, $path)
	{
		if ( ! $path)
		{
			unset($this->_partials[$name]);
		}
		else
		{
			$this->_partials[$name] = $this->_load($path);
		}

		return $this;
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
	 * Renders the template using the current view.
	 *
	 * @return  string
	 */
	public function render()
	{
		return $this->_stash($this->_template, $this, $this->_partials)->render();
	}

	/**
	 * Return a new Mustache for the given template, view, and partials.
	 *
	 * @param   string    template
	 * @param   Kostache  view object
	 * @param   array     partial templates
	 * @return  Mustache
	 */
	protected function _stash($template, Kostache $view, array $partials)
	{
		return new Mustache($template, $view, $partials, array(
			'charset' => Kohana::$charset,
		));
	}

	/**
	 * Load a template and return it.
	 *
	 * @param   string  template path
	 * @return  string
	 * @throws  Kohana_Exception  if the template does not exist
	 */
	protected function _load($path)
	{
		$file = Kohana::find_file('templates', $path, 'mustache');

		if ( ! $file)
		{
			throw new Kohana_Exception('Template file does not exist: :path', array(
				':path' => 'templates/'.$path,
			));
		}

		return file_get_contents($file);
	}

	/**
	 * Detect the template name from the class name.
	 *
	 * @return  string
	 */
	protected function _detect_template()
	{
		// Start creating the template path from the class name
		$template = explode('_', get_class($this));

		// Remove "View" prefix
		array_shift($template);

		// Convert name parts into a path
		$template = strtolower(implode('/', $template));

		return $template;
	}

}
