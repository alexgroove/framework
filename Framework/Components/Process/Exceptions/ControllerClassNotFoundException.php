<?php

namespace Framework\Components\Process\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class ControllerClassNotFoundException extends \Exception {

	public function __construct ($class_name, $file_name) {
		$msg = "Controller class <strong>$class_name</strong> was not found in <strong>$file_name</strong>";
		parent::__construct($msg);
	}
}