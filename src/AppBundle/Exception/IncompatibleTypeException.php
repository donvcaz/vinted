<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.23
 * Time: 21.10
 */

namespace AppBundle\Exception;


class IncompatibleTypeException extends \Exception {

    public function __construct($compatibleClass)
    {
        parent::__construct('Incompatible type. Class have to be '.$compatibleClass);
    }
} 