<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.23
 * Time: 20.02
 */
namespace AppBundle\EntityList;

use AppBundle\Entity\Provider;
use AppBundle\Exception\IncompatibleTypeException;

class ProviderList extends EntityListAbstract
{

    /**
     * @param Provider $item
     * @param null $key
     * @return $this
     * @throws IncompatibleTypeException
     */
    public function addItem($item, $key = null)
    {
        if(!$item instanceof Provider) throw new IncompatibleTypeException('Provider');

        return parent::addItem($item, $item->getName());
    }

    /**
     * @param $key
     *
     * @return Provider
     */
    public function getItem($key)
    {
        return parent::getItem($key);
    }

} 