<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\PagedModel;

class ResponseCategoryGetList extends PagedModel
{
    protected $mappingClasses = [
        'items' => 'Yandex\Market\Content\Models\Categories'
    ];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data['categories']);
    }
}
