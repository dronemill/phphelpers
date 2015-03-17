<?php

namespace DroneMill\Helpers;

class Email
{
	public static function strip($email)
	{
		$parts = explode('@', $email);

		// remove everything after and including a plus sign
		$user = explode('+', $parts[0]);
		$parts[0] = array_shift($user);

		// remove all dots
		$parts[0] = str_replace('.', '', $parts[0]);

		return implode('@', $parts);
	}
}
