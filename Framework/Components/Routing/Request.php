<?php

namespace Framework\Components\Routing;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class Request
 *
 * @author Alexandre Pagé
 *
 */
class Request {
	

	/**
	 *
	 * @var $method
	 * @access public
	 *
	 */
	public $method;


	/**
	 *
	 * @var $request
	 * @access public
	 *
	 */
	public $request = "";


	/**
	 *
	 * @var (array) $params 
	 * @access public
	 *
	 */
	public $params = array();


	/**
	 * Constructor
	 * @access public
	 *
	 */
	public function __construct () {
		$this->method = $_SERVER['REQUEST_METHOD'];
		if (isset($_GET['mvc'])) { 
			$this->request = rtrim($_GET['mvc'], '/'); 
		}
		$params = (isset($_GET['mvc'])) ? explode('/', rtrim($_GET['mvc'], '/')) : array('index');
		foreach($params as $param) {
			// Accumulate params when the value is numeric
			// Need to change that behavior to accept text parameter
			if (is_numeric($param)) {
				$this->params[] = $param;
			}
		}
	}


	/**
	 * - getGenericRequest
	 * This method replace the :id string in the request with the right regex.
	 * It also remove the last '/' at the end is present.
	 *	
	 * @access public
	 * @return string regex replacement
	 *
	 */	 
	public function getGenericRequest () {
		return rtrim(preg_replace("/\/[0-9]+\/?/", "/:id/", $this->request), '/');
	}
}