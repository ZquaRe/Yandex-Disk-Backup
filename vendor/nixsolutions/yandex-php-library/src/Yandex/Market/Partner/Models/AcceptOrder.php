<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class AcceptOrder extends Model
{

    protected $accepted = null;

    protected $id = null;

    protected $reason = null;

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Retrieve the accepted property
     *
     * @return boolean|null
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set the accepted property
     *
     * @param boolean $accepted
     * @return $this
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;
        return $this;
    }

    /**
     * Retrieve the id property
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id property
     *
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Retrieve the reason property
     *
     * @return string|null
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set the reason property
     *
     * @param string $reason
     * @return $this
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
        return $this;
    }
}
