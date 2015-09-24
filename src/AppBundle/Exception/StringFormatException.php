<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.23
 * Time: 21.10
 */

namespace AppBundle\Exception;


class StringFormatException extends \Exception {

    public function __construct($pattern)
    {
        parent::__construct('String do not match patter : '.$pattern);
    }
} 