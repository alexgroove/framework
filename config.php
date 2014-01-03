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
 * htaccess mod_rewrite get contianer;
 *
 */
define('REWRITE_CONTAINER', 'mvc');


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
 * Autoload function
 *
 */
spl_autoload_register(function ($class) {
	@require_once str_replace('\\', '/', $class).'.php';
});	


/**
 *
 * ENVIRONMENT setup
 *
 */
switch (ENVIRONMENT) {

	case 'production' : 
		error_reporting(0);
		set_exception_handler(function () {});
		libxml_use_internal_errors(false);
	break;

	case 'development' : 
		error_reporting(E_ALL ^ E_STRICT);
		set_exception_handler(function ($exception) {
			echo $exception->getMessage();
		});
		libxml_use_internal_errors(true);
	break;
}









