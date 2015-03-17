<?php

namespace DroneMill\Helpers\Integer;

Class Misc
{

	/**
	 * function random64
	 *
	 * Generate random 64bit integer
	 *
	 * @return int $random_integer
	 */
	public static function random64()
	{
		return self::rand(64);
	}

	public static function rand64()
	{
		return self::rand(64);
	}

	public static function rand($bits = 64)
	{
		$randmax_bits = strlen(base_convert(mt_getrandmax(), 10, 2));  // how many bits is mt_getrandmax()

		$x = '';

		while (strlen($x) < $bits)
		{
			$maxbits = ($bits - strlen($x) < $randmax_bits) ? $bits - strlen($x) :  $randmax_bits;

			$rand = mt_rand(0, (pow(2,$maxbits) - 1));

			$base_converted = base_convert($rand, 10, 2);

			$x .= str_pad($base_converted, $maxbits, "0", STR_PAD_LEFT);
		}

		return base_convert($x, 2, 10);
	}
}
