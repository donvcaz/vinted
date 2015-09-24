<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.18
 * Time: 11.48
 */

namespace AppBundle\Entity;

class Package
{
    const SIZE_S = 'S';
    const SIZE_M = 'M';
    const SIZE_L = 'L';

    /**
     * @var string
     */
    private $size;

    public function __construct($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    public function isSizeAllowed()
    {
        if (in_array($this->size,[static::SIZE_S,static::SIZE_M,static::SIZE_L])) {
            return true;
        } else {
            return false;
        }
    }
} 