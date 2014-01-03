<?php

namespace Framework\Components\Process\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class ControllerMethodNotFoundException extends \Exception {

	public function __construct ($method_name, $class_name) {
		$msg = "Method <strong>$method_name</strong> was not found in Controller <strong>$class_name</strong>";
		parent::__construct($msg);
	}
}