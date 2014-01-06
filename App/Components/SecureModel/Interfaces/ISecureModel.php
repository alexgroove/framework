<?php

namespace App\Components\SecureModel\Interfaces;
use Framework\Components\Model\Interfaces\IModel;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * App Component
 * Secure Model Interface
 *
 * @author Alexandre Pagé
 *
 */
interface ISecureModel extends IModel {

	public static function secure_get ($credentials);
}
