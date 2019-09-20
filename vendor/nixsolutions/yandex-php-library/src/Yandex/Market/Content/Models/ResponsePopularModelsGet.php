<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ResponsePopularModelsGet extends Model
{
    protected $categories = null;

    protected $mappingClasses = [
        'categories' => 'Yandex\Market\Content\Models\Categories'
    ];

    protected $propNameMap = [
        'topCategoryList' => 'categories'
    ];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data['popular']);
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
}
