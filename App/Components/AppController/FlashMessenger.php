<?php

namespace App\Components\AppController;
use Framework\Components\Session\Session;
use App\Components\AppController\Interfaces\IFlashMessenger;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 *
 * AppController FlashMessenger
 * 
 * This class represent the message container from the server that you
 * can use to send message to the user.
 *
 * @author Alexandre Pagé
 *
 */
class FlashMessenger implements IFlashMessenger {


	const WARNING = 'warning';
	const INFO    = 'info';
	const ERROR   = 'error';
	const SUCCESS = 'success';


	/**
	 *
	 * FlashMessenger constructor
	 * If the flash message is not set, it is set to an empty string
	 * @access public
	 *
	 */
	public function __construct () {
		if (!Session::exists('FLASH.message')) {
			Session::write('FLASH.type', '');
			Session::write('FLASH.message', '');
		}
	}


	/** 
	 *
	 * - setMessage
	 * @access public
	 * @param (string) $message
	 *
	 */
	public function setMessage ($message='', $type=self::ERROR) {
		Session::write('FLASH.type', $type);
		Session::write('FLASH.message', $message);
	}


	/**
	 *
	 * - getMessage
	 * This function fetch the message and than delete the flash message
	 * @access public
	 * @return (string) $result - flash message
	 *
	 */
	public function getMessage () {
		$result = Session::read('FLASH.message');
		self::remove_flash();
		return $result;
	}


	/**
	 *
	 * - getType
	 * This function fetch the type of the flash message
	 * @access public
	 * @return (string) 
	 *
	 */
	 public function getType () {
		return Session::read('FLASH.type');
	}
	

	/**
	 *
	 * - remove_flash
	 * @static
	 * @access private
	 *
	 */
	private static function remove_flash () {
		Session::delete('FLASH');
		Session::delete('FLASH.type');
		Session::delete('FLASH.message');				
	}

}