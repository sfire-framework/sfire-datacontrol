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
use sFire\DataControl\TypeNumber;


/**
 * Class TypeNumberTest
 */
final class TypeNumberTest extends TestCase {


    /**
     * Test
     * @return void
     */
    public function test(): void {

        $number = new TypeNumber('123 abc 456');
        $this -> assertEquals('123 abc 456', $number -> get());

        $number -> set('€1.000.000,52');
        $this -> assertEquals('€1.000.000,52', $number -> get());
    }
}