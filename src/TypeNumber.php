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
 * Class TypeNumber
 * @package sFire\DataControl
 */
class TypeNumber {


    /**
     * Contains a string or number that contains numbers
     * @var mixed
     */
    private $data;


    /**
     * Constructor
     * @param mixed $data A string or number that will be used to extract/modify the numbers in it
     */
    public function __construct($data = null) {

        if(null !== $data) {
            $this -> set($data);
        }
    }


    /**
     * Returns current value
     * @return mixed
     */
    public function __toString() {
        return $this -> get();
    }


    /**
     * Returns current value
     * @return mixed
     */
    public function get() {
        return $this -> data;
    }


    /**
     * Sets new data
     * @param mixed $data
     * @return self
     */
    public function set($data): self {

        $this -> data = $data;
        return $this;
    }


    /**
     * Ceil all the numbers found in data string
     * @return self
     */
    public function ceil(): self {

        return $this -> convert(function($number) {
            return ceil($number);
        });
    }


    /**
     * Floors all the numbers found in data string
     * @return self
     */
    public function floor(): self {

        return $this -> convert(function($number) {
            return floor($number);
        });
    }


    /**
     * Round all the numbers with a precision found in data string
     * @param int $decimals The amount of numbers after the decimal
     * @return self
     */
    public function round(int $decimals = 2): self {

        return $this -> convert(function($number, $decimals) {
            return round($number, $decimals);
        }, [$decimals]);
    }


    /**
     * Converts number into a string, keeping a specified number of decimal
     * @param int $decimals The amount of numbers after the decimal
     * @return self
     */
    public function toFixed(int $decimals = 2): self {

        return $this -> convert(function($number, $decimals) {

            $split = explode('.', (string) $number);

            if(count($split) < 2) {
                $split[1] = str_repeat('0', $decimals);
            }

            if(strlen($split[1]) < $decimals) {
                $split[1] .= str_repeat('0', $decimals - strlen($split[1]));
            }

            return rtrim(rtrim($split[0] . '.' . substr($split[1], 0, $decimals), ','), '.');

        }, [$decimals]);
    }


    /**
     * Strips all numbers from string and returns these as an array
     * @return array
     */
    public function strip(): array {

        if(true === (bool) preg_match_all('#([0-9.,\-]+)#', (string) $this -> data, $numbers)) {
            return $numbers[1];
        }

        return [];
    }


    /**
     * Strips all the numbers from a string and returns the value with an optional index to retrieve
     * @param int The array index which should be returned
     * @return mixed
     */
    public function val(int $index = 0) {

        $val = $this -> strip();

        if(true === isset($val[$index])) {
            return $val[$index];
        }

        return null;
    }


    /**
     * Converts all the numbers in a string to a specific format
     * @param int $decimals The amount of numbers after the decimal
     * @param string $point The decimal character
     * @param string $thousands_sep The thousand separator character
     * @param string $currency The currency (i.e. dollar, euro, pound, etc.)
     * @return self
     */
    public function format(int $decimals = 2, string $point = '.', string $thousands_sep = ',', string $currency = null): self {

        return $this -> convert(function($number, $decimals, $point, $thousands_sep, $currency) {
            return $currency . number_format($number, $decimals, $point, $thousands_sep);
        }, [$decimals, $point, $thousands_sep, $currency]);
    }


    /**
     * Executes a callable function and returns this instance
     * @param callable $callback A callable callback function for each number found
     * @param array $variables The variables that should be included in the callback
     * @return self
     */
    private function convert(callable $callback, array $variables = []): self {

        $this -> data = preg_replace_callback('~[0-9.,-]+~', function($number) use ($callback, $variables) {
            return call_user_func_array($callback, array_merge([(float) str_replace(',', '', $number[0])], $variables));
        }, $this -> data);

        return $this;
    }
}