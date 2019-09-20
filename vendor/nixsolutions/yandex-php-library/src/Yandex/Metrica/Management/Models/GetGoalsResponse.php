<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Goals;
use Yandex\Common\Model;

class GetGoalsResponse extends Model
{

    protected $goals = null;

    protected $mappingClasses = [
        'goals' => 'Yandex\Metrica\Management\Models\Goals'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the goals property
     *
     * @return Goals|null
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * Set the goals property
     *
     * @param Goals $goals
     * @return $this
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;
        return $this;
    }
}
