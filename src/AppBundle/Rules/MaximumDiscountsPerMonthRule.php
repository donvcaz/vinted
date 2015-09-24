<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.22
 * Time: 09.59
 */

namespace AppBundle\Rules;

use AppBundle\Entity\Shipment;
use AppBundle\Utils;

class MaximumDiscountsPerMonthRule extends RuleAbstract
{

    private $appliedDiscount = [];

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

        if(!isset($this->appliedDiscount[$month])) $this->appliedDiscount[$month] = 0;

        $this->appliedDiscount[$month] += $shipment->getDiscount();
        $this->appliedDiscount[$month] = Utils::toFixed($this->appliedDiscount[$month]);

        if ($this->appliedDiscount[$month] > $this->configs->maximumDiscount) {
            $aboveDiscount = $this->appliedDiscount[$month] - $this->configs->maximumDiscount;

            $shipment
                ->setPrice($shipment->getPrice() + $aboveDiscount)
                ->setDiscount($shipment->getDiscount() - $aboveDiscount)
            ;

            $this->appliedDiscount[$month] -= $aboveDiscount;
        }


        return $shipment;
    }
} 