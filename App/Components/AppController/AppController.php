<?php

namespace App\Components\AppController;
use App\Components\SecureController\SecureController;
use App\Components\AppController\FlashMessenger;
use App\Components\AppController\Interfaces\IAppController;
use Framework\Components\Session\Session;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * AppController Component
 *
 * This class is a abstraction over the SecureController.
 * It also implement the FlashMessenger class to send message to the user
 *
 * @author Alexandre Pagé
 *
 */
class AppController extends SecureController implements IAppController {


	/**
	 *
	 * @var $flash
	 * @access protected
	 * Reference to the flash messenger object
	 *
	 */
	protected $flash;


	/**
	 *
	 * AppController Constructor
	 * @access public
	 * This constructor also bind the flash message to the view.
	 *
	 */
	public function __construct () {
		parent::__construct();
		$this->flash = new FlashMessenger();
		if (isset($this->view)) {
			$this->view->set('SESSION_PRIVILEDGE', Session::read('SESSION_PRIVILEDGE_LEVEL'));
			$this->view->set('USER_NAME', Session::read('USER.name'));
			$this->view->set('USER_ID', Session::read('USER.id'));
			$this->view->set('USER_PROFILE_URL', Session::read('USER.id').'/'.seo_url_fix(Session::read('USER.name')));
			$this->view->bind('flash', $this->flash->getMessage());
		}

	}
}












