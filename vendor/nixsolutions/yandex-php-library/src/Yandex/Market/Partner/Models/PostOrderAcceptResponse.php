<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Market\Partner\Models\AcceptOrder;
use Yandex\Common\Model;

class PostOrderAcceptResponse extends Model
{

    protected $order = null;

    protected $mappingClasses = [
        'order' => 'Yandex\Market\Partner\Models\AcceptOrder'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the order property
     *
     * @return AcceptOrder|null
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the order property
     *
     * @param AcceptOrder $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }
}
