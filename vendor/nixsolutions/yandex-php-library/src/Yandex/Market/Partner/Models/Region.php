<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class Region extends Model
{

    protected $id = null;

    protected $name = null;

    protected $type = null;

    protected $parent = null;

    protected $mappingClasses = [
        'parent' => 'Yandex\Market\Partner\Models\Region'
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
     * Retrieve the name property
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
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
     * Retrieve the parent property
     *
     * @return Region|null
     */
    public function getParent()
    {
        return $this->parent;
    }
}
