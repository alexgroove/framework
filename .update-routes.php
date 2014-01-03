<?php

/**
 *
 * - update routes script
 * Use this script to update the new routes in the routes.sql
 * When in production, you must delete this file
 *
 *
 */


use Framework\Components\Database\Database;

define('CORE_EXEC', 'core');

require_once 'utils.php';
require_once 'config.php';
require_once 'Framework/Components/Database/Database.php';



$sql_routes = file_get_contents('Migrations/routes.sql');

Database::init();
Database::execute($sql_routes);
header('Location: '.location());