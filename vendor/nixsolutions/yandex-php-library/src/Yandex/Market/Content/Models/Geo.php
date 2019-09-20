<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Geo extends Model
{
    protected $id = null;

    protected $latitude = null;

    protected $longitude = null;

    protected $distance = null;

    protected $propNameMap = [
        'geoId' => 'id'
    ];

    /**
     * Retrieve the id property
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Retrieve the latitude property
     *
     * @return string|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Retrieve the longitude property
     *
     * @return string|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Retrieve the distance property
     *
     * @return string|null
     */
    public function getDistance()
    {
        return $this->distance;
    }
}
