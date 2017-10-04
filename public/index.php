<?php
/**
 * frontcontroller
 */

/**
 * Include the config-file
 */
require(__DIR__.'/../App/config.php');

$router = new Core\Router;

// Add the routes
$router->add('', ['controller' => 'Posts', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/{id:\d+}');

/**
 * Dispatch the route to the controller/action
 */
$url = $_SERVER['QUERY_STRING'];
$router->dispatch($url);
