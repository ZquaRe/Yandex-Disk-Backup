<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Market\Partner\Models\CartRequest;
use Yandex\Common\Model;

class PostCartRequest extends Model
{

    protected $cart = null;

    protected $mappingClasses = [
        'cart' => 'Yandex\Market\Partner\Models\CartRequest'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the cart property
     *
     * @return CartRequest|null
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set the cart property
     *
     * @param CartRequest $cart
     * @return $this
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
        return $this;
    }
}
