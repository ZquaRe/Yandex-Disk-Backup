<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Outlets extends ObjectModel
{
    /**
     * Add outlet to collection
     *
     * @param Outlet|array $outlet
     *
     * @return Outlets
     */
    public function add($outlet)
    {
        if (is_array($outlet)) {
            $this->collection[] = new Outlet($outlet);
        } elseif (is_object($outlet) && $outlet instanceof Outlet) {
            $this->collection[] = $outlet;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Outlets
     */
    public function getAll()
    {
        return $this->collection;
    }
}
