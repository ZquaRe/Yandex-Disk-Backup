<?php

namespace Yandex\Market\Content\Models\Base;

use Yandex\Common\ObjectModel;

class Models extends ObjectModel
{
    /**
     * Add category to collection
     *
     * @param MarketModel|array $model
     *
     * @return Models
     */
    public function add($model)
    {
        if (is_array($model)) {
            // @note: add model type validation.
            $this->collection[] = MarketModel::getInstance($model);
        } elseif (is_object($model) && $model instanceof MarketModel) {
            $this->collection[] = $model;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Models|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
