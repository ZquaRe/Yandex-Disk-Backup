<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

namespace Yandex\Market\Partner\Models;

use Yandex\Common\Model;

class MarketModelPrices extends Model
{
    /**
     * @var float
     */
    protected $min;

    /**
     * @var float
     */
    protected $max;

    /**
     * @var float
     */
    protected $avg;

    /**
     * Get min price
     *
     * @return float
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * Set min price
     *
     * @param float $min
     * @return MarketModelPrices
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * Get max price
     *
     * @return float
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Set max price
     *
     * @param float $max
     * @return MarketModelPrices
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }

    /**
     * Get avg price
     *
     * @return float
     */
    public function getAvg()
    {
        return $this->avg;
    }

    /**
     * Set avg price
     *
     * @param float $avg
     * @return MarketModelPrices
     */
    public function setAvg($avg)
    {
        $this->avg = $avg;
        return $this;
    }
}
