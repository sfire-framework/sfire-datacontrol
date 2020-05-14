<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use sFire\DataControl\TypeString;


/**
 * Class TypeStringTest
 */
final class TypeStringTest extends TestCase {


    /**
     * Test strings to camel case
     * @return void
     */
    public function testCameCase(): void {

        $this -> assertEquals('thisIsATest', TypeString :: toCamelCase('This is a test'));
        $this -> assertEquals('thisisatest', TypeString :: toCamelCase('Thisisatest'));
        $this -> assertEquals('thisIsATest', TypeString :: toCamelCase(' this  is  a test   '));
    }


    /**
     * Test strings to pascal case
     * @return void
     */
    public function testPascalCase(): void {

        $this -> assertEquals('ThisIsATest', TypeString :: toPascalCase('This is a test'));
        $this -> assertEquals('Thisisatest', TypeString :: toPascalCase('Thisisatest'));
        $this -> assertEquals('ThisIsATest', TypeString :: toPascalCase(' this  is  a test   '));
    }

    /**
     * Test strings to snake case
     * @return void
     */
    public function testSnakeCase(): void {

        $this -> assertEquals('this_is_a_test', TypeString :: toSnakeCase('This is a test'));
        $this -> assertEquals('thisisatest', TypeString :: toSnakeCase('Thisisatest'));
        $this -> assertEquals('this_is_a_test', TypeString :: toSnakeCase('ThisIsATest'));
        $this -> assertEquals('this_is_a_test', TypeString :: toSnakeCase(' this  is  a test   '));
    }


    /**
     * Test strings to kebab case
     * @return void
     */
    public function testKebabCase(): void {

        $this -> assertEquals('this-is-a-test', TypeString :: toKebabCase('This is a test'));
        $this -> assertEquals('thisisatest', TypeString :: toKebabCase('Thisisatest'));
        $this -> assertEquals('this-is-a-test', TypeString :: toKebabCase('ThisIsATest'));
        $this -> assertEquals('this-is-a-test', TypeString :: toKebabCase(' this  is  a test   '));
    }
}