<?php

namespace DroneMill\Helpers\String;

class Format
{
	/**
	 * format a string to be SEO friendly.
	 * ex: 'This needs to be SEO friendly!' => 'this-needs-to-be-seo-friendly'
	 *
	 * @param string $string the string to format
	 */
	public static function seo_friendly($string)
	{
		$seoname = preg_replace('/\%/',      ' percentage', $string);
		$seoname = preg_replace('/\@/',      ' at ',        $seoname);
		$seoname = preg_replace('/\&/',      ' and ',       $seoname);
		$seoname = preg_replace('/\s[\s]+/', '-',           $seoname);  // Strip off multiple spaces
		$seoname = preg_replace('/[\s\W]+/', '-',           $seoname);  // Strip off spaces and non-alpha-numeric
		$seoname = preg_replace('/^[\-]+/',  '',            $seoname);  // Strip off the starting hyphens
		$seoname = preg_replace('/[\-]+$/',  '',            $seoname);  // // Strip off the ending hyphens
		$seoname = strtolower($seoname);

		return $seoname;
	}
}
