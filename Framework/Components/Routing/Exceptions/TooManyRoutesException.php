<?php

namespace Framework\Components\Routing\Exceptions;


defined('CORE_EXEC') or die('Restricted Access');


class TooManyRoutesException extends \Exception {

	public function __construct ($request) {
		$path = location().$request->request;
		parent::__construct("Too many routes for this request '$path', please check your routes");
	}
}