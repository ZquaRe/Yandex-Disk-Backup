<?php

namespace Yandex\Market\Content\Models;

use Yandex\Market\Content\Models\Base\MarketModel;

class ModelVisual extends MarketModel
{
    protected $offersCount = null;

    protected $vendorId = null;

    protected $categoryId = null;

    protected $id = null;

    protected $photos = null;

    protected $link = null;

    protected $vendorName = null;

    protected $name = null;

    protected $prices = null;

    protected $description = null;

    protected $previewPhotos = null;

    protected $filters = null;

    protected $offers = null;

    /**
     * Additional properties available during listed requests.
     */
    protected $childrenCount = null;

    protected $mappingClasses = [
        'photos' => 'Yandex\Market\Content\Models\ModelVisualPhotos',
        'prices' => 'Yandex\Market\Content\Models\Prices',
        'previewPhotos' => 'Yandex\Market\Content\Models\ModelVisualPhotos',
        // @todo Need test below properties.
        'filters' => 'Yandex\Market\Content\Models\Filters',
        'offers' => 'Yandex\Market\Content\Models\Offers'
    ];

    protected $propNameMap = [
        'modificationsCount' => 'childrenCount'
    ];

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
     * Retrieve the vendorId property
     *
     * @return int|null
     */
    public function getVendorId()
    {
        return $this->vendorId;
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
     * Retrieve the filters property
     *
     * @return Filters|null
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * Retrieve the previewPhotos property
     *
     * @return Photos|null
     */
    public function getPreviewPhotos()
    {
        return $this->previewPhotos;
    }

    /**
     * Retrieve the offers property
     *
     * @return Offers|null
     */
    public function getOffers()
    {
        return $this->offers;
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
}
