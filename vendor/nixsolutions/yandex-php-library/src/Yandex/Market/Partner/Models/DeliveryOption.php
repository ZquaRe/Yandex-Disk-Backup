<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Market\Partner\Models\DatesRange;
use Yandex\Market\Partner\Models\Outlets;
use Yandex\Common\Model;

class DeliveryOption extends Model
{

    protected $id = null;

    protected $type = null;

    protected $serviceName = null;

    protected $price = null;

    protected $dates = null;

    protected $outlets = null;

    protected $paymentMethods = null;

    protected $mappingClasses = [
        'dates' => 'Yandex\Market\Partner\Models\DatesRange',
        'outlets' => 'Yandex\Market\Partner\Models\Outlets'
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
     * Set the id property
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * Set the type property
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
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
     * Set the serviceName property
     *
     * @param string $serviceName
     * @return $this
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
        return $this;
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
     * Set the price property
     *
     * @param int $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
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

    /**
     * Set the dates property
     *
     * @param DatesRange $dates
     * @return $this
     */
    public function setDates($dates)
    {
        $this->dates = $dates;
        return $this;
    }

    /**
     * Retrieve the outlets property
     *
     * @return Outlets|null
     */
    public function getOutlets()
    {
        return $this->outlets;
    }

    /**
     * Set the outlets property
     *
     * @param Outlets $outlets
     * @return $this
     */
    public function setOutlets($outlets)
    {
        $this->outlets = $outlets;
        return $this;
    }
    
    /**
     * Retrieve the paymentMethods property
     *
     * @return array|null
     */
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }

    /**
     * Set the paymentMethods property
     *
     * @param array $paymentMethods
     * @return $this
     */
    public function setPaymentMethods($paymentMethods)
    {
        $this->paymentMethods = $paymentMethods;
        return $this;
    }
}
