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
 * Class Token
 * @package sFire\DataControl
 */
class Token {


    /**
     * Create random token
     * @param int $length [optional] The length of the token
     * @param bool $numbers [optional] True if token may have numbers, false if not
     * @param bool $letters [optional] True if token may have letters, false if not
     * @param bool $capitals [optional] True if token may have capital letters, false if not
     * @param bool $symbols [optional] True if token may have symbols, false if not
     * @return string
     */
    public static function create(?int $length = 16, bool $numbers = true, bool $letters = true, bool $capitals = true, bool $symbols = false): string {

        $array 			 = [];
        $caseInsensitive = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $caseSensitive 	 = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $numbersArr 	 = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
        $symbolsArr 	 = ['!', '@', '%', '$', '.', '&', '*', '-', '+', '#', '{', '}', '[', ']', ':', ';', '?'];

        $numbers  && ($array = array_merge($array, $numbersArr));
        $letters  && ($array = array_merge($array, $caseInsensitive));
        $capitals && ($array = array_merge($array, $caseSensitive));
        $symbols  && ($array = array_merge($array, $symbolsArr));

        $str = '';

        if(count($array) > 0) {

            for($i = 0; $i < $length; $i++) {
                $str .= $array[array_rand($array, 1)];
            }
        }

        return $str;
    }
}