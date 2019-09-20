<?php

namespace Yandex\Metrica\Management\Models;

use Yandex\Common\Model;

class Filter extends Model
{

    protected $id = null;

    protected $attr = null;

    protected $type = null;

    protected $value = null;

    protected $action = null;

    protected $status = null;

    protected $startIp = null;

    protected $endIp = null;

    protected $mappingClasses = [];

    protected $propNameMap = [
        'start_ip' => 'startIp',
        'end_ip' => 'endIp'
    ];

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

    /**
     * Retrieve the startIp property
     *
     * @return string|null
     */
    public function getStartIp()
    {
        return $this->startIp;
    }

    /**
     * Set the startIp property
     *
     * @param string $startIp
     * @return $this
     */
    public function setStartIp($startIp)
    {
        $this->startIp = $startIp;
        return $this;
    }

    /**
     * Retrieve the endIp property
     *
     * @return string|null
     */
    public function getEndIp()
    {
        return $this->endIp;
    }

    /**
     * Set the endIp property
     *
     * @param string $endIp
     * @return $this
     */
    public function setEndIp($endIp)
    {
        $this->endIp = $endIp;
        return $this;
    }
}
