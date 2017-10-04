<?php
/**
 *  Config-file for MVC. 
 */


/**
 * Set error reporting
 */
// Repport all types of errors
error_reporting(-1);

// Display all errors
if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}

// Do not buffer outputs
if (!ini_get('output_buffering')) {
    ini_set('output_buffering', 0);
}


/**
 * Define MVC path
 */
define('MVC_ROOT_PATH', dirname(__DIR__));

$hej = "hej";

/**
 * Require helper functions
 */
require MVC_ROOT_PATH . "/App/helper_functions.php";


/**
 * Include bootstrap
 */
require(MVC_ROOT_PATH . '/App/bootstrap.php');


/**
 * Database settings
 */
define('DB_NAME', 'my_mvc');
define('DB_HOST', 'unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock');
define('DB_DNS', 'mysql:' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_DRIVER_OPTIONS', [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"]);
define('DB_FETCH_STYLE', PDO::FETCH_OBJ);


/**
 * Start session
 */
session_start();


/**
 * Create the MVC variable
 */
$mvc = [];


/**
 * Site basic settings
 */
$mvc['lang'] 		 = 'sv';
$mvc['title_append'] = ' | MVC web template';


/**
 * Theme settings
 */
$mvc['stylesheets'] = [
	'assets/css/fluid_grid.css',
	'assets/css/style.css'
];


/**
 * Settings for JavaScript
 */
$mvc['jquery'] = 'https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js';
$mvc['javascript_inc'] = [
	'assets/js/form_validation.js'
];