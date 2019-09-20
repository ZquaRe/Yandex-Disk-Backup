<?php

namespace Yandex\Metrica\Stat\Models;

use Yandex\Common\Model;

class ComparisonParams extends Model
{

    protected $id = null;

    protected $metrics = null;

    protected $accuracy = null;

    protected $callback = null;

    protected $date1A = null;

    protected $date1B = null;

    protected $date2A = null;

    protected $date2B = null;

    protected $dimensions = null;

    protected $filters = null;

    protected $filtersA = null;

    protected $filtersB = null;

    protected $includeUndefined = null;

    protected $lang = null;

    protected $limit = null;

    protected $offset = null;

    protected $preset = null;

    protected $pretty = null;

    protected $sort = null;

    protected $mappingClasses = [];

    protected $propNameMap = [
        'date1_a' => 'date1A',
        'date1_b' => 'date1B',
        'date2_a' => 'date2A',
        'date2_b' => 'date2B',
        'filters_a' => 'filtersA',
        'filters_b' => 'filtersB',
        'include_undefined' => 'includeUndefined'
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
     * Retrieve the accuracy property
     *
     * @return string|null
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * Set the accuracy property
     *
     * @param string $accuracy
     * @return $this
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
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

    /**
     * Retrieve the includeUndefined property
     *
     * @return bool|null
     */
    public function getIncludeUndefined()
    {
        return $this->includeUndefined;
    }

    /**
     * Set the includeUndefined property
     *
     * @param bool $includeUndefined
     * @return $this
     */
    public function setIncludeUndefined($includeUndefined)
    {
        $this->includeUndefined = $includeUndefined;
        return $this;
    }

    /**
     * Retrieve the lang property
     *
     * @return string|null
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set the lang property
     *
     * @param string $lang
     * @return $this
     */
    public function setLang($lang)
    {
        $this->lang = $lang;
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
     * Retrieve the pretty property
     *
     * @return bool|null
     */
    public function getPretty()
    {
        return $this->pretty;
    }

    /**
     * Set the pretty property
     *
     * @param bool $pretty
     * @return $this
     */
    public function setPretty($pretty)
    {
        $this->pretty = $pretty;
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
}
