<?php

namespace DroneMill\Helpers\Stdclass;


/**
 * General utils for Misc things
 */
class Misc
{
	/**
	 * Pasrse the host id from the host id config file
	 *
	 * @return int $host_id
	 */
	public static function property_default($value, $property, $default)
	{
		if (isset($value->$property)) return $value->$property;

		return $default;
	}

	public static function pluck($values, $property, $default = null)
	{
		if (! is_array($values))
		{
			return (isset($values->$property) ? $values->$property : $default);
		}

		$return = array();

		foreach ($values as $value)
		{
			if (isset($value->$property))
			{
				$return[] = $value->$property;
			}
		}

		return $return;
	}
}
