<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Property extends Model
{
    protected $longName = null;

    protected $description = null;

    protected $propNameMap = [
        'longname' => 'longName'
    ];

    /**
     * Retrieve the longName property
     *
     * @return string|null
     */
    public function getLongName()
    {
        return $this->longName;
    }

    /**
     * Retrieve the description property
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }
}
