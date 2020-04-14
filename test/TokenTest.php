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
use sFire\DataControl\Token;

final class TokenTest extends TestCase {


    /**
     * Test if a token can be generated
     * @return void
     */
    public function testIfTokenCanBeGenerated(): void {

        $this -> assertRegExp('#[a-zA-Z0-9]{16,16}#', Token :: create());
        $this -> assertRegExp('#[a-zA-Z0-9]{48,48}#', Token :: create(48));
        $this -> assertRegExp('#[0-9]{48,48}#', Token :: create(48, true, false, false));
        $this -> assertRegExp('#[a-z0-9]{48,48}#', Token :: create(48, true, true, false));
        $this -> assertRegExp('#[a-zA-Z0-9]{48,48}#', Token :: create(48, true, true, true));
    }
}