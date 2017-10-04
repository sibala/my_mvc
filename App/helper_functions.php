<?php

/**
 * Dump all contents of variabel and stop executing
 * 
 * @param  mixed $a chosen variable/object to dump
 * 
 * @return void
 */
function dd($a) {
	echo '<pre>' . print_r($a, 1) . '</pre>';
	die;
}


/**
 * Get url
 * 
 * @param  string $path part of url
 * 
 * @return string
 */
function url($path) {
	$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
	$url = $root . $path;

	return $url;
}


/**
 * Redirects to url and stop executing
 * 
 * @param  string $path part of url
 * 
 * @return void
 */
function redirect($path) {
	header('Location: ' . url($path));
	die;
}