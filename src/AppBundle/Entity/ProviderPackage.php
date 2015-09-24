<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.18
 * Time: 11.13
 */

namespace AppBundle\Entity;

use AppBundle\Utils;

class ProviderPackage
{
    /**
     * @var Package
     */
    private $package;

    /**
     * @var float
     */
    private $price;

    public function __construct(Package $package, $price)
    {
        $this->package = $package;
        $this->price = Utils::toFixed($price);
    }

    /**
     * @return Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}