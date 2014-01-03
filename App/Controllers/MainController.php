<?php

namespace App\Controllers;
use Framework\Components\Controller\Controller;
use Framework\Components\Session\Session;


defined('CORE_EXEC') or die('Restricted Access');



class MainController extends Controller {

	public function index () {
		$this->view->set('title', __METHOD__);
		$this->view->set('description', 'This is the meta description');
		$this->view->set('keywords', 'Choose your words wisely');
		echo $this->view->render('App/Views/Main/index');
	}
}









