<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Counter;
use Yandex\Common\Model;

class AddCounterResponse extends Model
{

    protected $counter = null;

    protected $mappingClasses = [
        'counter' => 'Yandex\Metrica\Management\Models\Counter'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the counter property
     *
     * @return Counter|null
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * Set the counter property
     *
     * @param Counter $counter
     * @return $this
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;
        return $this;
    }
}
