<?php
/**
 * Bootstrapping functions. Autoload classes.
 */


/**
 * Autoloader for classes
 */

function autoloadCore($class) {
	$file = MVC_ROOT_PATH . "/Core/{$class}.php";
		if (is_readable($file)) {
			require $file;
		}
}
spl_autoload_register('autoloadCore');

function autoloadModels($class) {
	$file = MVC_ROOT_PATH . "/App/Models/{$class}.php";
		if (is_readable($file)) {
			require $file;
		}
}
spl_autoload_register('autoloadModels');

function autoloadControllers($class) {
	$root = MVC_ROOT_PATH; // Get the parent directory
	$file = $root . '/' . str_replace('\\', '/', $class) . '.php';
		if (is_readable($file)) {
			require $file;
		}
}
spl_autoload_register('autoloadControllers');


/**
 * Default exception handler
 */
function myExceptionHandler($exception) {
	echo 'MVC: Uncaught exception: <p>' . $exception->getMessage() . '</p><pre>' . $exception->getTraceAsString() . '</pre>';
}
set_exception_handler('myExceptionHandler');