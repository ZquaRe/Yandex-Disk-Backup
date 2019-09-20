<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Market\Partner\Models\Order;
use Yandex\Common\Model;

class UpdateOrderDeliveryResponse extends Model
{

    protected $order = null;

    protected $mappingClasses = [
        'order' => 'Yandex\Market\Partner\Models\Order'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the order property
     *
     * @return Order|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the order property
     *
     * @param Order $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }
}
