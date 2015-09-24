<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.23
 * Time: 21.10
 */

namespace AppBundle\Exception;


class PackageSizeException extends \Exception {

    public function __construct($size)
    {
        parent::__construct('Package size ['.$size.'] not allowed');
    }
} 