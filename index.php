<?php

/**
 *
 * Core Framework
 * - index.php
 *
 * This file is the main framework file.
 * Everything should be execute from here.
 *
 * @author Alexandre Pagé
 *
 */


/**
 *
 * Check php version MUST by equal or higher that 5.4.4
 *
 */
if (version_compare(phpversion(), '5.3.0', '<')) {
	die('Your PHP version on your server is not high enough, 5.3.0 is required');
}


/**
 *
 * CORE_EXEC (constant)
 * This constant is the front gate guardian of the framework.
 * It also generate a secure id that can be use.
 *
 */
define('CORE_EXEC', hash('sha256', 'YOUR APP SECRET'));


/**
 *
 * Namespace declarations
 *
 */
use Framework\Components\Database\Database;
use Framework\Components\Session\Session;
use Framework\Components\Routing\Request;
use Framework\Components\Routing\Router;


/**
 *
 * Essentials files
 *
 */
require_once 'utils.php';
require_once 'config.php';


/**
 *
 * Database initialization
 *
 */
Database::init();


/**
 *
 * Start session with new user
 *
 */
Session::start();


/**
 *
 * Router routing the next request
 * This line is the front controller execution
 *
 */
Router::route(new Request());

