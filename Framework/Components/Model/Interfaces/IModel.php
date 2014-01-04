<?php

namespace Framework\Components\Model\Interfaces;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Model Interface
 *
 * @author Alexandre Pagé
 *
 */
interface IModel {

	public function __construct ($inputs);

	public function save ();

	public function remove ();

	public static function all ();

	public static function create ($inputs);

	public static function find ($id_or_array);

	public static function delete ($id);

	public static function update ($id, $inputs);

}


