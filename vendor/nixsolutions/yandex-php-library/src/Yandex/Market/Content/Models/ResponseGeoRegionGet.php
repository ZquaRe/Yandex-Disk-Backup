<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ResponseGeoRegionGet extends Model
{
    protected $geoRegion = null;

    protected $mappingClasses = [
        'geoRegion' => 'Yandex\Market\Content\Models\GeoRegion'
    ];

    protected $propNameMap = [
        'georegion' => 'geoRegion'
    ];

    /**
     * Retrieve the geoRegion property
     *
     * @return GeoRegion|null
     */
    public function getGeoRegion()
    {
        return $this->geoRegion;
    }
}
