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
class ArrayTranslator extends TranslatorAbstract {


    /**
     * Stores a new piece of data and tries to merge the data if already exists
     * @param string|array $key
     * @param mixed $value
     * @return void
     */
    public function add($key, $value = null): void {

        if(true === is_array($key)) {

            $this -> data = array_replace_recursive($key, $this -> data);
            return;
        }

        if(true === isset($this -> data[$key]) && true === is_array($this -> data[$key])) {

            if(true === is_array($value)) {
                $this -> data[$key] = array_replace_recursive($this -> data[$key], $value);
            }
            else {
                $this -> data[$key][] = $value;
            }

            return;
        }

        $this -> data[$key] = $value;
    }


    /**
     * Stores a new piece of data and overwrites the data if already exists
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value = null): void {

        $this -> remove($key);
        $this -> add($key, $value);
    }


    /**
     * Check if an item exists
     * @param mixed $key
     * @return bool
     */
    public function has($key): bool {
        return null !== static :: get($key, null);
    }


    /**
     * Remove data based on key
     * @param mixed $key
     * @return void
     */
    public function remove($key): void {

        if(true === is_array($key)) {

            $this -> data = array_diff_assoc($key, $this -> data);
            return;
        }

        unset($this -> data[$key]);
    }


    /**
     * Retrieve data based on key. Returns $default if not exists
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null) {

        if(true === is_array($key)) {

            $tmp = $this -> data;

            foreach($key as $index) {

                if(false === isset($tmp[$index])) {
                    return [];
                }

                $tmp = $tmp[$index];
            }

            return $tmp;
        }

        if(true === isset($this -> data[$key])) {
            return [$this -> data[$key]];
        }

        return $default;
    }


    /**
     * Retrieve and delete an item. Returns $default if not exists
     * @param string|array $key
     * @param mixed $default A default value which will be returned if the key is not found
     * @return mixed
     */
    public function pull($key, $default = null) {

        if(true === is_string($key)) {
            $key = [$key];
        }

        $tmp 	=& $this -> data;
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
}