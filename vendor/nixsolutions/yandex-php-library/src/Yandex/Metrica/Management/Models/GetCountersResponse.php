<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Counters;
use Yandex\Common\Model;

class GetCountersResponse extends Model
{

    protected $counters = null;

    protected $rows = null;

    protected $mappingClasses = [
        'counters' => 'Yandex\Metrica\Management\Models\Counters'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the counters property
     *
     * @return Counters|null
     */
    public function getCounters()
    {
        return $this->counters;
    }

    /**
     * Set the counters property
     *
     * @param Counters $counters
     * @return $this
     */
    public function setCounters($counters)
    {
        $this->counters = $counters;
        return $this;
    }

    /**
     * Retrieve the rows property
     *
     * @return int|null
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Set the rows property
     *
     * @param int $rows
     * @return $this
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }
}
