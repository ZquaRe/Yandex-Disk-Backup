<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\ObjectModel;

class Conditions extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($condition)
    {
        if (is_array($condition)) {
            $this->collection[] = new Condition($condition);
        } elseif (is_object($condition) && $condition instanceof Condition) {
            $this->collection[] = $condition;
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
