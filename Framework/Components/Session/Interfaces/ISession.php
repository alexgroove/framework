<?php

namespace Framework\Components\Session\Interfaces;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Session Interface
 *
 * @author Alexandre Pagé
 *
 */
interface ISession {

	public static function start ();

	public static function write ($key, $value);

	public static function read ($object);

	public static function delete ($key);

	public static function close ();

	public static function exists ($key);

	public static function reset ();

}


