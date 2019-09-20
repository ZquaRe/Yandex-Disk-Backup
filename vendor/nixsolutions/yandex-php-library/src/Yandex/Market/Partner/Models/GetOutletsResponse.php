<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Market\Partner\Models\Pager;
use Yandex\Market\Partner\Models\Outlets;
use Yandex\Common\Model;

class GetOutletsResponse extends Model
{

    protected $pager = null;

    protected $outlets = null;

    protected $mappingClasses = [
        'pager' => 'Yandex\Market\Partner\Models\Pager',
        'outlets' => 'Yandex\Market\Partner\Models\Outlets'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the pager property
     *
     * @return Pager|null
     */
    public function getPager()
    {
        return $this->pager;
    }

    /**
     * Retrieve the Outlets property
     *
     * @return Outlets|null
     */
    public function getOutlets()
    {
        return $this->outlets;
    }
}
