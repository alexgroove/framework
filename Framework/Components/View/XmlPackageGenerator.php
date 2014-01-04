<?php

namespace Framework\Components\View;
use Framework\Components\View\Interfaces\IXmlPackageGenerator;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class XmlPackageGenerator
 * 
 * @author Alexandre Pagé
 *
 */
class XmlPackageGenerator implements IXmlPackageGenerator {


	/**
	 *
	 * @var $package
	 * @access private
	 *
	 */
	private $package;


	/**
	 *
	 * @var (array) $packets
	 * @access private
	 *
	 */
	private $packets = array();


	/**
	 *
	 * XmlPackageGenerator Constructor
	 * @param (string) $container_name
	 *
	 */
	public function __construct ($container_name='XML_PARTIAL_CONTAINER') {
		$this->package = new \DOMDocument ();
		$this->package->loadXml('<'.$container_name.'/>');
	}


	/**
	 *
	 * - add
	 * @access public 
	 * @param (string) $nodeName
	 * @param (array) $data
	 *
	 */
	public function add ($nodeName, $data) {
		$this->packets []= new XmlPacket($nodeName, $data);
	}


	/**
	 *
	 * - compressToXml
	 * @access public
	 * @return (string) - XML string
	 *
	 */
	public function compressToXml () {
		foreach($this->packets as $packet) {
			$packet = $this->package->importNode($packet->transform(), true);
			$this->package->documentElement->appendChild($packet);
		}
		return $this->package->saveXml();
	}
}

