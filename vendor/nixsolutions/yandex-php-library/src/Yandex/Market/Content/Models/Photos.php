<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;
use Yandex\Market\Content\Models\Base\Photo;

class Photos extends ObjectModel
{
    /**
     * Add photo to collection
     *
     * @param Photo|array $photo
     *
     * @return Photos
     */
    public function add($photo)
    {
        if (is_array($photo)) {
            $this->collection[] = new Photo($photo);
        } elseif (is_object($photo) && $photo instanceof Photo) {
            $this->collection[] = $photo;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Photos|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
