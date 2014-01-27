<?php

namespace Framework\Components\Model;
use Framework\Components\Model\Interfaces\IModel;
use Framework\Components\Model\Exceptions\UnknownPropertyException;
use Framework\Components\Model\Exceptions\MissingTableNameException;
use Framework\Components\Model\Exceptions\MissingForeignKeyException;
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
	 * HAS_MANY constant
	 *
	 * Use this constant if the model as a one too many relationship with another model.
	 * Use a string representing the name of the model. 
	 * Also the other model must have a property following this pattern: 
	 * - (singlular table name)_id
	 * @example 
	 * Recipe model, HAS_MANY = 'Ingredient'
	 * Ingredient model, public $recipe_id
	 * $recipe = new Recipe(1);
	 * print_r($recipe->getIngredients());
	 *
	 */


	/**
	 *
	 * HAS_ONE constant
	 *
	 * Use this constant if the model as a many to one relationship with another model.
	 * Use a string representing the name of the model.
	 * Also the current model must have a property following the pattern:
	 * - (singlular table name)_id	 
	 * @example 
	 * Ingredient model, HAS_ONE = 'Recipe'
	 * $ingredient = new Ingredient(1);
	 * echo $ingredient->getRecipe()->name;
	 *
	 */


	/**
	 *
	 * Model Constructor
	 * Bind all $inputs to class variables or find the right model associate with an id.
	 * Generate the relationships getter from child constant model name HAS_MANY and HAS_ONE, 
	 * if they are defined.
	 * @param (mixed) $id_or_array
	 *
	 */
	public function __construct ($id_or_array=array()) {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}		
		$model = self::get_child_model();
		$inputs = is_array($id_or_array) ? $id_or_array : $model::find($id_or_array);
		foreach($inputs as $key => $value) {
			if(!property_exists($model, $key)) {
				throw new UnknownPropertyException($model, $key);
			}
			$this->$key = $value;
		}
		if (defined('static::HAS_MANY')) {
			foreach(explode(',', static::HAS_MANY) as $link_model) {
				$link_model = trim($link_model);
				$has_many_model_name = '\\App\\Models\\'.$link_model;
				$has_many_model = new $has_many_model_name();
				$has_many_model_method_name = 'get'.plural($link_model);
				$host = $this;
				$has_many_model_method_function = function () use ($host, $has_many_model) {
					$foreign_key = singular($host::TABLE_NAME).'_id';
					if (!property_exists($has_many_model, $foreign_key)) {
						throw new MissingForeignKeyException($has_many_model, $foreign_key);
					}
					return $has_many_model::find(array($foreign_key => $host->id));
				};
				$this->$has_many_model_method_name = $has_many_model_method_function;
			}
		}
		if (defined('static::HAS_ONE')) {
			foreach(explode(',', static::HAS_ONE) as $link_model) {
				$link_model = trim($link_model);
				$has_one_model_name = '\\App\\Models\\'.$link_model;
				$has_one_method_name = 'get'.$link_model;
				$host = $this;
				$has_one_method_function = function () use ($has_one_model_name, $host) {
					$has_one_model = new $has_one_model_name();
					$foreign_key = singular($has_one_model::TABLE_NAME).'_id';
					if (!property_exists($host, $foreign_key)) {
						throw new MissingForeignKeyException($host, $foreign_key);
					}
					return new $has_one_model_name($host->$foreign_key);
				};
				$this->$has_one_method_name = $has_one_method_function;
			}
		}
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
	 * Model function extender
	 * @param $method
	 * @param @args
	 *
	 */
	public function __call ($method, $args=array()) {
		if (isset($this->$method)) {
			$func = $this->$method;
      return call_user_func_array($func, $args);
    }	
  }


  /**
   *
   * toString magic method
   *
   */
  public function __toString () {
  	pprint($this); return '';
  }


	/**
	 *
	 * - save
	 * This function check if an $id is not empty, if yes, it update the model at thid $id.
	 * Otherwise, it create a new row in the database if the $inputs values.
	 * It also remove the getters from foreign key relationships.
	 * @access public
	 * @return (array) - result from create method
	 *
	 */
	public function save () {
		$inputs = array();
		foreach($this as $key => $value) {
			if (!is_callable($value)) {
				$inputs[$key] = $value;
			}
		}
		if ($this->validate()) {
			return (empty($this->id)) ? self::create($inputs) : self::update($this->id, $inputs);
		}
		return false;
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
	 * @static
	 * @access public
	 * @return (array) - result from Database select_all method
	 *
	 */
	public static function all ($limit=-1) {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}		
		return Database::select_all(static::TABLE_NAME, $limit);
	}


	/**
	 *
	 * - find
	 * @static
	 * @access public
	 * @param (mixed) $id_or_array
	 * @return (array) - if param is id, return an array representing on row,
	 * if param is an array, return an array of arrays representing the
	 * matching rows int the table
	 *
	 */	
	public static function find ($id_or_array, $limit=-1) {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}
		if (is_array($id_or_array)) {
			return Database::select_where(static::TABLE_NAME, $id_or_array, $limit);
		} else {
			return Database::select_id(static::TABLE_NAME, $id_or_array);
		}
	}


	/**
	 *
	 * - create
	 * @static
	 * @access private
	 * @param (array) $inputs - columns values
	 * @return (array) - last inserted row
	 *
	 */
	private static function create ($inputs=array()) {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}		
		$id = Database::insert(static::TABLE_NAME, (array)$inputs);
		return Database::select_id(static::TABLE_NAME, $id);
	}


	/**
	 *
	 * - delete
	 * This method delete the row with the param id
	 * @static
	 * @access private
	 * @param (int) $id
	 * @return (array) - deleted row
	 *
	 */
	private static function delete ($id) {
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
	 * @static
	 * @access private
	 * @param (int) $id
	 * @param (array) $inputs
	 * @return (array) - updated row
	 *
	 */
	private static function update ($id, $inputs=array()) {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}		

		Database::update_id(static::TABLE_NAME, $id, $inputs);
		return Database::select_id(static::TABLE_NAME, $id);
	}


	/**
	 *
	 * - validate
	 * This method is the server validation call when save method is call.
	 * Use it in child model to validate.
	 * @access protected
	 * @abstract
	 * @return (bool)
	 *
	 */ 
	abstract protected function validate ();


	/**
	 *
	 * - get_child_model 
	 * This method is used internaly to get the child model class
	 * @static
	 * @access private
	 *
	 */
	private static function get_child_model () {
		if (!defined('static::TABLE_NAME')) {
			throw new MissingTableNameException();
		}
		$trace = debug_backtrace();
		return $trace[1]['object'];
	}
}

