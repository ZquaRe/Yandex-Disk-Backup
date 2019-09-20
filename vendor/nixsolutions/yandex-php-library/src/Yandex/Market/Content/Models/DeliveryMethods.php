<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class DeliveryMethods extends ObjectModel
{
    /**
     * Add method to collection
     *
     * @param DeliveryMethod|array $method
     *
     * @return DeliveryMethods
     */
    public function add($method)
    {
        if (is_array($method)) {
            $this->collection[] = new DeliveryMethod($method);
        } elseif (is_object($method) && $method instanceof DeliveryMethod) {
            $this->collection[] = $method;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return DeliveryMethods|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
