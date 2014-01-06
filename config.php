<?php

defined('CORE_EXEC') or die('Restricted Access');

/**
 *
 * Core Framework
 * - config.php
 *
 * Configuration file
 *
 */ 


/**
 *
 * ENVIRONMENT
 *
 */
define('DEVELOPMENT', 'development');
define('PRODUCTION', 'production');
define('TEST_PRODUCTION', 'test_production');
define('ENVIRONMENT', TEST_PRODUCTION);



/**
 *
 * Database setup
 *
 */
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', 'root');
define('DATABASE', 'framework');



/**
 *
 * ENVIRONMENT setup
 *
 */
switch (ENVIRONMENT) {

	case DEVELOPMENT : 
	case TEST_PRODUCTION : 
		spl_autoload_register(function ($class) {
			require_once str_replace('\\', '/', $class).'.php';
		});	
		error_reporting(E_ALL ^ E_STRICT);
		set_exception_handler('core_exception_handler');
		libxml_use_internal_errors(true);
	break;	

	case PRODUCTION : 
	default: 
		spl_autoload_register(function ($class) {
			@require_once str_replace('\\', '/', $class).'.php';
		});	
		error_reporting(0);
		set_exception_handler(function () {});
		libxml_use_internal_errors(false);

	break;
}


/**
 *
 * core_exception_handler
 * Default Exception handler
 *
 *
 */
function core_exception_handler (Exception $exception) {
	$msg = "<div style='border: 1px solid black; padding: 10px;'>";
	$msg .= "<span><strong style='text-decoration: underline;'>Exception</strong></span>";
	$msg .= '<pre><strong style=\'color: red; \'>Message</strong>: <strong>'.$exception->getMessage().'</strong><br/>';
	$msg .= 'Code: '.$exception->getCode().'<br/>';
	$msg .= 'File: '.$exception->getFile().'<br/>';
	$msg .= 'Line: '.$exception->getLine().'<br/>';
	$msg .= '</pre>';
	$msg .= '</div>';
	echo $msg;
}









