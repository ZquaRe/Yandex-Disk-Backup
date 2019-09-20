<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Filter extends Model
{
    protected $id = null;

    protected $name = null;

    protected $shortName = null;

    protected $type = null;

    protected $hasBoolNo = null;

    protected $subType = null;

    protected $description = null;

    protected $unit = null;

    protected $exactly = null;

    protected $minValue = null;

    protected $maxValue = null;

    protected $property = null;

    protected $options = null;

    protected $enumFilterType = null;

    protected $mappingClasses = [
        'property' => 'Yandex\Market\Content\Models\Property',
        'options' => 'Yandex\Market\Content\Models\Options'
    ];

    protected $propNameMap = [
        'shortname' => 'shortName',
        'filterProperty' => 'property'
    ];

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getShortName()
    {
        return $this->shortName;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getHasBoolNo()
    {
        return $this->hasBoolNo;
    }

    public function getSubType()
    {
        return $this->subType;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function getExactly()
    {
        return $this->exactly;
    }

    public function getMinValue()
    {
        return $this->minValue;
    }

    public function getMaxValue()
    {
        return $this->maxValue;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getEnumFilterType()
    {
        return $this->enumFilterType;
    }
}
