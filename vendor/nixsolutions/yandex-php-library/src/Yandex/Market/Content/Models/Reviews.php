<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Reviews extends ObjectModel
{
    /**
     * Add review to collection
     *
     * @param Review|array $review
     *
     * @return Reviews
     */
    public function add($review)
    {
        if (is_array($review)) {
            $this->collection[] = new Review($review);
        } elseif (is_object($review) && $review instanceof Review) {
            $this->collection[] = $review;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Reviews
     */
    public function getAll()
    {
        return $this->collection;
    }
}
