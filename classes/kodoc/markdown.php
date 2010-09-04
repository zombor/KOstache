<?php defined('SYSPATH') OR die('No direct access allowed.');

class Kodoc_Markdown extends Kohana_Kodoc_Markdown {

	public function doIncludeViews($text)
	{
		if (preg_match_all('/{{([^\s{}]++)}}/', $text, $matches, PREG_SET_ORDER))
		{
			$replace = array();

			foreach ($matches as $set)
			{
				list($search, $view) = $set;

				try
				{
					$replace[$search] = View::factory($view)->render();
				}
				catch (Exception $e)
				{
					// View file not found.  Do not replace {{text}}.
				}
			}

			$text = strtr($text, $replace);
		}

		return $text;
	}
}
