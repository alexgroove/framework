<?php

namespace Framework\Components\Database\Interfaces;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Database Interface
 *
 * @author Alexandre Pagé
 *
 */
interface IDatabase {


	public static function init ();

	public static function select_all ($table_name, $limit);

	public static function select_id ($table_name, $id);

	public static function select_where ($table_name, $conditions, $limit);

	public static function insert ($table_name, $inputs);

	public static function update_id ($table_name, $id, $inputs);

	public static function delete_id ($table_name, $id);

	public static function query ($query);

	public static function execute ($query);

}


