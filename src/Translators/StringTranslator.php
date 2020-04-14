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

use sFire\DataControl\Exception\InvalidArgumentException;


/**
 * Class StringTranslator
 * @package sFire\DataControl
 */
class StringTranslator implements TranslatorInterface {


    /**
     * Stores a new piece of data and tries to merge the data if already exists
     * @param array $data
     * @param string|array $key
     * @param mixed $value
     * @return void
     * @throws InvalidArgumentException
     */
    public function add(array &$data, $key, $value = null): void {

        if(false === is_string($key)) {
            throw new InvalidArgumentException(sprintf('Argument 2 passed to %s() must be of the type string, "%s" given', __METHOD__, gettype($key)));
        }

        $keys = explode('.', $key);
        $last = array_pop($keys);

        foreach($keys as $key) {

            if(false === array_key_exists($key, $data) || true === array_key_exists($key, $data) && false === is_array($data[$key])) {
                $data[$key] = [];
            }

            $data = &$data[$key];
        }

        if(false === isset($data[$last]) || false === is_array($data[$last])) {
            $data[$last] = $value;
        }
        else {
            $data[$last][] = $value;
        }
    }


    /**
     * Stores a new piece of data and overwrites the data if already exists
     * @param array $data
     * @param string $key
     * @param mixed $value
     * @return void
     * @throws InvalidArgumentException
     */
    public function set(array &$data, $key, $value = null): void {

        if(false === is_string($key) && false === is_array($key)) {
           throw new InvalidArgumentException(sprintf('Argument 2 passed to %s() must be of the type string or array, "%s" given', __METHOD__, gettype($key)));
        }

        if(true === is_array($key)) {
            $data = array_merge_recursive($data, $key);
        }
        else {

            $this -> remove($data, $key);
            $this -> add($data, $key, $value);
        }
    }


    /**
     * Check if an item exists
     * @param array $data
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function has(array &$data, $key): bool {

        if(false === is_string($key)) {
            throw new InvalidArgumentException(sprintf('Argument 2 passed to %s() must be of the type string, "%s" given', __METHOD__, gettype($key)));
        }

        $output = $this -> paths(explode('.', $key), $data, []);
        return null !== $output;
    }


    /**
     * Remove data based on key
     * @param array $data
     * @param mixed $key
     * @return void
     * @throws InvalidArgumentException
     */
    public function remove(array &$data, $key): void {

        if(false === is_string($key)) {
            throw new InvalidArgumentException(sprintf('Argument 2 passed to %s() must be of the type string, "%s" given', __METHOD__, gettype($key)));
        }

        $output = $this -> paths(explode('.', $key), $data, []);

        if(null !== $output) {

            foreach($output as $item) {
                $this -> removeFromKeys($item['path'], $data);
            }
        }
    }


    /**
     * Retrieve data based on key
     * @param array $data
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function get(array &$data, $key, $default = null) {

        if(false === is_string($key)) {
            throw new InvalidArgumentException(sprintf('Argument 2 passed to %s() must be of the type string, "%s" given', __METHOD__, gettype($key)));
        }

        $keys = explode('.', $key);

        return $this -> values($keys, $data) ?? $default;
    }


    /**
     * Retrieve and delete an item
     * @param array $data
     * @param string|array $key
     * @param null $default A default value which will be returned if the key is not found
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function pull(array &$data, $key, $default = null) {

        if(false === is_string($key)) {
            throw new InvalidArgumentException(sprintf('Argument 2 passed to %s() must be of the type string, "%s" given', __METHOD__, gettype($key)));
        }

        $paths = $this -> paths(explode('.', $key), $data, []);
        $output = [];

        if(null !== $paths) {

            foreach($paths as $item) {

                $output[] = $item['value'];
                $this -> removeFromKeys($item['path'], $data);
            }
        }

        return $output ?? $default;
    }


    /**
     * Searches the given data array for values based on a string path returns theses values with the corresponding paths
     * @param array $data An array with data
     * @param string $key The path as a string to search for
     * @return mixed
     */
    public function path(array &$data, string $key) {
        return $this -> paths(explode('.', $key), $data, []);
    }


    /**
     * Searches the given data array for values based on a flat key array and returns these values
     * @param array $match A flat key array structure
     * @param array $data An array with data
     * @return mixed
     */
    private function values(array $match, &$data) {

        $current = array_shift($match);
        $end  	 = count($match) === 0;

        if('*' === $current) {

            if(true === $end) {
                return $data;
            }

            $output = [];

            foreach($data as $key => $value) {

                if(false === is_array($value)) {
                    continue;
                }

                $result = $this -> values($match, $value);

                if(null === $result) {
                    continue;
                }

                if(false === is_array($result)) {

                    $output = $result;
                    continue;
                }

                $output = array_merge($output, array_values($result));
            }

            return $output;
        }


        if(false === isset($data[$current])) {
            return null;
        }

        if(true === $end) {

            if(true === is_numeric($current)) {
                return [$data[$current]];
            }

            return $data[$current];
            /*

            if(false === is_array($data[$current])) {
                return $data[$current];
            }

            if(true === is_array($data[$current])) {
                return $data[$current];
            }

            return [[$current => $data[$current]]];*/
        }

        return $this -> values($match, $data[$current]);
    }


    /**
     * Searches the given data array for values based on a flat key array and returns theses values with the corresponding paths
     * @param array $match A flat key array structure
     * @param array $data An array with data
     * @param array $path
     * @return mixed
     */
    private function paths(array $match, $data, $path = [])	{

        $current = array_shift($match);
        $end  	 = count($match) === 0;

        if('*' === $current) {

            if(true === $end) {

                $output = [];

                foreach($data as $key => $value) {

                    $tmp 		= $path;
                    $path[] 	= $key;
                    $output[] 	= ['value' => $value , 'path' => $path];
                    $path 		= $tmp;
                }

                return $output;
            }

            $output = [];

            foreach($data as $key => $value) {

                if(false === is_array($value)) {
                    continue;
                }

                $tmp 	= $path;
                $path[] = $key;
                $result = $this -> paths($match, $value, $path);

                if(null === $result) {
                    continue;
                }

                $output = array_merge($output, array_values($result));
                $path = $tmp;
            }

            if(0 === count($output)) {
                return null;
            }

            return $output;
        }

        if(false === isset($data[$current])) {
            return null;
        }

        $path[] = $current;

        if(true === $end) {

            if(false === is_array($data[$current])) {
                return [['value' => $data[$current], 'path' => $path]];
            }

            return [['value' => $data[$current], 'path' => $path]];
        }

        return $this -> paths($match, $data[$current], $path);
    }


    /**
     * Remove keys and values form an associative array by giving a flat key structure as array
     * @param array $keys A flat
     * @param array $data
     * @return mixed
     */
    public function removeFromKeys(array $keys, &$data) {

        $current = array_shift($keys);
        $end  	 = count($keys) === 0;

        if(true === $end) {
            unset($data[$current]);
        }

        if(false === isset($data[$current])) {
            return null;
        }

        return $this -> removeFromKeys($keys, $data[$current]);
    }
}