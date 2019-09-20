<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class GetMarketModelsResponse extends Model
{
    /**
     * @var MarketModels
     */
    protected $models;

    /**
     * @var Pager
     */
    protected $pager;

    protected $mappingClasses = [
        'models' => MarketModels::class,
        'pager' => Pager::class,
    ];

    /**
     * @var int
     */
    protected $regionId;

    /**
     * @var string
     */
    protected $currency;

    /**
     * Retrieve the models property
     *
     * @return MarketModels
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * Set the models property
     *
     * @param MarketModels $models
     * @return GetMarketModelsResponse
     */
    public function setModels($models)
    {
        $this->models = $models;
        return $this;
    }

    /**
     * Retrieve the pager property
     *
     * @return Pager|null
     */
    public function getPager()
    {
        return $this->pager;
    }

    /**
     * Set the pager property
     *
     * @param Pager $pager
     * @return GetMarketModelsResponse
     */
    public function setPager($pager)
    {
        $this->pager = $pager;
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
     * @return GetMarketModelsResponse
     */
    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;
        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return GetMarketModelsResponse
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }
}
