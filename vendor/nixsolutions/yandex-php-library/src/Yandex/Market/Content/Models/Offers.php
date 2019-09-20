<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Offers extends ObjectModel
{
    /**
     * Add photo to collection
     *
     * @param Offer|array $offer
     *
     * @return Offers
     */
    public function add($offer)
    {
        if (is_array($offer)) {
            $this->collection[] = new Offer($offer);
        } elseif (is_object($offer) && $offer instanceof Offer) {
            $this->collection[] = $offer;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Offers|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
