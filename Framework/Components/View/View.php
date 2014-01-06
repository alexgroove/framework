<?php

namespace Framework\Components\View;
use Framework\Components\View\Interfaces\IView;
use Framework\Components\View\Exceptions\NoStylesheetFoundException;
use Framework\Components\View\Exceptions\CacheFolderMissingException;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class View
 *
 * @author Alexandre Pagé
 *
 */
class View implements IView {



	/**
	 *
	 * @constant TEMPLATE_EXTENSION
	 *
	 */
	const TEMPLATE_EXTENSION = '.xsl';


	/**
	 *
	 * @constant CACHE_FOLDER
	 *
	 */
	const CACHE_FOLDER = 'public/cache/';


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
	 * @var $cache_file_name
	 * @access private
	 *
	 */
	private $cache_file_name;

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
	 * Caching can only take place in production ENVIRONMENT
	 * @access public
	 * @param (string) $path - path to view stylesheet (without extension)
	 * @param (bool) $cache - if the result should use caching
	 * @param (int) $cachetime - number of second 
	 * @return (string) - transformation result
	 *
	 */
	public function render ($path, $cache=false, $cachetime=300) {
		if ($cache && ENVIRONMENT == PRODUCTION) {
			if (!is_dir(self::CACHE_FOLDER)) {
				throw new CacheFolderMissingException(self::CACHE_FOLDER);
			}
			$this->cache_file_name = self::CACHE_FOLDER.md5($path);
			if (file_exists($this->cache_file_name)) {
				if (time() - $cachetime < @filemtime($this->cache_file_name)) {
					return file_get_contents($this->cache_file_name);
				}
			}
		}
		$stylesheet_path = $path.self::TEMPLATE_EXTENSION;
		if (!file_exists($stylesheet_path)) {
			throw new NoStylesheetFoundException ($stylesheet_path);
		}
		$this->processor->importStylesheet(simplexml_load_file($stylesheet_path));
		if ($result = $this->processor->transformToXml(simplexml_load_string($this->package->compressToXml()))) {
			if ($cache && ENVIRONMENT == PRODUCTION) {
				file_put_contents($this->cache_file_name, $result);
			}
			return $result;
		} else {
			pprint(libxml_get_errors());
		}
	}
}

