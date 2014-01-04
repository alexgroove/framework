<?php

namespace Framework\Components\Database\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class UnknownIdentifierException extends \Exception {

	public function __construct ($table_name, $id) {
		parent::__construct("Cannot access unknown identifier: $id in table: $table_name");
	}
}