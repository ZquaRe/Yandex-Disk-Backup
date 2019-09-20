<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class ModelOpinions extends ObjectModel
{
    /**
     * Add opinion to collection
     *
     * @param ModelOpinion|array $opinion
     *
     * @return ModelOpinions
     */
    public function add($opinion)
    {
        if (is_array($opinion)) {
            $this->collection[] = new ModelOpinion($opinion);
        } elseif (is_object($opinion) && $opinion instanceof ModelOpinion) {
            $this->collection[] = $opinion;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return ModelOpinions|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
