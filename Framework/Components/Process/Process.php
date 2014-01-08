<?php

namespace Framework\Components\Process;
use Framework\Components\Process\Interfaces\IProcess;
use Framework\Components\Process\Exceptions\ControllerFileNotFoundException;
use Framework\Components\Process\Exceptions\ControllerClassNotFoundException;
use Framework\Components\Process\Exceptions\ControllerMethodNotFoundException;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class Process
 * 
 * This class is an execution container
 * @author Alexandre Pagé
 *
 */
class Process implements IProcess {


	/**
	 *
	 * @var $route
	 * @access private
	 *
	 */
	private $route;


	/**
	 *
	 * @var $request
	 * @access private
	 *
	 */
	private $request;


	/**
	 *
	 * Process Contructor
	 * @param (array) $route
	 * @param (Request) $request
	 *
	 */
	public function __construct ($route, $request) {
		$this->route = $route;
		$this->request = $request;
	}


	/**
	 *
	 * - execute
	 * @access public
	 * This method instanciate the controller and call the method
	 * It is where the magic appends :)
	 *
	 */
	public function execute () {

		// Fetch controller file
		$file_name = 'App/Controllers/'.$this->route['controller'].'.php';
		if (!file_exists($file_name)) {
			throw new ControllerFileNotFoundException($file_name);
		}
		require $file_name;


		// Instanciate the controller
		$class_name = 'App\\Controllers\\'.$this->route['controller'];
		if (!class_exists($class_name, false)) {
			throw new ControllerClassNotFoundException($class_name, $file_name);
		}
		$controller = new $class_name ();


		// Call controller method
		$method_name = $this->route['action'];
		if (!method_exists($controller, $method_name)) {
			throw new ControllerMethodNotFoundException($method_name, $class_name);
		}
		call_user_func_array(array($controller, $method_name), $this->request->params);
	}
}



