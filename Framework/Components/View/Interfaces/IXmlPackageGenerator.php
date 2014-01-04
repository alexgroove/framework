<?php

namespace Framework\Components\View\Interfaces;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * XmlPackageGenerator Interface
 *
 * @author Alexandre Pagé
 *
 */
interface IXmlPackageGenerator {

	public function __construct ($container_name);

	public function add ($nodeName, $data);

	public function compressToXml ();

}


