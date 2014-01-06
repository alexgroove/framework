<?php

namespace Framework\Components\Routing\Interfaces;

defined('CORE_EXEC') or die('Restricted Access');


interface IResponse {

	public function __construct ($content, $http_code, $content_type, $http_caching);

	public function setContentType ($content_type);

	public function setStatusCode ($http_code);

	public function setContent ($content);

	public function setCaching ($http_caching);

	public function send($content);

}

