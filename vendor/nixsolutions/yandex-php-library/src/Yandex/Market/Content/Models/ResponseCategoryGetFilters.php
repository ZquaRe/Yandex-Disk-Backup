<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ResponseCategoryGetFilters extends Model
{
    protected $filters = null;

    protected $mappingClasses = [
        'filters' => 'Yandex\Market\Content\Models\Filters'
    ];

    /**
     * Retrieve the filters property
     *
     * @return Filters|null
     */
    public function getFilters()
    {
        return $this->filters;
    }
}
