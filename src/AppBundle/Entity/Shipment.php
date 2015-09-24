<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.18
 * Time: 11.12
 */

namespace AppBundle\Entity;

use AppBundle\EntityList\ProviderList;
use AppBundle\Exception\PackageSizeException;
use AppBundle\Exception\StringFormatException;
use AppBundle\Service\TextFileService;
use AppBundle\Utils;

class Shipment
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var Package
     */
    private $package;

    /**
     * @var Provider
     */
    private $provider;

    private $price;

    private $discount = 0.00;

    public function __toString()
    {
        $entityString = '';
        if ($this->package->isSizeAllowed()) {
            $entityString .= $this->date->format('Y-m-d').' ';
            $entityString .= $this->package->getSize().' ';
            $entityString .= $this->provider->getName().' ';
            $entityString .= $this->price.' ';
            $entityString .= ($this->discount > 0) ? $this->discount : '-';
        } else {
            $entityString .= $this->date->format('Y-m-d').' ';
            $entityString .= $this->package->getSize().' ';
            $entityString .= 'Ignored';
        }
        return $entityString;
    }

    /**
     * @param \DateTime $date
     *
     * @return Shipment
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $discount
     *
     * @return Shipment
     */
    public function setDiscount($discount)
    {
        $this->discount = Utils::toFixed($discount);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param Package $package
     *
     * @return Shipment
     */
    public function setPackage($package)
    {
        $this->package = $package;
        return $this;
    }

    /**
     * @return Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @param mixed $price
     *
     * @return Shipment
     */
    public function setPrice($price)
    {
        $this->price = Utils::toFixed($price);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param Provider $provider
     *
     * @return Shipment
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @return Provider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Convert string to object
     *
     * @param string $string
     * @param ProviderList $providerList
     *
     * @return $this
     *
     * @throws \AppBundle\Exception\PackageSizeException
     * @throws \AppBundle\Exception\StringFormatException
     */
    public function fromString($string, ProviderList $providerList){
        $stringFormat = '/^[0-9]{4}-[0-9]{2}-[0-9]{2} [A-Z] [A-Z]{2}/';
        if (!preg_match($stringFormat,$string)) {
            throw new StringFormatException($stringFormat);
        }

        $shipmentData = explode(TextFileService::FILE_LINE_DELIMITER, $string);

        $shipmentDate           = trim($shipmentData[0]);
        $shipmentPackageSize    = trim($shipmentData[1]);
        $shipmentProvider       = trim(@$shipmentData[2]);

        $package = new Package($shipmentPackageSize);

        if(!$package->isSizeAllowed()){
            throw new PackageSizeException($package->getSize());
        }

        $provider = ($providerList->getItem($shipmentProvider)) ? $providerList->getItem($shipmentProvider) : null;

        $this->setDate(new \DateTime($shipmentDate));
        $this->setPackage($package);
        $this->setProvider($provider);

        if($provider){
            $this->setPrice($provider->getProviderPackageList()->getItem($package->getSize())->getPrice());
        }

        return $this;
    }

} 