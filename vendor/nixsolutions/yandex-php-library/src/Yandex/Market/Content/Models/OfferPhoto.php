<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\Photo;

class OfferPhoto extends Photo
{
    protected $id = null;

    /**
     * Retrieve the id property
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }
}
