<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class Pager extends Model
{

    protected $total = null;

    protected $from = null;

    protected $to = null;

    protected $pageSize = null;

    protected $pagesCount = null;

    protected $currentPage = null;

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Retrieve the total property
     *
     * @return int|null
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Retrieve the from property
     *
     * @return int|null
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Retrieve the to property
     *
     * @return int|null
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Retrieve the pageSize property
     *
     * @return int|null
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * Retrieve the pagesCount property
     *
     * @return int|null
     */
    public function getPagesCount()
    {
        return $this->pagesCount;
    }

    /**
     * Retrieve the currentPage property
     *
     * @return int|null
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }
}
