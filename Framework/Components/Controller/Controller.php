<?php

namespace Framework\Components\Controller;
use Framework\Components\Controller\Interfaces\IController;
use Framework\Components\Controller\Exceptions\HeadersAlreadySentException;
use Framework\Components\View\View;
use Framework\Components\Routing\Response;

defined('CORE_EXEC') or die('Restrcited Access');


/**
 *
 * Core Framework
 * Class Controller
 *
 * This class is the main parent to all controllers on the framework.
 * @abstract
 *
 * @author Alexandre Pagé
 *
 */
abstract class Controller implements IController  {


	/**
	 *
	 * @var $view;
	 * @access protected
	 * 
	 * variable that hold the reference to the view
	 *
	 */
	protected $view;


	/**
	 *
	 * @var $response;
	 * @access protected
	 * 
	 * variable that hold the reference to the response
	 *
	 */
	protected $response;


	/**
	 *
	 * Controller constructor
	 * 
	 * This method bind the class variable to a new View object and a Response object
	 * You can also set params for the view
	 * HTTP_LOCATION is a essential param for the view
	 * If REQUEST METHOD is POST, the view is not instanciate. This will fasten the process.
	 *
	 */
	public function __construct () { 
		
		// Response initial setup
		$this->response = new Response ();

		if ($_SERVER['REQUEST_METHOD'] != 'POST') {

			// View inital setup
			$this->view = new View();
			$this->view->set('HTTP_LOCATION', location());
		}
	}


	/**
	 *
	 * -redirect
	 * Method use to redirect to another controller using http url
	 * If headers already sent, throw an Exception
	 *
	 * @param (string) $path - url to be redirect
	 * @param (array) $params - variables pass in the GET
	 *
	 */
	protected static function redirect ($path='', $params=array()) {
		if (headers_sent()) {
			throw new HeadersAlreadySentException();
		}
		$url_parameters = "";
		if (!empty($params)) {
			$url_parameters .= "?";
			foreach($params as $key => $value) {
				$url_parameters .= urlencode($key).'='.urlencode($value).'&';
			}
		}
		$url_parameters = rtrim($url_parameters, '&');
		header('Location: '.location().$path.$url_parameters);
	}
}

