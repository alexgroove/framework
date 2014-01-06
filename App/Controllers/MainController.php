<?php

namespace App\Controllers;
use App\Components\SecureController\SecureController;

// File security
defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * App Main Controller
 *
 * @author Your name
 *
 */
class MainController extends SecureController {

	public function index () {
		// View parameters
		$this->view->set('title', __METHOD__);
		$this->view->set('description', 'This is the meta description');
		$this->view->set('keywords', 'Choose your words wisely');
		
		// Send response with rendered View
		$content = $this->view->render('App/Views/Main/index');
		return $this->response->send($content);
	}
}









