<?php

/**
 * TEST
 * Core Framework
 * - index.php
 *
 * This file is the main framework file.
 * Everything should be execute from here.
 *
 */


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
 * CORE_EXEC (constant)
 * This constant is the front gate guardian of the framework.
 * It also generate a secure id that can be use.
 *
 */
define('CORE_EXEC', hash('sha256', uniqid(rand(), true)));


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
 * Set privildege level for every new session
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

