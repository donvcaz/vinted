<?php
/**
 * Created by PhpStorm.
 * User: Donatas
 * Date: 15.9.23
 * Time: 20.05
 */

namespace AppBundle\EntityList;

abstract class EntityListAbstract {

    private $list = [];

    /**
     * Is this list empty?
     */
    public function isEmpty()
    {
        return empty($this->list);
    }

    /**
     * Set items to list
     * @param array $items
     *
     * @return $this
     */
    public function setItems(array $items)
    {
        $this->list = $items;

        return $this;
    }

    /**
     * Get list
     * @return array
     */
    public function getItems()
    {
        return $this->list;
    }

    /**
     * Append Items to the list.
     *
     * @param $item
     * @param $key
     *
     * @return $this
     */
    public function addItem($item, $key = null)
    {
        if (!$key) {
            return $this->list[] = $item;
        } else {
            return $this->list[$key] = $item;
        }
    }

    /**
     * @param $key
     *
     * @return Object|null
     */
    public function getItem($key)
    {
        if (isset($this->list[$key])) {
            return $this->list[$key];
        } else {
            return null;
        }

    }

    /**
     * Remove Items from the list.
     *
     * @param $key
     * @return $this
     */
    public function removeItem($key)
    {
        unset($this->list[$key]);

        return $this;
    }
} 