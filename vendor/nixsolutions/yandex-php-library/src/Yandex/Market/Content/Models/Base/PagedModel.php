<?php

namespace Yandex\Market\Content\Models\Base;

use Yandex\Common\Model;

class PagedModel extends Model
{
    protected $page = null;

    protected $total = null;

    protected $count = null;

    protected $items = null;

    /**
     * Retrieve the count property
     *
     * @return int|null
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Retrieve the page property
     *
     * @return int|null
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Retrieve the total property
     *
     * @return int|null
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Retrieve the items property
     *
     * @return ObjectModel|null
     */
    public function getItems()
    {
        return $this->items;
    }
}
