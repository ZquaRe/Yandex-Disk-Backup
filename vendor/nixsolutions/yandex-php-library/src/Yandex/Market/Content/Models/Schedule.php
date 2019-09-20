<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Schedule extends Model
{
    protected $workingDaysFrom = null;

    protected $workingDaysTill = null;

    protected $workingHoursFrom = null;

    protected $workingHoursTill = null;

    /**
     * Retrieve the workingDaysFrom property
     *
     * @return int|null
     */
    public function getWorkingDaysFrom()
    {
        return $this->workingDaysFrom;
    }

    /**
     * Retrieve the workingDaysTill property
     *
     * @return int|null
     */
    public function getWorkingDaysTill()
    {
        return $this->workingDaysTill;
    }

    /**
     * Retrieve the workingHoursFrom property
     *
     * @return string|null
     */
    public function getWorkingHoursFrom()
    {
        return $this->workingHoursFrom;
    }

    /**
     * Retrieve the workingHoursTill property
     *
     * @return string|null
     */
    public function getWorkingHoursTill()
    {
        return $this->workingHoursTill;
    }
}
