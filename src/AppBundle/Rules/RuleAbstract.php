<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.18
 * Time: 11.10
 */

namespace AppBundle\Rules;


use AppBundle\Entity\Shipment;
use Symfony\Component\DependencyInjection\ContainerAware;

abstract class RuleAbstract extends ContainerAware
{
    /**
     * @var \JsonSerializable
     */
    protected $configs;

    /**
     * @param Shipment $item
     *
     * @return Shipment
     */
    abstract public function applyRule(Shipment $item);
} 