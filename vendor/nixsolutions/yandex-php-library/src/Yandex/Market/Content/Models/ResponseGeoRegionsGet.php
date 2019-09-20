<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\PagedModel;

class ResponseGeoRegionsGet extends PagedModel
{
    protected $mappingClasses = [
        'items' => 'Yandex\Market\Content\Models\GeoRegions'
    ];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        parent::__construct($data['georegions']);
    }
}
