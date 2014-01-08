<?php

namespace Framework\Components\Routing;
use Framework\Components\Model\Model;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework Route Model
 *
 * @author Alexandre Pagé
 *
 */
class Route extends Model {


	/**
	 *
	 * @constant TABLE_NAME - represent the sql table name
	 *
	 */
	const TABLE_NAME = 'routes';


	public $id;
	public $method;
	public $route;
	public $controller;
	public $action;

	protected function validate () {
		return true;
	}

}