<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\Price;

class Prices extends Price
{
    protected $max = null;

    protected $min = null;

    protected $avg = null;

    protected $propNameMap = [
        'curCode' => 'currencyCode',
        'curName' => 'currencyName'
    ];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data);
        // @todo: create property propNameExcl?
        unset($this->value);
    }

    /**
     * Retrieve the max property
     *
     * @return float|null
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Retrieve the min property
     *
     * @return float|null
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Retrieve the avg property
     *
     * @return float|null
     */
    public function getAvg()
    {
        return $this->avg;
    }
}
