<?php

namespace Framework\Components\Routing\Exceptions;


defined('CORE_EXEC') or die('Restricted Access');


class TooManyRoutesExpcetions extends RoutingException {

	public function __construct ($request) {
		parent::__construct('Too many routes for this request, please check your routes', $request);
	}
}