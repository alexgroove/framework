<?php

namespace Framework\Components\View\Interfaces;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * View Interface
 *
 * @author Alexandre Pagé
 *
 */
interface IView {

	public function __construct ();

	public function bind ($name, $data);

	public function set ($key, $value);

	public function render ($path);	

}


