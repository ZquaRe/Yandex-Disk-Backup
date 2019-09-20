<?php

namespace Yandex\Metrica\Stat\Models;

use Yandex\Common\ObjectModel;

class DrillDownData extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($drillDownItems)
    {
        if (is_array($drillDownItems)) {
            $this->collection[] = new DrillDownItems($drillDownItems);
        } elseif (is_object($drillDownItems) && $drillDownItems instanceof DrillDownItems) {
            $this->collection[] = $drillDownItems;
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
