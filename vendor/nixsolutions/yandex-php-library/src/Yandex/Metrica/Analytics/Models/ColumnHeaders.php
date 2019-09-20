<?php

namespace Yandex\Metrica\Analytics\Models;

use Yandex\Common\ObjectModel;

class ColumnHeaders extends ObjectModel
{

    protected $collection = [];

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Add item
     */
    public function add($header)
    {
        if (is_array($header)) {
            $this->collection[] = new Header($header);
        } elseif (is_object($header) && $header instanceof Header) {
            $this->collection[] = $header;
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
