<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\Photo;

class ModelVisualPhoto extends Photo
{
    protected $offerId = null;

    protected $colorId = null;

    /**
     * Retrieve the offerId property
     *
     * @return string|null
     */
    public function getOfferId()
    {
        return $this->offerId;
    }

    /**
     * Retrieve the colorId property
     *
     * @return int|null
     */
    public function getColorId()
    {
        return $this->colorId;
    }
}
