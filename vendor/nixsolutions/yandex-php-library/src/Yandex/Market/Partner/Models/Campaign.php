<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class Campaign extends Model
{

    protected $id = null;

    protected $domain = null;

    protected $state = null;

    protected $stateReasons = null;

    protected $mappingClasses = [];

    protected $propNameMap = [];

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
     * Retrieve the domain property
     *
     * @return string|null
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Retrieve the state property
     *
     * @return int|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Retrieve the stateReasons property
     *
     * @return array|null
     */
    public function getStateReasons()
    {
        return $this->stateReasons;
    }
}
