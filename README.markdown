# Kostache

Kostache is a [Kohana 3](https://github.com/kohana/kohana) module for using [Mustache](http://defunkt.github.com/mustache/) templates in your application.

Mustache is a logic-less template class. It is impossible to embed logic into mustache files.

## Example

Did you know the pagination view in Kohana is terrible? We are going to fix it:

### How it exists now:

	<p class="pagination">

		<?php if ($first_page !== FALSE): ?>
			<a href="<?php echo $page->url($first_page) ?>" rel="first"><?php echo __('First') ?></a>
		<?php else: ?>
			<?php echo __('First') ?>
		<?php endif ?>

		<?php if ($previous_page !== FALSE): ?>
			<a href="<?php echo $page->url($previous_page) ?>" rel="prev"><?php echo __('Previous') ?></a>
		<?php else: ?>
			<?php echo __('Previous') ?>
		<?php endif ?>

		<?php for ($i = 1; $i <= $total_pages; $i++): ?>

			<?php if ($i == $current_page): ?>
				<strong><?php echo $i ?></strong>
			<?php else: ?>
				<a href="<?php echo $page->url($i) ?>"><?php echo $i ?></a>
			<?php endif ?>

		<?php endfor ?>

		<?php if ($next_page !== FALSE): ?>
			<a href="<?php echo $page->url($next_page) ?>" rel="next"><?php echo __('Next') ?></a>
		<?php else: ?>
			<?php echo __('Next') ?>
		<?php endif ?>

		<?php if ($last_page !== FALSE): ?>
			<a href="<?php echo $page->url($last_page) ?>" rel="last"><?php echo __('Last') ?></a>
		<?php else: ?>
			<?php echo __('Last') ?>
		<?php endif ?>

	</p><!-- .pagination -->

Wow, look at all that logic in there! How do you plan on effectively maintaining that?!?

### Our new View Class (classes/view/pagination/basic.php)

	<?php defined('SYSPATH') or die('No direct script access.');

	class View_Pagination_Basic extends kostache {
	
		protected $pagination;

		protected function items()
		{	
			$items = array();
		
			// First.
			$first['title'] = 'first';
			$first['name'] = __('first');
			$first['url'] = ($this->pagination->first_page !== FALSE) ? $this->pagination->url($this->pagination->first_page) : FALSE;
			$items[] = $first;
		
			// Prev.
			$prev['title'] = 'prev';
			$prev['name'] = __('previous');
			$prev['url'] = ($this->pagination->previous_page !== FALSE) ? $this->pagination->url($this->pagination->previous_page) : FALSE;
			$items[] = $prev;
		
			// Numbers.
			for ($i=1; $i<=$this->pagination->total_pages; $i++)
			{
				$item = array();
			
				$item['num'] = TRUE;
				$item['name'] = $i;
				$item['url'] = ($i != $this->pagination->current_page) ? $this->pagination->url($i) : FALSE;
			
				$items[] = $item;
			}
		
			// Next.
			$next['title'] = 'next';
			$next['name'] = __('next');
			$next['url'] = ($this->pagination->next_page !== FALSE) ? $this->pagination->url($this->pagination->next_page) : FALSE;
			$items[] = $next;
		
			// Last.
			$last['title'] = 'last';
			$last['name'] = __('last');
			$last['url'] = ($this->pagination->last_page !== FALSE) ? $this->pagination->url($this->pagination->last_page) : FALSE;
			$items[] = $last;

			return $items;
		}
	}

Yum, logic in a class, where it belongs :)

### Our mustache template (templates/pagination/basic.mustache)

	<p class="pagination">
	{{#items}}
	{{#url}}<a href="{{url}}" {{#title}}rel="{{rel}}"{{/title}}>{{/url}}
		{{#num}}<strong>{{/num}}{{name}}{{#num}}</strong>{{/num}}
	{{#url}}</a>{{/url}}
	{{/items}}
	</p>

Holy cow, that's more maintainable :)

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

For specific usage and documentation, see:

[PHP Mustache](http://github.com/bobthecow/mustache.php)

[Original Mustache](http://defunkt.github.com/mustache/)