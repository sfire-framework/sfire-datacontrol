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

use sFire\DataControl\Exception\InvalidArgumentException;


/**
 * Class Hash
 * @package sFire\DataControl
 */
class Hash {


    /**
     * Contains the algorithm
     * @var string
     */
    private string $algorithm = 'sha512';


    /**
     * Hashes text and returns it
     * @param string $data
     * @return string
     */
    public function hash(string $data): string {
        return hash($this -> algorithm, $data);
    }


    /**
     * Verifies that data matches a hash
     * @param string $data
     * @param string $hash
     * @return boolean
     */
    public function validateHash(string $data, string $hash): bool {
        return hash($this -> algorithm, $data) === $hash;
    }


    /**
     * Set the algorithm to use when hashing (i.e. ripemd320, sha512, md5)
     * @param string $algorithm
     * @return void
     * @throws InvalidArgumentException
     */
    public function setAlgorithm(string $algorithm): void {

        if(false === in_array($algorithm, hash_algos())) {
            throw new InvalidArgumentException(sprintf('Algorithm "%s" given to $%s$ is not supported', $algorithm, __METHOD__));
        }

        $this -> algorithm = $algorithm;
    }
}