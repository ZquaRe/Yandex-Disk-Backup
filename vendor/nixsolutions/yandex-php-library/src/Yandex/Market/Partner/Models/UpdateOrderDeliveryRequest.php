<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Market\Partner\Models\Delivery;
use Yandex\Common\Model;

class UpdateOrderDeliveryRequest extends Model
{

    protected $delivery = null;

    protected $mappingClasses = [
        'delivery' => 'Yandex\Market\Partner\Models\Delivery'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the delivery property
     *
     * @return Delivery|null
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set the delivery property
     *
     * @param Delivery $delivery
     * @return $this
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;
        return $this;
    }
}
