<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\ObjectModel;

class Schedules extends ObjectModel
{
    /**
     * Add review to collection
     *
     * @param Schedule|array $sсhedule
     *
     * @return Schedules
     */
    public function add($schedule)
    {
        if (is_array($schedule)) {
            $this->collection[] = new Schedule($schedule);
        } elseif (is_object($schedule) && $schedule instanceof Schedule) {
            $this->collection[] = $schedule;
        }

        return $this;
    }

    /**
     * Retrieve the collection property
     *
     * @return Schedules
     */
    public function getAll()
    {
        return $this->collection;
    }
}
