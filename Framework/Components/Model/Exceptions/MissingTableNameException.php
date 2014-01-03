<?php

namespace Framework\Components\Model\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class MissingTableNameException extends \Exception {

	public function __construct () {
		parent::__construct("Missing const TABLE_NAME in a child model");
	}
}