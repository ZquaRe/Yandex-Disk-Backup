<?php

namespace Yandex\Metrica\Analytics\Models;

use Yandex\Common\Model;

class Params extends Model
{

    protected $endDate = null;

    protected $ids = null;

    protected $metrics = null;

    protected $startDate = null;

    protected $callback = null;

    protected $dimensions = null;

    protected $filters = null;

    protected $maxResults = null;

    protected $samplingLevel = null;

    protected $sort = null;

    protected $startIndex = null;

    protected $mappingClasses = [];

    protected $propNameMap = [
        'end-date' => 'endDate',
        'start-date' => 'startDate',
        'max-results' => 'maxResults',
        'start-index' => 'startIndex'
    ];

    /**
     * Retrieve the endDate property
     *
     * @return string|null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set the endDate property
     *
     * @param string $endDate
     * @return $this
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * Retrieve the ids property
     *
     * @return string|null
     */
    public function getIds()
    {
        return $this->ids;
    }

    /**
     * Set the ids property
     *
     * @param string $ids
     * @return $this
     */
    public function setIds($ids)
    {
        $this->ids = $ids;
        return $this;
    }

    /**
     * Retrieve the metrics property
     *
     * @return string|null
     */
    public function getMetrics()
    {
        return $this->metrics;
    }

    /**
     * Set the metrics property
     *
     * @param string $metrics
     * @return $this
     */
    public function setMetrics($metrics)
    {
        $this->metrics = $metrics;
        return $this;
    }

    /**
     * Retrieve the startDate property
     *
     * @return string|null
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set the startDate property
     *
     * @param string $startDate
     * @return $this
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * Retrieve the callback property
     *
     * @return string|null
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Set the callback property
     *
     * @param string $callback
     * @return $this
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * Retrieve the dimensions property
     *
     * @return string|null
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * Set the dimensions property
     *
     * @param string $dimensions
     * @return $this
     */
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;
        return $this;
    }

    /**
     * Retrieve the filters property
     *
     * @return string|null
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Set the filters property
     *
     * @param string $filters
     * @return $this
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

    /**
     * Retrieve the maxResults property
     *
     * @return string|null
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * Set the maxResults property
     *
     * @param string $maxResults
     * @return $this
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
        return $this;
    }

    /**
     * Retrieve the samplingLevel property
     *
     * @return string|null
     */
    public function getSamplingLevel()
    {
        return $this->samplingLevel;
    }

    /**
     * Set the samplingLevel property
     *
     * @param string $samplingLevel
     * @return $this
     */
    public function setSamplingLevel($samplingLevel)
    {
        $this->samplingLevel = $samplingLevel;
        return $this;
    }

    /**
     * Retrieve the sort property
     *
     * @return string|null
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set the sort property
     *
     * @param string $sort
     * @return $this
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * Retrieve the startIndex property
     *
     * @return int|null
     */
    public function getStartIndex()
    {
        return $this->startIndex;
    }

    /**
     * Set the startIndex property
     *
     * @param int $startIndex
     * @return $this
     */
    public function setStartIndex($startIndex)
    {
        $this->startIndex = $startIndex;
        return $this;
    }
}
