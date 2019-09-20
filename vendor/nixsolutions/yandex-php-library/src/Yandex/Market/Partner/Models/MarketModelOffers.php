<?php
/**
 * Yandex PHP Library
 *
 * @copyright NIX Solutions Ltd.
 * @link https://github.com/nixsolutions/yandex-php-library
 */

namespace Yandex\Market\Partner\Models;

use Yandex\Common\ObjectModel;

class MarketModelOffers extends ObjectModel
{
    /**
     * Add model offer
     *
     * @param array|MarketModelOffer $offer
     * @return MarketModelOffers
     */
    public function add($offer)
    {
        if (is_array($offer)) {
            $this->collection[] = new MarketModelOffer($offer);
        } elseif ($offer instanceof MarketModelOffer) {
            $this->collection[] = $offer;
        }

        return $this;
    }

    /**
     * Get all model offers
     *
     * @return array
     */
    public function getAll()
    {
        return $this->collection;
    }
}
