<?php

namespace Framework\Components\Session;
use Framework\Components\Session\Interfaces\ISession;
use Framework\Components\Session\Exceptions\UnableToStartSessionException;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class Session
 *
 * @author Alexandre Page
 * 
 * Use nested session keys with dotted notation
 * Read either as object or as specific value
 * @example Session::write('User.name'); Session::read('User'), Session::read('User.name');
 *
 *
**/
class Session implements ISession {


	/**
	 *
	 * private constructor
	 * @access private
	 *
	 */
	private function __construct () {}


	/**
	 *
	 * - start
	 * @static
	 * @access public
	 *
	 */
	public static function start () {
		if (headers_sent()) {
			throw new UnableToStartSessionException();
		}
		session_start();
	}


	/**
	 *
	 * - write
	 * @static
	 * @access public
	 * @param (string) $key
	 * @param (string) $value
	 *
	 */
	public static function write ($key, $value) {
		$_SESSION[$key] = $value;
	}


	/**
	 *
	 * - read
	 * @static 
	 * @access public 
	 * @param (string) $object - @example 'User.name' or 'User'
	 * @return (mixed) values to be read
	 *
	 */
	public static function read ($object) {
		$acc = array();
		$object = self::fixDot($object);
		foreach($_SESSION as $key => $value) {
			if (preg_match("/$object/", self::fixDot($key)) ? true : false) {
				$acc[ltrim($key, '.'.$object)] = $value;
			}
		}
		switch(count($acc)) {
			case 0 : return null;
			case 1 : return reset($acc); current($acc);
			default : return $acc;
		}
	}


	/**
	 *
	 * - delete
	 * @static
	 * @access public
	 * @param $key
	 *
	 */
	public static function delete ($key) {
		if (isset($_SESSION[$key])) {
			unset($_SESSION[$key]);
		}
	}

	
	/**
	 *
	 * - close
	 * @static 
	 * @access public
	 *
	 */
	public static function close () {
		session_unset();
		session_destroy();
	}


	/**
	 *
	 * - exist
	 * @static 
	 * @access public
	 * @param (string) $key
	 * @return (bool) - if the key exist in the $_SESSION
	 *
	 */
	public static function exist ($key) {
		return isset($_SESSION[$key]);
	}


	/**
	 *
	 * - reset
	 * @static 
	 * @access public
	 *
	 */
	public static function reset () {
		self::close();
		self::start();
	}


	/**
	 *
	 * - fixDot 
	 * This method is an class util
	 * @static
	 * @access private
	 * @param (string) $str
	 *
	 */
	private static function fixDot ($str) {
		return str_replace('.', '__random_separator__', $str);
	}
}


