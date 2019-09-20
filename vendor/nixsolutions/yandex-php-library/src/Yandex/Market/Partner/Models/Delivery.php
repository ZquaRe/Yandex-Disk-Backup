<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Market\Partner\Models\Region;
use Yandex\Market\Partner\Models\Address;
use Yandex\Market\Partner\Models\DatesRange;
use Yandex\Common\Model;

class Delivery extends Model
{

    protected $id = null;

    protected $type = null;

    protected $serviceName = null;

    protected $price = null;

    protected $outletId = null;

    protected $region = null;

    protected $address = null;

    protected $dates = null;

    protected $mappingClasses = [
        'region' => 'Yandex\Market\Partner\Models\Region',
        'address' => 'Yandex\Market\Partner\Models\Address',
        'dates' => 'Yandex\Market\Partner\Models\DatesRange'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the id property
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retrieve the type property
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

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
     * Retrieve the price property
     *
     * @return int|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Retrieve the outletId property
     *
     * @return int|null
     */
    public function getOutletId()
    {
        return $this->outletId;
    }

    /**
     * Retrieve the region property
     *
     * @return Region|null
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Retrieve the address property
     *
     * @return Address|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Retrieve the dates property
     *
     * @return DatesRange|null
     */
    public function getDates()
    {
        return $this->dates;
    }
}
