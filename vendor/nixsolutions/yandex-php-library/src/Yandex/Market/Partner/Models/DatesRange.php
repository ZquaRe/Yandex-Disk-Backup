<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class DatesRange extends Model
{

    protected $fromDate = null;

    protected $toDate = null;

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Retrieve the fromDate property
     *
     * @return string|null
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * Set the fromDate property
     *
     * @param string $fromDate
     * @return $this
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
        return $this;
    }

    /**
     * Retrieve the toDate property
     *
     * @return string|null
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * Set the toDate property
     *
     * @param string $toDate
     * @return $this
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
        return $this;
    }
}
