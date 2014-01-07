<?php

namespace Framework\Components\Database\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class QueryErrorException extends \Exception {

	public function __construct ($method, $error) {
		parent::__construct("$method: $error[2]");
	}
}