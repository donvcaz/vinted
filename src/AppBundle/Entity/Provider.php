<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.18
 * Time: 11.12
 */

namespace AppBundle\Entity;

use AppBundle\EntityList\ProviderPackageList;

class Provider
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var ProviderPackageList
     */
    private $providerPackageList = [];

    public function __construct($name)
    {
        $this->name = $name;
        $this->providerPackageList = new ProviderPackageList();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ProviderPackageList
     */
    public function getProviderPackageList()
    {
        return $this->providerPackageList;
    }

    /**
     * @param $packageSize
     *
     * @return float|null
     */
    public function getPackageShipmentPrice($packageSize)
    {
        if ($this->providerPackageList->getItem($packageSize)) {
            return $this->providerPackageList->getItem($packageSize)->getPrice();
        } else {
            return null;
        }
    }
} 