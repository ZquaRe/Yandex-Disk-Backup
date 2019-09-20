<?php

namespace Yandex\Metrica\Analytics\Models;

use Yandex\Common\Model;

class Header extends Model
{

    protected $name = null;

    protected $columnType = null;

    protected $dataType = null;

    protected $mappingClasses = [];

    protected $propNameMap = [];

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
     * Retrieve the columnType property
     *
     * @return string|null
     */
    public function getColumnType()
    {
        return $this->columnType;
    }

    /**
     * Set the columnType property
     *
     * @param string $columnType
     * @return $this
     */
    public function setColumnType($columnType)
    {
        $this->columnType = $columnType;
        return $this;
    }

    /**
     * Retrieve the dataType property
     *
     * @return string|null
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Set the dataType property
     *
     * @param string $dataType
     * @return $this
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
        return $this;
    }
}
