<?php

namespace App\Components\AppController\Interfaces;

defined('CORE_EXEC') or die('Restricted Access');


interface IFlashMEssenger {

	public function __construct ();

	public function setMessage ($message);

	public function getMessage ();
}