<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class MarketModelOffer extends Model
{
    /**
     * @var int
     */
    protected $discount;

    /**
     * @var int
     */
    protected $inStock;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $pos;

    /**
     * @var float
     */
    protected $preDiscountPrice;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var int
     */
    protected $regionId;

    /**
     * @var float
     */
    protected $shippingCost;

    /**
     * @var string
     */
    protected $shopName;

    /**
     * @var int
     */
    protected $shopRating;

    /**
     * Get percent of discount
     *
     * @return int|null
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set percent of discount
     *
     * @param int $discount
     * @return MarketModelOffer
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * Get in stock flag (0 - on request, 1 - in stock)
     *
     * @return int
     */
    public function getInStock()
    {
        return $this->inStock;
    }

    /**
     * Set in stock flag (0 - on request, 1 - in stock)
     *
     * @param int $inStock
     * @return MarketModelOffer
     */
    public function setInStock($inStock)
    {
        $this->inStock = $inStock;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return MarketModelOffer
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get search result position
     *
     * @return int
     */
    public function getPos()
    {
        return $this->pos;
    }

    /**
     * Set search result position
     *
     * @param int $pos
     * @return MarketModelOffer
     */
    public function setPos($pos)
    {
        $this->pos = $pos;
        return $this;
    }

    /**
     * Get price excluding discount
     *
     * @return float|null
     */
    public function getPreDiscountPrice()
    {
        return $this->preDiscountPrice;
    }

    /**
     * Set price excluding discount
     *
     * @param float $preDiscountPrice
     * @return MarketModelOffer
     */
    public function setPreDiscountPrice($preDiscountPrice)
    {
        $this->preDiscountPrice = $preDiscountPrice;
        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return MarketModelOffer
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get region ID
     *
     * @return int
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     * Set region ID
     *
     * @param int $regionId
     * @return MarketModelOffer
     */
    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;
        return $this;
    }

    /**
     * Get shipping cost
     *
     * @return float
     */
    public function getShippingCost()
    {
        return $this->shippingCost;
    }

    /**
     * Set shipping cost
     *
     * @param float $shippingCost
     * @return MarketModelOffer
     */
    public function setShippingCost($shippingCost)
    {
        $this->shippingCost = $shippingCost;
        return $this;
    }

    /**
     * Get shop name
     *
     * @return string
     */
    public function getShopName()
    {
        return $this->shopName;
    }

    /**
     * Set shop name
     *
     * @param string $shopName
     * @return MarketModelOffer
     */
    public function setShopName($shopName)
    {
        $this->shopName = $shopName;
        return $this;
    }

    /**
     * Get shop rating (1 - 5)
     *
     * @return int
     */
    public function getShopRating()
    {
        return $this->shopRating;
    }

    /**
     * Set shop rating (1 - 5)
     *
     * @param int $shopRating
     * @return MarketModelOffer
     */
    public function setShopRating($shopRating)
    {
        $this->shopRating = $shopRating;
        return $this;
    }
}
