<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Comments extends ObjectModel
{
    /**
     * Add comment to collection
     *
     * @param Comment|array $comment
     *
     * @return Comments
     */
    public function add($comment)
    {
        if (is_array($comment)) {
            $this->collection[] = new Comment($comment);
        } elseif (is_object($comment) && $comment instanceof Comment) {
            $this->collection[] = $comment;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Comments|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
