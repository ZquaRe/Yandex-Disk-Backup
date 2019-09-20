<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Filters extends ObjectModel
{
    /**
     * Add filter to collection
     *
     * @param Filter|array $filter
     *
     * @return Filters
     */
    public function add($filter)
    {
        if (is_array($filter)) {
            $this->collection[] = new Filter($filter);
        } elseif (is_object($filter) && $filter instanceof Filter) {
            $this->collection[] = $filter;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Filters
     */
    public function getAll()
    {
        return $this->collection;
    }
}
