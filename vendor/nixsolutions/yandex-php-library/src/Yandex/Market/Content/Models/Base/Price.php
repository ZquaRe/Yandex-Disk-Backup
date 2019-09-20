<?php

namespace Yandex\Market\Content\Models\Base;

use Yandex\Common\Model;

class Price extends Model
{
    protected $currencyName = null;

    protected $currencyCode = null;

    protected $discount = null;

    protected $base = null;

    protected $value = null;

    /**
     * Retrieve the currencyName property
     *
     * @return string|null
     */
    public function getCurrencyName()
    {
        return $this->currencyName;
    }

    /**
     * Retrieve the currencyCode property
     *
     * @return string|null
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Retrieve the discount property
     *
     * @return string|null
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Retrieve the base property
     *
     * @return string|null
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Retrieve the base property
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }
}
