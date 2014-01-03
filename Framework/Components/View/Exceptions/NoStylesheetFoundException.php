<?php

namespace Framework\Components\View\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class NoStylesheetFoundException extends \Exception {
	
	public function __construct ($path) {
		$msg = "No stylesheet found at this path: $path";
		parent::__construct($msg);
	}
}