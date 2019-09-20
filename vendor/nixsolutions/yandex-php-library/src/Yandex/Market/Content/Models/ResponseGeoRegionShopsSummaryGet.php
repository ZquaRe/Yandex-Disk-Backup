<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ResponseGeoRegionShopsSummaryGet extends Model
{
    protected $homeCount = null;

    protected $deliveryCount = null;

    protected $totalCount = null;

    /**
     * Retrieve the homeCount property
     *
     * @return int|null
     */
    public function getHomeCount()
    {
        return $this->homeCount;
    }

    /**
     * Retrieve the deliveryCount property
     *
     * @return int|null
     */
    public function getDeliveryCount()
    {
        return $this->deliveryCount;
    }

    /**
     * Retrieve the totalCount property
     *
     * @return int|null
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }
}
