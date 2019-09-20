<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Category extends Model
{
    protected $id = null;

    protected $name = null;

    protected $uniqueName = null;

    protected $parentId = null;

    protected $type = null;

    protected $childrenCount = null;

    protected $offersCount = null;

    protected $modelsCount = null;

    protected $isVisual = false;

    /**
     * Additional properties available during listed requests.
     */
    protected $vendors = null;

    protected $children = null;

    protected $popularity = null;

    protected $filterId = null;

    protected $filterValueId = null;

    protected $imageUrl = null;

    protected $mappingClasses = [
        'vendors' => 'Yandex\Market\Content\Models\Vendors',
        'children' => 'Yandex\Market\Content\Models\Categories'
    ];

    protected $propNameMap = [
        'visual' => 'isVisual',
        'uniqName' => 'uniqueName',
        'modelsNum' => 'modelsCount',
        'nmodels' => 'modelsCount',
        'offersNum' => 'offersCount',
        'topVendors' => 'vendors',
        'innerCategories' => 'children',
        'count' => 'offersCount',
        'uniq_name' => 'uniqueName',
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
     * Retrieve the name property
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Retrieve the uniqueName property
     *
     * @return string|null
     */
    public function getUniqueName()
    {
        return $this->uniqueName;
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
     * Retrieve the childrenCount property
     *
     * @return int|null
     */
    public function getChildrenCount()
    {
        return $this->childrenCount;
    }

    /**
     * Retrieve the offersCount property
     *
     * @return int|null
     */
    public function getOffersCount()
    {
        return $this->offersCount;
    }

    /**
     * Retrieve the modelsCount property
     *
     * @return int|null
     */
    public function getModelsCount()
    {
        return $this->modelsCount;
    }

    /**
     * Retrieve the isVisual property
     *
     * @return bool|null
     */
    public function getIsVisual()
    {
        return $this->isVisual;
    }

    /**
     * Retrieve the vendors property
     *
     * @note Property available during /popular request.
     * @note Property available during /popular/category request.
     *
     * @return Vendors|null
     */
    public function getVendors()
    {
        return $this->vendors;
    }

    /**
     * Retrieve the children property
     *
     * @note Property available during /vendor request.
     *
     * @return Categories|null
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Retrieve the popularity property
     *
     * @note Property available during /vendor request.
     *
     * @return float|null
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * Retrieve the filterId property
     *
     * @note Property available during /vendor request.
     *
     * @return int|null
     */
    public function getFilterId()
    {
        return $this->filterId;
    }

    /**
     * Retrieve the filterValueId property
     *
     * @note Property available during /vendor request.
     *
     * @return int|null
     */
    public function getFilterValueId()
    {
        return $this->filterValueId;
    }

    /**
     * Retrieve the imageUrl property
     *
     * @note Property available during /vendor request.
     *
     * @return string|null
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
}
