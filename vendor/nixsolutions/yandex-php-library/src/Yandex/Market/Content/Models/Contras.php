<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Contras extends ObjectModel
{
    /**
     * Add fact to collection
     *
     * @param Fact|array $fact
     *
     * @return Contras
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
     * @return Contras|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
