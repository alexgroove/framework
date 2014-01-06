<?php

namespace Framework\Components\Process\Exceptions;

class ControllerFileNotFoundException extends \Exception {

	public function __construct ($file_name) {
		parent::__construct("Controller file: $file_name is not found ");
	}
}