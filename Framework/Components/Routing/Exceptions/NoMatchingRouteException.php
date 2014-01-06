<?php

namespace Framework\Components\Routing\Exceptions;


defined('CORE_EXEC') or die('Restricted Access');


class NoMatchingRouteException extends \Exception {

	public function __construct ($request) {
		parent::__construct('No matching route for this request => '.$request->method.' '.location().$request->request);
		if (ENVIRONMENT == 'production') {
			include 'public/404.html';
		}
	}
}