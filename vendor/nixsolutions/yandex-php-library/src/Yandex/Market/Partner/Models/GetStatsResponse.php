<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class GetStatsResponse extends Model
{
    protected $mainStats = null;

    protected $mappingClasses = [
        'mainStats' => 'Yandex\Market\Partner\Models\Stats'
    ];

    protected $propNameMap = [];

    /**
     * @return null
     */
    public function getMainStats()
    {
        return $this->mainStats;
    }
}
