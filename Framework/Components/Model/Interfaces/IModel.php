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

	public function __construct ($id_or_array);

	public function save ();

	public function remove ();

	public static function all ();

	public static function find ($id_or_array);

	protected static function create ($inputs);

	protected static function delete ($id);

	protected static function update ($id, $inputs);

}


