<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class Vendor extends Model
{
    protected $id = null;

    protected $name = null;

    protected $pictureUrl = null;

    protected $site = null;

    protected $categories = null;

    /**
     * Additional properties available during listed requests.
     */
    protected $modelId = null;

    protected $modelPhotoUrl = null;

    protected $topCategories = null;

    protected $mappingClasses = [
        'categories' => 'Yandex\Market\Content\Models\Categories',
        'topCategories' => 'Yandex\Market\Content\Models\Categories'
    ];

    protected $propNameMap = [
        'topModelId' => 'modelId',
        'topModelImage' => 'modelPhotoUrl',
        'picture' => 'pictureUrl'
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
     * Retrieve the pictureUrl property
     *
     * @return string|null
     */
    public function getPictureUrl()
    {
        return $this->pictureUrl;
    }

    /**
     * Retrieve the site property
     *
     * @return string|null
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Retrieve the categories property
     *
     * @return ???|null
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Retrieve the modelPhotoUrl property
     *
     * @note Property available during /popular request.
     *
     * @return int|null
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * Retrieve the modelPhotoUrl property
     *
     * @note Property available during /popular request.
     * @note Property available during /popular/category request.
     *
     * @return string|null
     */
    public function getModelPhotoUrl()
    {
        return $this->modelPhotoUrl;
    }

    /**
     * Retrieve the topCategories property
     *
     * @note Property available during /vendor request.
     *
     * @return Categories|null
     */
    public function getTopCategories()
    {
        return $this->topCategories;
    }
}
