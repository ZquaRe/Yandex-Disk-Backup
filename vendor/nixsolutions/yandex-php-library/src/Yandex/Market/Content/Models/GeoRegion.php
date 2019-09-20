<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class GeoRegion extends Model
{
    protected $id = null;

    protected $parentId = null;

    protected $type = null;

    protected $name = null;

    protected $childrenCount = null;

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
     * Retrieve the parentId property
     *
     * @return int|null
     */
    public function getParentId()
    {
        return $this->parentId;
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
     * Retrieve the name property
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Retrieve the childrenCount property
     *
     * @return int|null
     */
    public function getChildrenCount()
    {
        return $this->childrenCount;
    }
}
