<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\Model;

class CounterParams extends Model
{

    protected $callback = null;

    protected $field = null;

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Retrieve the callback property
     *
     * @return string|null
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Set the callback property
     *
     * @param string $callback
     * @return $this
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
        return $this;
    }

    /**
     * Retrieve the field property
     *
     * @return string|null
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the field property
     *
     * @param string $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }
}
