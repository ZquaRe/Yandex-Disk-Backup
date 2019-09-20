<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ResponseShopGet extends Model
{
    protected $shop = null;

    protected $mappingClasses = [
        'shop' => 'Yandex\Market\Content\Models\Shop'
    ];

    /**
     * Retrieve the shop property
     *
     * @return Shop|null
     */
    public function getShop()
    {
        return $this->shop;
    }
}
