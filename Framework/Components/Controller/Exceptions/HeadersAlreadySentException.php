<?php

namespace Framework\Components\Controller\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class HeadersAlreadySentException extends \Exception {

	public function __construct () {
		parent::__construct('Headers already sent, controller cannot redirect');
	}
}