<?php

namespace Yandex\Metrica\Analytics\Models;

use Yandex\Common\Model;

class Query extends Model
{

    protected $ids = null;

    protected $startDate = null;

    protected $endDate = null;

    protected $dimensions = null;

    protected $metrics = null;

    protected $sort = null;

    protected $filters = null;

    protected $startIndex = null;

    protected $maxResults = null;

    protected $mappingClasses = [];

    protected $propNameMap = [
        'start-date' => 'startDate',
        'end-date' => 'endDate',
        'start-index' => 'startIndex',
        'max-results' => 'maxResults'
    ];

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
     * Retrieve the dimensions property
     *
     * @return array|null
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * Set the dimensions property
     *
     * @param array $dimensions
     * @return $this
     */
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;
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
     * Retrieve the sort property
     *
     * @return array|null
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set the sort property
     *
     * @param array $sort
     * @return $this
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
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

    /**
     * Retrieve the maxResults property
     *
     * @return int|null
     */
    public function getMaxResults()
    {
        return $this->maxResults;
    }

    /**
     * Set the maxResults property
     *
     * @param int $maxResults
     * @return $this
     */
    public function setMaxResults($maxResults)
    {
        $this->maxResults = $maxResults;
        return $this;
    }
}
