<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Goal;
use Yandex\Common\Model;

class GetGoalResponse extends Model
{

    protected $goal = null;

    protected $mappingClasses = [
        'goal' => 'Yandex\Metrica\Management\Models\Goal'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the goal property
     *
     * @return Goal|null
     */
    public function getGoal()
    {
        return $this->goal;
    }

    /**
     * Set the goal property
     *
     * @param Goal $goal
     * @return $this
     */
    public function setGoal($goal)
    {
        $this->goal = $goal;
        return $this;
    }
}
