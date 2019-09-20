<?php

namespace Yandex\Market\Content\Models;

class ResponseShopMatchGet extends ResponseShopGet
{
    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        if (isset($data['shops'])) {
            $shop = reset($data['shops']);
            if (isset($shop['id'])) {
                $data['shop'] = $shop;
                unset($data['shops']);
            }
        }
        parent::__construct($data);
    }
}
