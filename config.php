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
define('ENVIRONMENT', 'development');



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

	case 'development' : 
		spl_autoload_register(function ($class) {
			require_once str_replace('\\', '/', $class).'.php';
		});	
		error_reporting(E_ALL ^ E_STRICT);
		set_exception_handler(function ($exception) {
			echo $exception->getMessage();
		});
		libxml_use_internal_errors(true);
	break;	

	case 'production' : 
	default: 
		spl_autoload_register(function ($class) {
			@require_once str_replace('\\', '/', $class).'.php';
		});	
		error_reporting(0);
		set_exception_handler(function () {});
		libxml_use_internal_errors(false);

	break;


}









