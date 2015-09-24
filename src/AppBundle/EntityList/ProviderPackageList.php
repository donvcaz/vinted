<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.23
 * Time: 20.02
 */

namespace AppBundle\EntityList;


use AppBundle\Entity\ProviderPackage;
use AppBundle\Exception\IncompatibleTypeException;

class ProviderPackageList extends EntityListAbstract
{

    /**
     * @param ProviderPackage $item
     * @param null $key
     *
     * @return $this
     *
     * @throws \AppBundle\Exception\IncompatibleTypeException
     */
    public function addItem($item, $key = null)
    {
        if(!$item instanceof ProviderPackage) throw new IncompatibleTypeException('ProviderPackage');

        return parent::addItem($item, $item->getPackage()->getSize());
    }

    /**
     * @param $key
     *
     * @return ProviderPackage
     */
    public function getItem($key)
    {
        return parent::getItem($key);
    }
} 