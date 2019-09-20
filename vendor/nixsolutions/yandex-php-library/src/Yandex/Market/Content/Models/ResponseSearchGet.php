<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\PagedModel;

class ResponseSearchGet extends PagedModel
{
    protected $categories = null;

    protected $regionDelimiterPosition = null;

    protected $requestParams = null;

    protected $mappingClasses = [
        'items' => 'Yandex\Market\Content\Models\SearchResults',
        'categories' => 'Yandex\Market\Content\Models\Categories',
        'requestParams' => 'Yandex\Market\Content\Models\SearchRequestParams'
    ];

    protected $propNameMap = [
        'results' => 'items'
    ];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data['searchResult']);
    }

    /**
     * Retrieve the categories property
     *
     * @return Categories|null
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Retrieve the regionDelimiterPosition property
     *
     * @return int|null
     */
    public function getRegionDelimiterPosition()
    {
        return $this->regionDelimiterPosition;
    }

    /**
     * Retrieve the requestParams property
     *
     * @return SearchRequestParams|null
     */
    public function getRequestParams()
    {
        return $this->requestParams;
    }
}
