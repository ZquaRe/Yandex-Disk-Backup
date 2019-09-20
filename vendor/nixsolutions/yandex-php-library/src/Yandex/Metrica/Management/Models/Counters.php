<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\ObjectModel;

class Counters extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($counterItem)
    {
        if (is_array($counterItem)) {
            $this->collection[] = new CounterItem($counterItem);
        } elseif (is_object($counterItem) && $counterItem instanceof CounterItem) {
            $this->collection[] = $counterItem;
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
