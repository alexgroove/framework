<?php

namespace Framework\Components\Session\Exceptions;

defined('CORE_EXEC') or die('Restrited Access');


class UnableToStartSessionException extends \Exception {

	public function __construct () {
		parent::__construct('Unable to start server session');
	}
}