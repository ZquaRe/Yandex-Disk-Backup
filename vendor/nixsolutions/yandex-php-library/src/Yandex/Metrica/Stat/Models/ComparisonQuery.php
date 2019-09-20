<?php

namespace Yandex\Metrica\Stat\Models;

use Yandex\Common\Model;

class ComparisonQuery extends Model
{

    protected $id = null;

    protected $preset = null;

    protected $dimensions = null;

    protected $metrics = null;

    protected $sort = null;

    protected $limit = null;

    protected $offset = null;

    protected $date1A = null;

    protected $date2A = null;

    protected $filtersA = null;

    protected $date1B = null;

    protected $date2B = null;

    protected $filtersB = null;

    protected $mappingClasses = [];

    protected $propNameMap = [
        'date1_a' => 'date1A',
        'date2_a' => 'date2A',
        'filters_a' => 'filtersA',
        'date1_b' =>'date1B',
        'date2_b' =>'date2B',
        'filters_b' =>'filtersB'
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
     * Set the id property
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Retrieve the preset property
     *
     * @return string|null
     */
    public function getPreset()
    {
        return $this->preset;
    }

    /**
     * Set the preset property
     *
     * @param string $preset
     * @return $this
     */
    public function setPreset($preset)
    {
        $this->preset = $preset;
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
     * Retrieve the limit property
     *
     * @return int|null
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Set the limit property
     *
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Retrieve the offset property
     *
     * @return int|null
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Set the offset property
     *
     * @param int $offset
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Retrieve the date1A property
     *
     * @return string|null
     */
    public function getDate1A()
    {
        return $this->date1A;
    }

    /**
     * Set the date1A property
     *
     * @param string $date1A
     * @return $this
     */
    public function setDate1A($date1A)
    {
        $this->date1A = $date1A;
        return $this;
    }

    /**
     * Retrieve the date2A property
     *
     * @return string|null
     */
    public function getDate2A()
    {
        return $this->date2A;
    }

    /**
     * Set the date2A property
     *
     * @param string $date2A
     * @return $this
     */
    public function setDate2A($date2A)
    {
        $this->date2A = $date2A;
        return $this;
    }

    /**
     * Retrieve the filtersA property
     *
     * @return string|null
     */
    public function getFiltersA()
    {
        return $this->filtersA;
    }

    /**
     * Set the filtersA property
     *
     * @param string $filtersA
     * @return $this
     */
    public function setFiltersA($filtersA)
    {
        $this->filtersA = $filtersA;
        return $this;
    }

    /**
     * Retrieve the date1B property
     *
     * @return string|null
     */
    public function getDate1B()
    {
        return $this->date1B;
    }

    /**
     * Set the date1B property
     *
     * @param string $date1B
     * @return $this
     */
    public function setDate1B($date1B)
    {
        $this->date1B = $date1B;
        return $this;
    }

    /**
     * Retrieve the date2B property
     *
     * @return string|null
     */
    public function getDate2B()
    {
        return $this->date2B;
    }

    /**
     * Set the date2B property
     *
     * @param string $date2B
     * @return $this
     */
    public function setDate2B($date2B)
    {
        $this->date2B = $date2B;
        return $this;
    }

    /**
     * Retrieve the filtersB property
     *
     * @return string|null
     */
    public function getFiltersB()
    {
        return $this->filtersB;
    }

    /**
     * Set the filtersB property
     *
     * @param string $filtersB
     * @return $this
     */
    public function setFiltersB($filtersB)
    {
        $this->filtersB = $filtersB;
        return $this;
    }
}
