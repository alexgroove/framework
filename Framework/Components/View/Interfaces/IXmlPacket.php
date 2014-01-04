<?php

namespace Framework\Components\View\Interfaces;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * XmlPacket Interface
 *
 * @author Alexandre Pagé
 *
 */
interface IXmlPacket {

	public function __construct ($nodeName, $data);

	public function transform ();

}


