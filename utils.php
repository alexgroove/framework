<?php

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * - utils.php
 *
 * This file contains all the utilities functions that are global on all the framework
 *
 * @author Alexandre Pagé
 *
 */

	
/**
 *
 * pprint 
 * This function is useful to print on the browswer complex object
 * 
 * @param (string) $str -- message to be echo
 *
 */
function pprint ($str) {
	echo '<pre>'.print_r($str, true).'</pre>';
}


/**
 *
 * location
 * To get the url of the site, depending on where it is host
 *
 * @return (string) $location -- current url location
 *
 */
function location () {
	$location = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/';
	if (substr($location, -2) == '//') {
		return substr($location, -1);
	}
	return $location;
}


/**
 *
 * c2d (Camelcase to Dash)
 * Transform any camelcase string into a dashed pattern string
 *
 * @param (string) $str -- string to be transform
 * @return (string) -- transformation result
 *
 */
function c2d ($str) {
 	$str[0] = strtolower($str[0]);
	$callback = create_function('$c', 'return "-" . strtolower($c[1]);');
  return preg_replace_callback('/([A-Z])/', $callback, $str);	
}


/**
 *
 * c2c (Camelcase to Underscore)
 * Transform any camelcase string into a underscrore pattern string
 *
 * @param (string) $str -- string to be transform
 * @return (string) -- transformation result
 *
 */
function c2u ($str) {
 	$str[0] = strtolower($str[0]);
	$callback = create_function('$c', 'return "_" . strtolower($c[1]);');
  return preg_replace_callback('/([A-Z])/', $callback, $str);	
}


/**
 *
 * u2c (Underscore to Camelcase)
 * Transform any underscore string into a camelcase pattern string
 *
 * @param (string) $str -- string to be transform
 * @param (bool) $capitalise_first_char -- set if the first chacracter is capitalize
 * @return (string) -- transformation result
 * 
 */
function u2c ($str, $capitalise_first_char=true) {
  if($capitalise_first_char) {
    $str[0] = strtoupper($str[0]);
  }
  $callback = create_function('$c', 'return strtoupper($c[1]);');
  return preg_replace_callback('/_([a-z])/', $callback, $str);	
}


/**
 *
 * - generate_secure_id
 * This function generate a secure 64 bit id using sha256 algorithm
 *
 * @return (string) -- unique 64 character string
 *
 */
function generate_secure_id () {
	return hash('sha256', uniqid(rand(), true));
}


/**
 *
 * - prefix_array 
 * This function prefix a numeric array so it becomes associative
 * Uselful when passing a numeric array to the view int the ArrayToXml, 
 * because otherwise it generate an Exception
 * @param (array) $array
 * @param (string) $prefix
 * @return (array)
 *
 */
function prefix_array ($array=array(), $prefix='prefix') {
	$acc = array();
	foreach($array as $key => $value) {
		$acc[$prefix.$key] = $value;
	}
	return $acc;
}


/**
 *
 * - plural
 * This function return a plural version of the string
 * @param (string) $str
 * @return (string)
 *
 */
function plural ($str='') {
	if (substr($str, -2) == 'ss') {
		return $str.'es';
	}
	switch (substr($str, -1)) {
		case 'y': return substr($str, 0, -1).'ies';
		case 's': return $str;
		default : return $str.'s';
	}
}


/**
 *
 * - singular
 * This function return a singular version of a string
 * @param (string) $str
 * @return (string)
 *
 */
function singular ($str='') {
	if (substr($str, -4) == 'sses') {
		return substr($str, 0, -2);
	}
	if (substr($str, -3) == 'ies') {
		return substr($str, 0, -3).'y';
	} else {
		return rtrim($str, 's');
	}
}


/**
 *
 * - ls
 * This function scan all files from a directory.
 * @param (string) $dir_path
 * @param (bool) $showHiddenFiles - default = false
 * @return (array)
 *
 */
function ls ($dir_path='.', $showHiddenFiles=false) {
	$files = scandir($dir_path);
	$acc = array();
	if ($showHiddenFiles) {
		return $files;
	}
	foreach($files as $file) {
		if ($file[0] != '.') {
			$acc[] = $file;
		}
	}
	return $acc;
}


/**
 *
 * - get_class_name
 * This function is useful for getting the class name without the namespace
 * @param (string) $class
 * @param (string) $namespace
 * @example get_class_name(__CLASS__, __NAMESPACE__)
 * @return (string)
 *
 */
function get_class_name ($class, $namespace='') {
	return ltrim($class, $namespace);
}


/**
 *
 * - is_associative_array 
 * Method that check if an array is the format associative
 * @static
 * @access private
 * @param (array) $arr
 * @return (bool)
 *
 */
function is_associative_array ($arr) {
	return array_keys($arr) !== range(0, count($arr) - 1);
}


/**
 *
 * -seo_url_fix
 * This function replace the space by dash and put the first word with a uppercase.
 * @param (string) $str
 * @return (string)
 *
 */
function seo_url_fix ($str) {
	return strtr(ucfirst(preg_replace('/\s+/', '-', $str)), array('é'=>'e', 'è'=>'e'));
}
