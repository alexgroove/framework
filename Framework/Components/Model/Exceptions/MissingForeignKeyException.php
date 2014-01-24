<?php

namespace Framework\Components\Model\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class MissingForeignKeyException extends \Exception {

	public function __construct ($model, $foreign_key) {
		$model_name = get_class($model);
		parent::__construct("$model_name is missing the foreign key property '$foreign_key' to complete the relationship");
	}
}