<?php

namespace Framework\Components\View;
use Framework\Components\View\Interfaces\IXmlPacket;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class XmlPacket
 * 
 * @author Alexandre Pagé
 *
 */
class XmlPacket implements IXmlPacket {


	/**
	 *
	 * @var $nodeName
	 * @access private
	 *
	 */
	private $nodeName;


	/**
	 *
	 * @var $data
	 * @access private
	 *
	 */
	private $data;


	/**
	 *
	 * XmlPacket Contructor
	 * @param (string) $nodeName
	 * @param (mixed) $data
	 *
	 */
	public function __construct ($nodeName, $data) {
		$this->nodeName = $nodeName;
		$this->data = $data;
	}


	/**
	 *
	 * - transform
	 * This function transform $this->data into XML
	 * @access public
	 * @return DOMDocument
	 *
	 */
	public function transform () {
		switch(true) {
			// If data is a string or number;
			case !is_array($this->data) ? true : false:
				$result = ArrayToXml::createXml($this->nodeName, array('@value'=>$this->data));
				break;
			// If data is an array of array
			case !is_associative_array($this->data) ? true : false:
				$model_name = singular($this->nodeName);
				// $model_name = rtrim($this->nodeName, 's'); // Trimming 's', example: shops => shop
				$acc = array($model_name => array());
				foreach($this->data as $data) {
					$acc[$model_name] []= (array)$data;
				}
				$result = ArrayToXml::createXml($this->nodeName, $acc);
				break;
			// If data is an associative array
			case is_associative_array($this->data): 
				$result = ArrayToXml::createXml($this->nodeName, $this->data);
				break;
			default : 
				throw new \Exception("Data format is wrong", 1);
				break;
		}
		return $result->documentElement;
	}
}

