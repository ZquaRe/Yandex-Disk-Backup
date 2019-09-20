<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Metrica\Management\Models\Conditions;
use Yandex\Common\Model;

class Goal extends Model
{

    protected $id = null;

    protected $name = null;

    protected $type = null;

    protected $class = null;

    protected $flag = null;

    protected $conditions = null;

    protected $mappingClasses = [
        'conditions' => 'Yandex\Metrica\Management\Models\Conditions'
    ];

    protected $propNameMap = [];

    /**
     * Retrieve the id property
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id property
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Retrieve the name property
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name property
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Retrieve the type property
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type property
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Retrieve the class property
     *
     * @return int|null
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the class property
     *
     * @param int $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    /**
     * Retrieve the flag property
     *
     * @return int|null
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * Set the flag property
     *
     * @param int $flag
     * @return $this
     */
    public function setFlag($flag)
    {
        $this->flag = $flag;
        return $this;
    }

    /**
     * Retrieve the conditions property
     *
     * @return Conditions|null
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set the conditions property
     *
     * @param Conditions $conditions
     * @return $this
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }
}
