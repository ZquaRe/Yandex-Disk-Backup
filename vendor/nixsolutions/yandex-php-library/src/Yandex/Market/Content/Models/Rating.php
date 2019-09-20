<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Rating extends Model
{
    protected $value = null;

    protected $count = null;

    /**
     * Retrieve the value property
     *
     * @return float|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Retrieve the count property
     *
     * @return float|null
     */
    public function getCount()
    {
        return $this->count;
    }
}
