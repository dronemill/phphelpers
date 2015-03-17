<?php

namespace DroneMill\Helpers\String;

Class Misc
{

	/**
	 * function string_random
	 *
	 * Generate random string
	 *
	 * @param int $length the length of the string to return
	 * @param string $character_set (optional) the set of characters to use
	 * @return string $random_string
	 */
	public static function random($length = 0, $character_set = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		if ($length === 0 || (! is_numeric($length)))
		{
			return false;
		}

		$random_string = '';
		$set_length = strlen($character_set) - 1;

		for ($i = 0; $i < $length; $i++)
		{
			$random_string .= $character_set[rand(0, $set_length)];
		}

		return $random_string;
	}

	public static function randomHex($length = 16)
	{
		return self::random($length, '0123456789ABCDEF');
	}

	public static function starts_with($haystack, $needle)
	{
		return (substr($haystack, 0, strlen($needle)) === $needle);
	}

	public static function replace_last($str, $search, $replace)
	{
		if (($pos = strrpos($str, $search) ) !== false)
		{
			$search_length = strlen($search);
			$str = substr_replace($str, $replace, $pos, $search_length);
		}

		return $str;
	}
}
