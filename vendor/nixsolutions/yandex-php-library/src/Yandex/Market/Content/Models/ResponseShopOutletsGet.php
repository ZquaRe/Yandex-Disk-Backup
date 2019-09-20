<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\PagedModel;

class ResponseShopOutletsGet extends PagedModel
{
    protected $mappingClasses = [
        'items' => 'Yandex\Market\Content\Models\Outlets'
    ];

    protected $propNameMap = [
        'outlet' => 'items'
    ];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data['outlets']);
    }
}
