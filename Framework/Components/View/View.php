<?php

namespace Framework\Components\View;
use Framework\Components\View\Exceptions\NoStylesheetFoundException;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class View
 *
 * @author Alexandre Pagé
 *
 */
class View {


	/**
	 *
	 * @var $package
	 * @access private
	 *
	 */
	private $package;


	/**
	 *
	 * @var $processor
	 * @access private
	 *
	 */
	private $processor;


	/**
	 *
	 * @var $template_extension
	 * @access private
	 *
	 */
	private $template_extension = '.xsl';


	/**
	 *
	 * View Conctructor
	 * This constructor instanciate the XML package, instanciate the XSLTProcessor
	 * and register the PHP functions to the processor.
	 *
	 */ 
	public function __construct () {
		$this->package = new XmlPackageGenerator ();
		$this->processor = new \XSLTProcessor ();
		$this->processor->registerPHPFunctions();
	}


	/**
	 *
	 * - bind 
	 *  This method bind a xml node to some data, if data is an object, 
	 * it is cast as an array.
	 * @access public
	 * @param (string) $name
	 * @param (mixed) $data
	 *
	 */
	public function bind ($name, $data=array()) {
		$this->package->add($name, (array)$data);
	}


	/**
	 *
	 * - set
	 * This method set a parameter for XSL template
	 * @example The title or meta tags
	 * @access public
	 * @param (string) $key
	 * @param (string) $value
	 *
	 */
	public function set ($key, $value) {
		$this->processor->setParameter('', $key, $value);
	}


	/**
	 *
	 * - render
	 * @access public
	 * @param (string) $path - path to view stylesheet (without extension)
	 * @return (string) - transformation result
	 *
	 */
	public function render ($path) {
		$stylesheet_path = $path.$this->template_extension;
		if (!file_exists($stylesheet_path)) {
			throw new NoStylesheetFoundException ($stylesheet_path);
		}
		$this->processor->importStylesheet(simplexml_load_file($stylesheet_path));
		if ($result = $this->processor->transformToXml(simplexml_load_string($this->package->compressToXml()))) {
			return $result;
		} else {
			// Print XML errors if the views didnt render properly
			pprint(libxml_get_errors());
		}
	}
}

