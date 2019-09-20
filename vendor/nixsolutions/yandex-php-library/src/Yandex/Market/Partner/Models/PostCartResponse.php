<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Market\Partner\Models\CartResponse;
use Yandex\Common\Model;

class PostCartResponse extends Model
{

    protected $cart = null;

    protected $mappingClasses = [
        'cart' => 'Yandex\Market\Partner\Models\CartResponse'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the cart property
     *
     * @return CartResponse|null
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set the cart property
     *
     * @param CartResponse $cart
     * @return $this
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }
}
