<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\PagedModel;

class ResponseShopOpinionsGet extends PagedModel
{
    protected $mappingClasses = [
        'items' => 'Yandex\Market\Content\Models\ShopOpinions'
    ];

    protected $propNameMap = [
        'opinion' => 'items'
    ];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data['shopOpinions']);
    }
}
