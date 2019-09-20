<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\ObjectModel;

class Items extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($item)
    {
        if (is_array($item)) {
            $this->collection[] = new Item($item);
        } elseif (is_object($item) && $item instanceof Item) {
            $this->collection[] = $item;
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
