<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.18
 * Time: 11.11
 */

namespace AppBundle\Rules;


use AppBundle\Entity\Provider;
use AppBundle\Entity\Shipment;
use AppBundle\EntityList\ProviderList;

class PackageLowestPriceRule extends RuleAbstract
{
    /**
     * @var ProviderList
     */
    private $providerList = [];

    public function __construct($configs)
    {
        $this->configs = $configs;

    }

    /**
     * @param Shipment $shipment
     *
     * @return Shipment
     */
    public function applyRule(Shipment $shipment)
    {
        if (in_array($shipment->getPackage()->getSize(), $this->configs->includedPackages)) {
            $price = $shipment->getPrice();
            $lowestPrice = $shipment->getPrice();

            foreach ($this->getProviderList()->getItems() as $provider) {
                /** @var Provider $provider */
                $providerPrice = $provider->getPackageShipmentPrice($shipment->getPackage()->getSize());

                if ($providerPrice && $providerPrice < $lowestPrice) {
                    $lowestPrice = $providerPrice;
                }
            }

            if ($price > $lowestPrice) {
                $discount = $price - $lowestPrice;

                $shipment
                    ->setPrice($lowestPrice)
                    ->setDiscount($discount)
                ;
            }
        }

        return $shipment;
    }

    /**
     * @return ProviderList
     */
    private function getProviderList()
    {
        if (empty($this->providerList)) {
            $this->providerList = $this->container->get('entity_list_service')->getProviderList();
        }

        return $this->providerList;
    }
} 