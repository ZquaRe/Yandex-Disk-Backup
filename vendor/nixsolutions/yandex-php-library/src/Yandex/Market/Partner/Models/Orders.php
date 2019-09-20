<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\ObjectModel;

class Orders extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($order)
    {
        if (is_array($order)) {
            $this->collection[] = new Order($order);
        } elseif (is_object($order) && $order instanceof Order) {
            $this->collection[] = $order;
        }

        return $this;
    }

    /**
     * Get items
     */
    public function getAll()
    {
        return $this->collection;
    }
}
