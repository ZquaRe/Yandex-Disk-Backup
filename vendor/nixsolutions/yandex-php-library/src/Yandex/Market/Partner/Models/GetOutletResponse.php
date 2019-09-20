<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Market\Partner\Models\Outlet;
use Yandex\Common\Model;

class GetOutletResponse extends Model
{
    protected $outlet = null;

    protected $mappingClasses = [
        'outlet' => 'Yandex\Market\Partner\Models\Outlet'
    ];

    protected $propNameMap = [];

    /**
     * @return Outlet|null
     */
    public function getOutlet()
    {
        return $this->outlet;
    }
}
