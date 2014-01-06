<?php

namespace App\Components\SecureController;
use Framework\Components\Controller\Controller;
use Framework\Components\Session\Session;
use App\Components\SecureController\Interfaces\ISecureController;
use App\Components\SecureController\Exceptions\ForbiddenSectionException;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Class SecureController
 *
 * This class offer a layer of security over the Controller class
 * @abstract
 * 
 * @author Alexandre Pagé
 *
 */
abstract class SecureController extends Controller implements ISecureController {


	/**
	 *
	 * @constant VISITOR
	 * This priviledge doesnt require any kind of login
	 *
	 */
	const VISITOR = 3;


	/**
	 *
	 * @constant USER
	 * This privliledge require a user to be login
	 *
	 */
	const USER = 2;


	/**
	 *
	 * @constant ADMIN
	 * This priviledge is only accessible for site administrator
	 * Often use when there is a back-end.
	 * 
	 */
	const ADMIN = 1;


	/**
	 *
	 * @constant SUPER_ADMIN
	 * This priviledge is only accessible for site super-administrator
	 * Often use for the one that control users and other admnistrators.
	 *
	 */
	const SUPER_ADMIN = 0;


	/**
	 *
	 * @constant PRIVILEDGE_LEVEL
	 * Use in child controller to set the priviledge level
	 * Default priviledge is visitor, 
	 *
	 */
	const PRIVILEDGE_LEVEL = self::VISITOR;


	/**
	 *
	 * - SecureController constructor
	 * @access public
	 * If session priviledge is not setup, set to VISITOR
	 * Test if the requested priviledge level from the child controller is 
	 * superior to the current session priviledge level
	 *
	 */
	public function __construct () {
		if (!Session::exist('SESSION_PRIVILEDGE_LEVEL')) {
			Session::write('SESSION_PRIVILEDGE_LEVEL', self::VISITOR);
		}
		if (Session::read('SESSION_PRIVILEDGE_LEVEL') > static::PRIVILEDGE_LEVEL) {
			throw new ForbiddenSectionException();
		}
		parent::__construct();

		// View extra parameters
		if (isset($this->view)) {
			$this->view->set('flash', @$_GET['flash']);
		}

		// Response settings
		if (isset($this->response)) {
			$this->response->setContentType('text/html');
		}
	}


	/**
	 *
	 * - activate_secure_session
	 * @static
	 * @access protected
	 * @param (class constant) $priviledge_level
	 *
	 */
	protected static function activate_secure_session ($priviledge_level) {
		Session::reset();
		Session::write('SESSION_PRIVILEDGE_LEVEL', $priviledge_level);
	}


	/**
	 *
	 * - close_secure_session
	 * @static
	 * @access protected
	 *
	 */
	protected static function close_secure_session () {
		Session::close();
	}
}




