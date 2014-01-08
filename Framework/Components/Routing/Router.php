<?php

namespace Framework\Components\Routing;
use Framework\Components\Routing\Interfaces\IRouter;
use Framework\Components\Process\Process;
use Framework\Components\Routing\Exceptions\NoMatchingRouteException;
use Framework\Components\Routing\Exceptions\TooManyRoutesException;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class Router
 * 
 * This class is the front controller of the framework, it checks if the
 * request match a known route and instanciate a new process with
 * the matched route and the request
 * 
 * @author Alexandre Pagé
 *
 */
class Router implements IRouter {


	/**
	 *
	 * private constructor
	 * @access private
	 *
	 */
	private function __construct () {}


	/**
	 *
	 * - route
	 * This method try to match a request with the right route if it exist.
	 * If the route is found, a new Process is made and execute
	 *
	 * @static
	 * @access public
	 * @param (Request) $request - the request object.
	 *
	 */
	public static function route (Request $request) {
		$foundRoutes = Route::find(array(
			'route'  => $request->getGenericRequest(), 
			'method' => $request->method,
		));
		if (empty($foundRoutes)) {
			throw new NoMatchingRouteException($request);
		}
		if (count($foundRoutes) > 1) {
			throw new TooManyRoutesException($request);
		}
		$route = $foundRoutes[0];
		// This is where the process is build and execute.
		// It is possible to pass the process to something else and delay the execution.
		$process = new Process ($route, $request);
		$process->execute();
	}
}
