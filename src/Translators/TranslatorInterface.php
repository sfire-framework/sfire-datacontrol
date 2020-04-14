<?php
/**
 * sFire Framework (https://sfire.io)
 *
 * @link      https://github.com/sfire-framework/ for the canonical source repository
 * @copyright Copyright (c) 2014-2020 sFire Framework.
 * @license   http://sfire.io/license BSD 3-CLAUSE LICENSE
 */

declare(strict_types=1);

namespace sFire\DataControl\Translators;


/**
 * Interface TranslatorInterface
 * @package sFire\DataControl
 */
interface TranslatorInterface {


    /**
     * Stores a new piece of data and tries to merge the data if already exists
     * @param array $data
     * @param string|array $key
     * @param mixed $value
     * @return bool if value has been set
     */
    public function add(array &$data, $key, $value);


    /**
     * Stores a new piece of data and overwrites the data if already exists
     * @param array $data
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function set(array &$data, $key, $value): void;


    /**
     * Check if an item exists
     * @param array $data
     * @param string $key
     * @return bool
     */
    public function has(array &$data, $key): bool;


    /**
     * Remove data based on key
     * @param array $data
     * @param mixed $key
     * @return void
     */
    public function remove(array &$data, $key): void;


    /**
     * Retrieve data based on key
     * @param array $data
     * @param mixed $key
     * @param mixed $default A default value which will be returned if the key is not found
     * @return mixed
     */
    public function get(array &$data, $key, $default = null);


    /**
     * Retrieve and delete an item
     * @param array $data
     * @param string|array $key
     * @param mixed $default A default value which will be returned if the key is not found
     * @return mixed
     */
    public function pull(array &$data, $key, $default);
}