<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Shops extends ObjectModel
{
    /**
     * Add shop to collection
     *
     * @param Shop|array $shop
     *
     * @return Shops
     */
    public function add($shop)
    {
        if (is_array($shop)) {
            $this->collection[] = new Shop($shop);
        } elseif (is_object($shop) && $shop instanceof Shop) {
            $this->collection[] = $shop;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Shops|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
