<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class DeliveryMethod extends Model
{
    protected $serviceName = null;

    protected $priceCurrency = null;

    protected $priceValue = null;

    protected $speedFrom = null;

    protected $speedTo = null;

    protected $propNameMap = [
        'price' => 'priceValue',
    ];

    /**
     * Retrieve the serviceName property
     *
     * @return string|null
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * Retrieve the priceCurrency property
     *
     * @return string|null
     */
    public function getPriceCurrency()
    {
        return $this->priceCurrency;
    }

    /**
     * Retrieve the priceValue property
     *
     * @return int|null
     */
    public function getPriceValue()
    {
        return $this->priceValue;
    }

    /**
     * Retrieve the speedFrom property
     *
     * @return int|null
     */
    public function getSpeedFrom()
    {
        return $this->speedFrom;
    }

    /**
     * Retrieve the speedTo property
     *
     * @return int|null
     */
    public function getSpeedTo()
    {
        return $this->speedTo;
    }
}
