<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class MarketModel extends Model
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var MarketModelPrices
     */
    protected $prices;

    /**
     * @var MarketModelOffers
     */
    protected $offers;

    /**
     * @var int
     */
    protected $offlineOffers;

    /**
     * @var int
     */
    protected $onlineOffers;

    protected $mappingClasses = [
        'prices' => MarketModelPrices::class,
        'offers' => MarketModelOffers::class,
    ];

    /**
     * Retrieve the id property
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the id property
     *
     * @param int $id
     * @return MarketModel
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return MarketModel
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get model prices
     *
     * @return MarketModelPrices|null
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * Set model prices
     *
     * @param MarketModelPrices $prices
     * @return MarketModel
     */
    public function setPrices($prices)
    {
        $this->prices = $prices;
        return $this;
    }

    /**
     * Get model offers
     *
     * @return MarketModelOffers|null
     */
    public function getOffers()
    {
        return $this->offers;
    }

    /**
     * Set model offers
     *
     * @param MarketModelOffers $offers
     * @return MarketModel
     */
    public function setOffers($offers)
    {
        $this->offers = $offers;
        return $this;
    }

    /**
     * Get number of product offerings int the retail (offline) stores
     *
     * @return int|null
     */
    public function getOfflineOffers()
    {
        return $this->offlineOffers;
    }

    /**
     * Set number of product offerings in retail (offline) stores
     *
     * @param int $offlineOffers
     * @return MarketModel
     */
    public function setOfflineOffers($offlineOffers)
    {
        $this->offlineOffers = $offlineOffers;
        return $this;
    }

    /**
     * Get the number of product offerings online
     *
     * @return int|null
     */
    public function getOnlineOffers()
    {
        return $this->onlineOffers;
    }

    /**
     * Set the number of product offerings online
     *
     * @param int $onlineOffers
     * @return MarketModel
     */
    public function setOnlineOffers($onlineOffers)
    {
        $this->onlineOffers = $onlineOffers;
        return $this;
    }
}
