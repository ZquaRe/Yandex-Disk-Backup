<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\ObjectModel;

class DeliveryRules extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($deliveryRule)
    {
        if (is_array($deliveryRule)) {
            $this->collection[] = new DeliveryRule($deliveryRule);
        } elseif (is_object($deliveryRule) && $deliveryRule instanceof DeliveryRule) {
            $this->collection[] = $deliveryRule;
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
