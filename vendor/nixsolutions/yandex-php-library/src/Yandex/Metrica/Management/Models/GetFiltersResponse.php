<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Filters;
use Yandex\Common\Model;

class GetFiltersResponse extends Model
{

    protected $filters = null;

    protected $mappingClasses = [
        'filters' => 'Yandex\Metrica\Management\Models\Filters'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the filters property
     *
     * @return Filters|null
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set the filters property
     *
     * @param Filters $filters
     * @return $this
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
        return $this;
    }
}
