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
 * Class TypeString
 * @package sFire\DataControl
 */
class TypeString {


    /**
     * Converts string to camelCase
     * @param string $string The string that needs to be converted
     * @return string
     */
    public static function toCamelCase(string $string): string {

        $string = static :: toPascalCase($string);

        if(strlen($string) > 0) {
            $string[0] = strtolower($string[0]);
        }

        return $string;
    }


    /**
     * Converts string to PascalCase
     * @param string $string The string that needs to be converted
     * @return string
     */
    public static function toPascalCase(string $string): string {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }


    /**
     * Converts string to snake case
     * @param string $string The string that needs to be converted
     * @return string
     */
    public static function toSnakeCase(string $string): string {

        $string = preg_replace('#[ -]#', '_', $string);
        $string = strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $string));

        return trim(preg_replace('#[_]{2,}#', '_', $string), '_');
    }


    /**
     * Converts string to kebab case
     * @param string $string The string that needs to be converted
     * @return string
     */
    public static function toKebabCase(string $string): string {
        return str_replace('_', '-', self :: toSnakeCase($string));
    }
}