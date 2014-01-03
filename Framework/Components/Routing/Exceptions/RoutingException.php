<?php

namespace Framework\Components\Routing\Exceptions;


defined('CORE_EXEC') or die('Restricted Access');


class RoutingException extends \Exception {

	public function __construct ($message, $request=array()) {
		echo '<span style="color: red;">'.$message.'</span>';
		if (!empty($request)) {
			pprint($request);
		}
	}
}