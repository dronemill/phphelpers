<?php

namespace DroneMill\Helpers;

class ArraysException extends \Exception {}

class Arrays
{
	/**
	 * Ensure key(s) are present
	 *
	 * @param mixed $key the key to check against || an array of keys
	 * @param array $array the array to check the keys of
	 * @return boolean
	 */
	public static function ensure_key_present($key, $array)
	{
		// ensure that the array we are checking is an array
		if (! is_array($array))
		{
			throw new ArraysException('Value of $array is not an array');
		}

		// if we are not checking an array of keys,
		// then just return array_key_exists check
		if (! is_array($key))
		{
			return array_key_exists($key, $array);
		}

		// gather the keys of the array
		$array_keys = array_keys($array);

		// itterate over the keys to check
		foreach ($key as $check_key)
		{
			// if the key does not exists
			if (! in_array($check_key, $array_keys))
			{
				// return false
				return false;
			}
		}

		// all keys exist
		return true;
	}


	/**
	 * Convert an array into an associative array
	 *
	 * @param array $columns the columns to match indexes on
	 * @param array $array the data array to process
	 */
	public static function make_assoc($columns, $array)
	{
		/* init the array */
		$assoc = array();

		/* set the cursor to */
		$cursor = 0;

		/* itterate over the data, and combine the data */
		foreach ($array as $record)
		{
			foreach ($record as $key => $value)
			{
				$assoc[$cursor][$columns[$key]] = $value;
			}
			$cursor++;
		}

		return $assoc;
	}


	/**
	 * emulate the MySql group concat function for a result set
	 *
	 * @param array $data the data array to process
	 * @param string|array $column the column to concat
	 * @param boolean $strings treat the values as strings
	 * @param string $quotes the quotes to use when handeling strings
	 * @return array('column']=>'concated_string',...)
	 */
	public static function group_concat($data, $column, $strings = false, $quotes = '\'')
	{
		if (is_string($column))
		{
			$column = array($column);
		}

		/* init the return array */
		$return = array();
		foreach ($column as $col)
		{
			$return[$col] = ($strings ? $quotes : '');
		}

		/* itterate over the data */
		foreach ($data as $row)
		{
			foreach ($column as $col)
			{
				$return[$col] .= $row[$col] . ($strings ? ($quotes . ',' . $quotes) : ',');
			}
		}

		/* clean up the trailing comma */
		foreach ($return as $column => $ret)
		{
			/* if the string is empty, continue on */
			if (($length = strlen($ret)) < 1) continue;

			/* the length to trim off */
			$trim = 1;
			if ($strings)
			{
				$trim = strlen($quotes) + 1;
			}

			$return[$column] = substr($ret, 0, $length - $trim);
		}

		/* return the values */
		return $return;
	}


	/**
	 * column of array to key
	 *
	 * @param array $data the data to process
	 * @param mixed the column to store as the array key
	 * @return the processed array
	 */
	public static function value_to_key($data, $column)
	{
		/* init the return array */
		$return = array();

		/* itterate over all the elements */
		foreach ($data as $key => $val)
		{
			if (is_object($val))
			{
				$return[$val->$column] = $val;
			}
			else
			{
				$return[$val[$column]] = $val;
			}
		}

		/* return the array */
		return $return;
	}


	/**
	 * pluck a value(s) from an array or stdClass
	 *
	 * @param array $data the data array
	 * @param mixed array|string $values of the values to pluck
	 * @param boolean $one_deep, set to true,  if we should iterate over the first
	 *        level of elements in the data array. Assumes data is array.
	 * @return array of results
	 */
	public static function pluck($data, $values, $one_deep = false)
	{
		if ($one_deep && is_array($data))
		{
			$return = array();

			foreach ($data as $dat)
			{
				$return[] = self::pluck($dat, $values);
			}

			return $return;
		}

		$is_object = is_object($data);

		if (! is_array($values))
		{
			if ($is_object) return $data->$values;

			return $data[$values];
		}

		$result = ( $is_object ? new \stdClass : array() );

		foreach ($values as $value)
		{
			if ($is_object)
			{
				$result->$value = $data->$value;
			}
			else
			{
				$result[$value] = $data[$value];
			}
		}

		return $result;
	}


	/**
	 * merge two arrays and maintain key structure. (sane array_merge function)
	 *
	 * ref: http://www.epochdev.com/blog/tutorials/php_development/array_merge_retain
	 *
	 * @param array $array_a
	 * @param array $array_b
	 * @return merged array
	 */
	public static function merge_retain_recursive($array_a = array(), $array_b = array())
	{
		$array_merge = $array_a;

		if (empty($array_a) && empty($array_b))
		{
			return $array_merge;
		}

		foreach ($array_b as $field => $value)
		{
			if (! array_key_exists($field, $array_a))
			{
				$array_merge[$field] = $value;
				continue;
			}

			if (! empty($value))
			{
				if (is_array($array_merge[$field]) && is_array($value))
				{
					$array_merge[$field] = self::merge_retain_recursive($array_merge[$field], $value);
				}
				else
				{
					$array_merge[$field] = $value;
				}
			}
		}

		return $array_merge;
	}


	/**
	 * Ensure a key is present in the array
	 *
	 * @method  ensureKeyExists
	 * @param   array           $array  the array to check in
	 * @param   mixed           $key    the key to check for
	 * @param   mixed           $value  new value if key doesnt exist. Default Array
	 * @return  void
	 */
	public static function ensureKeyExists(&$array, $key, $value = [], $return = false)
	{
		if (! array_key_exists($key, $array))
		{
			$array[$key] = $value;
		}

		if ($return)
			return $array;
	}
}
