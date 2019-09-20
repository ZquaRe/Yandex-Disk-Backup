<?php

namespace Yandex\Metrica\Stat\Models;

use Yandex\Common\ObjectModel;

class DrillDownComparisonData extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($drillDownComparisonItems)
    {
        if (is_array($drillDownComparisonItems)) {
            $this->collection[] = new DrillDownComparisonItems($drillDownComparisonItems);
        } elseif (is_object($drillDownComparisonItems)
            && $drillDownComparisonItems instanceof DrillDownComparisonItems
        ) {
            $this->collection[] = $drillDownComparisonItems;
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
