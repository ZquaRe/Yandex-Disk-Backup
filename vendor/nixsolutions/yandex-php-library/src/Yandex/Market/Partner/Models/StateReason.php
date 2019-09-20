<?php

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class StateReason extends Model
{

    protected $feedId = null;

    protected $offerId = null;

    protected $feedCategoryId = null;

    protected $offerName = null;

    protected $price = null;

    protected $count = null;

    protected $mappingClasses = [];

    protected $propNameMap = [];

    /**
     * Retrieve the feedId property
     *
     * @return int|null
     */
    public function getFeedId()
    {
        return $this->feedId;
    }

    /**
     * Set the feedId property
     *
     * @param int $feedId
     * @return $this
     */
    public function setFeedId($feedId)
    {
        $this->feedId = $feedId;
        return $this;
    }

    /**
     * Retrieve the offerId property
     *
     * @return string|null
     */
    public function getOfferId()
    {
        return $this->offerId;
    }

    /**
     * Set the offerId property
     *
     * @param string $offerId
     * @return $this
     */
    public function setOfferId($offerId)
    {
        $this->offerId = $offerId;
        return $this;
    }

    /**
     * Retrieve the feedCategoryId property
     *
     * @return string|null
     */
    public function getFeedCategoryId()
    {
        return $this->feedCategoryId;
    }

    /**
     * Set the feedCategoryId property
     *
     * @param string $feedCategoryId
     * @return $this
     */
    public function setFeedCategoryId($feedCategoryId)
    {
        $this->feedCategoryId = $feedCategoryId;
        return $this;
    }

    /**
     * Retrieve the offerName property
     *
     * @return string|null
     */
    public function getOfferName()
    {
        return $this->offerName;
    }

    /**
     * Set the offerName property
     *
     * @param string $offerName
     * @return $this
     */
    public function setOfferName($offerName)
    {
        $this->offerName = $offerName;
        return $this;
    }

    /**
     * Retrieve the price property
     *
     * @return int|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the price property
     *
     * @param int $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
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
     * Set the count property
     *
     * @param int $count
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }
}
