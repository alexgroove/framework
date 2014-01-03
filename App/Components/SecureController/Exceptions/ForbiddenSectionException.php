<?php

namespace App\Components\SecureController\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class ForbiddenSectionException extends \Exception {

	public function __construct () {
		parent::__construct('Forbidden section');
		if (ENVIRONMENT == 'production') {
			include 'public/403.html';
		}
	}
}