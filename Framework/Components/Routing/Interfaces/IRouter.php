<?php

namespace Framework\Components\Routing\Interfaces;
use Framework\Components\Routing\Request;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Router Interface
 *
 * @author Alexandre Pagé
 *
 */
interface IRouter {

	public static function route (Request $request);

}


