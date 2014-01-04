<?php

namespace Framework\Components\Model;
use Framework\Components\Model\Interfaces\IModel;
use Framework\Components\Model\Exceptions\UnknownPropertyException;
use Framework\Components\Model\Exceptions\MissingTableNameException;
use Framework\Components\Database\Database;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class Model
 *
 * This class represent a layer of abstraction over the database tables
 *
 * --- IMPORTANT ---
 * Each child must implement a constant TABLE_NAME, otherwise an Exception is thrown
 *
 * @author Alexandre Pagé
 *
 * @abstract 
 *
 */
abstract class Model implements IModel {


	/**
	 *
	 * Model Constructor
	 * Bind all $inputs to class variables or find the right model associate with an id
	 * @param (mixed) $id_or_array
	 *
	 */
	public function __construct ($id_or_array=array()) {
		$model = self::get_child_model();
		$inputs = is_array($id_or_array) ? $id_or_array : $model::find($id_or_array);
		foreach($inputs as $key => $value) {
			if(!property_exists($model, $key)) {
				throw new UnknownPropertyException($model, $key);
			}
			$this->$key = $value;
		}
	}


	/**
	 *
	 * Model setter
	 * @param $key
	 * @param $value
	 *
	 */
	public function __set ($key, $value) {
		$model = self::get_child_model();
		if (!property_exists($model, $key)) {
			throw new UnknownPropertyException($model, $key);
		}
		$this->$key = $value;
		return $this;
	}


	/**
	 *
	 * Model Getter
	 * @param $key
	 *
	 */
	public function __get ($key) {
		$model = self::get_child_model();
		if (!property_exists($model, $key)) {
			throw new UnknownPropertyException($model, $key);
		}
		return $this->$key;
	}


	/**
	 *
	 * - save
	 * This function check if an $id is not empty, if yes, it update the model at thid $id.
	 * Otherwise, it create a new row in the database if the $inputs values.
	 * @access public
	 * @return (array) - result from create method
	 *
	 */
	public function save () {
		if (!empty($this->id)) {
			return self::update($this->id, (array)$this);
		}
		return self::create((array)$this);
	}


	/**
	 *
	 * - remove 
	 * @access public
	 * @return (array) - delete model
	 *
	 */
	public function remove () {
		return self::delete($this->id);
	}


	/**
	 *
	 * - all
	 * @return (array) - result from Database select_all method
	 *
	 */
	public static function all () {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}		
		return Database::select_all(static::TABLE_NAME);
	}


	/**
	 *
	 * - create
	 * @param (array) $inputs - columns values
	 * @return (array) - last inserted row
	 *
	 */
	protected static function create ($inputs=array()) {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}		
		$id = Database::insert(static::TABLE_NAME, (array)$inputs);
		return Database::select_id(static::TABLE_NAME, $id);
	}


	/**
	 *
	 * - find
	 * @param (mixed) $id_or_array
	 * @return (array) - if param is id, return an array representing on row,
	 * if param is an array, return an array of arrays representing the
	 * matching rows int the table
	 *
	 */	
	public static function find ($id_or_array) {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}
		if (is_array($id_or_array)) {
			return Database::select_where(static::TABLE_NAME, $id_or_array);
		} else {
			return Database::select_id(static::TABLE_NAME, $id_or_array);
		}
	}


	/**
	 *
	 * - delete
	 * This method delete the row with the param id
	 * @param (int) $id
	 * @return (array) - deleted row
	 *
	 */
	protected static function delete ($id) {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}		
		$model = Database::select_id(static::TABLE_NAME, $id);
		Database::delete_id(static::TABLE_NAME, $id);
		return $model;
	}


	/**
	 *
	 * - update
	 * This method update a row with the param id with the inputs
	 * @param (int) $id
	 * @param (array) $inputs
	 * @return (array) - updated row
	 *
	 */
	protected static function update ($id, $inputs=array()) {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}		
		Database::update_id(static::TABLE_NAME, $id, $inputs);
		return Database::select_id(static::TABLE_NAME, $id);
	}


	/**
	 *
	 * - get_child_model 
	 * This method is used internaly to get the child model class
	 * @static
	 * @access private
	 *
	 */
	private static function get_child_model () {
		$trace = debug_backtrace();
		return $trace[1]['object'];
	}
}

