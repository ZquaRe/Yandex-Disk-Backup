<?php

namespace Yandex\Metrica\Analytics\Models;

use Yandex\Metrica\Analytics\Models\Query;
use Yandex\Metrica\Analytics\Models\ColumnHeaders;
use Yandex\Common\Model;

class Ga extends Model
{

    protected $kind = null;

    protected $id = null;

    protected $selfLink = null;

    protected $containsSampledData = null;

    protected $sampleSize = null;

    protected $sampleSpace = null;

    protected $query = null;

    protected $itemsPerPage = null;

    protected $totalResults = null;

    protected $columnHeaders = null;

    protected $totalsForAllResults = null;

    protected $rows = null;

    protected $mappingClasses = [
        'query' => 'Yandex\Metrica\Analytics\Models\Query',
        'columnHeaders' => 'Yandex\Metrica\Analytics\Models\ColumnHeaders'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the kind property
     *
     * @return string|null
     */
    public function getKind()
    {
        return $this->kind;
    }

    /**
     * Set the kind property
     *
     * @param string $kind
     * @return $this
     */
    public function setKind($kind)
    {
        $this->kind = $kind;
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
     * Retrieve the selfLink property
     *
     * @return string|null
     */
    public function getSelfLink()
    {
        return $this->selfLink;
    }

    /**
     * Set the selfLink property
     *
     * @param string $selfLink
     * @return $this
     */
    public function setSelfLink($selfLink)
    {
        $this->selfLink = $selfLink;
        return $this;
    }

    /**
     * Retrieve the containsSampledData property
     *
     * @return bool|null
     */
    public function getContainsSampledData()
    {
        return $this->containsSampledData;
    }

    /**
     * Set the containsSampledData property
     *
     * @param bool $containsSampledData
     * @return $this
     */
    public function setContainsSampledData($containsSampledData)
    {
        $this->containsSampledData = $containsSampledData;
        return $this;
    }

    /**
     * Retrieve the sampleSize property
     *
     * @return string|null
     */
    public function getSampleSize()
    {
        return $this->sampleSize;
    }

    /**
     * Set the sampleSize property
     *
     * @param string $sampleSize
     * @return $this
     */
    public function setSampleSize($sampleSize)
    {
        $this->sampleSize = $sampleSize;
        return $this;
    }

    /**
     * Retrieve the sampleSpace property
     *
     * @return string|null
     */
    public function getSampleSpace()
    {
        return $this->sampleSpace;
    }

    /**
     * Set the sampleSpace property
     *
     * @param string $sampleSpace
     * @return $this
     */
    public function setSampleSpace($sampleSpace)
    {
        $this->sampleSpace = $sampleSpace;
        return $this;
    }

    /**
     * Retrieve the query property
     *
     * @return Query|null
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set the query property
     *
     * @param Query $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * Retrieve the itemsPerPage property
     *
     * @return int|null
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }

    /**
     * Set the itemsPerPage property
     *
     * @param int $itemsPerPage
     * @return $this
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
        return $this;
    }

    /**
     * Retrieve the totalResults property
     *
     * @return int|null
     */
    public function getTotalResults()
    {
        return $this->totalResults;
    }

    /**
     * Set the totalResults property
     *
     * @param int $totalResults
     * @return $this
     */
    public function setTotalResults($totalResults)
    {
        $this->totalResults = $totalResults;
        return $this;
    }

    /**
     * Retrieve the columnHeaders property
     *
     * @return ColumnHeaders|null
     */
    public function getColumnHeaders()
    {
        return $this->columnHeaders;
    }

    /**
     * Set the columnHeaders property
     *
     * @param ColumnHeaders $columnHeaders
     * @return $this
     */
    public function setColumnHeaders($columnHeaders)
    {
        $this->columnHeaders = $columnHeaders;
        return $this;
    }

    /**
     * Retrieve the totalsForAllResults property
     *
     * @return array|null
     */
    public function getTotalsForAllResults()
    {
        return $this->totalsForAllResults;
    }

    /**
     * Set the totalsForAllResults property
     *
     * @param array $totalsForAllResults
     * @return $this
     */
    public function setTotalsForAllResults($totalsForAllResults)
    {
        $this->totalsForAllResults = $totalsForAllResults;
        return $this;
    }

    /**
     * Retrieve the rows property
     *
     * @return array|null
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * Set the rows property
     *
     * @param array $rows
     * @return $this
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
        return $this;
    }
}
