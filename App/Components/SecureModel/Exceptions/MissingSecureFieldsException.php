<?php

namespace App\Components\SecureModel\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class MissingSecureFieldsException extends \Exception {

	public function __construct ($child_model) {
		$child_model_name = is_string($child_model) ? $child_model : get_class($child_model);
		parent::__construct("SecureModel child '$child_model_name' missing SECURE_FIELDS constant");
	}
}
