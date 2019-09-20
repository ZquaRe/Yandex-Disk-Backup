<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\ObjectModel;

class Campaigns extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($campaign)
    {
        if (is_array($campaign)) {
            $this->collection[] = new Campaign($campaign);
        } elseif (is_object($campaign) && $campaign instanceof Campaign) {
            $this->collection[] = $campaign;
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
