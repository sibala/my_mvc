<?php

namespace Core;

class View
{

	/**
	 * Render a view file
	 * 
	 * @param  string $view the view file
	 * 
	 * @return void
	 */
	public static function render($view, $args = [])
	{
		global $mvc;

		extract($args, EXTR_SKIP);

		$page = MVC_ROOT_PATH . "/App/Views/$view";
		$layout = MVC_ROOT_PATH . "/App/Views/layouts/app.php";

		if (is_readable($page)) {
			if (is_readable($layout)) {
				require $layout;
			} else {
				require $page;
			}
		} else {
			throw new \Exception("$page not found");
		}
	}
}