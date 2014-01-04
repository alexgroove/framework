<?php

namespace Framework\Components\Process\Interfaces;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Process Interface
 *
 * @author Alexandre Pagé
 *
 */
interface IProcess {

	public function __construct ($route, $request);

	public function execute ();

}


