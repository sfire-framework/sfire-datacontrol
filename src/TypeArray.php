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
 * Class TypeArray
 * @package sFire\DataControl
 */
class TypeArray {


    /**
     * @param $array
     * @param array $keys
     * @param $value
     * @return void
     */
    public static function insertIntoArray(&$array, array $keys, $value): void {

        $last = array_pop($keys);

        foreach($keys as $key) {

            if(false === array_key_exists($key, $array) || true === array_key_exists($key, $array) && false === is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        if(true === isset($array[$last])) {

            $data = $array[$last];

            if(false === is_array($data)) {
                $array[$last] = [$data];
            }

            $array[$last][] = $value;
        }
        else {
            $array[$last] = $value;
        }
    }


    /**
     * Flip values
     * @param array $result
     * @param array $keys
     * @param mixed $value
     * @return void
     */
    public static function flip(array &$result, array $keys, $value): void {

        if(true === is_array($value)) {

            foreach($value as $k => $v) {

                $newKeys = $keys;
                array_push($newKeys, $k);
                static :: flip($result, $newKeys, $v);
            }
        }
        else {

            $res   = $value;
            $first = array_shift($keys);

            array_push($keys, $first);

            foreach(array_reverse($keys) as $k) {
                $res = [$k => $res];
            }

            $result = array_replace_recursive($result, $res);
        }
    }
}