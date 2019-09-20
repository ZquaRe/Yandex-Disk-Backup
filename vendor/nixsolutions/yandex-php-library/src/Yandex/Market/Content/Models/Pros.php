<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Pros extends ObjectModel
{
    /**
     * Add fact to collection
     *
     * @param Fact|array $fact
     *
     * @return Pros
     */
    public function add($fact)
    {
        if (is_string($fact)) {
            $this->collection[] = new Fact(array('fact'=>$fact));
        } elseif (is_object($fact) && $fact instanceof Fact) {
            $this->collection[] = $fact;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Pros|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
