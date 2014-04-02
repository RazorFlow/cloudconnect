<?php
/**
 * @class ArrayUtils
 */
class ArrayUtils {
  /**
   * Extract a list of properties from an indexed array of associative arrays.
   *
   * Example:
   * pluck([{name: 'moe', age: 40}, {name: 'larry', age: 50}, {name: 'curly', age: 60}], 'name');
   *
   * ==> ["moe", "larry", "curly"]
   *
   * This can be used to extract a column from the result of a SQL query fetched as an associative array
   * @param {array} $data The data
   * @param {string} $columnKey The key of the column to pluck
   * @param  {boolean} $replaceEmptyWithNull If there is no item found on that key, replace with a null (default true)
   * @return {array}
   */
  public static function pluck ($data, $columnKey, $replaceEmptyWithNull = true) {
  	$results = array();

  	foreach ($data as $row) {
  		if(isset($row[$columnKey])) {
  			$results []= $row[$columnKey];
  		}
  		else if ($replaceEmptyWithNull) {
  			$results []= null;
  		}
  	}

  	return $results;
  }	
}