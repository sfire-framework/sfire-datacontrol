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
     * Constructor
     * @param array $data [optional] Data that will be used for retrieving and modifying items
     */
    public function __construct(array &$data = []);


    /**
     * Set new data that will be used for retrieving and modifying items
     * @param array $data
     * @return void
     */
    public function setData(array &$data): void;


    /**
     * Stores a new piece of data and tries to merge the data if already exists
     * @param string|array $key
     * @param mixed $value
     * @return bool if value has been set
     */
    public function add($key, $value);


    /**
     * Stores a new piece of data and overwrites the data if already exists
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value): void;


    /**
     * Check if an item exists
     * @param string $key
     * @return bool
     */
    public function has($key): bool;


    /**
     * Remove data based on key
     * @param mixed $key
     * @return void
     */
    public function remove($key): void;


    /**
     * Retrieve data based on key
     * @param mixed $key
     * @param mixed $default A default value which will be returned if the key is not found
     * @return mixed
     */
    public function get($key, $default = null);


    /**
     * Retrieve and delete an item
     * @param string|array $key
     * @param mixed $default A default value which will be returned if the key is not found
     * @return mixed
     */
    public function pull($key, $default);
}