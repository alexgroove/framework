<?php

namespace Framework\Components\View;
use Framework\Components\View\Interfaces\IView;
use Framework\Components\View\Exceptions\NoStylesheetFoundException;
use Framework\Components\View\Exceptions\WrongDataFormatException;
use Framework\Components\View\Exceptions\CannotBindDataWithNoNameException;
use Framework\Components\Model\Model;
use Framework\Components\Session\Session;

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
	public function bind ($name='', $data=array()) {
		if (!is_string($name) || empty($name)) {
			throw new CannotBindDataWithNoNameException();
		}
		$this->package->add($name, self::prepare($data));
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
	 * @param (string or nothing) $path - path to view stylesheet (without extension)
	 * @return (string) - transformation result
	 *
	 */
	public function render ($path='') {
		/**
		 * If not path is given, the default is to take the name of the called controller
		 * as the Views Folder and the name of the action for the stylesheet
		 */
		if (empty($path)) {
			$route = Session::read('ROUTE');
			$controller = $route['controller'];
			$action = $route['action'];
			$path = 'App/Views/'.$controller.'/'.$action;
		}
		$stylesheet_path = $path.self::TEMPLATE_EXTENSION;
		if (!file_exists($stylesheet_path)) {
			throw new NoStylesheetFoundException ($stylesheet_path);
		}
		$this->processor->importStylesheet(simplexml_load_file($stylesheet_path));
		if ($result = $this->processor->transformToXml(simplexml_load_string($this->package->compressToXml()))) {
			return $result;
		}
		else {
			// Should fine a better way to show the xml errors.
			pprint(libxml_get_errors());
		}
	}


	/**
	 *
	 * - prepare
	 * @static
	 * @access private
	 * @param (object) - $object
	 * @return (array)
	 * This method is a fix when passing a Model object that has HAS_MANY or 
	 * HAS_ONE constant activated. Because it creates properties that are functions.
	 *
	 */
	private static function prepare ($object) {
		if ($object instanceof Model) {
			$acc = array();
			foreach($object as $key => $value) {
				if (!is_callable($value)) {
					$acc[$key] = $value;
				}
			}
			return $acc;
		}
		return (array)$object;
	}
}














