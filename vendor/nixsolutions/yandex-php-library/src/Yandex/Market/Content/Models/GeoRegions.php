<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class GeoRegions extends ObjectModel
{
    /**
     * Add geo region to collection
     *
     * @param GeoRegion|array $geoRegion
     *
     * @return GeoRegions
     */
    public function add($geoRegion)
    {
        if (is_array($geoRegion)) {
            $this->collection[] = new GeoRegion($geoRegion);
        } elseif (is_object($geoRegion) && $geoRegion instanceof GeoRegion) {
            $this->collection[] = $geoRegion;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return GeoRegions|null
     */
    public function getAll()
    {
        return $this->collection;
    }
}
