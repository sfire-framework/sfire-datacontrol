<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\DataControl;


/**
 * Class Strings
 * @package sFire\DataControl
 */
class Strings {


	/**
	 * Converts string underscores and spaces to camelCase
	 * @param string $string The string that needs to be converted
	 * @return string
	 */
	public static function toCamelCase(string $string): string {

	    $str = static :: toPascalCase($string);

	    if(strlen($str) > 0) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
	}


    /**
     * Converts string underscores and spaces to PascalCase
     * @param string $string
     * @return string
     */
    public static function toPascalCase(string $string): string {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }


	/**
	 * Converts string camelcase to snake case
	 * @param string $string The string that needs to be converted
	 * @return string
	 */
	public static function toSnakeCase(string $string): string {
		return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $string)), '_');
	}
}