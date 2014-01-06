<?php

namespace App\Components\SecureModel\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class UnknownCredentialException extends \Exception {

	public function __construct ($key) {
		parent::__construct("Unknown credential '$key' for Secure Model");
	}
}
