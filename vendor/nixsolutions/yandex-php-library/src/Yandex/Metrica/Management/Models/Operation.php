<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\Model;

class Operation extends Model
{

    protected $id = null;

    protected $action = null;

    protected $attr = null;

    protected $value = null;

    protected $status = null;

    protected $mappingClasses = [];

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
     * Retrieve the action property
     *
     * @return string|null
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set the action property
     *
     * @param string $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * Retrieve the attr property
     *
     * @return string|null
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * Set the attr property
     *
     * @param string $attr
     * @return $this
     */
    public function setAttr($attr)
    {
        $this->attr = $attr;
        return $this;
    }

    /**
     * Retrieve the value property
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value property
     *
     * @param string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Retrieve the status property
     *
     * @return string|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the status property
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
