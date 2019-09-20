<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\ObjectModel;

class DeliveryOptions extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($deliveryOption)
    {
        if (is_array($deliveryOption)) {
            $this->collection[] = new DeliveryOption($deliveryOption);
        } elseif (is_object($deliveryOption) && $deliveryOption instanceof DeliveryOption) {
            $this->collection[] = $deliveryOption;
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
