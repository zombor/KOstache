# Kostache

Kostache is a [Kohana 3](https://github.com/kohana/kohana) module for using [Mustache](http://defunkt.github.com/mustache/) templates in your application.

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

For specific usage and documentation, see:

[PHP Mustache](http://github.com/bobthecow/mustache.php)

[Original Mustache](http://defunkt.github.com/mustache/)
