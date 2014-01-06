<?php

namespace Framework\Components\Routing;
use Framework\Components\Routing\Interfaces\IResponse;

defined('CORE_EXEC') or die('Restricted Access');


class Response {


	/**
	 *
	 * HTTP constant code
	 *
	 */
	const HTTP_OK = '200 OK';
	const HTTP_NOT_FOUND = '404 Not Found';
	const HTTP_FORBIDDEN = '403 Forbidden';


	/**
	 *
	 * @var $content
	 * @access private
	 *
	 */
	private $content;


	/**
	 *
	 * @var $http_code
	 * @access private
	 *
	 */
	private $http_code;


	/**
	 *
	 * @var $content_type
	 * @access private
	 *
	 */
	private $content_type;

	
	/**
	 *
	 * Response Contructor
	 * @access public
	 * @param (string) $content;
	 * @param (Reponse constant) $http_code
	 * @param (string) $content_type
	 *
	 */	
	public function __construct ($content='', $http_code=self::HTTP_OK, $content_type='text/html') {
		$this->content = $content;
		$this->http_code = $http_code;
		$this->content_type = $content_type;
	}

	
	/**
	 *		
	 * - setContentType		
	 * @access public
	 * @param (string) $content_type
	 *		
	 */
	public function setContentType ($content_type) {
		$this->content_type = $content_type;
	}


	/**
	 *		
	 * - setStatusCode
	 * @access public
	 * @param (Response constant) $http_code
	 *		
	 */
	public function setStatusCode ($http_code) {
		$this->http_code = $http_code;
	}


	/**
	 *		
	 * - setContent	
	 * @access public
	 * @param (string) $content
	 *		
	 */
	public function setContent ($content) {
		$this->content = $content;
	}


	/**
	 *		
	 * - send		
	 * @access public
	 * @param $content (optional) - use to faster sending content.
	 *		
	 */
	public function send($content='') {
		header('HTTP/1.1 '. $this->http_code);
		header('Content-type: '.$this->content_type);
		echo empty($content) ? $this->content : $content;

	}
}