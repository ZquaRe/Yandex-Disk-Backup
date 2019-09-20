<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ResponseCategoryGet extends Model
{
    protected $category = null;

    protected $mappingClasses = [
        'category' => 'Yandex\Market\Content\Models\Category'
    ];

    /**
     * Retrieve the categories property
     *
     * @return Categories|null
     */
    public function getCategory()
    {
        return $this->category;
    }
}
