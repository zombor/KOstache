# Kostache

Kostache is a [Kohana 3](https://github.com/kohana/kohana) module for using [Mustache](http://mustache.github.com/) templates in your application.

## Usage

To use, simply create a POPO (Plain Old PHP Object) like so:

```php
<?php

class View_Test
{
	public $hello = 'world';

	public function testing()
	{
		return 'foobar';
	}
}
```

And create a mustache renderer. The parameter to the engine method is the template name to use.

```php
<?php

$renderer = Kostache::factory();
```

And render it:

```php
<?php

$this->response->body($renderer->render(new View_Test));
```

## Templates

Templates should go in the `templates/` directory in your cascading file system. They should have a .mustache extension.

## Partials

Partials are loaded automatically based on the name used in the template. So if you reference `{{>foobar}}` in your template, it will look for that partial in `templates/partials/foobar.mustache`.

# Layouts

KOstache supports layouts. To use, just add a `templates/layout.mustache` file (a simple one is already provided), and use `Kostache_Layout` for your renderer instead of `Kostache`. You'll probably want to put a `$title` property in your view class. The layout should include a `{{>content}}` partial to render the body of the page.

# Additional Information

For specific usage and documentation, see:

[PHP Mustache](http://github.com/bobthecow/mustache.php)

[Original Mustache](http://mustache.github.com/)

## Additional Example (KOstache for Dummies)

To use, simply create a POPO (Plain Old PHP Object) like so:  Under Controller/View create Test.php.

```php
<?php

class View_Test
{
	public $title;

	public function testing()
	{
		return 'foobar';
	}
}
```

And modify the Controller/Welcome.php that comes default with Kohana.

```php
<?php
	public function action_index()	{
		$view = new View_Test;
		$view->title = "hello World";   or  //Kohana::$config->load("site.title");
		$this->response->body(Kostache::factory()->render($view));
	}
```

And create test.mustache in classes/templates subdir:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{title}}</title>
</head>
<body>
    <h1>{{title}}</h1>
    <p>{{testing}}</p>
    
</body>
</html>
```


