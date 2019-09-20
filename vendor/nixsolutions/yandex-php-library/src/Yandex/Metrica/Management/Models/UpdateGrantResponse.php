<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Grant;
use Yandex\Common\Model;

class UpdateGrantResponse extends Model
{

    protected $grant = null;

    protected $mappingClasses = [
        'grant' => 'Yandex\Metrica\Management\Models\Grant'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the grant property
     *
     * @return Grant|null
     */
    public function getGrant()
    {
        return $this->grant;
    }

    /**
     * Set the grant property
     *
     * @param Grant $grant
     * @return $this
     */
    public function setGrant($grant)
    {
        $this->grant = $grant;
        return $this;
    }
}
