<?php

namespace Framework\Components\Database\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class DeleteUnknownIdentifierException extends \Exception {

	public function __construct ($table_name, $id) {
		$msg = "Cannot delete row with unknown id <strong>$id</strong> in table <strong>$table_name</strong>";
		parent::__construct($msg);
	}
}