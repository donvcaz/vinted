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
use MyProject\Proxies\__CG__\stdClass;

class FreeShipmentPerMonthRule extends RuleAbstract
{

    /**
     * @var array
     */
    private $shipmentIteration = [];

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
        $month = $shipment->getDate()->format('Y-m');

        if(!isset($this->shipmentIteration[$month])) $this->shipmentIteration[$month] = $this->populateValues();

        $providerName = $shipment->getProvider()->getName();
        $shipmentSize = $shipment->getPackage()->getSize();

        if (isset($this->configs->providers->$providerName)) {

            if (isset($this->configs->providers->$providerName->$shipmentSize)) {
                // incrementing iteration
                $this->shipmentIteration[$month][$providerName][$shipmentSize] += 1;

                // if iteration is equals to config, free shipping would be applied
                if ($this->shipmentIteration[$month][$providerName][$shipmentSize] == $this->configs->providers->$providerName->$shipmentSize) {
                    // doing $shipment->getPrice()+$shipment->getDiscount() because discount can be
                    // already applied, so counting full discount
                    $shipment
                        ->setDiscount($shipment->getPrice()+$shipment->getDiscount())
                        ->setPrice(0)
                    ;
                }
            }

        }

        return $shipment;
    }

    /**
     * Creating array for counting iteration to free shipping
     *
     * @return array
     */
    public function populateValues()
    {
        $response = [];

        foreach ($this->configs->providers as $providerName => $shipmentSizeArray) {
            foreach($shipmentSizeArray as $shipmentSize => $freeShipmentIteration){
                $response[$providerName][$shipmentSize] = 0;
            }
        }

        return $response;
    }
} 