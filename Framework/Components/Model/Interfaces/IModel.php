<?php

namespace Framework\Components\Model\Interfaces;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Model Interface
 *
 * @author Alexandre Pagé
 *
 */
interface IModel {


	/**
	 *
	 * Model Contructor
	 * If an array is pass, it check if all properties exists and instanciate a model object with it.
	 * If an id is pass, it use the find method to get the properties and then instanciate the object.
	 * @access public
	 * @param (mixed) $id_or_array
	 *
	 */
	public function __construct ($id_or_array);


	/**
	 *
	 * - save
	 * This function check if an $id is not empty, if yes, it update the model at thid $id.
	 * Otherwise, it create a new row in the database if the $inputs values.
	 * @access public
	 * @return (array) - result from create method
	 *
	 */
	public function save ();


	/**
	 *
	 * - remove 
	 * This function remove a row with the id of the model object
	 * @access public
	 * @return (array) - delete model
	 *
	 */
	public function remove ();


	/**
	 *
	 * - all
	 * This method return all the rows of the model
	 * @static
	 * @return (array) - result from Database select_all method
	 *
	 */
	public static function all ($limit);


	/**
	 *
	 * - find
	 * This method find either an array of row mathcing an array of condition, or one row with specific id
	 * @static
	 * @param (mixed) $id_or_array
	 * @return (mixed) - if param is id, return an array representing on row,
	 * if param is an array, return an array of arrays representing the
	 * matching rows int the table
	 *
	 */	
	public static function find ($id_or_array, $limit);

}








