<?php

namespace Yandex\Market\Content\Models\Base;

use Yandex\Common\Model;

class Photo extends Model
{
    protected $url = null;

    protected $width = null;

    protected $height = null;

    /**
     * Retrieve the url property
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Retrieve the width property
     *
     * @return int|null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Retrieve the height property
     *
     * @return int|null
     */
    public function getHeight()
    {
        return $this->height;
    }
}
