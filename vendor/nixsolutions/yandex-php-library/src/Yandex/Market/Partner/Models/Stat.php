<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class Stat extends Model
{
    protected $date = null;

    protected $placeGroup = null;

    protected $clicks = null;

    protected $spending = null;

    protected $shows = null;

    protected $detailedStats = null;

    /**
     * @return null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @return null
     */
    public function getPlaceGroup()
    {
        return $this->placeGroup;
    }

    /**
     * @return null
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * @return null
     */
    public function getSpending()
    {
        return $this->spending;
    }

    /**
     * @return null
     */
    public function getShows()
    {
        return $this->shows;
    }

    /**
     * @return null
     */
    public function getDetailedStats()
    {
        return $this->detailedStats;
    }
}
