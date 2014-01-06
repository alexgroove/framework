<?php

namespace Framework\Components\View\Exceptions;

defined('CORE_EXEC') or die('Restricted Access');


class CacheFolderMissingException extends \Exception {
	
	public function __construct ($cache_folder) {
		$msg = "Cache folder '$cache_folder' is missing";
		parent::__construct($msg);
	}
}