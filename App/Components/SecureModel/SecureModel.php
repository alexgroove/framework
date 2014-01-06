<?php

namespace App\Components\SecureModel;
use Framework\Components\Model\Model;
use App\Components\SecureModel\Exceptions\MissingSecureFieldsException;
use App\Components\SecureModel\Exceptions\UnknownCredentialException;
use App\Components\SecureModel\Interfaces\ISecureModel;


defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * App Component Secure Model
 * 
 * --- IMPORTANT ---
 * All child model MUST implement a constant SECURE_FIELDS. This constant is a comma separeted list.
 *
 * @author Alexandre Pagé
 *
 */
abstract class SecureModel extends Model implements ISecureModel {


	/**
	 *
	 * - save
	 * This method overwrite the default Model::save to make secure needed fields.
	 * This method also verified if there is no other entries with the same secure fields.
	 * @return (bool) - Model::save method or more than one secure fields in database
	 *
	 */
	public function save () {
		if (!defined('static::SECURE_FIELDS')) {
			throw new MissingSecureFieldsException(self::get_child_model());
		}
		$secure_fields = explode(',', static::SECURE_FIELDS);
		$search_fields = array();
		foreach($secure_fields as $field) {
			$this->$field = hash('sha256', $this->$field);
			$search_fields[$field] = $this->$field;
		}

		// Check if the secure fields combinaison is unique in the model table.
		if (count(self::find($search_fields)) != 0) {
			return false;
		}
		return parent::save();
	}


	/**
	 *
	 * -secure_get
	 * This method fetch the the model associate with the right credentials
	 * @param (array) $credentials
	 * @return (mixed) - array of the model or false
	 *
	 */
	public static function secure_get ($credentials=array()) {
		$secure_fields = explode(',', static::SECURE_FIELDS);
		foreach($secure_fields as $field) {
			if (!isset($credentials[$field])) {
				throw new UnknownCredentialException($field);
			}
			$credentials[$field] = hash('sha256', $credentials[$field]);
		}
		$result = self::find($credentials, 1);
		if (count($result) == 1)
			return $result[0];
		return false;
	}

}














