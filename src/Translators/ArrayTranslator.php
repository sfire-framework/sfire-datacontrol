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
 * Class ArrayTranslator
 * @package sFire\DataControl
 */
class ArrayTranslator implements TranslatorInterface {


    /**
     * Stores a new piece of data and tries to merge the data if already exists
     * @param array $data
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function add(array &$data, $key, $value = null): void {

        if(true === is_array($key)) {

            $data = array_replace_recursive($key, $data);
            return;
        }

        if(true === isset($data[$key]) && true === is_array($data[$key])) {

            if(true === is_array($value)) {
                $data[$key] = array_replace_recursive($data[$key], $value);
            }
            else {
                $data[$key][] = $value;
            }

            return;
        }

        $data[$key] = $value;
    }


    /**
     * Stores a new piece of data and overwrites the data if already exists
     * @param array $data
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function set(array &$data, $key, $value = null): void {

        $this -> remove($data, $key);
        $this -> add($data, $key, $value);
    }


    /**
     * Check if an item exists
     * @param $data
     * @param mixed $key
     * @return bool
     */
    public function has(array &$data, $key): bool {
        return null !== static :: get($key, null);
    }


    /**
     * Remove data based on key
     * @param $data
     * @param mixed $key
     * @return void
     */
    public function remove(&$data, $key): void {

        if(true === is_array($key)) {

            $data = array_diff_assoc($key, $data);
            return;
        }

        unset($data[$key]);
    }


    /**
     * Retrieve data based on key. Returns $default if not exists
     * @param array $data
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function get(array &$data, $key, $default = null) {

        if(true === is_array($key)) {

            $tmp = $data;

            foreach($key as $index) {

                if(false === isset($tmp[$index])) {
                    return [];
                }

                $tmp = $tmp[$index];
            }

            return $tmp;
        }

        if(true === isset($data[$key])) {
            return [$data[$key]];
        }

        return $default;
    }


    /**
     * Retrieve and delete an item. Returns $default if not exists
     * @param array $data
     * @param string|array $key
     * @param mixed $default A default value which will be returned if the key is not found
     * @return mixed
     */
    public function pull(array &$data, $key, $default = null) {

        if(true === is_string($key)) {
            $key = [$key];
        }

        $tmp 	=& $data;
        $amount = count($key);
        $value 	= $default;

        foreach($key as $i => $index) {

            if(true === is_string($index) || true === is_int($index)) {

                if(true === isset($tmp[$index])) {

                    if($i === $amount - 1) {

                        $value = $tmp[$index];
                        unset($tmp[$index]);
                    }
                    else {
                        $tmp =& $tmp[$index];
                    }
                }
            }
        }

        return $value ?? $default;
    }


    /**
     * Searches the given data array for values based on a string path returns theses values with the corresponding paths
     * @param array $data An array with data
     * @param string $key The path as an string to search for
     * @return mixed
     */
    public function path(array &$data, string $key) {
        return $this -> paths($data, $key);
    }


    public function paths(array &$data, $key) {

        $tmp = $data;
        $path = [];

        if(false === is_array($key)) {
            $key = [$key];
        }

        foreach($key as $item) {

            if(true === isset($tmp[$item])) {
                $tmp = $tmp[$item];
                $path[] = $item;
            }
        }

        return [['value' => $tmp, 'path' => $path]];
    }
}