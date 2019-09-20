<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Delivery extends Model
{
    protected $priorityRegionId = null;

    protected $regionName = null;

    protected $userRegionName = null;

    protected $pickup = null;

    protected $delivery = null;

    protected $free = null;

    protected $deliveryIncluded = null;

    protected $priority = null;

    protected $store = null;

    protected $downloadable = null;

    protected $price = null;

    protected $description = null;

    protected $methods = null;

    protected $full = null;

    protected $brief = null;

    protected $mappingClasses = [
        'price' => 'Yandex\Market\Content\Models\Base\Price',
        'methods' => 'Yandex\Market\Content\Models\DeliveryMethods',
    ];

    protected $propNameMap = [
        'priorityRegion' => 'priorityRegionId',
    ];

    /**
     * Retrieve the priorityRegionId property
     *
     * @return int|null
     */
    public function getPriorityRegionId()
    {
        return $this->priorityRegionId;
    }

    /**
     * Retrieve the regionName property
     *
     * @return string|null
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * Retrieve the userRegionName property
     *
     * @return string|null
     */
    public function getUserRegionName()
    {
        return $this->userRegionName;
    }

    /**
     * Retrieve the pickup property
     *
     * @return bool|null
     */
    public function getPickup()
    {
        return $this->pickup;
    }

    /**
     * Retrieve the delivery property
     *
     * @return bool|null
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Retrieve the free property
     *
     * @return bool|null
     */
    public function getFree()
    {
        return $this->free;
    }

    /**
     * Retrieve the deliveryIncluded property
     *
     * @return bool|null
     */
    public function getDeliveryIncluded()
    {
        return $this->deliveryIncluded;
    }

    /**
     * Retrieve the priority property
     *
     * @return bool|null
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Retrieve the store property
     *
     * @return bool|null
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Retrieve the downloadable property
     *
     * @return bool|null
     */
    public function getDownloadable()
    {
        return $this->downloadable;
    }

    /**
     * Retrieve the description property
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Retrieve the full property
     *
     * @return string|null
     */
    public function getFull()
    {
        return $this->full;
    }

    /**
     * Retrieve the brief property
     *
     * @return string|null
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Retrieve the price property
     *
     * @return Price|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Retrieve the methods property
     *
     * @return DeliveryMethods|null
     */
    public function getMethods()
    {
        return $this->methods;
    }
}
