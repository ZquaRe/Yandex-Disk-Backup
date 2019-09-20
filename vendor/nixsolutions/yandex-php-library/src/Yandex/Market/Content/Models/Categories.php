<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Categories extends ObjectModel
{
    /**
     * Add category to collection
     *
     * @param Category|array $category
     *
     * @return Categories
     */
    public function add($category)
    {
        if (is_array($category)) {
            $this->collection[] = new Category($category);
        } elseif (is_object($category) && $category instanceof Category) {
            $this->collection[] = $category;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Categories|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
