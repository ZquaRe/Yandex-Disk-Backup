<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\ObjectModel;

class StateReasons extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($stateReason)
    {
        if (is_array($stateReason)) {
            $this->collection[] = new StateReason($stateReason);
        } elseif (is_object($stateReason) && $stateReason instanceof StateReason) {
            $this->collection[] = $stateReason;
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
