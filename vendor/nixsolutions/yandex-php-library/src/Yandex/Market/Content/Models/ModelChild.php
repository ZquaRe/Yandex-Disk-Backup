<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\MarketModel;

class ModelChild extends MarketModel
{
    protected $offersCount = null;

    protected $rating = null;

    protected $reviewsCount = null;

    protected $articlesCount = null;

    protected $isNew = null;

    protected $vendorId = null;

    protected $gradesCount = null;

    protected $categoryId = null;

    protected $id = null;

    protected $photos = null;

    protected $link = null;

    protected $isGroup = null;

    protected $vendorName = null;

    protected $name = null;

    protected $prices = null;

    protected $description = null;

    protected $facts = null;

    protected $mainPhoto = null;

    protected $parent = null;

    /**
     * Additional properties available during listed requests.
     */
    protected $childrenCount = null;

    protected $popularity = null;

    protected $mappingClasses = [
        'photos' => 'Yandex\Market\Content\Models\Photos',
        'prices' => 'Yandex\Market\Content\Models\Prices',
        'facts' => 'Yandex\Market\Content\Models\Facts',
        'mainPhoto' => 'Yandex\Market\Content\Models\Base\Photo',
        'parent' => 'Yandex\Market\Content\Models\ModelParent'
    ];

    protected $propNameMap = [
        'vendor' => 'vendorName',
        'parentModel' => 'parent',
        'modificationsCount' => 'childrenCount',
        'gradeCount' => 'gradesCount'
    ];

    /**
     * Constructor
     *
     * @param array $data
     */
    public function __construct($data = array())
    {
        // fix photo inheritance
        // @todo: Check whether only one child can be inherit in "photos" property.
        if (isset($data['photos']) && count($data['photos']) == 1 && isset($data['photos']['photo'])
        ) {
            $data['photos'] = $data['photos']['photo'];
        }
        parent::__construct($data);
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
     * Retrieve the rating property
     *
     * @return float|null
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Retrieve the reviewsCount property
     *
     * @return int|null
     */
    public function getReviewsCount()
    {
        return $this->reviewsCount;
    }

    /**
     * Retrieve the articlesCount property
     *
     * @return int|null
     */
    public function getArticlesCount()
    {
        return $this->articlesCount;
    }

    /**
     * Retrieve the isNew property
     *
     * @return bool|null
     */
    public function getIsNew()
    {
        if ($this->isNew === null) {
            return null;
        }

        if ($this->isNew == 1) {
            return true;
        }

        return false;
    }

    /**
     * Retrieve the vendorId property
     *
     * @return int|null
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * Retrieve the gradesCount property
     *
     * @return int|null
     */
    public function getGradesCount()
    {
        return $this->gradesCount;
    }

    /**
     * Retrieve the categoryId property
     *
     * @return int|null
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

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
     * Retrieve the id property
     *
     * @return Photos|null
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Retrieve the link property
     *
     * @return string|null
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Retrieve the isGroup property
     *
     * @return bool|null
     */
    public function getIsGroup()
    {
        return $this->isGroup;
    }

    /**
     * Retrieve the vendorName property
     * @return string|null
     */
    public function getVendorName()
    {
        return $this->vendorName;
    }

    /**
     * Retrieve the name property
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Retrieve the prices property
     *
     * @return Prices|null
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * Retrieve the description property
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Retrieve the facts property
     *
     * @return Facts|null
     */
    public function getFacts()
    {
        return $this->facts;
    }

    /**
     * Retrieve the mainPhoto property
     *
     * @return Photo|null
     */
    public function getMainPhoto()
    {
        return $this->mainPhoto;
    }

    /**
     * Retrieve the parent property
     *
     * @return ModelParent|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Retrieve the childrenCount property
     *
     * @note Property available during /category/{category_id}/models request.
     *
     * @return int|null
     */
    public function getChildrenCount()
    {
        return $this->childrenCount;
    }

    /**
     * Retrieve the popularity property
     *
     * @note Property available during /model/{model_id} request.
     * for list of children models in parent model.
     *
     * @return float|null
     */
    public function getPopularity()
    {
        return $this->popularity;
    }
}
