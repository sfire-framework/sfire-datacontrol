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
 * Class StringTranslator
 * @package sFire\DataControl
 */
abstract class TranslatorAbstract implements TranslatorInterface {


    /**
     * Contains the data for retrieving an modifying items
     * @var array
     */
    protected array $data = [];


    /**
     * Constructor
     * @param array $data
     */
    public function __construct(array &$data = []) {
        $this -> data = &$data;
    }


    /**
     * Set new data that will be used for retrieving and modifying items
     * @param array $data
     * @return void
     */
    public function setData(array &$data): void {
        $this -> data = &$data;
    }
}