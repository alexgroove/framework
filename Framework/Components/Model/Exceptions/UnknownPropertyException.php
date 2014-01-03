<?php

namespace Framework\Components\Model\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class UnknownPropertyException extends \Exception {

	public function __construct ($model, $property) {
		$model_name = get_class($model);
		$msg = "Unknown property <strong>$property</strong> for <strong>$model_name</strong>";
		parent::__construct($msg);
	}
}
