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
use sFire\DataControl\Hash;

final class HashTest extends TestCase {


    /**
     * Contains instance of Hash
     * @var Hash
     */
    private Hash $hash;
    

    /**
     * Setup. Created new Hash instance
     * @return voidw
     */
    protected function setUp(): void {
        $this -> hash = new Hash();
    }


    /**
     * Test if data can be hashed
     * Test if hashed data is valid
     * @return void
     */
    public function testHashing(): void {
        
        $this -> assertIsString($this -> hash -> hash('value'));
        $this -> assertTrue(128 === strlen($this -> hash -> hash('value')));
        $this -> assertTrue($this -> hash -> validateHash('value', $this -> hash -> hash('value')));
    }


    /**
     * Test setting non existing/not supported algorithms
     * @return void
     */
    public function testSettingNonExistingAlgorithms(): void {
        
        $this -> expectException(ErrorException :: class);
        $this -> hash -> setAlgorithm('non-existing');
    }


    /**
     * Test setting existing/supported algorithms
     * @return void
     */
    public function testSettingExistingAlgorithms() :void {
        $this -> assertNull($this -> hash -> setAlgorithm('ripemd320'));
    }
}