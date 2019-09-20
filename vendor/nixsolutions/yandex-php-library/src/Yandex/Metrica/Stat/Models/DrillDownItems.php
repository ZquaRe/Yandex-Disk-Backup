<?php

namespace Yandex\Metrica\Stat\Models;

use Yandex\Metrica\Stat\Models\Dimension;
use Yandex\Common\Model;

class DrillDownItems extends Model
{

    protected $dimension = null;

    protected $metrics = null;

    protected $expand = null;

    protected $mappingClasses = [
        'dimension' => 'Yandex\Metrica\Stat\Models\Dimension'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the dimension property
     *
     * @return Dimension|null
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set the dimension property
     *
     * @param Dimension $dimension
     * @return $this
     */
    public function setDimension($dimension)
    {
        $this->dimension = $dimension;
        return $this;
    }

    /**
     * Retrieve the metrics property
     *
     * @return array|null
     */
    public function getMetrics()
    {
        return $this->metrics;
    }

    /**
     * Set the metrics property
     *
     * @param array $metrics
     * @return $this
     */
    public function setMetrics($metrics)
    {
        $this->metrics = $metrics;
        return $this;
    }

    /**
     * Retrieve the expand property
     *
     * @return bool|null
     */
    public function getExpand()
    {
        return $this->expand;
    }

    /**
     * Set the expand property
     *
     * @param bool $expand
     * @return $this
     */
    public function setExpand($expand)
    {
        $this->expand = $expand;
        return $this;
    }
}
