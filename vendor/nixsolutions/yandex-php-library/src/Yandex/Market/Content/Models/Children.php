<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Children extends ObjectModel
{
    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        // fix children inheritance
        if (isset($data['models'])
            && count($data['models']) > 0
        ) {
            $data = $data['models'];
        }

        parent::__construct($data);
    }

    /**
     * Add childModel to collection
     *
     * @param ModelChild|array $childModel
     *
     * @return Children
     */
    public function add($childModel)
    {
        if (is_array($childModel)) {
            $this->collection[] = new ModelChild($childModel);
        } elseif (is_object($childModel) && $childModel instanceof ModelChild) {
            $this->collection[] = $childModel;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Children
     */
    public function getAll()
    {
        return $this->collection;
    }
}
