<?php

namespace Framework\Components\View\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class CannotBindDataWithNoNameException extends \Exception {
	
	public function __construct () {
		parent::__construct('View::bind method require first param to be the name of the data container');
	}
}