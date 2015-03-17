<?php

namespace DroneMill\Helpers;

class Date
{
	public static function convert_timezone($timestamp, $timestamp_timezone, $new_timezone)
	{
		$new_timezone = new \DateTimeZone($new_timezone);
		$timestamp_timezone = new \DateTimeZone($timestamp_timezone);

		$datetime = new \DateTime($timestamp, $timestamp_timezone);
		$datetime->setTimezone($new_timezone);

		return $datetime;
	}

	public static function format_ISO8601($timestamp, $timezone = 'UTC')
	{
		if (is_null($timestamp) || ($timestamp === "0000-00-00 00:00:00"))
		{
			return null;
		}

		if (! $timezone instanceof \DateTimeZone)
		{
			$timezone = new \DateTimeZone($timezone);
		}

		if (! $timestamp instanceof \DateTime)
		{
			$timestamp = new \DateTime($timestamp, $timezone);
		}

		return $timestamp->format(\DateTime::ISO8601);
	}
}
