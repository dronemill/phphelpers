<?php

namespace DroneMill\Helpers\String;

class Strip
{
	public static function only_alphanumeric_space($string)
	{
		return preg_replace('/[^0-9a-zA-Z ]/', '', $string);
	}

	public static function only_alphanumeric($string)
	{
		return preg_replace('/[^0-9a-zA-Z]/', '', $string);
	}
}
