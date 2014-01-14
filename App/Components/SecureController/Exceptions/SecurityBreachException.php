<?php

namespace App\Components\SecureController\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class SecurityBreachException extends \Exception {

	public function __construct () {
		parent::__construct('Security breach in a form, missing hidden input with right secure_key');
	}
}