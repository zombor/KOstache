# Kostache Usage

View classes go in classes/view/

classes/view/example.php

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

## Partials

To use a partial in your template you use the greater than sign (>) and the name, e.g. {{>header}}.

You must define partials within the $_partials array in your view class.  The key is the name that you use in your template and the value is a path to your partial file.

	protected $_partials = array(
		'header' => 'header',         // Loads templates/header.mustache
		'footer' => 'footer/default', // Loads templates/footer/default.mustache
	);

## Using the Kostache_Layout class

Kostache comes with a Kostache_Layout class instead of a template controller. This allows your layouts to be more OOP and self contained, and they do not rely on your controllers so much.

To use it, have your view extend the Kostache_Layout class. You can then specify your own layout file by placing it in templates/layout.mustache. At a minimum, it needs to have a {{>content}} partial defined in it.

If you have a view that extends the Kostache_Layout class, but wish to render only the template and not the entire layout, you can set the public $render_layout property to FALSE.  This is useful if you want to use the same view class for external requests and HMVC requests.

    $view = new View_Post_List;
    if ($this->request !== Request::instance) // Is internal request
    {
        $view->render_layout = FALSE;
    }

## Mustache Documentation

For specific usage and documentation, see:

[PHP Mustache](http://github.com/bobthecow/mustache.php)

[Original Mustache](http://defunkt.github.com/mustache/)