<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\PagedModel;

class ResponseCategoryGetModels extends PagedModel
{
    protected $mappingClasses = [
        'items' => 'Yandex\Market\Content\Models\Base\Models'
    ];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data['models']);
    }
}
