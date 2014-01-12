<?php

namespace Framework\Components\Database;
use Framework\Components\Database\Interfaces\IDatabase;
use Framework\Components\Database\Exceptions\UnknownIdentifierException;
use Framework\Components\Database\Exceptions\QueryErrorException;
use PDO;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class Database
 *
 * This database class use the PHP PDO extension.
 *
 * @author Alexandre Pagé
 *
 */
class Database implements IDatabase {


	/**
	 *
	 * @var $instance
	 * @access private
	 * @static
	 *
	 * class variable that hold the database PDO conection
	 *
	 */
	private static $instance;


	/**
	 *
	 * private constructor
	 * @access private
	 *
	 */
	private function __construct () {}


	/**
	 *
	 * - init
	 * @access public 
	 * @static
	 * This method make the connection with PDO
	 * It also register a shutdown function the close the Database connection
	 *
	 */
	public static function init () {
		// The registration is use to prevent a database connection to stay open
		// when a script fail. It set the connection instance to null, ready
		// for garbage collection.
		register_shutdown_function(function () {
			self::$instance = null;
		});
		if (is_null(self::$instance)) {
			self::$instance = new PDO ('mysql:host='.HOST.';dbname='.DATABASE, USER, PASSWORD);
			self::$instance->exec('SET NAMES UTF8');
			self::$instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
		}
	}


	/**
	 *
	 * - select_all 
	 * @access public
	 * @static
	 * This method fetch as a associative array, all the content from a table.
	 *
	 * @param (string) $table_name - name of the table in database
	 * @return (array) $result
	 *
	 */
 	public static function select_all ($table_name, $limit=-1) {
 		$query_str = "SELECT * FROM $table_name";	 		
 		if ($limit > -1) {
 			$query_str .= " LIMIT $limit";
 		}
		if (!$statement = self::$instance->query($query_str)) {
			throw new QueryErrorException(__METHOD__, self::$instance->errorInfo());
		}
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		$statement->closeCursor();
		return $result;
	}


	/**
	 *
	 * - select_id 
	 * @access public
	 * @static
	 * This method select the first result from a row that has the requested id
	 *
	 * @param (string) $table_name - name of the table in database
	 * @param (string or int) $id - id of the row
	 * @return (array) $result
	 *
	 */
	public static function select_id ($table_name, $id) {
		$statement = self::$instance->prepare("SELECT * FROM $table_name WHERE id = :id");
		if (!$statement) {
			throw new QueryErrorException(__METHOD__, self::$instance->errorInfo());
		}
		$statement->bindParam(':id', $id, PDO::PARAM_INT);
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		$statement->closeCursor();
		if (!$result) {
			throw new UnknownIdentifierException($table_name, $id);
		}
		return $result ? $result : array();
	}


	/**
	 *
	 * - select_where
	 * @access public
	 * @static	 
	 * This method fetch row that math all conditions
	 *
	 * @param (string) $table_name - name of the table in database
	 * @param (array) $conditions - search conditions
	 * @return (array) $result
	 *
	 */
	public static function select_where ($table_name, $conditions=array(), $limit=-1) {
		$acc = "";
		$bind_params = array();
		foreach($conditions as $key => $value) {
			$acc .= "$key=:$key AND ";
			$bind_params[":$key"] = $value;
		}
		$acc = rtrim($acc, "AND ");

		$query = "SELECT * FROM $table_name WHERE $acc";
		if ($limit > -1) {
			$query .= " LIMIT $limit";
		}
		$statement = self::$instance->prepare($query);
		if (!$statement) {
			throw new QueryErrorException(__METHOD__, self::$instance->errorInfo());
		}		
		$statement->execute($bind_params);
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		$statement->closeCursor();
		return $result;
	}


	/**
	 *
	 * - insert
	 * @access public
	 * @static	 
	 * This method insert ONE row of inputs in a table
	 *
	 * @param (string) $table_name - name of the table in database
	 * @param (array) $inputs - array of columns values
	 * @return (int)  id of the last inserted row
	 *
	 */
	public static function insert ($table_name, $inputs) {
		$keys = "";
		$values = "";
		foreach($inputs as $key => $value) {
			$keys .= $key.',';
			$values .= self::$instance->quote($value).',';
		}
		$keys = rtrim($keys, ',');
		$values = rtrim($values, ',');
		$query = "INSERT INTO $table_name ($keys) VALUES ($values)";
		$nblignes = self::$instance->exec($query);
		if ($nblignes != 1) {
			throw new QueryErrorException(__METHOD__, self::$instance->errorInfo());
		}
		return self::$instance->lastInsertId();
	}


	/**
	 *
	 * - update_id
	 * @access public
	 * @static	 
	 * This method update a row corresponding to the id, with inputs
	 *
	 * @param (string) $table_name - name of the table in database
	 * @param (string or int) $id - id of the row
	 * @param (array) $inputs - array of columns values
	 * @return (bool) 
	 *
	 */
	public static function update_id ($table_name, $id, $inputs=array()) {
		$acc_set = "";
		foreach($inputs as $key => $value) {
			$acc_set .= $key.'='.self::$instance->quote($value).',';
		}
		$acc_set = rtrim($acc_set, ',');
		$query_str = "UPDATE $table_name SET $acc_set WHERE id = $id";
		return self::$instance->exec($query_str);
	}


	/**
	 *
	 * - delete_id
	 * @access public
	 * @static	 
	 * This method delete the row corresponding to the id
	 *
	 * @param (string) $table_name - name of the table in database
	 * @param (string or int) $id - id of the row
	 * @return (bool)
	 *
	 */	
	public static function delete_id ($table_name, $id) {
		$nblignes = self::$instance->exec("DELETE FROM $table_name WHERE id = $id");
		if ($nblignes != 1) {
			throw new UnknownIdentifierException($table_name, $id);
		}
		return true;
	}


	/**
	 *
	 * - query
	 * @access public
	 * @static
	 * This method fetch all the result from a custom query
	 * 
	 * --- DANGER --- 
	 * This method is at risk of sql injection, only use in last resort
	 *
	 * @param (string) $query - custom sql query string
	 * @return (array) $result
	 *
	 */
	 public static function query ($query) {
		return self::$instance->query($query)->fetchAll(PDO::FETCH_ASSOC);
	}


	/**
	 *
	 * - excecute
	 * @access public
	 * @static
	 * This method fetch all the result from a custom query
	 * 
	 * --- DANGER --- 
	 * This method is at risk of sql injection, only use in last resort
	 *
	 * @param (string) $query - custom sql query string
	 * @return (int) 
	 *
	 */	
	public static function execute($query) {
		return self::$instance->exec($query);
	}


	/**
	 *
	 * - get_all_tables
	 * @static 
	 * @access public
	 *
	 */
	public static function get_all_tables () {
		$result = self::$instance->query('SHOW TABLES');
		$acc = array();
		$position = 0;
		while ($table = $result->fetch(PDO::FETCH_NUM)) {
			$acc[] = $table[0];
		}
		return $acc;
	}
}


