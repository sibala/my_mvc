<?php

namespace Core;

class Router
{
	/**
	 * Associative array of the routes
	 * @var array
	 */
	protected $routes = [];

	/**
	 * Paramters from matched route
	 * @var array
	 */
	protected $params = [];


	/**
	 * Add a route tot he routing table
	 * 
	 * @param string $route  The route URL
	 * @param array $params Parameters (controller, action, type of request, etc)
	 *
	 * @return void
	 */
	public function add($route, $params = [])
	{	
		// Convert the route to a regular expression: escape forward slashes
		$route = preg_replace('/\//', '\\/', $route);

		// Convert variables e.g. {controller}
		$route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

		// Convert variables e.g. {controller}
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

		// Add start and end delimiters, and case insensitive flag
		@$route = '/^' . $route . '$/i';

		$this->routes[$route] = $params;
	}

	/**
	 * Get all the routes from the routing table
	 * 
	 * @return [type] [description]
	 */
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
	 * Match the route to the routes in the table, setting the
	 * params property if a route is found.
	 * 
	 * @param  string $url The route URL
	 * 
	 * @return boolean true if a match found, else false
	 */
	public function match($url)
	{
		foreach ($this->routes as $route => $params) {
			if (preg_match($route, $url, $matches)) {

				foreach ($matches as $key => $match) {
					if (is_string($key)) {
						$params[$key] = $match;
					}
				}

				$this->params = $params;
				return true;
			}
		}

		return false;
	}

	/**
	 * Get the currently matched params
	 * 
	 * @return array
	 */
	public function getParams()
	{
		return $this->params;
	}


	/**
	 * Dispatches the route, creating the controler object and running the action method
	 * 
	 * @param  string $url The route url
	 * 
	 * @return void
	 */
	public function dispatch($url)
	{
		$url = $this->removeQeuryStringVariables($url);

		if ($this->match($url)) {
			$controller = $this->params['controller'];
			$controller = $this->convertToStudlyCaps($controller);
			$controller .= "Controller";
			$controller = "App\Controllers\\$controller";

			if (class_exists($controller)) {
				$controller_object = new $controller($this->params);

				$action = $this->params['action'];
				$action = $this->convertToCamelCase($action);

				if (is_callable([$controller_object, $action])) {
					$controller_object->$action();
				} else {
					throw new \Exception("Method $action (in controller $controller) not found");
				}
			} else {
				throw new \Exception("Controller class $controller not found");
			}
		} else {
			throw new \Exception("No route matched.", 404);
		}
	}


	/**
	 * Converts string with hyphens to StudlyCaps
	 * 
	 * @param string $string The string to convert
	 * 
	 * @return string
	 */
	public function convertToStudlyCaps($string)
	{
		return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
	}


	/**
	 * Converts string with hyphens to camelCase
	 * 
	 * @param string $string The string to convert
	 * 
	 * @return string
	 */
	public function convertToCamelCase($string)
	{
		return lcfirst($this->convertToStudlyCaps($string));
	}

	/**
	 * Removes the query string from the url
	 * 
	 * @param  string $url
	 * 
	 * @return string the url without query string
	 */
	public function removeQeuryStringVariables($url)
	{
		if ($url != '') {
			$parts = explode('&', $url, 2);

			if (strpos($parts[0], '=') === false) {
				$url = $parts[0];
			} else {
				$url = '';
			}
		}

		return $url;
	}
}