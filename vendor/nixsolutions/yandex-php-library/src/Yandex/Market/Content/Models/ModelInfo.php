<?php

namespace Yandex\Market\Content\Models;

use Yandex\Common\Model;

class ModelInfo extends Model
{
    protected $id = null;

    protected $offersCount = null;

    protected $type = null;

    protected $name = null;

    protected $category = null;

    protected $prices = null;

    protected $photoUrl = null;

    protected $vendor = null;

    protected $rating = null;

    protected $media = null;

    protected $facts = null;

    protected $mappingClasses = [
        'category' => 'Yandex\Market\Content\Models\Category',
        'prices' => 'Yandex\Market\Content\Models\Prices',
        'vendor' => 'Yandex\Market\Content\Models\Vendor',
        'rating' => 'Yandex\Market\Content\Models\Rating',
        'media' => 'Yandex\Market\Content\Models\Media',
        'facts' => 'Yandex\Market\Content\Models\Facts'
    ];

    protected $propNameMap = [
        'offerCount' => 'offersCount',
        'price' => 'prices',
        'photo' => 'photoUrl'
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
     * Retrieve the offersCount property
     *
     * @return int|null
     */
    public function getOffersCount()
    {
        return $this->offersCount;
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
     * Retrieve the category property
     *
     * @return Category|null
     */
    public function getCategory()
    {
        return $this->category;
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
     * Retrieve the photoUrl property
     *
     * @return string|null
     */
    public function getPhotoUrl()
    {
        return $this->photoUrl;
    }

    /**
     * Retrieve the vendor property
     *
     * @return Vendor|null
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Retrieve the rating property
     *
     * @return Rating|null
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Retrieve the media property
     *
     * @return Media|null
     */
    public function getMedia()
    {
        return $this->media;
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
}
