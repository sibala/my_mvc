<?php

namespace Core;

abstract class Controller
{
	/**
	 * Parameters from the matched route
	 * 
	 * @var array
	 */
	protected $route_params = [];


	/**
	 * Class constructor
	 * 
	 * @param  array $route_params parameters from the route
	 *
	 * @return  void
	 */
	public function __construct($route_params)
	{
		$this->route_params = $route_params;
		
		$this->setPostParams();
	}


	/**
	 * Retrive post parameters and assign to $route_params. This should later be refactored to a Request class
	 * 
	 * @return void
	 */
	private function setPostParams()
	{
		if(isset($_POST)) {
			foreach ($_POST as $name => $value) {
				$this->route_params[$name] = $value;
			}
		}
	}
}