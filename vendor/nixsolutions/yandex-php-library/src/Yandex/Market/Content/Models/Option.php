<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Option extends Model
{
    protected $valueId = null;

    protected $valueText = null;

    protected $count = null;

    protected $popularity = null;

    protected $tag = null;

    protected $code = null;

    protected $unit = null;

    protected $unitName = null;

    /**
     * Retrieve the valueId property
     *
     * @return int|null
     */
    public function getValueId()
    {
        return $this->valueId;
    }

    /**
     * Retrieve the valueText property
     *
     * @return string|null
     */
    public function getValueText()
    {
        return $this->valueText;
    }

    /**
     * Retrieve the count property
     *
     * @return int|null
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Retrieve the popularity property
     *
     * @return float|null
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * Retrieve the tag property
     *
     * @return string|null
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Retrieve the code property
     *
     * @return string|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Retrieve the unit property
     *
     * @return string|null
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Retrieve the unitName property
     *
     * @return string|null
     */
    public function getUnitName()
    {
        return $this->unitName;
    }
}
