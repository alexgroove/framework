<?php

namespace Framework\Components\View\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class WrongDataFormatException extends \Exception {
	
	public function __construct () {
		parent::__construct('Wrong data format for View::bind method, must be an array');
	}
}